<?php 
	if(!isset($_SESSION)){
		session_start();
	}

	if(isset($_GET['action'])){
		$action = $_GET['action'];

	} else {
		$action = "inscription";
	}

	if(!islogged()) {
		switch ($action) {
			case 'inscription':
				include("vues/inscription.php");
				break;
			
			case 'comfirminscription':
				if(isset($_POST['mail']) AND isset($_POST['MDP']) AND isset($_POST['Identifiant'])) {
					$mail = htmlspecialchars($_POST['mail']);
					$identifiant = htmlspecialchars($_POST['Identifiant']);
					$mdp = htmlspecialchars($_POST['MDP']);
					if($mail != "" AND $identifiant != "" AND $mdp != ""){
						$ok = Inscription($mail, $identifiant, $mdp);
						if($ok){
							include("vues/accueil.php");
						} else {
							include("vues/inscription.php");
						}
					} else {
						include("vues/inscription.php");
					}
				} else {
					include("vues/inscription.php");
				}

				break;

			default:
				include("vues/inscription.php");
				break;
		}
	} else {
		include("controleur/accueil.php");
	}
?>