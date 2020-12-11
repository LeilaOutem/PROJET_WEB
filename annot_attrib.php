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

else {?>

<link rel="stylesheet" href="css/general.css" />
    <div class="name"> AnnotGenome </div>
        <div class="navBar">
	    <?php display_menu(); ?>
      </div>
      <!DOCTYPE html>
<html>
  <head>
  <link rel="stylesheet" href="css/general.css" />
  <head>
		<title>Attribute sequences to annotators for annotation</title>

    </head>
  </head>
  <body>

    <div class="sucess">
    <center><h1>Welcome <?php echo $_SESSION['email']; ?>!</h1></center> </div>
    <div style = "position:absolute; right:5px; top:21px; textcolor: #10C837;">
    <input type="submit" class = "loginout" value="LOGOUT" onclick="window.location.href='logout.php';"  />
      </div>

      <?php

//only validators (3) and admin (1) are allowed in this page
if((! $_SESSION["id_role"] == 1) || (! $_SESSION["id_role"] == 3))
{
    echo '<center><br><b>You are not allowed';

}


else
{

  if(isset($_POST['attribannot'])){
    $email_session = $_SESSION["email"];
    $query = "SELECT id_user FROM users WHERE email = '".$email_session."';";
    $res = pg_query($db_conn,$query) or die('query failed with exception: ' . pg_last_error());

    while($row =  pg_fetch_array($res, null, PGSQL_ASSOC))
    {
    $id_session = $row['id_user'];
    }
    $idseq = $_POST['id_seq'];
    $id_annotator = $_POST['id_annotator'];
    $queryannot= "INSERT INTO assignation_sequence(id_annotator, id_validator, id_sequence)
					values( '".$id_annotator."', '".$id_session."', '".$idseq."');";
    $resultannot = pg_query($db_conn,$queryannot) or die('query failed with exception: ' . pg_last_error());

    $query = "SELECT first_name, surname FROM users WHERE id_user = '".$id_annotator."';";
    $res = pg_query($db_conn,$query) or die('query failed with exception: ' . pg_last_error());
    while($row = pg_fetch_array($res,null, PGSQL_ASSOC))
    {
    $firstname = $row['first_name'];
    $surname = $row['surname'];
    }
    echo " You have successfully attributed sequence $idseq to $firstname $surname ! ";
    $queryupdate= "UPDATE sequence SET status = 'annotation in progress' WHERE id_sequence = '".$idseq."';";
    $result = pg_query($db_conn,$queryupdate) or die('query failed with exception: ' . pg_last_error());

      //Sending an email to the annotator to inform him that he has a sequence to annotate
      $queryiduser = "SELECT id_annotator FROM assignation_sequence
      WHERE id_sequence = '".$idseq."';";
      $result = pg_query($db_conn,$queryiduser) or die('query failed with exception: ' . pg_last_error());
      while($row = pg_fetch_array($result,null,PGSQL_ASSOC)){
          $iduser=$row['id_annotator'];
          $queryemail = "SELECT email FROM users
          WHERE id_user = '".$iduser."';";
          $result = pg_query($db_conn,$queryemail) or die('query failed with exception: ' . pg_last_error());
          while($row = pg_fetch_array($result, null, PGSQL_ASSOC)){
              $email=$row['email'];
              $message = 'Hello, you have a new sequence to annotate. See you soon in our site
              Cordially,
              Annogenom Team';
              //sending the email
              $result = smtpmailer($email, 'annogeno@gmail.com', 'Annogeno', 'New annotation', $message);
              if (true !== $result)
              {
                // error
                echo $result;
              }
          }
      }
}


  //select the sequences that are not annotated yet
  $query = "SELECT id_sequence, status FROM sequence WHERE status = 'not annotated';";
  $res = pg_query($db_conn,$query) or die('query failed with exception: ' . pg_last_error());

  $list_seq = array();
  while($row = pg_fetch_array($res,null, PGSQL_ASSOC)){
    $list_seq[] = $row['id_sequence'];
  }

  $queryannot = 'SELECT id_user, first_name, surname FROM users WHERE id_role = 4;';
  $resannot = pg_query($db_conn,$queryannot) or die('query failed with exception: ' . pg_last_error());


  $annotator = "<select name ='id_annotator' type='submit' text-align : left>";
  while($rowannot = pg_fetch_array($resannot, null, PGSQL_ASSOC)){
    $id_annotator = $rowannot['id_user'];
    $first_name = $rowannot['first_name'];
    $surname = $rowannot['surname'];
    //dropdown list construction
    $annotator =  $annotator . "<option value = $id_annotator>$first_name $surname</option>";

  }
  ?>
  <center><table>
  <thead>
  <th>sequence id</th>
  <th>status</th>
  <th>annotators list</th>
  </thead>
  <tbody>
  <?php

  foreach($list_seq as $key => $id_sequence){
    echo "<tr>
    <td>$id_sequence</td>
    <td><i>not annotated</i></td>
    <td><form action='' method='post'>
    <textarea style='visibility:hidden' id='idseq' name='id_seq'>$id_sequence</textarea>
    $annotator
    <center><input class = 'assign' type='submit' id='$id_sequence' name='attribannot' value='Assign'>
    </form></td>
    </tr>";
  }
  echo"</tbody></table>\n";
}
//closing session
disconnect_db ();
}
?>

  </body>
</html>
