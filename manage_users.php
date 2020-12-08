<?php
require("php/menu.php");
include_once 'libphp/db_utils.php';
//connexion to db
connect_db ();


ini_set('display_errors',1); 
error_reporting(E_ALL);

// Verifying if user is connected, if not redirecting him to login page
if(!isset($_SESSION["email"])){
  header("Location: index.php");
  exit(); 
}

else 
{
    if(isset($_POST["confirm"])){
        $email_to_evaluate = $_POST["email"];
        $querystatus= "UPDATE users SET inscription_status = TRUE WHERE email = '$email_to_evaluate'";
        $result = mysqli_query($_SESSION['db'],$querystatus) or die(mysql_error());
        echo " You have validated $email inscription ! ";
      }
      if(isset($_POST["reject"]))
      {
        echo "no";        
        $email_to_evaluate = $_POST['email'];
        $querystatus= "DELETE FROM users WHERE email = '$email_to_evaluate'";
        $result = mysqli_query($_SESSION['db'],$querystatus) or die(mysql_error());
       echo " You have deleted $email from database ! ";
       }
        
}

?>
<div class="name"> AnnotGenome </div>
<div class="navBar">
	    <?php display_menu(); ?>
      </div>
      <head>
  <link rel="stylesheet" href="css/general.css" />
  </head>
    <head>
        <div class="content">
        <title>List of users</title>
    </head>
    <body>
    <h1><center>Welcome Admin <?php $_SESSION["email"] ?>!</h1>


<?php
//We get the IDs, emails and insription status of users
$email_session = $_SESSION['email'];
$query = "SELECT email, first_name, surname, phone_number, id_role, date_last_connexion, inscription_status 
FROM users WHERE email <> '$email_session' ORDER BY inscription_status";
$res = mysqli_query($_SESSION['db'],$query) or die(mysql_error());

#fisrt line of tab : columns names
echo"<center><table class='bicolor'>\n";
echo"<thead>
<th>Email</th>
<th>First name</th>
<th>Surname</th>
<th>Phone number</th>
<th>Role</th>
<th>Date last connexion</th>
<th>Inscription status</th>
</tr>
</thead>";
echo "<tbody>\n";

while($row = mysqli_fetch_array($res)){
    $email = $row['email'];
	$firstname = $row['first_name'];
	$surname = $row['surname'];
    $phone_number = $row['phone_number'];
    $date=$row['date_last_connexion'];
    if($row['id_role']==1)
    {
        $role = 'Administrator';
    }
    if($row['id_role']==2)
    {
        $role = 'Lector';
    }
    if($row['id_role']==3)
    {
        $role = 'Validator';
    }
    if($row['id_role']==4)
    {
        $role = 'Annotator';
    }

    if($row['inscription_status']==0)//not already registered
    {
        $status = "<form action='' method='post'>
                   <textarea style='visibility:hidden' id='email' name='email'>$email</textarea> 
                   <center><input  type='submit' class = 'confrej' name='confirm' value='Confirm'>
                   <input  type='submit' class = 'confrej' name='reject' value='Reject'>
                   </form>";
    }
    else{
        $status="";
    }

echo "<tr>
<td>$email</td>
<td>$firstname</td>
<td>$surname</td>
<td>$phone_number</td>
<td>$role</td>
<td>$date</td>
<td>$status</td>
</tr>";
}
echo "</tbody>";
echo "</table>";
//closing session
disconnect_db ();
?>
</div>
<div style = "position:absolute; right:5px; top:21px; textcolor: #10C837;">
<input type="submit" class = "loginout" value="LOGOUT" onclick="window.location.href='logout.php';"  />



