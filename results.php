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

	if (empty($_POST["idGenome"]) == FALSE) {
		$champs[] = "idGenome";
		$valeurs[] = $_POST["idGenome"];
		$n += 1;
	}
	if (empty($_POST["geneBiotype"]) == FALSE) {
		$champs[] = "geneBiotype";
		$valeurs[] = $_POST["geneBiotype"];
		$n += 1;
	}
	if (empty($_POST["geneName"]) == FALSE) {
		$champs[] = "geneName";
		$valeurs[] = $_POST["geneName"];
		$n += 1;
	}
	if (empty($_POST["transcript_biotype"]) == FALSE) {
		$champs[] = "transcript_biotype";
		$valeurs[] = $_POST["transcript_biotype"];
		$n += 1;
	}
	if (empty($_POST["geneSymbol"]) == FALSE) {
		$champs[] = "geneSymbol";
		$valeurs[] = $_POST["geneSymbol"];
		$n += 1;
	}
	if (empty($_POST["pos"]) == FALSE) {
		$champs[] = "pos";
		$valeurs[] = $_POST["pos"];
		$n += 1;
	}

	$select = implode(",", $champs);
	$where = " WHERE ".$champs[0]." = ".$valeurs[0];
	for ($i=1; $i < $n; $i++) {
		$where .= " AND ".$champs[$i]." = ".$valeurs[$i];
	}

	$query = 'SELECT '.$select.' FROM '.$where.";";
	echo $query;

	//$result = pg_query($query) or die('Échec de la requête : ' . pg_last_error());

	//while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {

    //	foreach ($line as $col_value) {
    //    }
    //}

	//pg_free_result($result);

	//pg_close($dbconn);




?>

</body>

</html>
