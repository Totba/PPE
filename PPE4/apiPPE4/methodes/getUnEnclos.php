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
    $enclos->codeenclos = $donnees->codeenclos;

    $enclos->getunEnclos();

    if($enclos->nom != null){
      $cli = [
          "codeenclos"=>$enclos->codeenclos,
          "nom" => $enclos->nom,
          "superficie" => $enclos->superficie
       ];

        http_response_code(200);
        echo json_encode($cli);
    }
  else
	{ echo($stmt);	 
	http_response_code(200);}
  }else{

    http_response_code(405);
    echo json_encode(array("message" => "La methode n'est pas autorisee"));
  }
?>