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
	$list_infos_sequence = ["id de la séquence","Séquence nucléotidique", "Séquence protéique",
					"Chromosome", "Position de départ", "Position de fin", "Longueur de la séquence", "Génome", "Statut"];
	//connexion a la bdd : $dbconn = pg_connect("host=localhost dbname=publishing user=www password=foo")or die('Connexion impossible : ' . pg_last_error());

	//$dbconn = pg_connect("host=ipadress port=5433 dbname=publishing user=user password=password")
    	//or die('Connexion impossible : ' . pg_last_error());
	$query = "SELECT * FROM sequence WHERE id_sequence = ". htmlspecialchars($_GET["id"]). ";";

	//$result = pg_query($query) or die('Échec de la requête : ' . pg_last_error());
	//$line = pg_fetch_array($result, null, PGSQL_ASSOC);
	//if ($line[7] != "not annotated" or $line[7] != "waiting for annotation") {
		$query_annot = "SELECT * FROM annotation WHERE id_sequence = ". htmlspecialchars($_GET["id"]). ";";
		$list_infos_annotation = ["id de la séquence", "Nom du gène", "Biotype", "Biotype du transcrit", "Symbole du gène",
								"Description", "Commentaire du validateur"];
		//$result_annot = pg_query($query_annot) or die('Échec de la requête : ' . pg_last_error());
		//$line_annot = pg_fetch_array($result_annot, null, PGSQL_ASSOC);
		//if ($line[7] == "validated") {
		//	echo "validated";
		//}
		//else {
		//	echo "not validated";
		//}
	//}

?>

		<table class="table_infos">
			<tr>
				<th class="th_infos" colspan="2"> <?php echo htmlspecialchars($_GET["id"]); ?> </th>
			</tr>


			<?php
				for ($i = 1; $i < 9; $i++) {
					echo "<tr class=\"tr_infos\"><td class=\"td_infos\">".$list_infos_sequence[$i]."</td><td class=\"td_infos\"> test </td></tr>";

				};


				//for ($i = 1; $i < 6; $i++){
				//
				//	echo "<tr class=\"tr_infos\"> $line[i] </tr>";
				//
				// };

			?>
		</table><br><br>

		<table class="table_infos">
			<tr>
				<th class="th_infos"> Liens externes </th>
			</tr>

			<tr class="tr_infos">
				<td> <a target="_blank" href= <?php echo "\"https://www.ncbi.nlm.nih.gov/protein/".htmlspecialchars($_GET["id"])."\""; ?>> GenBank </a></td>
			</tr>
			<tr class="tr_infos">
				<td> <a target="_blank" href= <?php echo "\"https://www.uniprot.org/uniprot/?query=".htmlspecialchars($_GET["id"])."\""; ?>> Uniprot </a></td>
			</tr>
			<tr class="tr_infos">
				<td> <a target="_blank" href= <?php echo "\"http://ensemblgenomes.org/id/".htmlspecialchars($_GET["id"])."\""; ?>> EnsemblBacteri </a></td>
			</tr>
		</table> <br><br>

		<?php
			//if ($line[7] != "not annotated" or $line[7] != "waiting for annotation") {
				?>
				<table class="table_infos">
					<tr>
						<th class="th_infos" colspan="2"> Annotation <th>
					</tr>
					<?php

					for ($i = 1; $i < 6; $i++) {

						echo "<tr class=\"tr_infos\"><td class=\"td_infos\">".$list_infos_annotation[$i]."</td><td class=\"td_infos\"> test </td></tr>";

					};

					//for ($i = 1; $i < 6; $i++){
					//
					//	echo "<tr class=\"tr_infos\"> $line_annot[i] </tr>";
					//
					// };
			//}
		 ?>
	 			</table>

		<?php
		//pg_free_result($result);

		//pg_close($dbconn);
		?>


</body>

</html>
