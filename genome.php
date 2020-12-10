<?php
	require("php/menu.php");
 ?>

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="css/general.css">
    <title> Genome </title>
</head>

<body>

<div class="name"> AnnotGenome </div>

<div class="navBar">
	<?php display_menu(); ?>
</div>

<?php

	$list_infos_genome = ["id du génome", "Longueur", "Chromosome", "Nom de l'espèce", "Souche"];
	//connexion a la bdd :
	$dbconn = pg_connect("host=localhost dbname=annotgenome user=freaky password=18A1A70oY/84bZG")or die('Connexion impossible : ' . pg_last_error());

	$query = "SELECT id_genome, length, chromosome, species_name, strain FROM genome WHERE id_genome = '". htmlspecialchars($_GET["id"]). "';";
	$query_seq = "SELECT genome_sequence FROM genome WHERE id_genome = '". htmlspecialchars($_GET["id"]). "';";
	$query_cds = "SELECT id_sequence, nt_sequence, start_pos, end_pos, status FROM sequence WHERE id_genome = '". htmlspecialchars($_GET["id"]). "' ORDER BY start_pos;";

	$result = pg_query($query) or die('Échec de la requête : ' . pg_last_error());
	$result_seq = pg_query($query_seq) or die('Échec de la requête : ' . pg_last_error());
	$result_cds = pg_query($query_cds) or die('Échec de la requête : ' . pg_last_error());
?>

		<table class="table_infos">
			<tr>
				<th class="th_infos" colspan="2"> <?php echo htmlspecialchars($_GET["id"]); ?> </th>
			</tr>

			<?php
				//for ($i = 1; $i < 6; $i++) {
				//	echo "<tr class=\"tr_infos\"><td class=\"td_infos\">".$list_infos_genome[$i]."</td><td class=\"td_infos\"> test </td></tr>";
				//};
				$line_seq = pg_fetch_array($result_seq, null, PGSQL_ASSOC);
				$line = pg_fetch_array($result, null, PGSQL_ASSOC);
				$line_cds = pg_fetch_array($result_cds, null, PGSQL_ASSOC);

				$i = 0;
				foreach ($line as $col_value){

					echo "<tr class=\"tr_infos\"><td class=\"td_infos\">".$list_infos_genome[$i]."</td><td class=\"td_infos\"> $col_value </td></tr>";
					$i++;

				};

				echo "<tr><td class=\"td_infos\"> Séquence du génome </td><td>";

				$seq = strval($line_seq["genome_sequence"]);

				//foreach ($line_cds) {
				//	$seq2 = substr_replace($seq, '<div class="gene">'.$line_cds["nt_sequence"].)
				//}

				for ($c = 0; $c < strlen($seq); $c++) {
					if ($c == $line_cds["start_pos"]-1) {
						echo "<div class=\"gene\"><a class=\"clickable_cds\" href = \"gene.php?id=".$line_cds["id_sequence"]."\">";
						echo $seq[$c];
					}
					elseif ($c == $line_cds["end_pos"]-1) {
						echo $seq[$c];
						echo "<span class=\"tooltip\">Id de la séquence : ".$line_cds["id_sequence"]."<br>Position de départ : ".$line_cds["start_pos"]."<br>Position de fin : ".$line_cds["end_pos"]."</span></a></div>";
						$line_cds = pg_fetch_array($result_cds, null, PGSQL_ASSOC);
					}
					else {
						echo $seq[$c];
					}


				}
				echo "</td></tr>";
			?>
	<!--
		</table><br><br>

		<table class="table_infos">
			<tr>
				<th class="th_infos"> CDS </th>
			</tr>
			<?php



				//while ($line = pg_fetch_array($result_cds, null, PGSQL_ASSOC)) {
				//	foreach ($line as $cds) {
				//		echo "<tr class=\"tr_infos\">";
				// 		echo "<td><a href = \"gene.php?id=".$cds[0]."\">$cds[0]</a></td>";
				//for ($j=1; $j < 4; $j++) {
					//echo "<tr class=\"tr_infos\"><td> info </td></tr>";
				//};
				//	echo "<td> cds[j] </td>";
				//	}
				//	echo "</tr>";
				//};
			?>
		</table>
	-->







		<?php
		pg_free_result($result);
		pg_free_result($result_cds);
		pg_free_result($result_seq);
		pg_close($dbconn);
		?>


</body>

</html>
