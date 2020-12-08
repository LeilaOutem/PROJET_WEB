<?php
	require("php/menu.php");
 ?>

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="css/general.css">
    <title>Formulaire de recherche</title>
</head>

<body>

<div class="name"> AnnotGenome </div>

<div class="navBar">
	<?php display_menu(); ?>
</div>



<form class="searchForm" action="results.php" method="post">
	<div class="champ">
    	<label class="input">idGenome / idGene :</label>
		<input class="input" type="text" name = "id"><br><br>
	</div>
	<div class="champ">
		<label class="input">Chromosome :</label>
		<input type="text" name = "chromosome"><br><br>
	</div>
	<div class="champ">
		<label class="input">Nom de l'espece : </label>
		<input type="text" name = "species_name"><br><br>
	</div>
	<div class="champ">
		<label class="input">Strain : </label>
		<input type="text" name = "strain"><br><br>
	</div>
	<div class="champ">
		<label class="input">Sequence nucleotides: </label>
		<input type="text" name = "sequence_nt"><br><br>
	</div>
	<div class="champ">
		<label class="input">Sequence protéique : </label>
		<input type="text" name = "sequence_prot"><br><br>
	</div>
	<div class="champ">
		<label class="input">Position de début : </label>
		<input type="text" name = "start_pos"><br><br>
	</div>
	<div class="champ">
		<label class="input">Position de fin : </label>
		<input type="text" name = "end_pos"><br><br>
	</div>
	<div class="champ">
		<label class="input">Genome ou Gene : </label>
		genome :
		<input type="radio" name="type" value="genome">
		gene :
		<input type="radio" name="type" value="sequence">
	</div><br>
	<div class="champ">
    	<input type="submit" value="Recherche">
	</div>
</form>
<br>

</body>

</html>
