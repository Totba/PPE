<?php
class Placement{
    // Connexion
    private $connexion;
    private $table1 = "animaloccuperenclos";
    private $table2 = "ESPECE";

    // object properties
    public $codeespece;
    public $nombapteme;
    public $codeenclos;
    public $encours;
    public $datedebut;


    /**
     * Constructeur avec $db pour la connexion à la base de données
     *
     * @param $db
     */
    public function __construct($db, $codeespece, $nombapteme, $codeenclos, $encours){
        $this->connexion = $db;
        $this->codeespece = $codeespece;
        $this->nombapteme = $nombapteme;
        $this->codeenclos = $codeenclos;
        $this->encours = $encours;
        $this->datedebut = null;


    }




    /**
     * Retourne 1 dans le cas où l'animal peut vivre dans l'enclos sinon 0
     *
     */

    public function verifierViabiliteEnclos(){
        // On écrit la requête
        
        $sql = "SELECT COUNT(*) as nb FROM especepouvoirvivreenclos 
        WHERE codeespece = " . $this->codeespece . " 
        AND codeenclos = " . $this->codeenclos . "";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }


    /**
     * Permet de connaitre le nombre d'espèces qui ne peuvent pas vivre avec l'espèce inserré
     *
     */

    public function verifierCohabitation(){
        // On écrit la requête
        
        $sql = "SELECT COUNT(distinct(codeespece)) 
        AS nb FROM animaloccuperenclos WHERE codeenclos = " . $this->codeenclos . "
        and codeespece not in(select codeespece from cohabiter where codeespece_1 = " . $this->codeespece . ")
        and codeespece <> " . $this->codeespece . "";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }

    /**
     * Fait un insert dans animaloccuperenclos
     *
     */
    public function placerAnimal(){
        // On écrit la requête
        
        $sql = "INSERT INTO animaloccuperenclos (codeespece, nombapteme, codeenclos, datedebut, encours) 
        VALUES (". $this->codeespece .", '". $this->nombapteme."', ".$this->codeenclos.",
        CURDATE(), 1)";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }

    /**
     * Permet de vérifier si l'animal est déjà placé. il retourne 0 si il n'est pas placé
     *
     */
    public function verifAnimalPlace(){
        // On écrit la requête
        
        $sql = "SELECT count(*) as nb 
        from animaloccuperenclos where nombapteme = '".$this->nombapteme."' and codeespece = ".$this->codeespece." and encours = 1";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }

    /**
     * Met à 0 le encours de l'animal et fait un nouvel insert dans placement
     *
     */
    public function deplacerAnimal(){
        $sql = "UPDATE animaloccuperenclos SET encours = 0 WHERE codeespece = ".$this->codeespece." AND nombapteme = '".$this->nombapteme."';
        INSERT INTO animaloccuperenclos (codeespece, nombapteme, codeenclos, datedebut, encours) 
        VALUES (". $this->codeespece .", '". $this->nombapteme."', ".$this->codeenclos.",
        CURDATE(), 1)";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }

    /**
     * Permet de supprimer placement
     *
     */
    public function supprimerPlacement() {

        $sql = "DELETE FROM animaloccuperenclos WHERE codeespece = :codeespece
        AND nombapteme = :nombapteme ";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

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
     * Permet de connaitre l'enclos actuel d'un animal
     *
     */
    public function getPlacement() {
        // On écrit la requête
        $sql = "SELECT * from animaloccuperenclos
        WHERE codeespece = " . $this->codeespece . " and nombapteme = '" . $this->nombapteme . "' and encours = 1";

        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On exécute la requête
        $query->execute();

        // on récupère la ligne
        $row = $query->fetch(PDO::FETCH_ASSOC);

      
        $this->codeenclos = $row['codeenclos'];
        $this->encours = $row['encours'];
        $this->datedebut = $row['datedebut'];

        return $query;
    }

    public function isAlreadyPlaceAtTime() {
        // On écrit la requête
        $sql = "SELECT count(*) nb from animaloccuperenclos WHERE codeespece = ".$this->codeespece." and nombapteme = '".$this->nombapteme."' and codeenclos = ".$this->codeenclos." and datedebut = CURDATE()";

        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On exécute la requête
        $query->execute();

        return $query;
    }

    public function updateAlready() {
        // On écrit la requête
        $sql = "UPDATE animaloccuperenclos SET encours = 1 WHERE codeespece = ".$this->codeespece." AND nombapteme = '".$this->nombapteme."' AND codeenclos = ".$this->codeenclos.";";
        
        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }
}
?>