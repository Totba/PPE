<?php $nomsalle = getNomSalle($_REQUEST['id']) ?>
<h1><center>Reservation <?php echo $nomsalle?></center></h1><br>
<div class="fluid-container">
	<div class="row">
		<div class="col-xs-0 col-sm-0 col-md-3 col-lg-4"></div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
			<form class="form" role="form" action="index.php?uc=reserver&action=choixreservertarif" method="post">
				<input type="number" class="form-control" name="nbpersonne" min="0" max="<?php echo getMaxnbSalle($_REQUEST['id']) ?>" placeholder="Nombre de personne"><br>
				<input type="date" class="form-control" min="<?php echo date('Y-m-j') ?>" name="date" id="date"><br>
				<select class="form-control" name="tranche">
					<option value="" selected disabled>Période</option>
					<?php
						$tranches = getTranches();
						foreach($tranches as $tranche){
							echo '<option value="'.$tranche['Id_Tranche'].'">'.$tranche['nom_tranche'].'</option>';
						}
					?>
				</select><br>
				<select class="form-control" name="salle">
					<?php
						$salles = getSalles();
						foreach($salles as $salle){
							if($salle['Id_Salle']==$_REQUEST['id']) {
								echo '<option value="'.$salle['Id_Salle'].'" selected>'.$salle['nom_salle'].'</option>';
							} else {
								echo '<option value="'.$salle['Id_Salle'].'">'.$salle['nom_salle'].'</option>';
							}
						}
					?>
				</select><br>

				<input type="submit" class="btnall" value="Réservé" name="submit">
			</form>
		</div>
	</div>
</div>
<?php $alignbot = ""; ?>