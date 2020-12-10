<?php
	require("php/menu.php");
 ?>

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="css/general.css">
    <title>Ajouter une annotation</title>
	<script type="text/javascript">
		function sendAnnot(){
			if (document.getElementById("gene").value == "") {
				alert("Please enter a gene");
				return false;
			}
			if (document.getElementById("biot_gene").value == "") {
				alert("Please enter a gene biotype");
				return false;
			}

			if (document.getElementById("biot_trans").value == "") {
				alert("Please enter a transcript biotype");
				return false;
			}

			if (document.getElementById("simb").value == "") {
				alert("Please enter a gene symbole");
				return false;
			}

			if (document.getElementById("descr").value == "") {
				alert("Please enter a description");
				return false;
			}
		}
	</script>
</head>

<body>

<div class="name"> AnnotGenome </div>

<div class="navBar">
	<?php display_menu(); ?>
</div>

<form name="annots" class="searchForm" action=<?php echo "\"annot_validée.php?id=".htmlspecialchars($_GET["id"])."\""; ?> onsubmit="return sendAnnot()" method="post">
	<div class="champ">
    	<label class="input">Gène :</label>
		<input class="input" type="text" id = "gene" name="gene"><br><br>
	</div>
	<div class="champ">
		<label class="input">Biotype du gène :</label>
		<input type="text" id = "biot_gene" name="biot_gene"><br><br>
	</div>
	<div class="champ">
		<label class="input">Biotype du trasncrit : </label>
		<input type="text" id = "biot_trans" name="biot_trans"><br><br>
	</div>
	<div class="champ">
		<label class="input">Symbole du gène : </label>
		<input type="text" id = "symb" name="symb"><br><br>
	</div>
	<div class="champ">
		<label class="input">Description : </label>
		<input type="text" id = "descr" name="descr"><br><br>
	</div>
	<br>
	<div class="champ">
    	<input type="submit" value="Submit">
	</div>
</form>
<br>

</body>

</html>
