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
	$list_infos_sequence = ["Sequence ID","Nucleotides sequence", "Protein sequence",
					"Chromosome", "Start position", "End position", "Sequence length", "Genome", "Status"];
	$dbconn = pg_connect("host=localhost dbname=annotgenome user=freaky password=")or die('Connexion impossible : ' . pg_last_error());

	$query = "SELECT * FROM sequence WHERE id_sequence = '". htmlspecialchars($_GET["id"]). "';";

	$result = pg_query($query) or die('Request fail : ' . pg_last_error());
	$line = pg_fetch_array($result, null, PGSQL_ASSOC);

	if ($line["status"] != "not annotated" and $line["status"] != "waiting for annotation") {

		$query_annot = "SELECT strand, gene, gene_biotype, transcript_biotype, gene_symbol, description, validator_comment FROM annotation WHERE id_sequence = '". htmlspecialchars($_GET["id"]). "';";
		$list_infos_annotation = ["Strand", "Gene Name", "Biotype", "Transcript Biotype", "Gene Symbol",
								"Description", "Validator Comment"];
		$result_annot = pg_query($query_annot) or die('Request fail : ' . pg_last_error());
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
			<tr>
				<td> <a target="_blank" href=<?php echo "\"https://blast.ncbi.nlm.nih.gov/Blast.cgi?PROGRAM=blastx&PAGE_TYPE=BlastSearch&LINK_LOC=blasthome&QUERY=".$line["nt_sequence"]."\""; ?>> Blast </a> </td>
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
				<th class="th_infos"> Download </th>
			</tr>
			<tr class="tr_infos">
				<td>
					<form class="searchForm" name="downloadForm" action="" onsubmit="return downloadInfosGene()" method="post">
						<div class="champ">
							<label class="input" for="sequence"> Type of sequence : </label>
							Protein : <input type="radio" name="sequence" id="sequence" value="protein">
						 	Nucleotides : <input type="radio" name="sequence" id="sequence" value="nucleotides">
						</div>
						<br>
						<div class="champ">
							<label class="input" for="chromosome"> Chromosome : </label>
							yes : <input type="radio" name="chromosome" id="chromosome" value="yes">
							no : <input type="radio" name="chromosome" id="chromosome" value="no" checked="checked">
						</div>
						<br>
						<div class="champ">
							<label class="input" for="start_pos"> Start position : </label>
							yes : <input type="radio" name="start_pos" id="start_pos" value="yes">
							no : <input type="radio" name="start_pos" id="start_pos" value="no" checked="checked">
						</div>
						<br>
						<div class="champ">
							<label class="input" for="end_pos"> End position : </label>
							yes : <input type="radio" name="end_pos" id="end_pos" value="yes">
							no : <input type="radio" name="end_pos" id="end_pos" value="no" checked="checked">
						</div>
						<br>
						<div class="champ">
							<label class="input" for="length"> Sequence length : </label>
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
								<label class="input" for="strand"> Strand : </label>
								yes : <input type="radio" name="strand" id="strand" value="yes">
								no : <input type="radio" name="strand" id="strand" value="no" checked="checked">
							</div>
							<div class="champ">
								<label class="input" for="gene"> Gene Name : </label>
								yes : <input type="radio" name="gene" id="gene" value="yes">
								no : <input type="radio" name="gene" id="gene" value="no" checked="checked">
							</div>
							<br>
							<div class="champ">
								<label class="input" for="gene_biotype"> Gene Biotype : </label>
								yes : <input type="radio" name="gene_biotype" id="gene_biotype" value="yes">
								no : <input type="radio" name="gene_biotype" id="gene_biotype" value="no" checked="checked">
							</div>
							<br>
							<div class="champ">
								<label class="input" for="transcript_biotype"> Transcript Biotype : </label>
								yes : <input type="radio" name="transcript_biotype" id="transcript_biotype" value="yes">
								no : <input type="radio" name="transcript_biotype" id="transcript_biotype" value="no" checked="checked">
							</div>
							<br>
							<div class="champ">
								<label class="input" for="gene_symbol"> Gene Symbol : </label>
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
								<label class="input" for="validator_comment"> Validator comment : </label>
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
			function downloadInfosGene() {

				var filename = <?php echo json_encode($line["id_sequence"]); ?>;
				var text = ">id:"+<?php echo json_encode($line["id_sequence"]); ?>+";";

				if (document.downloadForm.chromosome.value != "no") {
					text = text + "chromosome:" + <?php echo json_encode($line["chromosome"]); ?>+";";
				}
				if (document.downloadForm.start_pos.value != "no") {
					text = text + "stratPos:" + <?php echo json_encode($line["start_pos"]); ?>+";";
				}
				if (document.downloadForm.end_pos.value != "no") {
					text = text + "endPos:" + <?php echo json_encode($line["end_pos"]); ?>+";";
				}
				if (document.downloadForm.length.value != "no") {
					text = text + "length:" + <?php echo json_encode($line["length"]); ?>+";";
				}
				if (document.downloadForm.status.value != "no") {
					text = text + "status:" + <?php echo json_encode($line["status"]); ?>+";";
				}
				if (document.downloadForm.strand.value != "no") {
					text = text + "strand:" + <?php echo json_encode($line_annot["strand"]); ?>+";";
				}
				if (document.downloadForm.gene.value != "no") {
					text = text + "gene:" + <?php echo json_encode($line_annot["gene"]); ?>+";";
				}
				if (document.downloadForm.gene_biotype.value != "no") {
					text = text + "geneBiotype:" + <?php echo json_encode($line_annot["gene_biotype"]); ?>+";";
				}
				if (document.downloadForm.transcript_biotype.value != "no") {
					text = text + "transcriptBiotype:" + <?php echo json_encode($line_annot["transcript_biotype"]); ?>+";";
				}
				if (document.downloadForm.gene_symbol.value != "no") {
					text = text + "geneSymbol" + <?php echo json_encode($line_annot["gene_symbol"]); ?>+";";
				}
				if (document.downloadForm.description.value != "no") {
					text = text + "description:" + <?php echo json_encode($line_annot["description"]); ?>+";";
				}
				if (document.downloadForm.validator_comment.value != "no") {
					text = text + "validatorComment:" + <?php echo json_encode($line_annot["validator_comment"]); ?>+";";
				}
				if (document.downloadForm.sequence.value == "nucleotides") {

					var textCDS = text + "\n" + <?php echo json_encode($line["nt_sequence"]); ?> + ";";

					var element = document.createElement('a');
					element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(textCDS));
					element.setAttribute('download', filename+"_cds.fa");
					element.style.display = 'none';
					document.body.appendChild(element);

					element.click();

					document.body.removeChild(element);
					download(filename+"_cds.fa",textCDS);

				}
				else if (document.downloadForm.sequence.value == "protein") {

					var textPEP = text + "\n" + <?php echo json_encode($line["prot_sequence"]); ?> + ";";

					var element = document.createElement('a');
					element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(textPEP));
					element.setAttribute('download', filename+"_pep.fa");
					element.style.display = 'none';
					document.body.appendChild(element);

					element.click();

					document.body.removeChild(element);
					download(filename+"_pep.fa",textPEP);

				}
				else if (document.downloadForm.sequence.value != "nucleotides" && document.downloadForm.sequence.value != "protein") {
					alert("Please choose nucleotide sequence and/or proteique sequence to download a file.");
				}

			}
		</script>


</body>

</html>
