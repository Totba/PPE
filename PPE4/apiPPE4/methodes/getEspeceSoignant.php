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

    $espece = new Espece($db);
    $donnees = json_decode(file_get_contents("php://input"));

    $espece->soignant = $donnees->matricule;
    $stmt = $espece->getEspecesSoignant();


    if($stmt->rowCount() > 0){

		
        $tableauEspeces = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $esp = [
                "codeespece" => $codeespece,
                "libelle" => $libelle,
            ];

            $tableauEspeces[] = $esp;
        }

        http_response_code(200);
        echo json_encode($tableauEspeces);
    }
  else
	{
	http_response_code(200);
    echo json_encode(array("message" => "Ce soignant n'a pas d'espèce"));}
  }else{

    http_response_code(405);
    echo json_encode(array("message" => "La methode n'est pas autorisee"));
  }
?>