<?php
	require("php/menu.php");
 ?>

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="css/general.css">
    <title>Ajouter une annotation</title>
</head>

<body>

<div class="name"> AnnotGenome </div>

<div class="navBar">
	<?php display_menu(); ?>
</div>
<br><br>



<div style="text-align: center;">L'annotation a été enregistrée ! Vous allez être redirigé vers la page du gène.</div>
<?php
	$dbconn = pg_connect("host=localhost dbname=annotgenome user=freaky password=18A1A70oY/84bZG")or die('Connexion impossible : ' . pg_last_error());
	$id = "'".$_GET["id"]."',";
	$gene = "'".$_POST["gene"]."',";
	$bio_gene = "'".$_POST["biot_gene"]."',";
	$biot_trans = "'".$_POST["biot_trans"]."',";
	$symb = "'".$_POST["symb"]."',";
	$descr = "'".$_POST["descr"]."',";
	$string = $id.$gene.$bio_gene.$biot_trans.$symb.$descr."'Pas encore de commentaire'" ;


	$insert = "INSERT INTO annotation VALUES (".$string.");";
	if (pg_query($dbconn, $insert) and pg_query($dbconn, "UPDATE sequence SET status = 'annotated, waiting for validation' WHERE id_sequence = '".$_GET["id"]."';")) {
		echo "<div style=\"text-align: center;\">Les données ont bien été insérées dans la base de données</div>";
	}
	else {
		echo "<div style=\"text-align: center;\">Les données n'ont pas pu être insérées dans la base de données</div>";
	}
	header("refresh:5;url=gene.php?id=".htmlspecialchars($_GET["id"]));

	//pg_free_result($insert);

	pg_close($dbconn);

	?>




</body>

</html>
