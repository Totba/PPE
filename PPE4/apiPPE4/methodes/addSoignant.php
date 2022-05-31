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


    if(count($donnees->especes) <= 3){
        
        $soignant->nomsoignant = $donnees->nomsoignant;
        $soignant->prenomsoignant = $donnees->prenomsoignant;
        $soignant->telsoignant = $donnees->telsoignant;
        $a = $donnees->especes;

        if($soignant->ajoutSoignant()){

            $stmt = $soignant->maxMatricule();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $soignant->matricule = $row["matricule"];

            foreach($a as $b){

                $soignant->codeespece = $b;
                $soignant->ajoutOccupe();

            }

            http_response_code(200);
            echo json_encode(array("message" => "Le soignant a bien été ajouté"));

        }



    }else{

        http_response_code(405);
        echo "Un soignant ne peut s'occuper que de 3 espèces au maximum";

    }

}else{

    http_response_code(405);
    echo json_encode(array("message" => "La methode n'est pas autorisee"));
  }
?>