<?php

include_once "bd.inc.php";

function login($login, $mdp) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $login = htmlspecialchars($login);
    $mdp = htmlspecialchars($mdp);
    $mdp = hash("whirlpool",$mdp);

    $pdo = connexionPDO();

    $req = $pdo->query("SELECT count(*) as nb from profil where mdp = '".$mdp."' AND login = '".$login."'");
    $requete = $req->fetch();
    if($requete['nb']==1) {
        $rep = $pdo->query("SELECT * from profil where mdp = '".$mdp."' AND login = '".$login."'");
        $reponse = $rep->fetch();
        $_SESSION['login'] = $login;
        $_SESSION['mail'] = $reponse['mail'];
        $_SESSION['typeprofil'] = $reponse['Type_profil'];
        return true;
    } else {
        return false;
    }
}

function logout() {
    $_SESSION = array();
    session_destroy();

    setcookie('login', '');
    setcookie('pass_hache', '');
}

function isLoggedOk() {
    if(isLogged()) {
        $pdo = connexionPDO();
        $req = $pdo->query("SELECT count(*) as nb from structure where profil = '".$_SESSION['login']."'");
        $requete = $req->fetch();
        if($requete['nb'] == 1) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function isLogged() {
    if(isset($_SESSION['mail'])) {
        return true;
    } else {
        return false;
    }
}

function isAdmin() {
    if (isLogged()) {
        if($_SESSION['typeprofil']==1) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
    
}

function SuppDemande($id){ // Suppression une demande de réservation
    try {
        $pdo = connexionPDO();
        $req = $pdo->prepare("DELETE FROM demande WHERE Id_Demande = :Id_Demande");
        $req->bindValue('Id_Demande', $id);
        $req->execute();
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function ValidDemandedate($id){ // Validation d'une demande de réservation
    try {
        $pdo = connexionPDO();
        $rep = $pdo->query("SELECT * FROM demande inner join tranche on demande.Id_tranche = tranche.Id_tranche inner join structure on demande.Id_Structure = structure.Id_Structure where Id_Demande = '".$id."'");
        $reponse = $rep->fetch();

        //INSERT dans date_p
        $req = $pdo->prepare("INSERT INTO date_p (datereserv) VALUES (:datedemande)");
        $req->bindValue('datedemande', $reponse['date_resa']);
        $req->execute();
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function ValidDemandereserv($id){ // Validation d'une demande de réservation
    try {
        $pdo = connexionPDO();
        $rep = $pdo->query("SELECT * FROM demande inner join tranche on demande.Id_tranche = tranche.Id_tranche inner join structure on demande.Id_Structure = structure.Id_Structure where Id_Demande = '".$id."'");
        $reponse = $rep->fetch();
        echo 'wesh1';

        $rep2 = $pdo->query("SELECT * FROM date_p where datereserv = '".$reponse['date_resa']."'");
        $reponse2 = $rep2->fetch();
        echo 'wesh2';

        //INSERT dans planning
        $req = $pdo->prepare("INSERT INTO planning (Id_Tranche, Id_Salle, Id_Date_P, Id_Demande) VALUES (?, ?, ?, ?)");
        $req->bindValue(1, $reponse['Id_Tranche']);
        $req->bindValue(2, $reponse['Id_Salle']);
        $req->bindValue(3, $reponse2['Id_Date_P']);
        $req->bindValue(4, $id);
        $req->execute();
        echo 'wesh3';

        //UPDATE DEMANDE
        $req2 = $pdo->prepare("UPDATE demande SET staut_demande = 'O' WHERE Id_Demande = :Id_Demande");
        $req2->execute(array('Id_Demande' => $id));
        echo 'wesh4';
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function Inscription($mail,$login,$mdp){
    try {
        htmlspecialchars($mail);
        htmlspecialchars($login);
        htmlspecialchars($mdp);

        $pdo = connexionPDO();

        $mdphash = hash("whirlpool",$mdp);

        $req = $pdo->prepare("INSERT into profil (login, mdp, mail, Type_profil) Values (:Vlogin, :Vmdp, :Vmail, :Vtype)");
        $req->bindValue('Vlogin', $login, PDO::PARAM_STR);
        $req->bindValue('Vmdp', $mdphash, PDO::PARAM_STR);
        $req->bindValue('Vmail', $mail, PDO::PARAM_STR);
        $req->bindValue('Vtype', 0, PDO::PARAM_INT);
            
        $resultat = $req->execute();

        login($login, $mdp);
        return true;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
        return false;
    }
    return $resultat;
}

function getNomSalle($idsalle) {
    $salle = getSalle($idsalle);
    return $salle['nom_salle'];
}

function getMaxnbSalle($idsalle) {
    $salle = getSalle($idsalle);
    $categorie = $salle['Id_Categorie'];
    try {
        $pdo = connexionPDO();
        $req = $pdo->query("SELECT capacite from categorie where Id_Categorie = '".$categorie."'");
        $requete = $req->fetch();
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $requete['capacite'];
}

function getSalle($idsalle) {
    $resultat = array();

    try {
        $pdo = connexionPDO();
        $req = $pdo->query("SELECT * from salle where Id_Salle = '".$idsalle."'");
        $resultat = $req->fetch();
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function getSalles() {
    $resultat = array();

    try {
        $pdo = connexionPDO();
        $req = $pdo->prepare("SELECT * from salle inner join categorie on salle.Id_Categorie=categorie.Id_Categorie");
        $req->execute();

        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) {
            $resultat[] = $ligne;
            $ligne = $req->fetch(PDO::FETCH_ASSOC);

        }
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function modifSalle($id, $nom, $description, $categorie, $img = "") {
    try {
        $pdo = connexionPDO();
        if($img == "") {
            $rep = $pdo->query("SELECT nom_image FROM salle where Id_Salle = '".$id."'");
            $reponse = $rep->fetch();
            $img = $reponse['nom_image'];
        }
        $req = $pdo->prepare("UPDATE salle SET nom_salle = :nom, description = :description, nom_image = :img, Id_Categorie = :categorie where Id_salle = :id");
        $req->bindValue('nom', $nom, PDO::PARAM_STR);
        $req->bindValue('description', $description, PDO::PARAM_STR);
        $req->bindValue('img', $img, PDO::PARAM_STR);
        $req->bindValue('categorie', $categorie, PDO::PARAM_INT);
        $req->bindValue('id', $id, PDO::PARAM_INT);
        echo '<br>';
            
        $resultat = $req->execute();
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function addSalle($nom, $description, $img, $categorie){
    try {
        $pdo = connexionPDO();
        $req = $pdo->prepare("INSERT INTO salle(nom_salle, description, nom_image, Id_Categorie) VALUES (:nom, :description, :img, :categorie)");
        $req->bindValue('nom', $nom, PDO::PARAM_STR);
        $req->bindValue('description', $description, PDO::PARAM_STR);
        $req->bindValue('img', $img, PDO::PARAM_STR);
        $req->bindValue('categorie', $categorie, PDO::PARAM_INT);
        echo '<br>';
            
        $resultat = $req->execute();
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function delSalle($id_Salle) {
    try {
        $pdo = connexionPDO();

        $req = $pdo->prepare("DELETE from salle where Id_Salle=:id_Salle");
        $req->bindValue(':id_Salle', $id_Salle, PDO::PARAM_INT);
        
        $resultat = $req->execute();
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function getReservations() {
    $resultat = array();

    try {
        $pdo = connexionPDO();
        $req = $pdo->prepare("SELECT * FROM planning inner join date_p on planning.Id_Date_P = date_p.Id_Date_P inner join tranche on planning.Id_Tranche = tranche.Id_Tranche inner join salle on planning.Id_Salle = salle.Id_Salle");
        $req->execute();

        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) {
            $resultat[] = $ligne;
            $ligne = $req->fetch(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function getReservation($iddemande) {
    $resultat = array();

    try {
        $pdo = connexionPDO();
        $req = $pdo->prepare("SELECT * FROM planning inner join date_p on planning.Id_Date_P = date_p.Id_Date_P inner join tranche on planning.Id_Tranche = tranche.Id_Tranche inner join salle on planning.Id_Salle = salle.Id_Salle where Id_Demande = ".$iddemande);
        $req->execute();

        $resultat = $req->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function getDemandes() {
    $resultat = array();

    try {
        $pdo = connexionPDO();
        $req = $pdo->prepare("SELECT * FROM demande inner join tranche on demande.Id_Tranche = tranche.Id_Tranche inner join structure on demande.Id_Structure = structure.Id_Structure inner join salle on demande.Id_Salle = salle.Id_Salle where staut_demande = 'N'");
        $req->execute();

        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) {
            $resultat[] = $ligne;
            $ligne = $req->fetch(PDO::FETCH_ASSOC);

        }
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function suppReservation($Id_Tranche, $Id_Salle, $Id_Date_P) {
    $pdo = connexionPDO();
    $req = $pdo->prepare("DELETE FROM planning WHERE Id_Tranche = :Id_Tranche AND Id_Salle = :idsalle AND Id_Date_P = :Id_Date_P");
    $req->bindValue(':Id_Tranche', $Id_Tranche, PDO::PARAM_INT);
    $req->bindValue(':Id_Salle', $Id_Salle, PDO::PARAM_INT);
    $req->bindValue(':Id_Date_P', $Id_Date_P, PDO::PARAM_INT);
    $req->execute();
}

function adddemande($nbpersonne, $date, $structure, $tranche, $salle) {
    $resultat = array();

    try {
        $pdo = connexionPDO();
        $req = $pdo->prepare("INSERT INTO demande (nb_personne, date_resa, staut_demande, Id_Structure, Id_Tranche, Id_Salle) VALUES (:nbpersonne, :dateresa, :demande, :structure, :tranche, :salle)");
        $req->bindValue('nbpersonne', $nbpersonne);
        $req->bindValue('dateresa', $date);
        $req->bindValue('demande', 'N');
        $req->bindValue('structure', $structure);
        $req->bindValue('tranche', $tranche);
        $req->bindValue('salle', $salle);

        $resultat = $req->execute();
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) {
            $resultat[] = $ligne;
            $ligne = $req->fetch(PDO::FETCH_ASSOC);

        }
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function getTranches() {
    $resultat = array();

    try {
        $pdo = connexionPDO();
        $req = $pdo->prepare("SELECT * from tranche");
        $req->execute();

        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) {
            $resultat[] = $ligne;
            $ligne = $req->fetch(PDO::FETCH_ASSOC);

        }
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function getCategorie() {
    $resultat = array();

    try {
        $pdo = connexionPDO();
        $req = $pdo->prepare("SELECT * from categorie");
        $req->execute();

        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) {
            $resultat[] = $ligne;
            $ligne = $req->fetch(PDO::FETCH_ASSOC);

        }
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function testimagevalide($fileimg) {
    $target_dir = "image/";
    $target_file = $target_dir . basename($fileimg["name"]);
    //on initialise la variable update ok
    $uploadOk = "OK";
    //on recup l'extention du fichier
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    
    //on a cliqué sur le bouton qui s'appel submit
    if(isset($_POST["submit"])) {
        //fichier image?
        $check = getimagesize($fileimg["tmp_name"]);
        if($check !== false) {
            $uploadOk = "OK";
        } else {
            $uploadOk = "size";
        }
    }
    // le fichier existe déjà?
    if (file_exists($target_file)) {
        $uploadOk = "already";
    }
    // le poid de l'image
    if ($fileimg["size"] > 500000) {
        $uploadOk = "poids de l'image";
    }
    // les formats autorisés
    if($imageFileType != "jpg" &&$imageFileType != "JPG"&& $imageFileType != "png" && $imageFileType != "PNG" && $imageFileType != "jpeg" && $imageFileType != "JPEG" && $imageFileType != "gif" && $imageFileType != "GIF") {
        
        $uploadOk = "format d'image non autoriser";
    }
    // tt c'est bien passé
    if ($uploadOk == "OK") {
        if (move_uploaded_file($fileimg["tmp_name"], $target_file)) {
            return $uploadOk;   
        } else {
            $uploadOk = "enregistrement de l'image";
            return $uploadOk;
        }
    // erreur
    } else {
        return $uploadOk;
    }
}

function getStructure() {
    try {
        $pdo = connexionPDO();
        $rep = $pdo->query("SELECT * from structure where profil = '".$_SESSION['login']."'");
        $reponse = $rep->fetch();

    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $reponse;
}

function getTarif($idsalle, $idstructure, $idtranche){
    try {
        $pdo = connexionPDO();

        $rep = $pdo->query(
            "SELECT * from tarif where Id_Categorie = (
                SELECT Id_Categorie from salle where Id_Salle = '".$idsalle."'
            ) and Id_Type_structure = (
                SELECT Id_Type_structure from structure where Id_Structure = '".$idstructure."'
            ) and Id_Periode = '".$idtranche."'"
        );
        $reponse = $rep->fetch();
        return $reponse['prix'];
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getnomtranche($idtarif){
    $pdo = connexionPDO();
    $rep = $pdo->query("SELECT * from tranche where Id_Tranche = '".$idtarif."'");
    $reponse = $rep->fetch();
    return $reponse['nom_tranche'];
}

function getPeriode($idtranche){
    $pdo = connexionPDO();
    $rep = $pdo->query("SELECT * FROM tranche where Id_Tranche = '".$idtranche."'");
    $reponse = $rep->fetch();
    return $reponse['Id_Periode'];
}


function addStructure($nomStructure, $IBAN, $profil, $Id_Type_structure){
    try {
        $pdo = connexionPDO();
        $req = $pdo->prepare("INSERT INTO structure (nom, IBAN, profil, ID_Type_structure) VALUES (?, ?, ?, ?)");
        $req->bindValue(1 , $nomStructure, PDO::PARAM_STR);
        $req->bindValue(2 , $IBAN, PDO::PARAM_STR);
        $req->bindValue(3 , $profil, PDO::PARAM_STR);
        $req->bindValue(4 , $Id_Type_structure, PDO::PARAM_INT);
        echo '<br>';
            
        $resultat = $req->execute();
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}


function getAllStructure() {
    $resultat = array();

    try {
        $pdo = connexionPDO();
        $req = $pdo->prepare("SELECT * from structure");
        $req->execute();

        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) {
            $resultat[] = $ligne;
            $ligne = $req->fetch(PDO::FETCH_ASSOC);

        }
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}



function recupStructure($id_structure) {
    
    try {
        $pdo = connexionPDO();
        $req = $pdo->prepare("SELECT * from structure where Id_Structure='$id_structure'");
        $req->execute();
        
        $resultat = $req->fetch(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}


function modifStructure ($id_structure, $nomStructure, $IBAN, $profil, $Type_Structure) {
    try {
        $pdo = connexionPDO();
        $req = $pdo->prepare("UPDATE structure SET nom='$nomStructure',IBAN='$IBAN',profil='$profil' ,Id_Type_structure='$Type_Structure' WHERE Id_Structure='$id_structure'");
        $req->bindValue(1 , $nomStructure, PDO::PARAM_STR);
        $req->bindValue(2 , $IBAN, PDO::PARAM_STR);
        $req->bindValue(3 , $profil, PDO::PARAM_STR);
        $req->bindValue(4 , $Type_Structure, PDO::PARAM_INT);
        
        $resultat = $req->execute();
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function delStructure ($id_structure) {
    try {
        $pdo = connexionPDO();
    
        $req = $pdo->prepare("DELETE from structure where Id_Structure=:id_structure");
        $req->bindValue(':id_structure', $id_structure, PDO::PARAM_INT);
        
        $resultat = $req->execute();
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}


function typeStructure ($Id_Type_structure) {
    try {
        $pdo = connexionPDO();
        $req = $pdo->prepare("SELECT nom_type_structure from type_structure where Id_Type_structure='$Id_Type_structure'");
        $req->execute();

        $resultat = $req->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}
        

function allTypesStructure () {
    $resultat = array();

    try {
        $pdo = connexionPDO();
        $req = $pdo->prepare("SELECT * from type_structure");
        $req->execute();

        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) {
            $resultat[] = $ligne;
            $ligne = $req->fetch(PDO::FETCH_ASSOC);
        }

    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function sendMailvalid($iddemande){
    $reservation = getReservation($iddemande);
    $mail = $_SESSION['mail'];
    $subject = "Réservation de la ".$reservation['nom_salle'];
    $message = "Bonjour, \n".
            "\n".
            "Votre réservation de la " .$reservation['nom_salle']. " vien d'être valider pour la date du ".$reservation['datereserv']." pendant ".$reservation['nom_tranche']. ".\n".
            "\n".
            "Cordialement";
    mail($mail, $subject, $message);
}

function sendMailsuppr($iddemande){
    $reservation = getReservation($iddemande);
    $mail = $_SESSION['mail'];
    $subject = "Réservation de la ".$reservation['nom_salle']; 
    $message = "Bonjour, \n".
            "\n".
            "Votre réservation de la " .$reservation['nom_salle']. " vien d'être valider pour la date du ".$reservation['datereserv']." pendant ".$reservation['nom_tranche']. ".\n".
            "\n".
            "Cordialement";  
    mail($mail, $subject, $message);
}

?>