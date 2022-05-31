<?php 
	if(!isset($_SESSION)){
		session_start();
	}

	if(isset($_GET['action'])){
		$action = $_GET['action'];

	} else {
		$action = "voirreservation";
	}

	switch ($action) {
		case 'voirreservation':
			include("vues/voirreservation.php");
			break;

		case 'voirdemande':
			include("vues/voirdemande.php");
			break;
			
		case 'reserver':
			include("vues/reserver.php");
			break;
			
		case 'choixreserver':
			if(isset($_REQUEST['id'])){	
				include("vues/addreservation.php");
			} else {
				include("vues/reserver.php");
			}
			break;
			
		case 'choixreservertarif':
				include("vues/addreservationverifprix.php");
			break;

		case 'addreserv':
			if(isset($_REQUEST['nbpersonne']) AND isset($_REQUEST['date']) AND isset($_REQUEST['tranche']) AND isset($_REQUEST['salle'])) {
				$structure = getStructure();
				$res = adddemande($_REQUEST['nbpersonne'], $_REQUEST['date'], $structure['Id_Structure'], $_REQUEST['tranche'], $_REQUEST['salle']);
				include("vues/voirreservation.php");
			} else {
				include("vues/reserver.php");
			}
			break;
			
		case 'suppreserv':
			if(isset($_REQUEST['idsalle']) AND isset($_REQUEST['iddate']) AND isset($_REQUEST['idtranche'])) {
				$idsalle = $_REQUEST['idsalle'];
				$iddate = $_REQUEST['iddate'];
				$idtranche = $_REQUEST['idtranche'];
				suppReservation($idtranche, $idsalle, $iddate);
			}
			include("vues/voirreservation.php");
			break;

		case 'suppdemande':
			SuppDemande($_REQUEST['Id_Demande']);
			include("vues/voirdemande.php");
			break;

		case 'validdemande':
			ValidDemandedate($_REQUEST['Id_Demande']);
			ValidDemandereserv($_REQUEST['Id_Demande']);
			include("vues/voirreservation.php");
			break;

		default:
			include("vues/voirreservation.php");
			break;
	}
?>