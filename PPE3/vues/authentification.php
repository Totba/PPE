<link rel="stylesheet" type="text/css" href="util/authentification.css">
<h1><center>Connexion</center></h1><br>
<form action="index.php?uc=connexion&action=comfirmauthentification" method="post">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-0 col-sm-0 col-md-3 col-lg-4"></div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
				<input type="text" class="form-control" name="Identifiant" placeholder="Identifiant"><br>
				<input type="password" class="form-control" name="MDP" placeholder="Mot de passe"><br>
				<a class="align-right" href="index.php?uc=inscription">Pas de compte ?</a><br><br>
				<input class="btnall" type="submit" value="Connexion">
			</div>
		</div>
	</div>
</form>
<?php $alignbot = ""; ?>