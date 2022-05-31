
<h1><center>Voir structure</center></h1><br>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-0 col-sm-0 col-md-1 col-lg-2"></div>
		<div class="col-xs-12 col-sm-12 col-md-10 col-lg-8">
			<div class="row">
				<?php 
					$Structures = getAllStructure();
					$a = 0;
					while($a != sizeof($Structures)){
						$id_structure=$Structures[$a]['Id_Structure'];
						$nomStructure = $Structures[$a]['nom'];
						$IBANstructure = $Structures[$a]['IBAN'];
                        $profilStructure = $Structures[$a]['profil'];
						$Id_Type_Structure = $Structures[$a]['Id_Type_structure'];
						$type_structure = typeStructure($Id_Type_Structure);
						$nom_type_structure = $type_structure['nom_type_structure'];
						echo '
		<tr>
			<td class="content">
				<span class="content">'.$nomStructure.'</span>
			</td>
			<td class="content">
				<span class="content">'.$profilStructure.'</span>
			</td>
			<td class="content">
				<span class="content">'.$IBANstructure.'</span>
			</td>
			<td class="content">
				<span class="content">'.$nom_type_structure.'</span>
			</td>
			<td class="btninline">
			<button class="btnall btngreen" onclick="window.location=\'index.php?uc=structure&action=modifStructure&id_structure='.$Structures[$a]['Id_Structure'].'\';">Modifier</button>
			</td>
			<td class="btninline">
			<button class="btnall btngreen" onclick="window.location=\'index.php?uc=structure&action=delStructure&id_structure='.$Structures[$a]['Id_Structure'].'\';">Supprimer</button>
			</td>
		</tr>
				';

						$a = $a+1;
					}
				?>
			</div>
		</div>
	</div><br>
	<?php if(isAdmin()){ ?>
		<center><input type="submit" class="btnall" value="Ajout Structure" name="addstructure" onclick="window.location='index.php?uc=structure&action=ajoutStructure'"></center>
	<?php } ?>
	<br>
</div>