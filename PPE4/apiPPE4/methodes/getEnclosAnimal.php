<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD']== 'POST') {	

	// On inclut les fichiers de configuration et d'accès aux données
	include_once '../config/database.php';
	include_once '../models/animaux.php';

    $donnees = json_decode(file_get_contents("php://input"));

	$database = new Database();
	$db = $database->getConnection();

	$animaux = new Animaux($db);

	if(isset($donnees->codeespece) && isset($donnees->nombapteme)) {

        $tableau = [];

        $animaux->codeespece = $donnees->codeespece;
        $animaux->nombapteme = $donnees->nombapteme;

        $stmt = $animaux->getenclos();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $tableau = ["codeenclos" => $row["codeenclos"],
        				"nomenclos" => $row["nomenclos"]];
        }
		http_response_code(200);
		echo json_encode($tableau);

	} else {
		http_response_code(405);
		echo json_encode(array("message" => "La methode n'est pas autorisee"));
	}

} else {
	http_response_code(405);
	echo json_encode(array("message" => "La methode n'est pas autorisee"));
}
?>