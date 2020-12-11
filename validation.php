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
		<title>Validate annotations</title>
      
    </head>  
  </head>
  <body>
  
    <div class="sucess">
    <center><h1>Welcome <?php echo $_SESSION['email']; ?>!</h1></center> </div>
    <div style = "position:absolute; right:5px; top:21px; textcolor: #10C837;">
    <input type="submit" class = "loginout" value="LOGOUT" onclick="window.location.href='logout.php';"  />
    
      </div>
  </body>
</html>
<?php

    if((! $_SESSION["id_role"] == 1) || (! $_SESSION["id_role"] == 3))
    {
        echo '<center><br><b>You are not allowed';

    }
   
    
    else 
    {  
        if(isset($_POST['submit'])){
            $validcomment = $_POST['comment'];
            $id_seq = $_POST['id_seq'];
            $querystatus= "UPDATE annotation SET validator_comment = '$validcomment' WHERE id_sequence = '$id_seq'";
            $result = pg_query($db_conn,$querystatus) or die('query failed with exception: ' . pg_last_error());
            echo " You have added a comment to sequence $id_seq ! ";
        }
        if(isset($_POST["validate"]))
        {  
            
            $id_seq = $_POST['id_seq'];   
            $querystatus= "UPDATE sequence SET status = 'validated' WHERE id_sequence = '$id_seq'";
            $result = pg_query($db_conn,$querystatus) or die('query failed with exception: ' . pg_last_error());
            echo " You have validated an annotation ! ";

            //Sending an email to the sequence's annotator to inform him about the decision
            $queryiduser = "SELECT id_annotator FROM assignation_sequence
            WHERE id_sequence = '$id_seq'";
            $result = pg_query($db_conn,$queryiduser) or die('query failed with exception: ' . pg_last_error());
            while($row = pg_fetch_array($result,null, PG_ASSOC)){
                $iduser=$row['id_annotator'];
                $queryemail = "SELECT email FROM users
                WHERE id_user = '$iduser'";
                $result = pg_query($db_conn,$queryemail) or die('query failed with exception: ' . pg_last_error());
                while($row = pg_fetch_array($result,null, PG_ASSOC)){
                    $email=$row['email'];
                    $message = 'Happy to anounce you that your annotation has been validated, please consult your account.
                    See you soon in our site,
                    Cordially,
                    Annogenom team. ';
                    ///sending the email from annogeno@gmail.com
                    $result = smtpmailer($email, 'annogeno@gmail.com', 'Annogeno', 'Annotation decision', $message);
                    if (true !== $result)
                    {
                        // error 
                        echo $result;
                    }
            }

        }

        if(isset($_POST["reject"]))
        { 
            $id_seq = $_POST['id_seq'];
            $querydelete= "DELETE FROM annotation WHERE id_sequence = '$id_seq' ";
            $querystatus = "UPDATE sequence SET status = 'not annoted' WHERE id_sequence = '$id_seq'";
            $result = pg_query($db_conn,$querydelete) or die('query failed with exception: ' . pg_last_error());
            $result = pg_query($db_conn,$querystatus) or die('query failed with exception: ' . pg_last_error());

            echo " You have deleted an annotation from database ! ";
            //Sending an email to the sequence's annotator to inform him about the decision
            $queryiduser = "SELECT id_annotator FROM assignation_sequence
            WHERE id_sequence = '$id_seq'";
            $result = pg_query($db_conn,$queryiduser) or die('query failed with exception: ' . pg_last_error());
            while($row = pg_fetch_array($result, null, PG_ASSOC)){
                $iduser=$row['id_annotator'];
                $queryemail = "SELECT email FROM users
                WHERE id_user = '$iduser'";
                $result = pg_query($db_conn,$queryemail) or die('query failed with exception: ' . pg_last_error());
                while($row = pg_fetch_array($result, null, PG_ASSOC)){
                    $email=$row['email'];
                    $message = 'Sorry to anounce you that your annotation  has been rejected. Please, consult your account.
                    See you soon in our site,
                    Cordially,
                    Annogenom Team.';
                     //sending the email from annogeno@gmail.com
                    $result = smtpmailer($email, 'annogeno@gmail.com', 'Annogeno', 'Annotation decision', $message);
                    if (true !== $result)
                    {
                        // error 
                        echo $result;
                    }
                }  
            }
        }
        //select the annotation informations for the validator to confirm or reject it
        $email_session = $_SESSION['email'];
        $query = "SELECT annotation.id_sequence, gene, gene_biotype, transcript_biotype, gene_symbol, description, validator_comment, status
        FROM annotation, sequence WHERE annotation.id_sequence = sequence.id_sequence 
        AND sequence.status ='annotated, waiting for validation'";
        $res = pg_query($db_conn,$query) or die('query failed with exception: ' . pg_last_error());
        if(! $row = pg_fetch_array($res, null, PG_ASSOC)){
            echo '<center><b>No annotation waiting for validation</center></b>';
          }
        else {
        //fisrt line of tab : columns names
        echo"<center><table class='bicolor'>\n";
        echo"<thead>
        <th>sequence id</th>
        <th>gene</th>
        <th>gene biotype</th>
        <th>transcript_biotype</th>
        <th>gene symbol</th>
        <th>description</th>
        <th>validator comment</th>
        <th>status</th>
        </tr>
        </thead>";
        echo "<tbody>\n";

        
        while($row = pg_fetch_array($res,null,PG_ASSOC)){
            $id_seq = $row['id_sequence'];
            $gene = $row['gene'];
            $genebio = $row['gene_biotype'];
            $transbio = $row['transcript_biotype'];
            $genesymb=$row['gene_symbol'];
            $desc=$row['description'];
            $status=$row['status'];
            $comment = $row['validator_comment'];
            if ($comment == ""){
                $comment = " <form action='' method='post'>
                            <textarea style='visibility:hidden' id='idseq' name='id_seq'>$id_seq</textarea>
                            <div>
                            <label for='message'>Comment:</label>
                            <textarea name='comment'></textarea>
                            </div>
                            <center><input  type='submit' class = 'annot' name='submit' value='Submit'>
                            </form>";
            }
                
            
            if ($status == "annotated, waiting for validation"){
            $status = "<form action='' method='post' >
                    <textarea style='visibility:hidden' id='idseq' name='id_seq'>$id_seq</textarea>
                    <center><input  type='submit' class = 'annot' name='validate' value='Validate'>
                    <input  type='submit' class = 'annot' name='reject' value='Reject'>
                    </form>";
            
                echo "<tr>
                <td>$id_seq</td>
                <td>$gene</td>
                <td>$genebio</td>
                <td>$transbio</td>
                <td>$genesymb</td>
                <td>$desc</td>
                <td>$comment</td>
                <td>$status</td>
                </tr>";
                 
                
            }
        }
            echo "</tbody>";
            echo "</table>";
    }
    }
}
//closing session
disconnect_db ();
?>


