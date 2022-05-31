<link rel="stylesheet" type="text/css" href="util/authentification.css">
<h1><center>Inscription</center></h1><br>
<form action="index.php?uc=inscription&action=comfirminscription" method="post">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-0 col-sm-0 col-md-3 col-lg-4"></div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
				<input type="text" class="form-control" name="mail" placeholder="Mail"><br>
				<input type="text" class="form-control" name="Identifiant" placeholder="Identifiant"><br>
				<input type="password" class="form-control" name="MDP" placeholder="Mot de passe"><br>
				<a class="align-right" href="index.php?uc=connexion">Déja un compte ?</a><br><br>
				<input class="btnall" type="submit" value="Inscription">
			</div>
		</div>
	</div>
</form>
<?php $alignbot = ""; ?>