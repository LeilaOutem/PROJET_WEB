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

	$list_infos_genome = ["Genome ID", "Length", "Chromosome", "Species Name", "Strain"];
	//connexion a la bdd :
	$dbconn = pg_connect("host=localhost dbname=annotgenome user=freaky password=")or die('Connexion impossible : ' . pg_last_error());

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

				$line_seq = pg_fetch_array($result_seq, null, PGSQL_ASSOC);
				$line = pg_fetch_array($result, null, PGSQL_ASSOC);
				$line_cds = pg_fetch_array($result_cds, null, PGSQL_ASSOC);

				$i = 0;
				foreach ($line as $col_value){

					echo "<tr class=\"tr_infos\"><td class=\"td_infos\">".$list_infos_genome[$i]."</td><td class=\"td_infos\"> $col_value </td></tr>";
					$i++;

				};

				echo "<tr><td class=\"td_infos\"> Genome Sequence : </td><td>";

				$seq = strval($line_seq["genome_sequence"]);

				for ($c = 0; $c < strlen($seq); $c++) {
					if ($c == $line_cds["start_pos"]-1) {
						echo "<div class=\"gene\"><a class=\"clickable_cds\" href = \"gene.php?id=".$line_cds["id_sequence"]."\">";
						echo $seq[$c];
					}
					elseif ($c == $line_cds["end_pos"]-1) {
						echo $seq[$c];
						echo "<span class=\"tooltip\">Sequence ID : ".$line_cds["id_sequence"]."<br>Start position : ".$line_cds["start_pos"]."<br>End position : ".$line_cds["end_pos"]."</span></a></div>";
						$line_cds = pg_fetch_array($result_cds, null, PGSQL_ASSOC);
					}
					else {
						echo $seq[$c];
					}


				}
				echo "</td></tr>";
			?>

			<table class="table_infos">
				<tr>
					<th class="th_infos"> Download </th>
				</tr>
				<tr class="tr_infos">
					<td>
						<form class="searchForm" name="downloadForm" action="" onsubmit="return downloadInfosGenome()" method="post">
							<div class="champ">
								<label class="input" for="length"> Length : </label>
								yes : <input type="radio" name="length" id="length" value="yes">
								no : <input type="radio" name="length" id="length" value="no" checked="checked">
							</div>
							<br>
							<div class="champ">
								<label class="input" for="chromosome"> Chromosome : </label>
								yes : <input type="radio" name="chromosome" id="chromosome" value="yes">
								no : <input type="radio" name="chromosome" id="chromosome" value="no" checked="checked">
							</div>
							<br>
							<div class="champ">
								<label class="input" for="species_name"> Species Name : </label>
								yes : <input type="radio" name="species_name" id="species_name" value="yes">
								no : <input type="radio" name="species_name" id="species_name" value="no" checked="checked">
							</div>
							<br>
							<div class="champ">
								<label class="input" for="strain"> Strain : </label>
								yes : <input type="radio" name="strain" id="strain" value="yes">
								no : <input type="radio" name="strain" id="strain" value="no" checked="checked">
							</div>

							<div class="champ">
								<input type="submit" value="Download">
							</div>
						</form>
					</td>
				</tr>
			</table><br><br>

			<script type="text/javascript">
				function downloadInfosGenome() {

					var filename = <?php echo json_encode($line["id_genome"]); ?>;
					var text = ">id:"+<?php echo json_encode($line["id_genome"]); ?>+";";

					if (document.downloadForm.length.value != "no") {
						text = text + "length:" + <?php echo json_encode($line["length"]); ?>+";";
					}
					if (document.downloadForm.chromosome.value != "no") {
						text = text + "chromosome:" + <?php echo json_encode($line["chromosome"]); ?>+";";
					}
					if (document.downloadForm.species_name.value != "no") {
						text = text + "speciesName:" + <?php echo json_encode($line["species_name"]); ?>+";";
					}
					if (document.downloadForm.strain.value != "no") {
						text = text + "strain:" + <?php echo json_encode($line["strain"]); ?>+";";
					}

					var text = text + "\n" + <?php echo json_encode($line["genome_sequence"]); ?> + ";";

					var element = document.createElement('a');
					element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
					element.setAttribute('download', filename+".fa");
					element.style.display = 'none';
					document.body.appendChild(element);

					element.click();

					document.body.removeChild(element);
					download(filename+".fa",text);

				}
			</script>







		<?php
		pg_free_result($result);
		pg_free_result($result_cds);
		pg_free_result($result_seq);
		pg_close($dbconn);
		?>


</body>

</html>
