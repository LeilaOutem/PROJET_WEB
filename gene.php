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
					foreach ($line_annot as $col_value_annot){

						echo "<tr class=\"tr_infos\"><td class=\"td_infos\">".$list_infos_annotation[$i]."</td><td class=\"td_infos\"> $col_value_annot </td></tr>";
						$i ++;
					 };
			};
		 ?>
	 </table><br><br>

		<?php
		pg_free_result($result);
		if ($line["status"] != "not annotated" and $line["status"] != "waiting for annotation") {
			pg_free_result($result_annot);
		}

		pg_close($dbconn);
		?>

		<table class="table_infos">
			<tr>
				<th class="th_infos"> Liens externes </th>
			</tr>
			<tr class="tr_infos">
				<td>
					<form class="searchForm" name="downloadForm" action="" onsubmit="return downloadInfos()" method="post">
						<div class="champ">
							<label class="input" for="nt_sequence"> Séquence nucléotidique : </label>
							yes : <input type="radio" name="nt_sequence" id="nt_sequence" value="yes">
							no : <input type="radio" name="nt_sequence" id="nt_sequence" value="no" checked="checked">
						</div>
						<br>
						<div class="champ">
							<label class="input" for="prot_sequence"> Séquence protéique : </label>
							yes : <input type="radio" name="prot_sequence" id="prot_sequence" value="yes">
							no : <input type="radio" name="prot_sequence" id="prot_sequence" value="no" checked="checked">
						</div>
						<br>
						<div class="champ">
							<label class="input" for="chromosome"> Chromosome : </label>
							yes : <input type="radio" name="chromosome" id="chromosome" value="yes">
							no : <input type="radio" name="chromosome" id="chromosome" value="no" checked="checked">
						</div>
						<br>
						<div class="champ">
							<label class="input" for="start_pos"> Position de départ : </label>
							yes : <input type="radio" name="start_pos" id="start_pos" value="yes">
							no : <input type="radio" name="start_pos" id="start_pos" value="no" checked="checked">
						</div>
						<br>
						<div class="champ">
							<label class="input" for="end_pos"> Position de fin : </label>
							yes : <input type="radio" name="end_pos" id="end_pos" value="yes">
							no : <input type="radio" name="end_pos" id="end_pos" value="no" checked="checked">
						</div>
						<br>
						<div class="champ">
							<label class="input" for="length"> Taille : </label>
							yes : <input type="radio" name="length" id="length" value="yes">
							no : <input type="radio" name="length" id="length" value="no" checked="checked">
						</div>
						<br>
						<div class="champ">
							<label class="input" for="status"> Status : </label>
							yes : <input type="radio" name="status" id="status" value="yes">
							no : <input type="radio" name="status" id="status" value="no" checked="checked">
						</div>
						<br>

						<?php if ($line["status"] != "not annotated" and $line["status"] != "waiting for annotation") {	?>
							<div class="champ">
								<label class="input" for="gene"> Nom du gène : </label>
								yes : <input type="radio" name="gene" id="gene" value="yes">
								no : <input type="radio" name="gene" id="gene" value="no" checked="checked">
							</div>
							<br>
							<div class="champ">
								<label class="input" for="gene_biotype"> Biotype du gène : </label>
								yes : <input type="radio" name="gene_biotype" id="gene_biotype" value="yes">
								no : <input type="radio" name="gene_biotype" id="gene_biotype" value="no" checked="checked">
							</div>
							<br>
							<div class="champ">
								<label class="input" for="transcript_biotype"> Biotype du transcrit : </label>
								yes : <input type="radio" name="transcript_biotype" id="transcript_biotype" value="yes">
								no : <input type="radio" name="transcript_biotype" id="transcript_biotype" value="no" checked="checked">
							</div>
							<br>
							<div class="champ">
								<label class="input" for="gene_symbol"> Symbole du gène : </label>
								yes : <input type="radio" name="gene_symbol" id="gene_symbol" value="yes">
								no : <input type="radio" name="gene_symbol" id="gene_symbol" value="no" checked="checked">
							</div>
							<br>
							<div class="champ">
								<label class="input" for="description"> Description : </label>
								yes : <input type="radio" name="description" id="description" value="yes">
								no : <input type="radio" name="description" id="description" value="no" checked="checked">
							</div>
							<br>
							<div class="champ">
								<label class="input" for="validator_comment"> Comentaire du validateur : </label>
								yes : <input type="radio" name="validator_comment" id="validator_comment" value="yes">
								no : <input type="radio" name="validator_comment" id="validator_comment" value="no" checked="checked">
							</div>
							<br>
						<?php } ?>

						<div class="champ">
					    	<input type="submit" value="Download">
						</div>
					</form>
				</td>
			</tr>
		</table><br><br>

		<script type="text/javascript">
			function downloadInfos() {

				var filename = <?php echo json_encode($line["id_sequence"]); ?>;
				var text = ">"+<?php echo json_encode($line["id_sequence"]); ?>+";";

				//alert(document.downloadForm.chromosome.value);

				if (document.downloadForm.chromosome.value != "no") {
					text = text + <?php echo json_encode($line["chromosome"]); ?>+";";
				}
				if (document.downloadForm.start_pos.value != "no") {
					text = text + <?php echo json_encode($line["start_pos"]); ?>+";";
				}
				if (document.downloadForm.end_pos.value != "no") {
					text = text + <?php echo json_encode($line["end_pos"]); ?>+";";
				}
				if (document.downloadForm.length.value != "no") {
					text = text + <?php echo json_encode($line["length"]); ?>+";";
				}
				if (document.downloadForm.status.value != "no") {
					text = text + <?php echo json_encode($line["status"]); ?>+";";
				}
				if (document.downloadForm.gene.value != "no") {
					text = text + <?php echo json_encode($line_annot["gene"]); ?>+";";
				}
				if (document.downloadForm.gene_biotype.value != "no") {
					text = text + <?php echo json_encode($line_annot["gene_biotype"]); ?>+";";
				}
				if (document.downloadForm.transcript_biotype.value != "no") {
					text = text + <?php echo json_encode($line_annot["transcript_biotype"]); ?>+";";
				}
				if (document.downloadForm.gene_symbol.value != "no") {
					text = text + <?php echo json_encode($line_annot["gene_symbol"]); ?>+";";
				}
				if (document.downloadForm.description.value != "no") {
					text = text + <?php echo json_encode($line_annot["description"]); ?>+";";
				}
				if (document.downloadForm.validator_comment.value != "no") {
					text = text + <?php echo json_encode($line_annot["validator_comment"]); ?>+";";
				}
				if (document.downloadForm.nt_sequence.value != "no" && document.downloadForm.prot_sequence.value == "no") {

					var textCDS = text + "\n" + <?php echo json_encode($line["nt_sequence"]); ?> + ";";

					var element = document.createElement('a');
					element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(textCDS));
					element.setAttribute('download', filename+"_cds.txt");
					element.style.display = 'none';
					document.body.appendChild(element);

					element.click();

					document.body.removeChild(element);
					download(filename+"_cds.txt",textCDS);

				}
				if (document.downloadForm.prot_sequence.value != "no" && document.downloadForm.nt_sequence.value == "no") {

					var textPEP = text + "\n" + <?php echo json_encode($line["prot_sequence"]); ?> + ";";

					var element = document.createElement('a');
					element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(textPEP));
					element.setAttribute('download', filename+"_pep.txt");
					element.style.display = 'none';
					document.body.appendChild(element);

					element.click();

					document.body.removeChild(element);
					download(filename+"_pep.txt",textPEP);

				}
				if (document.downloadForm.prot_sequence.value != "no" && document.downloadForm.nt_sequence.value != "no") {

					var textCDS = text + "\n" + <?php echo json_encode($line["nt_sequence"]); ?> + ";";
					var textPEP = text + "\n" + <?php echo json_encode($line["prot_sequence"]); ?> + ";";

					var element = document.createElement('a');
					element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(textPEP));
					element.setAttribute('download', filename+"_pep.txt");
					element.style.display = 'none';
					document.body.appendChild(element);

					element.click();

					document.body.removeChild(element);
					download(filename+"_pep.txt",textPEP);

					var element = document.createElement('a');
					element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(textCDS));
					element.setAttribute('download', filename+"_cds.txt");
					element.style.display = 'none';
					document.body.appendChild(element);

					element.click();

					document.body.removeChild(element);
					download(filename+"_cds.txt",textCDS);

				}
				if (document.downloadForm.nt_sequence.value == "no" && document.downloadForm.prot_sequence.value == "no") {
					alert("Please choose nucleotide sequence and/or proteique sequence to download a file");
				}
			}
		</script>


</body>

</html>
