<?php $nomsalle = getNomSalle($_REQUEST['salle']) ?>
<h1><center>Reservation <?php echo $nomsalle?></center></h1><br>
<div class="fluid-container">
	<div class="row">
		<div class="col-xs-0 col-sm-0 col-md-3 col-lg-4"></div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
			<center><h3>Récapitulatif de votre choix</h3></center>
			<table class="tableprix">
				<tr>
					<td class="titre">
						Nb personnes :
					</td>
					<td class="valeur">
						<?php echo $_REQUEST['nbpersonne'] ?>
					</td class="titre">
				</tr>
				<tr>
					<td class="titre">
						Salle :
					</td>
					<td class="valeur">
						<?php echo $nomsalle ?>
					</td>
				</tr>
				<tr>
					<td class="titre">
						Date :
					</td>
					<td class="valeur">
						<?php echo $_REQUEST['date'] ?>
					</td>
				</tr>
				<tr>
					<td class="titre">
						Période :
					</td>
					<td class="valeur">
						<?php echo getnomtranche($_REQUEST['tranche']) ?>
					</td>
				</tr>
				<tr>
					<td class="titre">
						Prix :
					</td>
					<td class="valeur">
						<?php $structure = getStructure();
						echo getTarif($_REQUEST['salle'], $structure['Id_Structure'], $_REQUEST['tranche']) ?>
					</td>
				</tr>
			</table>
			<form class="form" role="form" action="index.php?uc=reserver&action=addreserv" method="post">
				<input type="number" class="form-control" name="nbpersonne" min="0" value="<?php echo $_REQUEST['nbpersonne'] ?>" max="<?php echo getMaxnbSalle($_REQUEST['salle']) ?>" placeholder="Nombre de personne" hidden><br>
				<input type="date" class="form-control" value="<?php echo $_REQUEST['date'] ?>" name="date" id="date" hidden><br>
				<select class="form-control" name="tranche" hidden>
					<?php
						$tranches = getTranches();
						foreach($tranches as $tranche){
							if($tranche['Id_Tranche']==$_REQUEST['tranche']) {
								echo '<option value="'.$tranche['Id_Tranche'].'" selected>'.$tranche['nom_tranche'].'</option>';
							} else {
								echo '<option value="'.$tranche['Id_Tranche'].'">'.$tranche['nom_tranche'].'</option>';
							}
						}
					?>
				</select><br>
				<select class="form-control" name="salle" hidden>
					<?php
						$salles = getSalles();
						foreach($salles as $salle){
							if($salle['Id_Salle']==$_REQUEST['salle']) {
								echo '<option value="'.$salle['Id_Salle'].'" selected>'.$salle['nom_salle'].'</option>';
							} else {
								echo '<option value="'.$salle['Id_Salle'].'">'.$salle['nom_salle'].'</option>';
							}
						}
					?>
				</select><br>

				<input type="submit" class="btnall" value="Valider la réservation" name="submit">
			</form>
		</div>
	</div>
</div>
<?php $alignbot = ""; ?>