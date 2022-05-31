<?php
class Database{
    // Connexion à la base de données
    private $host = "db718503023.db.1and1.com";
    private $db_name = "db718503023";
    private $username = "dbo718503023";
    private $password = "BMw1234*";
    public $connexion;

    // getter pour la connexion
    public function getConnection(){

        $this->connexion = null;

        try{
            $this->connexion = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->connexion->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Erreur de connexion : " . $exception->getMessage();
        }

        return $this->connexion;
    }   
}