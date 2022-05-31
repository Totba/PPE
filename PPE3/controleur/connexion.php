<?php 
	if(!isset($_SESSION)){
		session_start();
	}

	if(isset($_GET['action'])){
		$action = $_GET['action'];

	} else {
		$action = "authentification";
	}

	if(!islogged()) {
		switch ($action) {
			case 'authentification':
				include("vues/authentification.php");
				break;
			
			case 'comfirmauthentification':
				if(isset($_POST['Identifiant']) AND isset($_POST['MDP'])) {
					$identifiant = htmlspecialchars($_POST['Identifiant']);
					$mdp = htmlspecialchars($_POST['MDP']);
					if($identifiant != "" AND $mdp != "") {
						$try = login($identifiant, $mdp);
						if($try) {
							include("vues/accueil.php");
						} else {
							include("vues/authentification.php");
						}
					} else {
						include("vues/authentification.php");
					}
				} else {
					include("vues/authentification.php");
				}

				break;

			default:
				include("vues/authentification.php");
				break;
		}
	} else {
		include("controleur/accueil.php");
	}
?>