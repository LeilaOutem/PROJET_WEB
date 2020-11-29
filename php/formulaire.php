<?php
	require("menu.php");
 ?>

<!DOCTYPE html>

<html>

    <head>
        <meta charset="utf-8">
        <link type="text/css" rel="stylesheet" href="css/general.css"> <!--lien css-->
        </head>  
<body>
        <div id="cnx" href = css/form.css>  
        <img src="AnnotGenome.png" height=37px>
                <table align = "right" class="menutop" width=30% cellspacing="0" border="0">
                    <tr>
                        <td><label><b>Email</b></label>
                        <input type="text" placeholder="Please enter your email" name="email" required></td>
                        <td><label><b>Password</b></label>
                        <input type="password" placeholder="Please enter your password" name="password" required></td>
                        <td><input type="submit" id='submit' value='LOGIN' style = "margin: 20px 0px 0px 0px;"></td>
                    </tr>
                    <!-- <div class="login-page"> -->
                </table>
                <!-- <ul id="navlist">
                    <li><a href="menu.php">Home</a></li>
                    <li><a href="search.php">Genome browser</a></li>
                </ul>   -->
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

<div>
	<?php display_menu(); ?>
</div>

	<!-- main -->
	<div class="main-w3layouts wrapper">
		<div class="main-agileinfo">
			<div class="agileits-top">
				<form action="#" method="post">
                    <p>Don't have an Account? Sign up Now!</p>
                    <label for="text email">email :</label>
					<input class="text email" type="email" name="email" placeholder="Email" required="">
                    <label for="firstname">firstname:</label>
                    <input type="text" id="firstname" name="firstname" required>
                    <label for="surname">surname :</label>
                    <input type="text" id="surname" name="surname" required>
                    <label for="tel">phone number:</label>
                    <input type="text" placeholder="phone number" name="phone number" > 
                    <label for="password">password :</label>
					<input class="text" type="password" name="password" placeholder="Password" required="">
                    <label for="confirm">confirm password :</label>
					<input class="text w3lpass" type="password" name="password" placeholder="Confirm Password" required="">
                    <label for="role">role :</label>
                    <input type="radio" name="role">
                    <label for="size_1">Lector</label>            
                    <input type="radio" name="role">
                    <label for="size_1">Annotator</label>
                    <input type="radio" name="role">
                    <label for="size_1">Validator</label>
					<div class="wthree-text">
						<label class="anim">
							<input type="checkbox" class="checkbox" required="">
							<span>I Agree To The Terms & Conditions</span>
						</label>
						<div class="clear"> </div>
					</div>
					<input type="submit" value="SIGNUP">
				</form>
			</div>
		</div>
		<!-- copyright -->
		<!-- <div class="colorlibcopy-agile">
			<p>© 2018 Colorlib Signup Form. All rights reserved | Design by <a href="https://colorlib.com/" target="_blank">Colorlib</a></p>
		</div> -->
		<!-- //copyright -->
		<ul class="colorlib-bubbles">
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
		</ul>
	</div>
	<!-- //main -->
</body>
</html>

      
    </body>

</html>