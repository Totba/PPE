<h1><center>Ajout d'une structure</center></h1><br>
<div class="fluid-container">
	<div class="row">
		<div class="col-xs-0 col-sm-0 col-md-3 col-lg-4"></div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
			<form class="form" role="form" action="index.php?uc=structure&action=ajoutstructureconfirm" method="post"  enctype="multipart/form-data">

				<input type="text" class="form-control" name="nomStructure" placeholder="Nom de la structure"><br>
				<input type="textarea" class="form-control" name="IBAN" placeholder="Entré votre IBAN"><br>
				<input type="textarea" class="form-control" name="profil" placeholder="Profil"><br>
				<select class="form-control" name="Type_Structure">
					<option value="" selected disabled>Choisissez votre type de structure</option>
					<?php
						$typeStructure = allTypesStructure();
						foreach($typeStructure as $typeStructure){
							echo '<option value="'.$typeStructure['Id_Type_structure'].'">'.$typeStructure['nom_type_structure'].'</option>';
						}
					?>
				</select><br>

				<input type="submit" class="btnall" value="Ajout de la Structure" name="submit" >
			</form>
		</div>
	</div>
</div>
<?php $alignbot = ""; ?>