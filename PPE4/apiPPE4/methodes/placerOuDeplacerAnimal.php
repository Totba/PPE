<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: get");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD']== 'POST') {                               

    include_once '../config/database.php';
    include_once '../models/placement.php';

    $database = new Database();
    $db = $database->getConnection();

    $donnees = json_decode(file_get_contents("php://input"));

    $placement = new Placement($db, $donnees->codeespece, $donnees->nombapteme, $donnees->codeenclos, 1);



    $var = $placement->verifAnimalPlace();
    $vari = $var->fetch(PDO::FETCH_ASSOC);

    if ($vari['nb'] == 0) {

        $stmt = $placement->verifierViabiliteEnclos();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['nb'] == 1) {

            $v = $placement->verifierCohabitation();
            $r = $v->fetch(PDO::FETCH_ASSOC);

            if ($r["nb"] == 0) {

                $req = $placement->isAlreadyPlaceAtTime();
                $res = $req->fetch(PDO::FETCH_ASSOC);

                if ($res['nb'] == 0) {

                    if ($placement->placerAnimal()) {

                        http_response_code(200);
                        echo json_encode(["message" => "L'ajout a été effectué"]);

                    } else {
                        http_response_code(503);
                        echo json_encode(["message" => "L'ajout n'a pas été effectué"]);         
                    }

                } else {
                    if ($placement->updateAlready()) {

                        http_response_code(200);
                        echo json_encode(["message" => "L'ajout a été effectué"]);

                    } else {
                        http_response_code(503);
                        echo json_encode(["message" => "L'ajout n'a pas été effectué"]);         
                    }
                }
                
            } else {
                http_response_code(503);
                echo json_encode(["message" => "Des animaux ne peuvent pas cohabiter"]);         
            }

        } else {
            http_response_code(503);
            echo json_encode(["message" => "L'animal ne peut pas vivre dans l'enclos"]);         
        }

    } else {
        
        $stmt = $placement->verifierViabiliteEnclos();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['nb'] == 1) {

            $v = $placement->verifierCohabitation();
            $r = $v->fetch(PDO::FETCH_ASSOC);

            if ($r["nb"] == 0) {

                $req = $placement->isAlreadyPlaceAtTime();
                $res = $req->fetch(PDO::FETCH_ASSOC);

                if ($res['nb'] == 0) {

                    if ($placement->deplacerAnimal()) {

                        http_response_code(200);
                        echo json_encode(["message" => "Le déplacementent est effectué"]);
                    } else {

                        http_response_code(503);
                        echo json_encode(["message" => "Le déplacement a échoué"]);         
                    }

                } else {
                    if ($placement->updateAlready()) {

                        http_response_code(200);
                        echo json_encode(["message" => "L'ajout a été effectué"]);

                    } else {
                        http_response_code(503);
                        echo json_encode(["message" => "L'ajout n'a pas été effectué"]);         
                    }
                }

            } else {
                http_response_code(503);
                echo json_encode(["message" => "Des animaux ne peuvent pas cohabiter"]);         
            }

        } else {
            http_response_code(503);
            echo json_encode(["message" => "L'animal ne peut pas vivre dans l'enclos"]);         
        }
    }

} else {
    // // On gère l'erreur
	{http_response_code(405);
	echo json_encode(["message" => "La methode n'est pas autorisee"]);
	}
}