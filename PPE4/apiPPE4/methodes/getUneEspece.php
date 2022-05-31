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
    include_once '../models/espece.php';


    $database = new Database();
    $db = $database->getConnection();

    $donnees = json_decode(file_get_contents("php://input"));

    $espece = new Espece($db);
    $espece->codeespece = $donnees->codeespece;


    $cohab = $espece->getCohabitation();
    $espece->getEspece();
    $enclosok = $espece->getEnclosPourEspece();

    if($espece->codeespece != null){


        if($cohab->rowCount() > 0){

		
          $tableauEspeces = [];
  
          while($row = $cohab->fetch(PDO::FETCH_ASSOC))
          {
              extract($row);
  
              $tableauEspeces[] = $codeespece_1;
          }
        }

        if($enclosok->rowCount() > 0){

		 
          $tableauEnclos = [];
  
          while($row = $enclosok->fetch(PDO::FETCH_ASSOC))
          {
              extract($row);
  
              $tableauEnclos[] = $codeenclos;
          }
        }

        $info = [
          "codeespece"=>$espece->codeespece,
          "libelle"=>$espece->libelle,
          "cohabitation"=>$tableauEspeces,
          "enclos"=>$tableauEnclos
       ];

      http_response_code(200);
      echo json_encode($info);


    }
    else
	  {  
	  http_response_code(405);
    echo json_encode(array("message" => "Il n'y pas d'espece avec ce code espece"));
    }
}else{
  http_response_code(405);
  echo json_encode(array("message" => "La methode n'est pas autorisee"));
}
?>