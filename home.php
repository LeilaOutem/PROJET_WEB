<?php
require("php/menu.php");
include_once 'libphp/db_utils.php';
connect_db ();

ini_set('display_errors',1); 
error_reporting(E_ALL);

  // If the user is not connected, redirect him to login page
  if(!isset($_SESSION["email"])){
    header("Location: index.php");
    exit(); 
  }
  else 
  {
   
    $email = $_SESSION["email"];
    $queryrole = "SELECT id_role FROM users WHERE email = '$email'";
    $resultrole = pg_query($db_conn,$queryrole) or die('query failed: ' . pg_last_error());
    while($row =  pg_fetch_array($resultrole, null, PGSQL_ASSOC)
    { 
      $_SESSION['id_role'] = $row[0]; ?>

      <div class="name"> AnnotGenome </div>
      <div class="navBar">
	    <?php display_menu(); ?>
      </div>
<?php
    }
  }
  disconnect_db ();
  ?>

<!DOCTYPE html>
<html>
  <head>
  <link rel="stylesheet" href="css/general.css" />
  </head>
  <body>
  
    <div class="sucess">
    <center><h1>Welcome <?php echo $_SESSION['email']; ?>!</h1></center> </div>
    <div style = "position:absolute; right:5px; top:21px; textcolor: #10C837;">
    <input type="submit" class = "loginout" value="LOGOUT" onclick="window.location.href='logout.php';"  />
    
      </div>
  </body>
</html>