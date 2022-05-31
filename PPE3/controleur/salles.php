<?php 
	if(!isset($_SESSION)){
		session_start();
	}

	if(isset($_GET['action'])){
		$action = $_GET['action'];

	} else {
		$action = "voirsalles";
	}

	switch ($action) {
		case 'voirsalles':
			include("vues/voirSalle.php");
			break;
			
		case 'voirsalle':
			include("vues/salle.php");
			break;
			
		case 'Modifsupp':
			$salle = getSalle($_REQUEST['id']);
			include("vues/modifsalle.php");
			break;
			
		case 'Supp':
			delSalle($_REQUEST['id']);
			include("vues/voirSalle.php");
			break;
			
			
		case 'ajoutsalle':
			include("vues/ajoutsalle.php");
			break;
			
		case 'ajoutsalleconfirm':
			if (testimagevalide($_FILES['img'])) {
				$wesh = addSalle($_POST['nomsalle'], $_POST['description'], $_FILES['img']["name"], $_POST['categorie']);
				include("vues/voirsalle.php");
			} else {
				include("vues/ajoutsalle.php");
			}
			break;
			
		case 'modifsalleconfirm':
			if($_FILES['iimg']["name"] != "") {
				$insertimage = testimagevalide($_FILES['iimg']);
				$wesh = modifSalle($_POST['idsalle'], $_POST['nomsalle'], $_POST['description'], $_POST['categorie'], $_FILES['iimg']["name"]);
			} else {	
				$wesh = modifSalle($_POST['idsalle'], $_POST['nomsalle'], $_POST['description'], $_POST['categorie']);
			}
			include("vues/voirsalle.php");
			break;
			
		default:
			include("vues/voirsalle.php");
			break;
	}
?>