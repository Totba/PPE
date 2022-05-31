<link rel="stylesheet" href="util/stylenavbar.css" type="text/css">

<?php 
	require_once("util/Class.pdo.OXAM.inc.php");
?>

<nav class="navbar navbar-expand-lg navbar-light bgcolor">
	<div class="container-fluid">
		<a class="navbar-brand noppading horizontalcenter" href="index.php?uc=accueil">
			<img class="ImageProfilNavbar" src="image/logo.jpg">
		</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item">
					<a class="nav-link active" aria-current="page" href="index.php?uc=accueil">Accueil</a>
				</li>
					<?php if(islogged()) {?>
				<li class="nav-item">
					<a class="nav-link" href="index.php?uc=reserver">Réserver</a>
				</li>
					<?php } ?>
				<li class="nav-item">
					<a class="nav-link" href="index.php?uc=salles">Presentation des salles</a>
				</li>
					<?php if(isAdmin()) { ?>
				<li class="nav-item">
					<a class="nav-link" aria-current="page" href="index.php?uc=reserver&action=voirdemande">Demande en attente</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" aria-current="page" href="index.php?uc=structure">Structure</a>
				</li>
					<?php } 

					if(!islogged()) {?>
				<li class="nav-item">
					<a class="nav-link" href="index.php?uc=connexion">Connexion</a>
				</li>
					<?php } else { ?>
				<li class="nav-item">
					<a class="nav-link" aria-current="page" href="index.php?uc=deco">Deconnexion</a>
				</li>
					<?php } ?>
			</ul>
		</div>
	</div>
</nav>
<br>