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
	include_once '../models/enclos.php';
	include_once '../models/espece.php';

	$database = new Database();
	$db = $database->getConnection();

	$enclos = new Enclos($db);

	$espece = new Espece($db);

	$donnees = json_decode(file_get_contents("php://input"));

    $espece->codeespece = $donnees->codeespece;

	$stmt = $espece->getEnclosPourEspece();

	if(isset($donnees->codeespece)) {
		if($stmt->rowCount() > 0) {

			$list = [];

			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				extract($row);
				$enclos->codeenclos = $row["codeenclos"];

				$stmt2 = $enclos->getListEspeceEnclos();
				
				$ok = true;

				if($stmt2->rowCount() > 0) {

					while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
						if($ok) {
							extract($row2);
							$ok = $espece->getpeutCohabiter($row2["codeespece"]);
						}
					}
				}
				
				if($ok) {
					$v = $enclos->getNbAnimauxEnclos();
					$r = $v->fetch(PDO::FETCH_ASSOC);

					$ok = [
						'id' => $enclos->codeenclos,
						'nom' => $row['nom'],
						'superficie' => $row['superficie'],
						'nb' => $r['nb']
					];
					$list[] = $ok;
				}
			}

			http_response_code(200);
			echo json_encode($list);

		} else {
			http_response_code(405);
			echo json_encode(array("message" => "Il n'y a pas d'enclos"));
		}

	} else {
		http_response_code(405);
		echo json_encode(array("message" => "La methode n'est pas autorisee"));
	}

} else {
	http_response_code(405);
	echo json_encode(array("message" => "La methode n'est pas autorisee"));
}
?>