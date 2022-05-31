<h1><center>Ajout d'une salle</center></h1><br>
<div class="fluid-container">
	<div class="row">
		<div class="col-xs-0 col-sm-0 col-md-3 col-lg-4"></div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
			<form class="form" role="form" action="index.php?uc=salles&action=ajoutsalleconfirm" method="post"  enctype="multipart/form-data">
				
				<input type="text" class="form-control" name="nomsalle" placeholder="Nom de la salle"><br>
				<input type="textarea" class="form-control" name="description" placeholder="Description"><br>
				<select class="form-control" name="categorie">
					<option value="" selected disabled>Catégorie</option>
					<?php
						$categories = getCategorie();
						foreach($categories as $categorie){
							echo '<option value="'.$categorie['Id_Categorie'].'">'.$categorie['nom_categorie'].'</option>';
						}
					?>
				</select><br>
				<span>Image de la salle</span>
				<input type="file" class="form-control" name="img" id="img"  accept="image/*"><br>

				<input type="submit" class="btnall" value="Ajout de la Salle" name="submit">
			</form>
		</div>
	</div>
</div>
<?php $alignbot = ""; ?>