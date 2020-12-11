<?php
	require("php/menu.php");
 ?>

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="css/general.css">
    <title>Add an Annotation</title>
</head>

<body>

<div class="name"> AnnotGenome </div>

<div class="navBar">
	<?php display_menu(); ?>
</div>
<br><br>


<?php
	$dbconn = pg_connect("host=localhost dbname=annotgenome user=freaky password=")or die('Connexion impossible : ' . pg_last_error());
	$id = "'".$_GET["id"]."',";
	$strand = "'".$_POST["strand"]."'";
	$gene = "'".$_POST["gene"]."',";
	$bio_gene = "'".$_POST["biot_gene"]."',";
	$biot_trans = "'".$_POST["biot_trans"]."',";
	$symb = "'".$_POST["symb"]."',";
	$descr = "'".$_POST["descr"]."',";
	$string = $id.$strand.$gene.$bio_gene.$biot_trans.$symb.$descr."'No comment'" ;


	$insert = "INSERT INTO annotation VALUES (".$string.");";
	if (pg_query($dbconn, $insert) and pg_query($dbconn, "UPDATE sequence SET status = 'annotated, waiting for validation' WHERE id_sequence = '".$_GET["id"]."';")) {
		echo "<div style=\"text-align: center;\">The annotation was added successfuly ! You will be redirected to the gene page.</div>";
	}
	else {
		echo "<div style=\"text-align: center;\">The annotation couldn't be added successfuly. You will be redirected to the gene page.</div>";
	}
	header("refresh:5;url=gene.php?id=".htmlspecialchars($_GET["id"]));

	pg_close($dbconn);

	?>




</body>

</html>
