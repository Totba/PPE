<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="util/footer.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<body>
	<?php if(isset($alignbot)) {?>
	<section class="footer" style="position: absolute; bottom: 0;">
	<?php } else { ?>
	<section class="footer">
	<?php } ?>
		<div class="social">
			<a href="https://www.instagram.com"><i class="fab fa-instagram"></i></a> <!-- Mettre logo Instagram -->
			<a href="https://twitter.com"><i class="fab fa-twitter"></i></a>
			<a href="https://fr-fr.facebook.com"><i class="fab fa-facebook"></i></a>
		</div>

		<ul class="liste">
			<li>
				<a href="index.php?uc=accueil">Accueil</a>
			</li>
			<?php if(islogged()) {?>
			<li>
				<a href="index.php?uc=reserver">Réserver</a>
			</li>
			<?php } ?>
			<li>
				<a href="index.php?uc=salles">Présentation des salles</a>
			</li>
			<?php if(isAdmin()) { ?>
			<li>
				<a href="index.php?uc=reserver&action=voirdemande">Demande en attente</a>
			</li>
			<li>
				<a href="index.php?uc=structure">Structure</a>
			</li>
			<?php } ?>

			<?php if(!islogged()) {?>
			<li>
				<a href="index.php?uc=connexion">Connexion</a>
			</li>
				<?php } else { ?>
			<li>
				<a href="index.php?uc=deco">Deconnexion</a>
			</li>
			<?php } ?>
		</ul>
		<p class="copyright">
			Oxam @ 2021 
		</p>
	</section>
</body>