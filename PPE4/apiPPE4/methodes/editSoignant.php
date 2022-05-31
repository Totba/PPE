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
        
        // ce sont des variables normales comme ce que tu as utilisé jusqu'à présent
        $soignant->matricule = $donnees->matricule;
        $soignant->nomsoignant = $donnees->nomsoignant;
        $soignant->prenomsoignant = $donnees->prenomsoignant;
        $soignant->telsoignant = $donnees->telsoignant;

        // dans ton json tu va avoir un array. dans la ligne qui suit $a est le array qui contient les id des espèces de mon soignant
        $a = $donnees->especes;

        // je créé mon soignant
        if($soignant->modifSoignant()){

            // comme on modifie avec une liste je te conseil de supprimer tous les enregistrements liés à ce que tu veux modifier comme ça tu évite d'avoir à tout trier 
            // de toute façon tout sera renvoyé depuis la page symfony

            if($soignant->supprOccupe()){

                // tu fais un balayage de ton array
                foreach($a as $b){

                    // tu ajoute tout au fure et à mesure dans la bdd le contenu de ton array
                    $soignant->codeespece = $b;
                    $soignant->ajoutOccupe();

                }

                // tu envois la réponce 
                http_response_code(200);
                echo json_encode(array("message" => "Le soignant a bien été modifié"));
            }

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
