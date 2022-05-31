<?php
class Soignant{
    // Connexion
    private $connexion;
    public $table = "SOIGNANT";


    // object properties
    public $matricule;
    public $nomsoignant;
    public $prenomsoignant;
    public $telsoignant;
    public $codeespece;

    /**
     * Constructeur avec $db pour la connexion à la base de données
     *
     * @param $db
     */
    public function __construct($db){
        $this->connexion = $db;
    }

    /**
     * Lecture des especes
     *
     * @return void
     */

    public function getSoignants(){
        // On écrit la requête
        $sql = "SELECT matricule, nomsoignant, prenomsoignant, telsoignant FROM " . $this->table. " order by matricule";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }

    /**
     * Lecture des especes
     *
     * @return void
     */

    public function getUnSoignant(){
        // On écrit la requête
        $sql = "SELECT matricule, nomsoignant, prenomsoignant, telsoignant FROM " . $this->table. " WHERE matricule = :matricule";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        
        $this->matricule=htmlspecialchars(strip_tags($this->matricule));

        $query->bindParam("matricule", $this->matricule);


        // On exécute la requête
        $query->execute();

        // on récupère la ligne
        $row = $query->fetch(PDO::FETCH_ASSOC);

      
        $this->matricule = $row['matricule'];
        $this->nomsoignant = $row['nomsoignant'];
        $this->prenomsoignant = $row['prenomsoignant'];
        $this->telsoignant = $row['telsoignant'];

        // On retourne le résultat
        return $query;
    }

    /**
     * Lecture des especes
     *
     * @return void
     */

    public function getOccupe(){
        // On écrit la requête
        $sql = "SELECT matricule, codeespece FROM prendresoin WHERE matricule = ". $this->matricule ."";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);


        // On exécute la requête
        $query->execute();


        // On retourne le résultat
        return $query;
    }


    /**
     * Lecture des especes
     *
     * @return void
     */

    public function maxMatricule(){
        // On écrit la requête
        $sql = "SELECT max(matricule) as matricule FROM SOIGNANT";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }


    /**
     * Ajouter un soignant
     *
     * @return void
     */
    public function ajoutSoignant(){

        // Ecriture de la requête SQL en y insérant le nom de la table
        $sql = "SELECT max(matricule) + 1 into @matricule FROM SOIGNANT;
        INSERT INTO " . $this->table . " SET matricule = @matricule, nomsoignant=:nomsoignant, prenomsoignant=:prenomsoignant, telsoignant=:telsoignant";

        // Préparation de la requête
        $query = $this->connexion->prepare($sql);

        // Protection contre les injections
        $this->nomsoignant=htmlspecialchars(strip_tags($this->nomsoignant));
        $this->prenomsoignant=htmlspecialchars(strip_tags($this->prenomsoignant));
        $this->telsoignant=htmlspecialchars(strip_tags($this->telsoignant));

        // Ajout des données protégées
        $query->bindParam("nomsoignant", $this->nomsoignant);
        $query->bindParam("prenomsoignant", $this->prenomsoignant);
        $query->bindParam("telsoignant", $this->telsoignant);

        // Exécution de la requête
        if($query->execute()){
            return true;
        }
        return false;
    }

    /**
     * Ajouter un s'occupe
     *
     * @return void
     */
    public function ajoutOccupe(){

        // Ecriture de la requête SQL en y insérant le nom de la table
        $sql = "INSERT INTO prendresoin SET matricule = :matricule, codeespece = :codeespece";

        // Préparation de la requête
        $query = $this->connexion->prepare($sql);

        // Protection contre les injections
        $this->matricule=htmlspecialchars(strip_tags($this->matricule));
        $this->codeespece=htmlspecialchars(strip_tags($this->codeespece));


        // Ajout des données protégées
        $query->bindParam("matricule", $this->matricule);
        $query->bindParam("codeespece", $this->codeespece);
        

        // Exécution de la requête
        if($query->execute()){
            return true;
        }
        return false;
    }

    /**
     * Ajouter un s'occupe
     *
     * @return void
     */
    public function supprOccupe(){

        // Ecriture de la requête SQL en y insérant le nom de la table
        $sql = "DELETE FROM prendresoin WHERE matricule = :matricule";

        // Préparation de la requête
        $query = $this->connexion->prepare($sql);

        // Protection contre les injections
        $this->matricule=htmlspecialchars(strip_tags($this->matricule));


        // Ajout des données protégées
        $query->bindParam("matricule", $this->matricule);
        

        // Exécution de la requête
        if($query->execute()){
            return true;
        }
        return false;
    }

    /**
     * Ajouter un soignant
     *
     * @return void
     */
    public function modifSoignant(){

        // Ecriture de la requête SQL en y insérant le nom de la table
        $sql = "UPDATE SOIGNANT SET nomsoignant = :nomsoignant, prenomsoignant = :prenomsoignant, telsoignant = :telsoignant WHERE matricule = :matricule ;";

        // Préparation de la requête
        $query = $this->connexion->prepare($sql);

        // Protection contre les injections
        $this->matricule=htmlspecialchars(strip_tags($this->matricule));
        $this->nomsoignant=htmlspecialchars(strip_tags($this->nomsoignant));
        $this->prenomsoignant=htmlspecialchars(strip_tags($this->prenomsoignant));
        $this->telsoignant=htmlspecialchars(strip_tags($this->telsoignant));

        // Ajout des données protégées
        $query->bindParam("matricule", $this->matricule);
        $query->bindParam("nomsoignant", $this->nomsoignant);
        $query->bindParam("prenomsoignant", $this->prenomsoignant);
        $query->bindParam("telsoignant", $this->telsoignant);

        // Exécution de la requête
        if($query->execute()){
            return true;
        }
        return false;
    }

    /**
     * Ajouter un soignant
     *
     * @return void
     */
    public function supprSoignant(){

        // Ecriture de la requête SQL en y insérant le nom de la table
        $sql = "DELETE FROM SOIGNANT WHERE matricule = :matricule";

        // Préparation de la requête
        $query = $this->connexion->prepare($sql);

        // Protection contre les injections
        $this->matricule=htmlspecialchars(strip_tags($this->matricule));

        // Ajout des données protégées
        $query->bindParam("matricule", $this->matricule);

        // Exécution de la requête
        if($query->execute()){
            return true;
        }
        return false;
    }

}
?>