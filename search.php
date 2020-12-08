<?php
	require("php/menu.php");
 ?>


<div class="name"> AnnotGenome </div>
<div class="navBar">
	    <?php display_menu(); ?>
      </div>
<head>
	<link rel="stylesheet" type="text/css" href="css/general.css">
    <title>Search form</title>
</head>


<body>
<form class="searchForm" action="results.php" method="post">
	<div class="champ">
    	<label class="input">Genome Id / Gene Id:</label>
		<input class="input" type="text" name = "id"><br><br>
	</div>
	<div class="champ">
		<label class="input">Chromosome :</label>
		<input type="text" name = "chromosome"><br><br>
	</div>
	<div class="champ">
		<label class="input">Species name : </label>
		<input type="text" name = "species_name"><br><br>
	</div>
	<div class="champ">
		<label class="input">Strain : </label>
		<input type="text" name = "strain"><br><br>
	</div>
	<div class="champ">
		<label class="input">Nucleotidic sequence: </label>
		<input type="text" name = "sequence_nt"><br><br>
	</div>
	<div class="champ">
		<label class="input">Proteic sequence : </label>
		<input type="text" name = "sequence_prot"><br><br>
	</div>
	<div class="champ">
		<label class="input">Start position : </label>
		<input type="text" name = "start_pos"><br><br>
	</div>
	<div class="champ">
		<label class="input">End position : </label>
		<input type="text" name = "end_pos"><br><br>
	</div>
	<div class="champ">
		<label class="input">Genome or Gene : </label>
		Genome :
		<input type="radio" name="type" value="genome">
		Gene :
		<input type="radio" name="type" value="sequence">
	</div><br>
	<div class="champ">
    	<input class = "search" type="submit" value="Search">
	</div>
</form>
<br>
<div style = "position:absolute; right:5px; top:21px; textcolor: #10C837;">
<input type="submit" class = "loginout" value="LOGOUT" onclick="window.location.href='logout.php';"  />
</body>

