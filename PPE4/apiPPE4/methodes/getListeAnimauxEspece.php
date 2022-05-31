<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: get");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD']== 'POST') {                               

    include_once '../config/database.php';
    include_once '../models/animaux.php';

    $database = new Database();
    $db = $database->getConnection();

    
	$donnees = json_decode(file_get_contents("php://input"));
    
    $animaux = new Animaux($db);

    if (!empty($donnees->codeespece)) {
        $animaux->codeespece = $donnees->codeespece;

         $stmt = $animaux->getAnimauxUneEspece();
         
    
         if ($stmt->rowCount() > 0) {

            $tableauAnimaux = [];
            

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                
                extract($row);
                
                $animaux->nombapteme = $row['nombapteme'];
                $v = $animaux->getenclos();
                $r = $v->fetch(PDO::FETCH_ASSOC);

                $ani = [
                    "nombapteme" => $row['nombapteme'],
                    "sexe" => $row['sexe'],
                    "dateNaissance" => $row['dateNaissance'],
                    "dateDeces" => $row['dateDeces'],
                    "enclos" => $r['nomenclos'],
                    "code" => $r['code']
                ];
    
                $tableauAnimaux[] = $ani;
            }
    
            http_response_code(200);
            echo json_encode($tableauAnimaux);
            
        } else {

            http_response_code(404);
            echo json_encode(array("message" => "Le client n'existe pas."));
        }
    }
} else {

    http_response_code(405);
    echo json_encode(array("message" => "La methode n'est pas autorisee"));
}
?>

