
<?php

class Animaux{
    // Connexion
    private $connexion;
    private $table = "ANIMAL";

    // object properties
    public $id;
    public $codeespece;
    public $nombapteme;
    public $sexe;
    public $dateNaissance;
    public $dateDeces;

    /**
     * Constructeur avec $db pour la connexion à la base de données
     *
     * @param $db
     */
    public function __construct($db){
        $this->connexion = $db;
    }

    /**
     * Permet de connaitre la liste d'animaux d'une espèce
     *
     */
    public function getAnimauxUneEspece(){
        // On écrit la requête
        
        $sql = "SELECT codeespece, nombapteme, sexe, dateNaissance, dateDeces 
        from " . $this->table. " where codeespece = ". $this->codeespece."  
        ORDER BY nombapteme";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }

    
    /**
     * Permet de connaitre la liste de tous les animaux
     *
     */
    public function getAnimaux(){
        // On écrit la requête
        $sql = "SELECT * FROM " . $this->table. " order by codeespece";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }

    
    /**
     * Permet de faire un insert dans la table ANIMAL
     *
     */
    public function ajoutAnimaux(){

        // Ecriture de la requête SQL en y insérant le nom de la table
        $sql = "INSERT INTO " . $this->table . " SET codeespece=:codeespece, nombapteme=:nombapteme, sexe=:sexe, dateNaissance=:dateNaissance, dateDeces=:dateDeces";

        // Préparation de la requête
        $query = $this->connexion->prepare($sql);

        // Protection contre les injections
        $this->codeespece=htmlspecialchars(strip_tags($this->codeespece));
        $this->nombapteme=htmlspecialchars(strip_tags($this->nombapteme));
        $this->sexe=htmlspecialchars(strip_tags($this->sexe));
        $this->dateNaissance=htmlspecialchars(strip_tags($this->dateNaissance));
        $this->dateDeces=htmlspecialchars(strip_tags($this->dateDeces));
   
   

        // Ajout des données protégées
        $query->bindParam(":codeespece", $this->codeespece);
        $query->bindParam(":nombapteme", $this->nombapteme);
        $query->bindParam(":sexe", $this->sexe);
        $query->bindParam(":dateNaissance", $this->dateNaissance);
        $query->bindParam(":dateDeces", $this->dateDeces);

        // Exécution de la requête
        if($query->execute()){
            return true;
        }
        return false;
    }
    
    /**
     * Permet de connaitre les informations d'un animal
     *
     */
    public function getAnimal(){
        // On écrit la requête
        $sql = "SELECT nombapteme,sexe,dateNaissance,dateDeces FROM " . $this->table . " 
        WHERE codeespece = " . $this->codeespece . " and nombapteme = '" . $this->nombapteme . "'";

        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On exécute la requête
        $query->execute();

        // on récupère la ligne
        $row = $query->fetch(PDO::FETCH_ASSOC);

      
        $this->nombapteme = $row['nombapteme'];
        $this->sexe = $row['sexe'];
        $this->dateNaissance = $row['dateNaissance'];
        $this->dateDeces = $row['dateDeces'];

        return $query;
    }

    
    /**
     * Permet de supprimer un animal
     *
     */
    public function suppAnimal(){
        // On écrit la requête
        $sql = "DELETE FROM " . $this->table . " WHERE codeespece = :codeespece and nombapteme = :nombapteme";

        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On sécurise les données
        $this->codeespece=htmlspecialchars(strip_tags($this->codeespece));
        $this->nombapteme=htmlspecialchars(strip_tags($this->nombapteme));

        // On attache les variables 
        $query->bindParam("codeespece", $this->codeespece);
        $query->bindParam("nombapteme", $this->nombapteme);

        // On exécute la requête
        if($query->execute()){
            return true;
        }
        
        return false;
    }


    /**
     * Permet de faire un update dans ANIMAL
     *
     */
    public function editAnimal(){
        // On écrit la requête
        $sql = "UPDATE " . $this->table . " SET nombapteme = :nombapteme, sexe = :sexe, dateNaissance = :dateNaissance, dateDeces = :dateDeces WHERE codeespece = :codeespece and nombapteme = :nombapteme";
        
        // On prépare la requête
        $query = $this->connexion->prepare($sql);
        
        // On sécurise les données
        $this->codeespece=htmlspecialchars(strip_tags($this->codeespece));
        $this->nombapteme=htmlspecialchars(strip_tags($this->nombapteme));
        $this->sexe=htmlspecialchars(strip_tags($this->sexe));
        $this->dateNaissance=htmlspecialchars(strip_tags($this->dateNaissance));
        $this->dateDeces=htmlspecialchars(strip_tags($this->dateDeces));
        
        // On attache les variables
		$query->bindParam('codeespece', $this->codeespece);
        $query->bindParam('nombapteme', $this->nombapteme);
        $query->bindParam('sexe', $this->sexe);
        $query->bindParam('dateNaissance', $this->dateNaissance);
        $query->bindParam('dateDeces', $this->dateDeces);
        
        // On exécute
        if($query->execute()){
            return true;
        }
        
        return false;
    }

    public function getenclos() {
        // On écrit la requête
        $sql = "SELECT animaloccuperenclos.codeenclos as code, nom nomenclos FROM ENCLOS 
        inner join animaloccuperenclos on ENCLOS.codeenclos=animaloccuperenclos.codeenclos 
        where animaloccuperenclos.encours = 1 and animaloccuperenclos.codeespece = :codeespece and animaloccuperenclos.nombapteme = :nombapteme";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);
        
        // On sécurise les données
        $query->bindParam("codeespece", $this->codeespece);
        $query->bindParam("nombapteme", $this->nombapteme);

        $query->execute();

        return $query;
    }

}


?>