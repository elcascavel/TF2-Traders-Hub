 <?php 
	require 'config/config.php';
	require 'includes/form_handlers/register_handler.php';
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 	<meta http-equiv="X-UA-Compatible" content="IE=9" />
 	<title>TF2 Trader's Hub</title>
 	<link rel="shortcut icon" href="https://steamcdn-a.akamaihd.net/apps/tf2/blog/images/favicon.ico" />
 	<link rel="stylesheet" href="../TH/css/main.css" />

 	<link rel="preconnect" href="https://fonts.googleapis.com">
 	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

 	<link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">

 	<link href="http://fonts.cdnfonts.com/css/tf2-build" rel="stylesheet">

 	<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
 </head>

 <body style="width: 100%; margin: 0; background-color: black">
 	<div class="homepage">
 		<h1 class="loginHeader">SIGN UP</h1>
 		<div class="loginBreak"></div>
 		<div class="loginFormContainer">
 			<img class="loginLogo" src="../TH/img/logo.png" />
 			<form class="loginForm" action="register.php" method="POST">
 				<input class="loginInput" type="text" id="username" name="username" placeholder="Username" value="<?php
					
					if (!empty($errors) && isset($errors['username'][0])) 
					{ #this is done to keep the value inputted by the user if this field is valid but others are not	
						
						echo $_POST['username'];
					}
						?>"><br>
 				<input class="loginInput" type="email" id="email" name="email" placeholder="E-mail" value="<?php

				if (!empty($errors) && isset($errors['email'][0]) ) 
				{
					echo $_POST['email'];	
				}
					?>"><br>
 				<input class="loginInput" type="password" id="password" name="password" placeholder="Password"><br>
 				<input class="loginInput" type="password" id="rpassword" name="rpassword" placeholder="Repeat Password"><br>
 				<div class="teamPickContainer">
					 <label>Pick your team, soldier!</label><br><br>
				 <select class="teamSelect" name="team" id="team">
  					<option id="redTeam" value="RED">RED</option>
					  
  					<option id="bluTeam" value="BLU">BLU</option>
				</select>
 				</div>
				 <br>
				 <?php
					//show if there is already either the same username or email in the user table on the database. This code can be placed anywhere the student desires. 
					if (!empty($existingRecords)) {

					if ($existingRecords['username'] && $existingRecords['email']) {
			
			//both the username and the email already exist in the database
						echo '<a class="errorMessage"> Both username and email already exist in our records.</a><br><br>';
						} elseif ($existingRecords['username']) {
			
			//only the username exists (you can erase the written username so that it does not show up in the filled form, but it seams better to keep it so that the user knows what was the input)
						echo '<a class="errorMessage"> This username is already taken. Please choose another one.</a><br><br>';
					} else {
			
					//only the email exists (you can erase the written email so that it does not show up in the filled form, but it seams better to keep it so that the user knows what was the input)
						echo '<a class="errorMessage">This email is already taken. Please choose another one.</a><br><br>';
						}
					} //end main if
					?>
				 <?php
				 if (!empty($errors)) { # Equal to "if ( !empty($errors) && $errors['username'][0] == true ){" #presents an error message if this field has invalid content
					
					if (isset($errors['username']) && $errors['username'][0]==true)
					{
						echo '<a class="errorMessage">' . $errors['username'][1] . '</a>' . '<br><br>';
					}

					if (isset($errors['email']) && $errors['email'][0]==true)
					{
						echo '<a class="errorMessage">' . $errors['email'][1] . '</a>' . '<br><br>';
					}

					if (isset($errors['password']) && $errors['password'][0]==true)
					{
						echo '<a class="errorMessage">' . $errors['password'][1] . '</a>' . '<br><br>';
					}

					if(isset($errors['rpassword']) && $errors['rpassword'][0]==true)
					{
						echo '<a class="errorMessage">' . $errors['rpassword'][1] . '</a>' . '<br><br>';
					}

					if(isset($errors['team']) && $errors['team'][0]==true)
					{
						echo '<a class="errorMessage">' . $errors['team'][1] . '</a>' . '<br><br>';
					}
				}
				 ?>
 				<input class="loginButton" type="submit" name="register_button" value="REGISTER">
 				<div class="signUpLog">
 					Do you have an account? <a class="loginLink" href="login.php">Login</a>
 				</div>
 			</form>
 			<img style="width:300px" src="../TH/img/soldierRegister.png" data-aos="fade-left" data-aos-delay="200" data-aos-duration="1500" />
 		</div>

 		<div class="footerArea">
 			<div class="footerLogos">
 				<a href="https://www.valvesoftware.com/en/about"><img class="footerLogoImg" src="https://cdn.cloudflare.steamstatic.com/apps/dota2/images/dota_react/valve_logo.png" /></a>
 				<a href="https://necm.utad.pt/"><img class="footerLogoImg" src="../TH/img/cmLogo.png" /></a>
 			</div>

 			<div class="footerLegal">
 				Team Fortress is a trademark of Valve Corporation, TF2 Trader's Hub is
 				a fan creation and is not affiliated with Valve or Steam.
 			</div>
 		</div>
 	</div>
 	<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
 	<script>
 		AOS.init();
 	</script>
 </body>

 </html>