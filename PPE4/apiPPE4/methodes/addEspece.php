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


    if($donnees->libelle != null){
        
        $espece->libelle = $donnees->libelle;
        $enclosvalid = $donnees->enclosvalid;
        $espececoha = $donnees->espececoha;

        if($espece->ajoutEspece()){

            $stmt = $espece->maxCodeEspece();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $espece->codeespece = $row["nbespece"];

            foreach($espececoha as $uneEspecePeut){
                
                $espece->codeespece_1 = $uneEspecePeut;
                $espece->ajoutCohabitation();

            }

            foreach($enclosvalid as $unEnclosValid){
                $espece->codeenclos = $unEnclosValid;
                $espece->ajoutEnclosValid();

            }

            http_response_code(200);
            echo json_encode(array("message" => "L'espece a bien ete ajouter"));

        }



    }else{

        http_response_code(405);
        echo "L'espece n'a pas de nom";

    }

}else{

    http_response_code(405);
    echo json_encode(array("message" => "La methode n'est pas autorisee"));
  }
?>