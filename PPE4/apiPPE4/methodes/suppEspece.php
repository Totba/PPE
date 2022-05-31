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
        
        // ce sont des variables normales comme ce que tu as utilisé jusqu'à présent
        $espece->codeespece = $donnees->codeespece;

        if($espece-> supprimerCohaEspece()){

            if($espece->supprimerEnclosDeEspece()){

                if($espece-> supprimerEspece()){

                    http_response_code(200);
                    echo json_encode(array("message" => "L'espece a bien été supprimé"));
                }
            }else{

                http_response_code(405);
                echo json_encode(array("message" => "La suppression a échouée lors de la suppression des enclos"));
            }
        }else{

            http_response_code(405);
            echo json_encode(array("message" => "La suppression a échouée "));
        }

}else{

    http_response_code(405);
    echo json_encode(array("message" => "La methode n'est pas autorisee"));
  }
?>