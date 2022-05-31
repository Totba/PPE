<?php
class Espece{
    // Connexion
    private $connexion;
    private $table = "ESPECE";
    private $table2 = "cohabiter";
    private $table3 = "especepouvoirvivreenclos";

    // object properties
    public $codeespece;
    public $libelle;
    public $soignant;


    /**
     * Constructeur avec $db pour la connexion à la base de données
     *
     * @param $db
     */
    public function __construct($db){
        $this->connexion = $db;
    }



    /**
     * Permet de connaitre la liste des espèces
     *
     */
    public function getEspeces(){
        // On écrit la requête
        $sql = "SELECT codeespece, libelle FROM " . $this->table. " order by codeespece";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }

    /**
     * Permet de connaitre la liste des espèces
     *
     */
    public function getEspecesSoignant(){
        // On écrit la requête
        $sql = "select ESPECE.codeespece, ESPECE.libelle, prendresoin.matricule from prendresoin 
        INNER JOIN ESPECE on prendresoin.codeespece = ESPECE.codeespece 
        Having prendresoin.matricule = ".$this->soignant."";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }

   
    /**
     * Permet de connaitre les informations d'une spèce
     *
     */
    public function getEspece(){
        // On écrit la requête
        $sql = "SELECT libelle FROM ESPECE WHERE codeespece = :codeespece";

        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On attache l'id
        $query->bindParam(":codeespece", $this->codeespece);

        // On exécute la requête
        $query->execute();

        // on récupère la ligne
        $row = $query->fetch(PDO::FETCH_ASSOC);

      
        $this->libelle = $row['libelle'];
        
    }
       
    /**
     * Permet de connaitre la liste des espèces qui peuvent cohabiter avec l'espèce choisie 
     *
     */
    public function getCohabitation(){
        // On écrit la requête
        $sql = "SELECT codeespece_1 FROM cohabiter WHERE codeespece = :codeespece";

        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On attache l'id
        $query->bindParam(":codeespece", $this->codeespece);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }
       
    /**
     * Permet de connaitre la liste des espèces qui peuvent cohabiter avec l'espèce choisie 
     *
     */
    public function getpeutCohabiter($codeespece){
        // On écrit la requête
        $sql = "SELECT count(*) nb FROM cohabiter WHERE codeespece = :codeespece and codeespece_1 = :codeespece_1";

        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On attache l'id
        $query->bindParam("codeespece", $this->codeespece);
        $query->bindParam("codeespece_1", $codeespece);

        // On exécute la requête
        $query->execute();

        $res = $query->fetch(PDO::FETCH_ASSOC);

        if ($res['nb'] == 1) {
            return true;

        } else {
            return false;
        }
    }


    /**
     * Permet de connaitre la liste des enclos dans les quels l'espèce peut vivre
     *
     */
    public function getEnclosPourEspece(){
        // On écrit la requête
        $sql = "SELECT ENCLOS.codeenclos, nom, superficie FROM especepouvoirvivreenclos 
        inner join ENCLOS on especepouvoirvivreenclos.codeenclos = ENCLOS.codeenclos
        WHERE codeespece = :codeespece";
 
        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On attache l'id
        $query->bindParam("codeespece", $this->codeespece);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }

    



    
    /**
     * Permet de faire un insert dans ESPECE
     *
     */
    public function ajoutEspece(){

        // Ecriture de la requête SQL en y insérant le nom de la table
        $sql = "select max(codeespece) into @nb from " . $this->table . ";
        INSERT INTO " . $this->table . " SET codeespece = @nb + 1, libelle= :libelle";

        // Préparation de la requête
        $query = $this->connexion->prepare($sql);

        // Protection contre les injections
        $this->libelle=htmlspecialchars(strip_tags($this->libelle));


        // Ajout des données protégées
        $query->bindParam(":libelle", $this->libelle);

        // Exécution de la requête
        if($query->execute()){
            return true;
        }
        return false;
    }

    /**
     * Permet de faire un insert d'une cohabitation en double pour avoir les deux sens 
     *
     */
    public function ajoutCohabitation(){

        // Ecriture de la requête SQL en y insérant le nom de la table
        $sql = "INSERT INTO cohabiter SET codeespece = :codeespece, codeespece_1= :codeespece_1;
        INSERT INTO cohabiter SET codeespece = :codeespece_1, codeespece_1= :codeespece";

        // Préparation de la requête
        $query = $this->connexion->prepare($sql);

        // Protection contre les injections
        $this->codeespece=htmlspecialchars(strip_tags($this->codeespece));
        $this->codeespece_1=htmlspecialchars(strip_tags($this->codeespece_1));


        // Ajout des données protégées
        $query->bindParam(":codeespece", $this->codeespece);
        $query->bindParam(":codeespece_1", $this->codeespece_1);

        // Exécution de la requête
        if($query->execute()){
            return true;
        }
        return false;
    }
 
    /**
     * Permet de connaitre le nombre d'espèces ? 
     *
     */
    public function maxCodeEspece(){
        // On écrit la requête
        $sql = "SELECT max(codeespece) as nbespece FROM ESPECE";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }

    /**
     * Permet de faire un insert dans especepouvoirvivreenclos
     *
     */
    public function ajoutEnclosValid(){

        // Ecriture de la requête SQL en y insérant le nom de la table
        $sql = "INSERT INTO especepouvoirvivreenclos SET codeespece = :codeespece, codeenclos= :codeenclos";

        // Préparation de la requête
        $query = $this->connexion->prepare($sql);

        // Protection contre les injections
        $this->codeespece=htmlspecialchars(strip_tags($this->codeespece));
        $this->codeenclos=htmlspecialchars(strip_tags($this->codeenclos));


        // Ajout des données protégées
        $query->bindParam(":codeespece", $this->codeespece);
        $query->bindParam(":codeenclos", $this->codeenclos);

        // Exécution de la requête
        if($query->execute()){
            return true;
        }
        return false;
    }
    
    /**
     * Permet de supprimer une espèce
     *
     */
    public function supprimerEspece(){
        // On écrit la requête
        $sql = "DELETE FROM " . $this->table . " WHERE codeespece = :codeespece";

        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On sécurise les données
        $this->codeespece=htmlspecialchars(strip_tags($this->codeespece));

        // On attache l'id
        $query->bindParam(":codeespece", $this->codeespece);

        // On exécute la requête
        if($query->execute()){
            return true;
        }
        
        return false;
    }

    /**
     * Permet de supprimer un enclos
     *
     */
    public function supprimerEnclosDeEspece(){
        // On écrit la requête
        $sql = "DELETE FROM especepouvoirvivreenclos WHERE codeespece = :codeespece";

        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On sécurise les données
        $this->codeespece=htmlspecialchars(strip_tags($this->codeespece));

        // On attache l'id
        $query->bindParam(":codeespece", $this->codeespece);

        // On exécute la requête
        if($query->execute()){
            return true;
        }
        
        return false;
    }

    /**
     * Permet de supprimer une cohabitation
     *
     */
    public function supprimerCohaEspece(){
        // On écrit la requête
        $sql = "DELETE FROM cohabiter WHERE codeespece = :codeespece or codeespece_1 = :codeespece";

        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On sécurise les données
        $this->codeespece=htmlspecialchars(strip_tags($this->codeespece));

        // On attache l'id
        $query->bindParam(":codeespece", $this->codeespece);

        // On exécute la requête
        if($query->execute()){
            return true;
        }
        
        return false;
    }

    
    /**
     * Permet de faire une update dans ESPECE
     *
     */
    public function editEspece(){
        // On écrit la requête
        $sql = "UPDATE " . $this->table . " SET libelle = :libelle WHERE codeespece = :codeespece";
        
        // On prépare la requête
        $query = $this->connexion->prepare($sql);
        
        // On sécurise les données
        $this->libelle=htmlspecialchars(strip_tags($this->libelle));
        
        // On attache les variables
		$query->bindParam(':codeespece', $this->codeespece);
        $query->bindParam(':libelle', $this->libelle);
        
        // On exécute
        if($query->execute()){
            return true;
        }
        
        return false;
    }
}

?>