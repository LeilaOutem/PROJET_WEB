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

<?php
	if (empty($_POST["idGenome"]) == FALSE) {
		echo $_POST["idGenome"]."<br>";
	}
	if (empty($_POST["geneBiotype"]) == FALSE) {
		echo $_POST["geneBiotype"]."<br>";
	}
	if (empty($_POST["geneName"]) == FALSE) {
		echo $_POST["geneName"]."<br>";
	}
	if (empty($_POST["transcript_biotype"]) == FALSE) {
		echo $_POST["transcript_biotype"]."<br>";
	}
	if (empty($_POST["geneSymbol"]) == FALSE) {
		echo $_POST["geneSymbol"]."<br>";
	}
	if (empty($_POST["pos"]) == FALSE) {
		echo $_POST["pos"]."<br>";
	}




?>

</body>

</html>
