<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD']== 'POST') {  

   // On inclut les fichiers de configuration et d'accès aux données
    include_once '../config/database.php';
    include_once '../models/enclos.php';


    $database = new Database();
    $db = $database->getConnection();

    $enclos = new Enclos($db);
    $donnees = json_decode(file_get_contents("php://input"));

    $enclos->nom = $donnees->nom;
    $enclos->superficie = $donnees->superficie;

    if($enclos->ajoutEnclos()){
        http_response_code(200);
        echo json_encode(array("message" => "L'enclos a bien été ajouté"));
    }
    else
	{	 
	http_response_code(405);
    echo json_encode(array("message" => "Erreur lors de l'ajout"));
    }
}else{

    http_response_code(405);
    echo json_encode(array("message" => "La methode n'est pas autorisee"));
  }
?>