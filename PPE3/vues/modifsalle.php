<h1><center>Modification de la salle<br><?php echo $salle['nom_salle'] ?></center></h1><br>
<div class="fluid-container">
	<form class="form" role="form" action="index.php?uc=salles&action=modifsalleconfirm" method="post"  enctype="multipart/form-data">
		<div class="row">
			<div class="col-xs-0 col-sm-0 col-md-3 col-lg-4"></div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
				<input type="text" value="<?php echo $salle['Id_Salle'] ?>" name="idsalle" hidden>

				<input type="text" class="form-control" name="nomsalle" value="<?php echo $salle['nom_salle'] ?>" placeholder="Nom de la salle"><br>
				<input type="textarea" class="form-control" name="description" value="<?php echo $salle['description'] ?>" placeholder="Description"><br>
				<select class="form-control" name="categorie">
					<?php
						$categories = getCategorie();
						foreach($categories as $categorie){
							if($categorie['Id_Categorie']==$salle['Id_Categorie']) {
								echo '<option value="'.$categorie['Id_Categorie'].'" selected>'.$categorie['nom_categorie'].'</option>';
							} else {
								echo '<option value="'.$categorie['Id_Categorie'].'">'.$categorie['nom_categorie'].'</option>';
							}
						}
					?>
				</select><br>
				<span>Image de la salle</span>
				<div class="row"  for="iimg">
					<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
						<img src="image/<?php echo $salle['nom_image'] ?>" id="img" style="max-width: 100%; height: 100px; width: auto;">
					</div>
					<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
						<input type="file" class="form-control" name="iimg" id="iimg"  accept="image/*" onchange="previewPicture(this)">
					</div>
				</div><br>
			</div>
			<div class="col-xs-0 col-sm-0 col-md-3 col-lg-4"></div>
			<div class="col-xs-0 col-sm-0 col-md-2 col-lg-3"></div>
			<input type="reset" class="btnall" value="Retour" onclick="window.location='index.php?uc=salles&action=voirsalle&id=<?php echo $salle['Id_Salle'] ?>'">
			<input type="submit" class="btnall" value="Valider modification" name="submit">
			<div class="col-xs-0 col-sm-0 col-md-2 col-lg-3"></div>
		</div>
	</form><br>
	<input type="submit" class="btnall" value="Suppression de la Salle" onclick="window.location='index.php?uc=salles&action=Supp&id=<?php echo $salle["Id_Salle"] ?>'"><br>
</div>
<script type="text/javascript">
	var image = document.getElementById("img");

		// La fonction previewPicture
		var previewPicture  = function (e) {

			// e.files contient un objet FileList
			const [picture] = e.files

			// "picture" est un objet File
			if (picture) {
				// On change l\'URL de l\'image
				image.src = URL.createObjectURL(picture)
			}
		}
</script>