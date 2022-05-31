<?php

function connexionPDO() {
    $login = "root";
    $mdp = "";
    $bd = "oxam";
    $serveur = "localhost";


    try{
        if ($_SERVER['HTTP_HOST']=='localhost'){
            $conn= new PDO ("mysql:host=$serveur;dbname=$bd",$login, $mdp, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        else{
            $conn= new PDO ('mysql:host=db672809078.db.1and1.com;dbname=db672809078','dbo672809078','BMw1234*', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        }
        catch(Exception $e){
            die('erreur :'.$e->getMessage());
        }
        $bdd->query("SET CHARACTER SET utf8");
}
?>