<?php
	require("php/menu.php");
 ?>

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="css/general.css">
    <title>Search Results</title>
</head>

<body>

<div class="name"> AnnotGenome </div>

<div class="navBar">
	<?php display_menu(); ?>
</div>

<?php
	//conexion a la bdd :
	$dbconn = pg_connect("host=localhost dbname=annotgenome user=freaky password=")or die('Connexion impossible : ' . pg_last_error());

	$champs = array();
	$valeurs = array();
	$n = 0;

	if (empty($_POST["id"]) == FALSE) {
		if ($_POST["type"] == "genome") {
			#$champs[] = "id_genome";
			#$valeurs[] = $_POST["id"];
			$champs[] = "id_genome = '" . $_POST["id"] . "'";
		}
		else {
			#$champs[] = "id_sequence";
			#$valeurs[] = $_POST["id"];
			$champs[] = "id_sequence = '" . $_POST["id"] . "'";
		}
		$n += 1;
	}
	if (empty($_POST["chromosome"]) == FALSE) {
		#$champs[] = "chromosome";
		#$valeurs[] = $_POST["chromosome"];
		$champs[] = "chromosome = '" . $_POST["chromosome"] . "'";
		$n += 1;
	}
	if ($_POST["type"] == "genome"){
		if (empty($_POST["species_name"]) == FALSE) {
			#$champs[] = "species_name";
			#$valeurs[] = $_POST["species_name"];
			$champs[] = "species_name = '" . $_POST["species_name"] . "'";
			$n += 1;
		}
		if (empty($_POST["strains"]) == FALSE) {
			#$champs[] = "strains";
			#$valeurs[] = $_POST["strains"];
			$champs[] = "strains = '" . $_POST["strains"] . "'";
			$n += 1;
		}
	}
	else {
		if (empty($_POST["sequence_prot"]) == FALSE) {
			#$champs[] = "prot_sequence";
			#$valeurs[] = $_POST["sequence_prot"];
			$champs[] = "prot_sequence LIKE '%" . $_POST["sequence_prot"] . "%'";
			$n += 1;
		}
		if (empty($_POST["start_pos"]) == FALSE) {
			#$champs[] = "start_pos";
			#$valeurs[] = $_POST["start_pos"];
			$champs[] = "start_pos = '" . $_POST["start_pos"] . "'";
			$n += 1;
		}
		if (empty($_POST["end_pos"]) == FALSE) {
			#$champs[] = "end_pos";
			#$valeurs[] = $_POST["end_pos"];
			$champs[] = "end_pos = '" . $_POST["end_pos"] . "'";
			$n += 1;
		}
	}
	if (empty($_POST["sequence_nt"]) == FALSE) {
		if ($_POST["type"] == "genome") {
			#$champs[] = "genome_sequence";
			#$valeurs[] = $_POST["sequence_nt"];
			$champs[] = "genome_sequence LIKE '%" . $_POST["sequence_nt"] . "%'";
		}
		else {
			#$champs[] = "nt_sequence";
			#$valeurs[] = $_POST["sequence_nt"];
			$champs[] = "nt_sequence LIKE '%" . $_POST["sequence_nt"] . "%'";

		}
		$n += 1;
	}


	if ($_POST["type"] == "genome") {
		$select = "id_genome";
		$type = "genome";
	}
	else {
		$select = "id_sequence";
		$type = "gene";
	}

	$where = " WHERE ".$champs[0];
	for ($i=1; $i < $n; $i++) {
		$where .= " AND ".$champs[$i];
	}

	$query = 'SELECT '.$select.' FROM '.$_POST["type"].$where.";";

	$result = pg_query($query) or die('Request fail : ' . pg_last_error());

	echo "<table class=\"table_infos\">";
		echo "<thead>";
			echo "<tr>";
				echo "<th class=\"th_infos\"> Results </th>";
			echo "</tr>";
		echo "</thead>";

	while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
		echo "<tr class=\"tr_infos\">";

    	foreach ($line as $col_value) {

			echo "<td><a href = \"".$type.".php?id=".$col_value."\">$col_value</a></td>";

        }
		echo "</tr>";
    }

	echo "</table>";

	pg_free_result($result);

	pg_close($dbconn);


?>

</body>

</html>
