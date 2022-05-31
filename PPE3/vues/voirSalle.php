<link rel="stylesheet" type="text/css" href="util/salle.css">
<h1><center>Voir salle</center></h1><br>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-0 col-sm-0 col-md-1 col-lg-2"></div>
		<div class="col-xs-12 col-sm-12 col-md-10 col-lg-8">
			<div class="row">
				<?php 
					$Salles = getSalles();
					$a = 0;
					while($a != sizeof($Salles)){
						$nomsalle = $Salles[$a]['nom_salle'];
						$nomimage = $Salles[$a]['nom_image'];
						$idsalle = $Salles[$a]['Id_Salle'];
						$nomcate = $Salles[$a]['nom_categorie'];

						echo '
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
						<div class="blockvoisalle" onclick="window.location=\'index.php?uc=salles&action=voirsalle&id='.$idsalle.'\'" style="cursor: pointer">
							<img class="image" src="image/'.$nomimage.'">
							<center><h3>'.$nomsalle.'</h3><h6>'.$nomcate.'</h6></center>
						</div>
					</div>
						';

						$a = $a+1;
					}
				?>
			</div>
		</div>
	</div><br>
	<?php if(isAdmin()){ ?>
		<center><input type="submit" class="btnall" value="Ajout Salle" name="addsalle" onclick="window.location='index.php?uc=salles&action=ajoutsalle'"></center>
	<?php } ?>
	<br>
</div>
<?php $alignbot = ""; ?>