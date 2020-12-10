<?php
	require("php/menu.php");
 ?>

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="css/general.css">
    <title>CDS </title>
</head>

<body>

<div class="name"> AnnotGenome </div>

<div class="navBar">
	<?php display_menu(); ?>
</div>

<?php
	$list_infos_sequence = ["id de la séquence","Séquence nucléotidique", "Séquence protéique",
					"Chromosome", "Position de départ", "Position de fin", "Longueur de la séquence", "Génome", "Statut"];
	$dbconn = pg_connect("host=localhost dbname=annotgenome user=freaky password=18A1A70oY/84bZG")or die('Connexion impossible : ' . pg_last_error());

	$query = "SELECT * FROM sequence WHERE id_sequence = '". htmlspecialchars($_GET["id"]). "';";

	$result = pg_query($query) or die('Échec de la requête : ' . pg_last_error());
	$line = pg_fetch_array($result, null, PGSQL_ASSOC);

	if ($line["status"] != "not annotated" and $line["status"] != "waiting for annotation") {

		$query_annot = "SELECT gene, gene_biotype, transcript_biotype, gene_symbol, description, validator_comment FROM annotation WHERE id_sequence = '". htmlspecialchars($_GET["id"]). "';";
		$list_infos_annotation = ["Nom du gène", "Biotype", "Biotype du transcrit", "Symbole du gène",
								"Description", "Commentaire du validateur"];
		$result_annot = pg_query($query_annot) or die('Échec de la requête : ' . pg_last_error());
		$line_annot = pg_fetch_array($result_annot, null, PGSQL_ASSOC);
		if ($line["status"] == "validated") {
			echo "validated";
		}
		else {
			echo "not validated";
		}
	}
	else {
		echo "<a href=\"insert_annotation.php?id=".htmlspecialchars($_GET["id"])."\"> Annoter le genome </a>";
	}

?>



		<table class="table_infos">
			<tr>
				<th class="th_infos" colspan="2"> <?php echo htmlspecialchars($_GET["id"]); ?> </th>
			</tr>


			<?php
				//for ($i = 1; $i < 9; $i++) {
				//	echo "<tr class=\"tr_infos\"><td class=\"td_infos\">".$list_infos_sequence[$i]."</td><td class=\"td_infos\"> test </td></tr>";
				//};
				$i = 0;

				foreach ($line as $col_value){

					echo "<tr class=\"tr_infos\"><td class=\"td_infos\">".$list_infos_sequence[$i]."</td><td class=\"td_infos\"> $col_value </td></tr>";
					$i ++;
				};

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
			if ($line["status"] != "not annotated" and $line["status"] != "waiting for annotation") {
				?>
				<table class="table_infos">
					<tr>
						<th class="th_infos" colspan="2"> Annotation <th>
					</tr>
					<?php

					//for ($i = 1; $i < 6; $i++) {

					//	echo "<tr class=\"tr_infos\"><td class=\"td_infos\">".$list_infos_annotation[$i]."</td><td class=\"td_infos\"> test </td></tr>";

					//};
					$i = 0;
					foreach ($line_annot as $col_value){

						echo "<tr class=\"tr_infos\"><td class=\"td_infos\">".$list_infos_annotation[$i]."</td><td class=\"td_infos\"> $col_value </td></tr>";
						$i ++;
					 };
			};
		 ?>
	 </table><br><br>

		<?php
		pg_free_result($result);

		pg_close($dbconn);
		?>


</body>

</html>
