<?php
	$salle = getSalle($_REQUEST['id']);
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-0 col-sm-0 col-md-1 col-lg-2"></div>
		<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
			<img src="image/<?php echo $salle['nom_image'] ?>" style="width: 100%; height: auto;"><br><br>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
			<h2 style="text-align: center;"><?php echo $salle['nom_salle'] ?></h2><br><br>

			<p><?php echo $salle['description'] ?></p><br>

		</div>

		<div class="col-xs-0 col-sm-0 col-md-1 col-lg-2"></div>
		<div class="col-xs-0 col-sm-0 col-md-1 col-lg-2"></div>

		<?php if(isLoggedOk()) {?>
			<button class="btnall" onclick="window.location='index.php?uc=reserver&action=choixreserver&id=<?php echo $salle['Id_Salle'] ?>';">Reservé</button><br>
		<?php } ?>
		
		<?php if(isAdmin()) {?>
			<button class="btnall" onclick="window.location='index.php?uc=salles&action=Modifsupp&id=<?php echo $salle['Id_Salle'] ?>';">Modifier/Supprimer</button><br>
		<?php } ?>

		<div class="col-xs-0 col-sm-0 col-md-1 col-lg-2"></div>
	</div>
</div>
<?php $alignbot = ""; ?>