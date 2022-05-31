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
    include_once '../models/placement.php';


    $database = new Database();
    $db = $database->getConnection();

    $placement = new Placement($db, null, null, null, null);
    $donnees = json_decode(file_get_contents("php://input"));
    
    $placement->codeespece = $donnees->codeespece;
    $placement->nombapteme = $donnees->nombapteme;

    $placement->getPlacement();


    if($placement->encours != null){
      $cli = [
          "codeenclos" => $placement->codeenclos,
          "encours" => $placement->encours,
          "datedebut" => $placement->datedebut

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