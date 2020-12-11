<?php
	require("php/menu.php");
 ?>

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="css/general.css">
    <title>Search Form</title>
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
		<label class="input">species Name : </label>
		<input type="text" name = "species_name"><br><br>
	</div>
	<div class="champ">
		<label class="input">Strain : </label>
		<input type="text" name = "strain"><br><br>
	</div>
	<div class="champ">
		<label class="input">Nucleotides sequence : </label>
		<input type="text" name = "sequence_nt"><br><br>
	</div>
	<div class="champ">
		<label class="input">Protein sequence : </label>
		<input type="text" name = "sequence_prot"><br><br>
	</div>
	<div class="champ">
		<label class="input">Start position : </label>
		<input type="text" name = "start_pos"><br><br>
	</div>
	<div class="champ">
		<label class="input">End position : </label>
		<input type="text" name = "end_pos"><br><br>
	</div>
	<div class="champ">
		<label class="input">Genome or Gene : </label>
		genome :
		<input type="radio" name="type" value="genome">
		gene :
		<input type="radio" name="type" value="sequence">
	</div><br>
	<div class="champ">
    	<input type="submit" value="Search">
	</div>
</form>
<br>

</body>

</html>
