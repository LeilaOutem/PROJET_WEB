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
		<title>Manage users </title>
      
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
    if($_SESSION["id_role"] != 1)
    {
        echo '<center><br><b>You are not allowed';

    }
    else 
    {
        if(isset($_POST["confirm"])){
            $email_to_evaluate = $_POST["email"];
            $querystatus= "UPDATE users SET inscription_status = TRUE WHERE email = '$email_to_evaluate'";
            $result = pg_query($db_conn,$querystatus) or die('query failed with exception: ' . pg_last_error());
            echo " You have validated $email_to_evaluate inscription ! ";
        }
        if(isset($_POST["reject"]))
        {     
            $email_to_evaluate = $_POST['email'];
            $querystatus= "DELETE FROM users WHERE email = '$email_to_evaluate'";
            $result = pg_query($db_conn,$querystatus) or die('query failed with exception: ' . pg_last_error());
        echo " You have deleted $email_to_evaluate from database ! ";
        }

        if(isset($_POST["modify"]))
        {     
            $email_to_evaluate = $_POST['email'];
            $new_role = intval($_POST['modify_role']);

            $queryrole= "UPDATE users SET id_role = $new_role WHERE email = '$email_to_evaluate'";
            $result = pg_query($db_conn['db'],$queryrole) or die('query failed with exception: ' . pg_last_error());
        echo " You have changed $email_to_evaluate's role ! ";
        }

            
        //We get the IDs, emails and insription status of users
        $email_session = $_SESSION['email'];
        $query = "SELECT email, first_name, surname, phone_number, id_role, date_last_connexion, inscription_status 
        FROM users WHERE email <> '$email_session' ORDER BY inscription_status";
        $res = pg_query($db_conn,$query) or die('query failed with exception: ' . pg_last_error());

        echo"<center><table class='bicolor'>\n";
        echo"<thead>
        <th>Email</th>
        <th>First name</th>
        <th>Surname</th>
        <th>Phone number</th>
        <th>Role</th>
        <th>Date last connexion</th>
        <th>Decision</th>
        </tr>
        </thead>";
        echo "<tbody>\n";

        $sec_tab = TRUE; 
        while($row = pg_fetch_array($res,null, PG_ASSOC)){
            $email = $row['email'];
            $firstname = $row['first_name'];
            $surname = $row['surname'];
            $phone_number = $row['phone_number'];
            $date=$row['date_last_connexion'];
            $role=$row['id_role'];
            $inscription_status = $row['inscription_status'];
            
            //retrieve the role in letter (not just the id)

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
                 //fisrt line of tab : columns names
              
                $status = "<form action='' method='post'>
                        <textarea style='visibility:hidden' id='email' name='email'>$email</textarea> 
                        <center><input  type='submit' class = 'confrej' name='confirm' value='Confirm'>
                        <input  type='submit' class = 'confrej' name='reject' value='Reject'>
                        </form>";

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

            else{//the user is already registered
                //another table for the registered users
                 //fisrt line of tab : columns names
                
                
                 if($sec_tab == TRUE){
                    echo "</tbody>";
                    echo "</table>";
                    echo "<br>";

                    echo"<center><table class='bicolor'>\n";
                    echo"<thead>
                    <th>Email</th>
                    <th>First name</th>
                    <th>Surname</th>
                    <th>Phone number</th>
                    <th>Role</th>
                    <th>Date last connexion</th>
                    <th>Inscription status</th>
                    <th>Modify role </th>
                    </tr>
                    </thead>";
                    echo "<tbody>\n";
                     $sec_tab=FALSE;
                 }
              
                 $modify = "<form action='' method='post'>
                         <textarea style='visibility:hidden' id='email' name='email'>$email</textarea> 
                         <select name ='modify_role' type='submit' text-align : left>
                         <option value = '2'>lector</option>
                         <option value = '4'>annotator</option>
                         <option value = '3'>validator</option>
                         <center><input  class = 'modifrole' type='submit'  name='modify' value='Modify'>                  
                         </form>";
 
                 echo "<tr>
                 <td>$email</td>
                 <td>$firstname</td>
                 <td>$surname</td>
                 <td>$phone_number</td>
                 <td>$role</td>
                 <td>$date</td>
                 <td>$inscription_status</td>
                 <td>$modify</td>
                 </tr>";
 
            }

            
            }
            
            echo "</tbody>";
            echo "</table>";

 ?>  

  <link rel="stylesheet" href="css/general.css" />
    <head>
        <div class="content">
        <title>List of users</title>
    </head>
    <body>

    <?php
    }
}
//closing session
disconnect_db ();
?>


