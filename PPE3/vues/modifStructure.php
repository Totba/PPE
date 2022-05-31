
<h1><center>Modifié structure</center></h1><br>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-0 col-sm-0 col-md-1 col-lg-2"></div>
		<div class="col-xs-12 col-sm-12 col-md-10 col-lg-8">
			<div class="row">
				<?php 
					$id_structure = $_GET['id_structure'];
					$Structure = recupStructure($id_structure);
					$nomStructure = $Structure['nom'];
					$IBANstructure = $Structure['IBAN'];
					$profilStructure = $Structure['profil'];
					$Id_Type_Structure = $Structure['Id_Type_structure'];
					$type_structure = typeStructure($Id_Type_Structure);
					$nom_type_structure = $type_structure['nom_type_structure'];
                ?>
				<form class="form" role="form" action="index.php?uc=structure&action=verifModifStructure" method="post"  enctype="multipart/form-data">

				<input type="text" class="form-control" name="nomStructure" value="<?php echo $nomStructure ?>"><br>
				<input type="textarea" class="form-control" name="IBAN" value="<?php echo $IBANstructure ?>"><br>
				<input type="textarea" class="form-control" name="profil" value="<?php echo $profilStructure ?>"><br>
				<select class="form-control" name="Type_Structure">
					<?php
						$typeStructure = allTypesStructure();
						foreach($typeStructure as $typeStructure){
							if($typeStructure['Id_Type_structure']==$Id_Type_Structure) {
								echo '<option value="'.$typeStructure['Id_Type_structure'].'" selected>'.$typeStructure['nom_type_structure'].'</option>';
							} else {
								echo '<option value="'.$typeStructure['Id_Type_structure'].'">'.$typeStructure['nom_type_structure'].'</option>';
							}
						}
					?>
				</select><br>

				<input type="hidden" name='id_structure' value="<?php echo $id_structure ?>">

				<?php if(isAdmin()){ ?>
		<center><input type="submit" class="btnall" value="Modifier Structure" name="modifstructure" onclick="window.location='index.php?uc=structure&action=verifModifStructure'"></center>
	<?php } ?>
				</form>
				
			</div>
		</div>
	</div><br>
	<br>
</div>
<?php $alignbot = ""; ?>