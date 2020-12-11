<!DOCTYPE html>
 <?php

include_once './libphp/db_utils.php';
connect_db ();

ini_set('display_errors',1); 
error_reporting(E_ALL);


if(isset($_POST['login']))
{
   if(isset($_POST['email']) && isset($_POST['password']))
   {
	  $email = $_POST['email'];
      $passwd =$_POST['password'];
      if($email !== "" && $passwd !== "")
      {
		  $query = "SELECT * FROM `users` WHERE email='$email' and password='".hash('sha256', $passwd)."'";
		  $result = pg_query($db_conn,$query) or die('query failed with exception: ' . pg_last_error());
		  $rows = pg_num_rows($result);
		  if($rows==1){
			//changing date
			$querydate = "UPDATE users SET date_last_connexion = CURDATE() WHERE email = '$email'";
			$newdate = pg_query($db_conn,$querydate) or die('query failed with exception: ' . pg_last_error());

			  $_SESSION['email'] = $email;
			  header("Location: home.php");
			
		  }else{
			$message = "Incorrect username or password";
			echo $message;
			}	

    	}
		
	}	
 }

if(isset($_POST['signup']))
{
	$email = $_POST['email'];
	$firstname = $_POST['firstname'];
	$surname = $_POST['surname'];
	$phone_number = $_POST['phone_number'];
	$passwd = $_POST['password'];
	$confpassword = $_POST['confpassword'];
	//$role = $_GET['role'];
	if (!empty($_POST['role'])){
		$role = $_POST['role'];
	} else {
		echo 'Please select your desired profil';
	}

	if(isset(($email), ($firstname), ($surname), ($passwd), ($confpassword), ($role)))
	{
		if(!empty($email) AND !empty($firstname) AND !empty($surname) AND !empty($passwd) AND !empty($confpassword) AND !empty($role))
		{
			if ($passwd == $confpassword) {
				//We check if the email form is valid
				// check if e-mail address is well-formed
				if (filter_var($email, FILTER_VALIDATE_EMAIL))
				{
					//verify if no such email already exists
					$queryemail="SELECT surname FROM users WHERE email='".$email."'";
					$check_email = pg_query($db_conn, $queryemail);
					
					if(!is_null($check_email) and $check_email !== TRUE)
					{
						$querymin = "SELECT id_role FROM role WHERE descriptor LIKE '".$role."'";
						$res = pg_query($db_conn,$querymin)or die('query failed with exception: ' . pg_last_error());
						while($row = pg_fetch_array($result, null, PG_ASSOC)){
						$query = "INSERT INTO users(email, password, first_name, surname, phone_number, date_last_connexion, id_role) 
						VALUES ('".$email."','".hash('sha256', $passwd)."','".$firstname."','".$surname."','".$phone_number."', NOW(), '".$row['role']."')";
						pg_query($db_conn,$query)or die('query failed with exception: ' . pg_last_error());}
	?>

<div class="message"><center>You have successfully been signed up. You can log in.<br />
<a href="index.php"></a></div>
 <?php		
					}
					else
					{
							//Otherwise, we say the email is not available
							$form = true;
							$message = 'The email you want to use is not available, please choose another one.';
							echo $message;
					}
				}
				else
				{
						//Otherwise, we say the email is not valid
						$form = true;
						$message = 'The email you entered is not valid.';
				}

			}
			else
			{
					//Otherwise, we say the passwords are not identical
					$form = true;
					$message = 'The passwords you entered are not identical.';
			}

		}
		else
		{
			$erreur = "Please complete your informations";
		}
	}
}
//closing session
disconnect_db ();
?> 



<html>
	  <meta charset="utf-8">
        <link type="text/css" rel="stylesheet" href="css/general.css"> <!--link css-->
    <head>
		<title>Welcome to AnnotGenome site</title>
      
    </head>  
<body>
        <div id="cnx" href = css/form.css>  
        <div class="name"> AnnotGenome </div>
			<form action="index.php" method="post">
                <table align = "right" class="menutop" width=30% cellspacing="0" border="0">
                    <tr>
                        <td><label><b>Email</b></label>
                        <input type="text" placeholder="Please enter your email" name="email" required></td>
                        <td><label><b>Password</b></label>
                        <input type="password" placeholder="Please enter your password" name="password" required></td>
						<div class="clear"> </div>
						</div>
                        <td><input type="submit" class = "loginout" name="login" value="LOGIN" style = "margin: 20px 0px 0px 0px;"></td>
                    </tr>
                </table>
			</form>
        </div>
    

  


<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Custom Theme files -->
<link href="css/form.css" rel="stylesheet" type="text/css" media="all" />
<!-- //Custom Theme files -->
<!-- web font -->
<link href="//fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,700,700i" rel="stylesheet">
<!-- //web font -->


	<!-- main -->
	<div class="main-w3layouts wrapper">
		<div class="main-agileinfo">
			<div class="agileits-top">
				<form action="index.php" method="post">
                    <p>Don't have an Account? Sign up Now!</p>
                    <label for="text email">email :</label>
					<input class="text email" type="email" name="email" placeholder="Email" required="">
                    <label for="firstname">firstname:</label>
                    <input type="text" id="firstname" name="firstname" required>
                    <label for="surname">surname :</label>
                    <input type="text" id="surname" name="surname" required>
                    <label for="tel">phone number:</label>
                    <input type="text" placeholder="phone number" name="phone_number" > 
                    <label for="password">password :</label>
					<input class="text" type="password" name="password" placeholder="Password" required="">
                    <label for="confirm">confirm password :</label>
					<input class="text w3lpass" type="password" name="confpassword" placeholder="Confirm Password" required="">
                    <label for="role">role :</label>
                    <input type="radio" id="role" name="role" value="Lector">Lector        
                    <input type="radio" id="role" name="role" value="Annotator">Annotator
                    <input type="radio" id="role" name="role" value="Validator">Validator
					<div class="wthree-text">
						<label class="anim">
							<input type="checkbox" class="checkbox" required="">
							<span>I Agree To The Terms & Conditions</span>
						</label>
						<div class="clear"> </div>
					</div>
					<input type="submit" name = "signup" value="SIGNUP">
				</form>
			</div>
		</div>
	</div>
	<!-- //main -->
</body>
</html>
