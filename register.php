 <?php 
	require 'config/config.php';
	require 'includes/form_handlers/register_handler.php';
	require 'includes/header.php';

	if(isset($userLoggedIn)) {
		header("Location: index.php");
	}
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<title>TF2 Trader's Hub</title>
 	<link rel="shortcut icon" href="https://steamcdn-a.akamaihd.net/apps/tf2/blog/images/favicon.ico" />
	 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
 	<link rel="stylesheet" href="../TH/css/main.css" />

 	<link rel="preconnect" href="https://fonts.googleapis.com">
 	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

 	<link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">

 	<link href="http://fonts.cdnfonts.com/css/tf2-build" rel="stylesheet">

 	<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
 </head>

 <body style="width: 100%; margin: 0; background-color: black">
 	<div class="container">
		 <div class= "row justify-content-md-center">
			 <div class="col-md-auto">
			 <h1 class="loginHeader">SIGN UP</h1>
 		<div class="loginBreak"></div>
			 </div>
		 </div>
		 <div class="row justify-content-md-center">
 			<div class="col-lg-2">
		 		<img class="loginLogo" src="../TH/img/logo.png" />
			</div>
			<div class="col-md-auto text-center">
 			<form action="register.php" method="POST">
				 <div class="form-floating">
				 <input class="form-control" type="text" id="floatingInput" name="username" placeholder="Username" value="<?php
					
					if (!empty($errors) && isset($errors['username'][0])) 
					{ #this is done to keep the value inputted by the user if this field is valid but others are not	
						
						echo $_POST['username'];
					}
						?>"><br>
						<label for="floatingInput">Username</label>
				 </div>
 				<div class="form-floating">
 				<input class="form-control" type="email" id="floatingInput" name="email" placeholder="E-mail" value="<?php

				if (!empty($errors) && isset($errors['email'][0]) ) 
				{
					echo $_POST['email'];	
				}
					?>"><br>
					<label for="floatingInput">E-mail</label>
				</div>
				<div class="form-floating">
 				<input class="form-control" type="password" id="password" name="password" placeholder="Password"><br>
				 <label for="password">Password</label>
			</div>
			<div class="form-floating">
 				<input class="form-control" type="password" id="rpassword" name="rpassword" placeholder="Repeat Password"><br>
				 <label for="floatingInput">Repeat Password</label>
			</div>
 				<div class="row">
					 <div class="col-sm">
					 <div class="logSignUp">
                <p style="font-size: 16px">Pick a team, soldier!</p>
              </div>
					 
				 <select class="form-select form-select-sm" name="team" id="team">
  					<option id="redTeam" value="RED">RED</option>
  					<option id="bluTeam" value="BLU">BLU</option>
				</select>
				</div>
 				</div>
				 <br>
				 <div class="row">
					 <div class="col-sm">
					<div style="display:<?php if (empty($errors)) {$style = "none"; } else {$style = "block";} echo $style;?>" class="alert alert-warning align-items-center" role="alert">
  <?php

if (isset($message)) {
	echo $message;
}
				 if (!empty($errors)) { # Equal to "if ( !empty($errors) && $errors['username'][0] == true ){" #presents an error message if this field has invalid content
					if (isset($errors['username']) && $errors['username'][0]==true)
					{
						echo $errors['username'][1] . '<br>';
					}

					if (isset($errors['email']) && $errors['email'][0]==true)
					{
						echo $errors['email'][1] . '<br>';
					}

					if (isset($errors['password']) && $errors['password'][0]==true)
					{
						echo $errors['password'][1] . '<br>';
					}

					if(isset($errors['rpassword']) && $errors['rpassword'][0]==true)
					{
						echo $errors['rpassword'][1] . '<br>';
					}

					if(isset($errors['team']) && $errors['team'][0]==true)
					{
						echo $errors['team'][1] . '<br>';
					}
				}
				 ?>
</div>		 
					 </div>			 
				 </div>		 
 				<input class="btn btn-success" type="submit" name="register_button" value="Register">
 				<div class="logSignUp">
 					Do you have an account? <a class="loginLink" href="login.php">Login</a>
 				</div>
 			</form>
			</div>
			<div class="col-md-auto">
 			<img style="width:300px" src="../TH/img/soldierRegister.png" data-aos="fade-left" data-aos-delay="200" data-aos-duration="1500" />
			</div>
			 </div>
			 <div class="row">
	<div class="col">
	<div class="footerArea fixed-bottom">
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
</div>
 		</div>

 	<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
 	<script>
 		AOS.init();
 	</script>
 </body>

 </html>