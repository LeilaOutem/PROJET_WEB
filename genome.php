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
	$query = "SELECT * FROM genome WHERE id_genome = ". htmlspecialchars($_GET["id"]). ";";
	$query_cds = "SELECT id_sequence, start_pos, end_pos, status FROM sequence WHERE id_genome = ". htmlspecialchars($_GET["id"]). ";";

	//$result = pg_query($query) or die('Échec de la requête : ' . pg_last_error());
	//$result_cds = pg_query($query_cds) or die('Échec de la requête : ' . pg_last_error());
?>

		<table>
			<tr>
				<th> <?php echo htmlspecialchars($_GET["id"]); ?> </th>
			</tr>

			<?php
				for ($i = 1; $i < 6; $i++) {

					echo "<tr><td> test </td></tr>";

				};

				//$line = pg_fetch_array($result, null, PGSQL_ASSOC);
				//for ($i = 1; $i < 6; $i++){
				//
				//	echo "<tr> $line[i] </tr>";
				//
				// };
			?>
		</table><br><br>

		<table>
			<tr>
				<th> <div>CDS</div> </th>
			</tr>
			<?php



				//while ($line = pg_fetch_array($result_cds, null, PGSQL_ASSOC)) {
				//	foreach ($line as $cds) {
				//		echo "<tr>";
				// 		echo "<td><a href = \"gene.php?id=".$cds[0]."\">$cds[0]</a></td>";
				for ($j=1; $j < 4; $j++) {
					echo "<tr><td> info </td></tr>";
				};
				//	echo "<td> cds[j] </td>";
				//	}
				//	echo "</tr>";
				//};
			?>
		</table>







		<?php
		//pg_free_result($result);
		//pg_free_result($result_cds);

		//pg_close($dbconn);
		?>


</body>

</html>
