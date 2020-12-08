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
	//connexion a la bdd : $dbconn = pg_connect("host=localhost dbname=publishing user=www password=foo")or die('Connexion impossible : ' . pg_last_error());

	//$dbconn = pg_connect("host=ipadress port=5433 dbname=publishing user=user password=password")
    	//or die('Connexion impossible : ' . pg_last_error());

	$champs = array();
	$valeurs = array();
	$n = 0;

	if (empty($_POST["id"]) == FALSE) {
		if ($_POST["type"] == "genome") {
			$champs[] = "id_genome";
			$valeurs[] = $_POST["id"];
		}
		else {
			$champs[] = "id_sequence";
			$valeurs[] = $_POST["id"];
		}
		$n += 1;
	}
	if (empty($_POST["chromosome"]) == FALSE) {
		$champs[] = "chromosome";
		$valeurs[] = $_POST["chromosome"];
		$n += 1;
	}
	if ($_POST["type"] == "genome"){
		if (empty($_POST["species_name"]) == FALSE) {
			$champs[] = "species_name";
			$valeurs[] = $_POST["species_name"];
			$n += 1;
		}
		if (empty($_POST["strains"]) == FALSE) {
			$champs[] = "strains";
			$valeurs[] = $_POST["strains"];
			$n += 1;
		}
	}
	else {
		if (empty($_POST["sequence_prot"]) == FALSE) {
			$champs[] = "prot_sequence";
			$valeurs[] = $_POST["sequence_prot"];
			$n += 1;
		}
		if (empty($_POST["start_pos"]) == FALSE) {
			$champs[] = "start_pos";
			$valeurs[] = $_POST["start_pos"];
			$n += 1;
		}
		if (empty($_POST["end_pos"]) == FALSE) {
			$champs[] = "end_pos";
			$valeurs[] = $_POST["end_pos"];
			$n += 1;
		}
	}
	if (empty($_POST["sequence_nt"]) == FALSE) {
		if ($_POST["type"] == "genome") {
			$champs[] = "genome_sequence";
			$valeurs[] = $_POST["sequence_nt"];
		}
		else {
			$champs[] = "nt_sequence";
			$valeurs[] = $_POST["sequence_nt"];
		}
		$n += 1;
	}



	$select = implode(",", $champs);
	$where = " WHERE ".$champs[0]." = ".$valeurs[0];
	for ($i=1; $i < $n; $i++) {
		$where .= " AND ".$champs[$i]." = ".$valeurs[$i];
	}

	$query = 'SELECT '.$select.' FROM '.$_POST["type"].$where.";";
	echo $query;

	//$result = pg_query($query) or die('Échec de la requête : ' . pg_last_error());

	echo "<table>";
		echo "<thead>";
			echo "<tr>";
				echo "<th> Resultats </th>";
			echo "</tr>";
		echo "</thead>";
	//echo "<tr>";
	//while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
	//
    //	foreach ($line as $col_value) {
	//
	//		echo "<td><a href = \"genome.php?id=".$col_value[0]."\">$col_value[0]</a></td>";
	//
    //    }
	//
    //}
	//echo "</tr>";
	echo "</table>";

	//pg_free_result($result);

	//pg_close($dbconn);
	$test = 304;
	echo "<a href = \"genome.php?id=".$test."\">888</a>";


?>

</body>

</html>
