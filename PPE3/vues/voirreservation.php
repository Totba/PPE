<link rel="stylesheet" type="text/css" href="util/reservation.css">
<h1><center>Liste des reservations</center></h1><br>
<div class="container">
	<table class="table">
		<tr>
			<th>
				<span class="head">Salle</span>
			</th>
			<th>
				<span class="head">Date</span>
			</th>
			<th>
				<span class="head">Temps</span>
			</th>
			<?php if(isAdmin()) { ?>
			<th>
				
			</th>
			<?php } ?>
		</tr>
		<?php 
			$reservation = getReservations();
			$a = 0;
			while($a != sizeof($reservation)){
				$date = $reservation[$a]['datereserv'];
				$nomsalle = $reservation[$a]['nom_salle'];
				$tranche = $reservation[$a]['nom_tranche'];

				echo '
		<tr>
			<td>
				<span class="content">'.$nomsalle.'</span>
			</td>
			<td>
				<span class="content">'.$date.'</span>
			</td>
			<td>
				<span class="content">'.$tranche.'</span>
			</td>
			';
			if(isAdmin()){
	echo '	<td>
				<button class="btnall btnred" onclick="window.location=\'
						index.php?uc=reserver&action=suppreservation&idsalle='.$reservation[$a]['Id_Salle'].'&iddate='.$reservation[$a]['Id_Date_P'].'&idtranche='.$reservation[$a]['Id_Tranche'].';\';"
						>Supprimer</button>
			</td>';
			}
echo '	</tr>
				';

				$a = $a+1;
			}
		?>
	</table>
	<?php if(isLoggedOk()) {?>
		<button class="btnall" onclick="window.location='index.php?uc=reserver&action=reserver';">Faire une demande</button><br>
	<?php } 

	if(isAdmin()) {?>
		<button class="btnall" onclick="window.location='index.php?uc=reserver&action=voirdemande';">Voir les demandes </button><br>
	<?php } ?>
</div>
<?php $alignbot = ""; ?>
