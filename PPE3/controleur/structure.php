<?php 

	if(isset($_GET['action'])){
		$action = $_GET['action'];

	} else {
		$action = "voirStructure";
	}

    if(isAdmin())
    {
	switch ($action) {
		case 'voirstructure':
			include("vues/voirStructure.php");
			break;
			
		case 'ajoutStructure':
			include("vues/ajoutStructure.php");
			break;
			
		case 'ajoutstructureconfirm':
			addStructure($_POST['nomStructure'], $_POST['IBAN'], $_POST['profil'], $_POST['Type_Structure']);
			include("vues/voirStructure.php");
			break;
		
		case 'modifStructure':
			include("vues/modifStructure.php");
			break;

		case 'verifModifStructure':
			modifStructure($_POST['id_structure'], $_POST['nomStructure'], $_POST['IBAN'], $_POST['profil'], $_POST['Type_Structure']);
			include("vues/voirStructure.php");
			break;
				
		case 'delStructure':
			delStructure($_REQUEST['id_structure']);
			include("vues/voirStructure.php");
			break;
			

		default:
			include("vues/voirStructure.php");
			break;
	}
}
    else
    {
        header('index.php');
    }
?>