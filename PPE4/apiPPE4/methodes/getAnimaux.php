<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD']== 'GET') {  

   // On inclut les fichiers de configuration et d'accès aux données
    include_once '../config/database.php';
    include_once '../models/animaux.php';


    $database = new Database();
    $db = $database->getConnection();

    $animaux = new Animaux($db);

    $stmt = $animaux->getAnimaux();


    if($stmt->rowCount() > 0){

		
        $tableauAni = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $ani = [
                "codeespece" => $codeespece,
                "nombapteme" => $nombapteme,
                "sexe" => $sexe,
                "dateNaissance" => $datenaissance,
                "dateDeces" => $datedeces
            ];

            $tableauAni[] = $ani;
        }

        http_response_code(200);
        echo json_encode($tableauAni);
    }
  else
	{ echo($stmt);	 
	http_response_code(200);}
  }else{

    http_response_code(405);
    echo json_encode(array("message" => "La methode n'est pas autorisee"));
  }
?>