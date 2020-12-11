<?php

include_once 'libphp/db_utils.php';
connect_db ();

function display_menu()  { ?>
	<nav>
		<?php
		if ($_SESSION['id_role'] == 2){ //Lecteur
			?>
			<a href="home.php">Home</a>
			<a href="search.php">Search</a>
			<a href="annot_attrib.php" onclick="return true;"> Annotation</a>
			<a href="validation.php" onclick="return true;"> Validation</a>
			<a href="manage_users.php" onclick="return true;">Users</a>
			<div class="animation start-home"></div>
		<?php
		}

		if ($_SESSION['id_role'] == 1){ //Administrateur
			?>
			<a href="home.php">Home</a>
			<a href="search.php">Search</a>
			<a href="annot_attrib.php" > Annotation</a>
			<a href="validation.php" > Validation</a>
			<a href="manage_users.php">Users</a>
			<div class="animation start-home"></div>
		<?php
		}

		if ($_SESSION['id_role'] == 3){ //Validator
			?>
			<a href="home.php">Home</a>
			<a href="search.php">Search</a>
			<a href="annot_attrib.php"> Annotation</a>
			<a href="validation.php"> Validation</a>
			<a href="manage_users.php" onclick="return true;">Users</a>
			<div class="animation start-home"></div>
		<?php
		}

		if ($_SESSION['id_role'] == 4){ //Annotator
			?>
			<a href="home.php">Home</a>
			<a href="search.php">Search</a>
			<a href="annot_attrib.php"> Annotation</a>
			<a href="validation.php" onclick="return true;"> Validation</a>
			<a href="manage_users.php" onclick="return true;">Users</a>
			<div class="animation start-home"></div>
		<?php
		} ?>
	</nav>
<?php
}
//closing session
disconnect_db ();
?>
