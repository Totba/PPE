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
    include_once '../models/soignants.php';


    $database = new Database();
    $db = $database->getConnection();

    $soignant = new Soignant($db);
    $donnees = json_decode(file_get_contents("php://input"));

    $soignant->matricule = $donnees->matricule;


    $soignant->getUnSoignant();
    $stmt = $soignant->getOccupe();


    if($soignant->nomsoignant != null){

         $occupe = [];
         if($stmt->rowCount() > 0){
             while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                

                extract($row);

                $occupe[] = $codeespece;
            }

        }
        
        $cli = [
          "matricule" => $soignant->matricule,
          "nomsoignant" => $soignant->nomsoignant,
          "prenomsoignant" => $soignant->prenomsoignant,
          "telsoignant" => $soignant->telsoignant,
          "occupe" => $occupe
       ];
  
          http_response_code(200);
          echo json_encode($cli);
    }
    else
	{ 	 
	  http_response_code(405);
      echo json_encode(array("message" => "Echec"));
    }
  }else{

    http_response_code(405);
    echo json_encode(array("message" => "La methode n'est pas autorisee"));
  }
?>