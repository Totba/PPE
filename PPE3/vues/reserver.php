<link rel="stylesheet" type="text/css" href="util/salle.css">
<h1><center>Reserver salle</center></h1><br>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-0 col-sm-0 col-md-1 col-lg-2"></div>
		<div class="col-xs-12 col-sm-12 col-md-10 col-lg-8">
			<div class="row">
				<?php 
					$Salles = getSalles();
					$a = 0;
					while($a != sizeof($Salles)){
						$idsalle = $Salles[$a]['Id_Salle'];
						$nomsalle = $Salles[$a]['nom_salle'];
						$nomimage = $Salles[$a]['nom_image'];

						echo '
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
					<div class="blockvoirsalle">
						<img class="image" src="image/'.$nomimage.'">
						<span class="nomsalle">
							'.$nomsalle.'
						</span>
						<button class="btnreserver" onclick="window.location=\'index.php?uc=reserver&action=choixreserver&id='.$idsalle.'\';">Choisir</button><br>
					</div>
				</div>
						';

						$a = $a+1;
					}
				?>
			</div>
		</div>
	</div>
</div>
<?php $alignbot = ""; ?>