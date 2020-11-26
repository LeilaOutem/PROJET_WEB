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
    	<label class="input">idGenome :</label>
		<input class="input" type="text" name = "idGenome"><br><br>
	</div>
	<div class="champ">
		<label class="input">Biotype du gene :</label>
		<input type="text" name = "geneBiotype"><br><br>
	</div>
	<div class="champ">
		<label class="input">geneName : </label>
		<input type="text" name = "geneName"><br><br>
	</div>
	<div class="champ">
		<label class="input">Biotype du transcrit : </label>
		<input type="text" name = "transcript_biotype"><br><br>
	</div>
	<div class="champ">
		<label class="input">Symbole du gene : </label>
		<input type="text" name = "geneSymbol"><br><br>
	</div>
	<div class="champ">
		<label class="input">Position : </label>
		<input type="text" name = "pos"><br><br>
	</div>
	<div class="champ">
    	<input type="submit" value="Recherche">
	</div>
</form>
<br>

</body>

</html>
