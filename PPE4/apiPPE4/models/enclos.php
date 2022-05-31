<?php
class Enclos{
    // Connexion
    private $connexion;
    private $table = "ENCLOS";
    private $table2 = "animaloccuperenclos";

    // object properties
    public $codeenclos;
    public $nom;
    public $superficie;

    /**
     * Constructeur avec $db pour la connexion à la base de données
     *
     * @param $db
     */
    public function __construct($db){
        $this->connexion = $db;
    }


    /**
     * Permet de connaitre la liste des enclos
     *
     */
    public function getEnclos(){
        // On écrit la requête
        $sql = "SELECT * FROM " . $this->table. " order by codeenclos";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }


    
    /**
     * Permet de faire un insert dans Enclos
     *
     */
    public function ajoutEnclos(){

        // Ecriture de la requête SQL en y insérant le nom de la table
        $sql = "select max(codeenclos) into @nb from " . $this->table . ";
        INSERT INTO " . $this->table . " SET codeenclos = @nb + 1, nom=:nom, superficie=:superficie";
        
        // Préparation de la requête
        $query = $this->connexion->prepare($sql);

        // Protection contre les injections

        $this->nom=htmlspecialchars(strip_tags($this->nom));
        $this->superficie=htmlspecialchars(strip_tags($this->superficie));

        // Ajout des données protégées

        $query->bindParam("nom", $this->nom);
        $query->bindParam("superficie", $this->superficie);
        // Exécution de la requête
        if($query->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Permet de connaitre les espece dans un enclos
     *
     */
    public function getListEspeceEnclos() {
        // On écrit la requête
        $sql = "SELECT distinct(codeespece) FROM `animaloccuperenclos` where codeenclos = :codeenclos and encours = 1";

        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On attache l'id
        $query->bindParam("codeenclos", $this->codeenclos);

        // On exécute la requête
        $query->execute();
        
        return $query;
    }

    /**
     * Permet de connaitre la liste des enclos dans les quels l'espèce peut vivre
     *
     */
    public function getNbAnimauxEnclos(){
        // On écrit la requête
        $sql = "SELECT count(*) as nb FROM animaloccuperenclos WHERE codeenclos = :codeenclos";
 
        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On attache l'id
        $query->bindParam(":codeenclos", $this->codeenclos);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }


    
    /**
     * Permet de connaitre les informations liés à un enclos
     *
     */
    public function getunEnclos(){
        // On écrit la requête
        $sql = "SELECT nom, superficie FROM " . $this->table . " WHERE codeenclos = ? LIMIT 0,1";

        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On attache l'id
        $query->bindParam(1, $this->codeenclos);

        // On exécute la requête
        $query->execute();

        // on récupère la ligne
        $row = $query->fetch(PDO::FETCH_ASSOC);

      
        $this->nom = $row['nom'];
        $this->superficie = $row['superficie'];
        
    }

    
    
    /**
     * Permet de supprimer un enclos
     *
     */
    public function suppEnclos(){
        // On écrit la requête
        $sql = "DELETE FROM " . $this->table . " WHERE codeenclos = ".$this->codeenclos.";
        UPDATE " . $this->table2 . " SET encours = 0 WHERE codeenclos = ".$this->codeenclos."";


        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On sécurise les données
        $this->codeenclos=htmlspecialchars(strip_tags($this->codeenclos));

        // On attache l'id
        $query->bindParam("codeenclos", $this->codeenclos);

        // On exécute la requête
        if($query->execute()){
            return true;
        }else{
            return false;
        }
        

    }

    
    /**
     * Permet de faire un update dans ENCLOS
     *
     */
    public function editEnclos(){
        // On écrit la requête
        $sql = "UPDATE " . $this->table . " SET nom = :nom, superficie=:superficie WHERE codeenclos = :codeenclos";
        
        // On prépare la requête
        $query = $this->connexion->prepare($sql);
        
        // On sécurise les données
        $this->codeenclos=htmlspecialchars(strip_tags($this->codeenclos));
        $this->nom=htmlspecialchars(strip_tags($this->nom));
        $this->superficie=htmlspecialchars(strip_tags($this->superficie));
        
        // On attache les variables
		$query->bindParam(':codeenclos', $this->codeenclos);
        $query->bindParam(':nom', $this->nom);
        $query->bindParam(':superficie', $this->superficie);
        
        // On exécute
        if($query->execute()){
            return true;
        }
        else{
            return false;
        }
        
        
    }
}

?>