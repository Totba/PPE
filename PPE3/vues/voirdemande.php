<link rel="stylesheet" type="text/css" href="util/reservation.css">
<h1><center>Liste des Demandes</center></h1><br>
<div class="container">
	<table class="table">
		<tr>
			<th>
				<span class="head">Structure</span>
			</th>
			<th>
				<span class="head">Salle</span>
			</th>
			<th>
				<span class="head">Date</span>
			</th>
			<th>
				<span class="head">Periode</span>
			</th>
			<th>
				<span class="head">Nb Personne</span>
			</th>
			<th>
				
			</th>
		</tr>
		<?php 
			$demandes = getDemandes();
			$a = 0;
			while($a != sizeof($demandes)){
				$nbprs = $demandes[$a]['nb_personne'];
				$date = $demandes[$a]['date_resa'];
				$nom = $demandes[$a]['nom'];
				$periode = $demandes[$a]['nom_tranche'];
				$salle = $demandes[$a]['nom_salle'];

				echo '
		<tr>
			<td class="content">
				<span class="content">'.$nbprs.'</span>
			</td>
			<td class="content">
				<span class="content">'.$salle.'</span>
			</td>
			<td class="content">
				<span class="content">'.$date.'</span>
			</td>
			<td class="content">
				<span class="content">'.$periode.'</span>
			</td>
			<td class="content">
				<span class="content">'.$nom.'</span>
			</td>
			<td class="btninline">
				<button class="btnall btngreen" onclick="window.location=\'index.php?uc=reserver&action=validdemande&Id_Demande='.$demandes[$a]['Id_Demande'].'\';">Valider</button>

				<button class="btnall btnred" onclick="window.location=\'index.php?uc=reserver&action=suppdemande&Id_Demande='.$demandes[$a]['Id_Demande'].'\';">Supprimer</button>
			</td>
		</tr>
				';

				$a = $a+1;
			}
		?>
	</table>
	<?php if(isLoggedOk()) {?>
		<button class="btnall" onclick="window.location='index.php?uc=reserver&action=voirreservation';">Voir les reservations</button>
	<?php } ?>
</div>
<?php $alignbot = ""; ?>
