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
	$query = "SELECT * FROM sequence WHERE id_sequence = ". htmlspecialchars($_GET["id"]). ";";

	//$result = pg_query($query) or die('Échec de la requête : ' . pg_last_error());
	//$line = pg_fetch_array($result, null, PGSQL_ASSOC);
	//if ($line[7] != "not annotated" or $line[7] != "waiting for annotation") {
		$query_annot = "SELECT * FROM annotation WHERE id_sequence = ". htmlspecialchars($_GET["id"]). ";";
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

		<table>
			<tr>
				<th> <?php echo htmlspecialchars($_GET["id"]); ?> </th>
			</tr>

			<?php
				for ($i = 1; $i < 6; $i++) {

					echo "<tr><td> test </td></tr>";

				};


				//for ($i = 1; $i < 6; $i++){
				//
				//	echo "<tr> $line[i] </tr>";
				//
				// };

			?>
		</table><br><br>

		<table>
			<tr>
				<th> Liens externes </th>
			</tr>

			<tr>
				<td> <a target="_blank" href= <?php echo "\"https://www.ncbi.nlm.nih.gov/protein/".htmlspecialchars($_GET["id"])."\""; ?>> GenBank </a></td>
			</tr>
			<tr>
				<td> <a target="_blank" href= <?php echo "\"https://www.uniprot.org/uniprot/?query=".htmlspecialchars($_GET["id"])."\""; ?>> Uniprot </a></td>
			</tr>
			<tr>
				<td> <a target="_blank" href= <?php echo "\"http://ensemblgenomes.org/id/".htmlspecialchars($_GET["id"])."\""; ?>> EnsemblBacteri </a></td>
			</tr>
		</table> <br><br>

		<?php
			//if ($line[7] != "not annotated" or $line[7] != "waiting for annotation") {
				?>
				<table>
					<tr>
						<th> Annotation <th>
					</tr>
					<?php

					for ($i = 1; $i < 6; $i++) {

						echo "<tr><td> test </td></tr>";

					};

					//for ($i = 1; $i < 6; $i++){
					//
					//	echo "<tr> $line_annot[i] </tr>";
					//
					// };
			//}
		 ?>

		<?php
		//pg_free_result($result);

		//pg_close($dbconn);
		?>


</body>

</html>
