 <?php

	session_start();
	if (isset($_SESSION['username'])) {
		header("Location: index.php");
	}

	if (!empty($_POST)) {

		//include validation tools
		require_once('cookies/valida.php');

		//call general form validation function
		$errors = validaFormRegisto($_POST);

		//check validation result and act upon it
		if (!is_array($errors) && !is_string($errors)) {

			require_once('cookies/configDb.php');

			//connected to the database
			$db = connectDB();

			//success?				
			if (is_string($db)) {
				//error connecting to the database
				echo ("Fatal error! Please return later.");
				die();
			}

			//building query string
			$username = trim($_POST['username']);
			$email = trim($_POST['email']);
			$password = md5(trim($_POST['password']));
			$team = $_POST['team'];

			//check if username or email already exist - Prepared statement
			$query = "SELECT username,email FROM users WHERE username=? OR email=?";

			//prepare the statement				
			$statement = mysqli_prepare($db, $query);

			if (!$statement) {
				//error preparing the statement. This should be regarded as a fatal error.
				echo "Something went wrong. Please try again later.";
				die();
			}

			//now bind the parameters by order of appearance
			$result = mysqli_stmt_bind_param($statement, 'ss', $username, $email); # 'ss' means that both parameters are expected to be strings.

			if (!$result) {
				//error binding the parameters to the prepared statement. This is also a fatal error.
				echo "Something went wrong. Please try again later.";
				die();
			}

			//execute the prepared statement
			$result = mysqli_stmt_execute($statement);

			if (!$result) {
				//again a fatal error when executing the prepared statement
				echo "Something went very wrong. Please try again later.";
				die();
			}

			//get the result set to further deal with it
			$result = mysqli_stmt_get_result($statement);

			if (!$result) {
				//again a fatal error: if the result cannot be stored there is no going forward
				echo "Something went wrong. Please try again later.";
				die();
			} elseif (mysqli_num_rows($result) == 0) {

				$query = "INSERT INTO users (username, email, password, team) VALUES (?,?,?,?)";

				//prepare the statement				
				$statement = mysqli_prepare($db, $query);

				if (!$statement) {
					//error preparing the statement. This should be regarded as a fatal error.
					echo "Something went wrong. Please try again later.";
					die();
				}

				//now bind the parameters by order of appearance
				$result = mysqli_stmt_bind_param($statement, 'ssss', $username, $email, $password, $team); # 'ssss' means that all parameters are expected to be strings.

				if (!$result) {
					//error binding the parameters to the prepared statement. This is also a fatal error.
					echo "Something went wrong. Please try again later.";
					die();
				}

				//execute the prepared statement
				$result = mysqli_stmt_execute($statement);

				if (!$result) {
					//again a fatal error when executing the prepared statement
					echo "Something went very wrong. Please try again later.";
					die();
				} else {

					//user registered - close db connection
					$result = closeDb($db);

					header("Location: index.php");
					exit();
				}
			} else {
				//there already an username or an email in the database matching the imputed data. Which one is it? Or they both exist?

				//get all rows returned in the result: one can have a row if there is only the email or username or two rows if both exist in different records
				$existingRecords = array('email' => false, 'username' => false);

				//now do it as you normally did it					
				while ($row = mysqli_fetch_assoc($result)) {

					if ($row['username'] == $username) {
						$existingRecords['username'] = true;
					}
					if ($row['email'] == $email) {
						$existingRecords['email'] = true;
					}
				} //end while																
			} //end else	
		} elseif (is_string($errors)) {
			//the function has received an invalid argument - this is a programmer error and must be corrected
			echo $errors;

			//so that there is no problem when displaying the form
			unset($errors);
		}
	}
	?>
 <?php
	//show if there is already either the same username or email in the user table on the database. This code can be placed anywhere the student desires. 
	if (!empty($existingRecords)) {

		if ($existingRecords['username'] && $existingRecords['email']) {
			//both the username and the email already exist in the database
			echo "Both username and email already exist in our records.";
		} elseif ($existingRecords['username']) {
			//only the username exists (you can erase the written username so that it does not show up in the filled form, but it seams better to keep it so that the user knows what was the input)
			echo "This username is already taken. Please choose another one.";
		} else {
			//only the email exists (you can erase the written email so that it does not show up in the filled form, but it seams better to keep it so that the user knows what was the input)
			echo "This email is already taken. Please choose another one.";
		}
	} //end main if
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
 			<form class="loginForm" action="" method="POST">
 				<input class="loginInput" type="text" id="username" name="username" placeholder="Username" value="<?php
						if (!empty($errors) && isset($errors['username'][0])) { #this is done to keep the value inputted by the user if this field is valid but others are not
							echo $_POST['username'];
						}
					?>"><br>
 				<?php
					if (!empty($errors) && isset($errors['username'][0])) { # Equal to "if ( !empty($errors) && $errors['username'][0] == true ){" #presents an error message if this field has invalid content
						echo $errors['username'][1] . "<br>";
					}
					?>
 				<input class="loginInput" type="email" id="email" name="email" placeholder="E-mail" value="<?php

					if (!empty($errors) && isset($errors['email'][0])) {
								echo $_POST['email'];
							}
					?>"><br>
 				<?php
					if (!empty($errors) && isset($errors['email'][0])) {
						echo $errors['email'][1] . "<br>";
					}
					?>
 				<input class="loginInput" type="password" id="password" name="password" placeholder="Password"><br>
 				<?php
					if (!empty($errors) && isset($errors['password'][0])) {
						echo $errors['password'][1] . "<br>";
					}
					?>
 				<input class="loginInput" type="password" id="rpassword" name="rpassword" placeholder="Repeat Password"><br>
 				<?php
					if (!empty($errors) && isset($errors['rpassword'][0])) {
						echo $errors['rpassword'][1] . "<br>";
					}
					?><br>
 				<div class="teamPickContainer">

 					<label>
 						<input type="radio" id="redTeam" name="team" value="RED" <?php
					if (!empty($errors) && isset($errors['team'][0]) && $_POST['team'] == "RED") {
						echo "checked";
					}
					?>>

 						<img class="teamPick" src="../TH/img/redteam" width="10%">
 					</label>
 					<label>
 						<input type="radio" id="bluTeam" name="team" value="BLU" <?php
							if (!empty($errors) && isset($errors['team'][0]) && $_POST['team'] == "BLU") {
										echo "checked";
									}
							?>>
 						<img class="teamPick" src="../TH/img/bluteam" width="10%">
 					</label>


 					<?php
						if (!empty($errors) && isset($errors['team'][0])) {
							echo $errors['team'][1] . "<br>";
						}
						?>
 				</div>
 				<input class="loginButton" type="submit" value="REGISTER">
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