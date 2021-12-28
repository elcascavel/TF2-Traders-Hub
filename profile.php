<!DOCTYPE html>
<html>
<?php
session_start();
if (!isset($_SESSION['username'])) {
	header("Location: index.php");
}

  		//this update will be done by having the user id passed on by POST
  		if ( !empty($_POST)){
 					
			/* If there is an user id available in $_POST, then it is the first time showing this page.  			
			 * Data should be loaded from the database and placed on each field that can be changed. 
			 * There are several ways to do this (all fields, one field at a time, etc).
			 * This example will allow the user to change the email and password, only. 
			*/
			
			if ( count($_POST) == 2 && array_key_exists('id', $_POST) && is_numeric(trim($_POST['id'])) ){
				//id parameter is passed on, which does not mean that it exists on the database. 
				 
				//get it to a local variable
				$id = trim($_POST['id']);

				require_once('cookies/configDb.php');
			
				//connected to the database
				$db = connectDB();
				
				//success?				
				if ( is_string($db) ){
					//error connecting to the database
					echo ("Fatal error! Please return later.");
					die();
				}
			
				//check if username or email already exist - Prepared statement
				$query = "SELECT * FROM users WHERE id_users=?";

				//prepare the statement				
				$statement = mysqli_prepare($db,$query);
				if (!$statement ){
					//error preparing the statement. This should be regarded as a fatal error.
					echo "Something went wrong. Please try again later.";
					die();				
				}				
				
				//now bind the parameters by order of appearance
				$result = mysqli_stmt_bind_param($statement,'i', $id);
				if ( !$result ){
					//error binding the parameters to the prepared statement. This is also a fatal error.
					echo "Something went wrong. Please try again later.";
					die();
				}
				
				//execute the prepared statement
				$result = mysqli_stmt_execute($statement);
							
				if( !$result ) {
					//again a fatal error when executing the prepared statement
					echo "Something went very wrong. Please try again later.";
					die();
				}
				
				//get the result set to further deal with it
				$result = mysqli_stmt_get_result($statement);
				
				if (!$result){
					//again a fatal error: if the result cannot be stored there is no going forward
					echo "Something went wrong. Please try again later.";	
					die();
				}
				elseif( mysqli_num_rows($result) == 1 ){
					//there is a user with this id. Get data to a local variable and it will be printed on the form.
					$user = mysqli_fetch_assoc($result);
				}
				else{
					//there is no user with this id: the request has an error.Place an appropriated error message.
								
					header('Location:index.php');					
					die();
				}
			} //end if to get user data to insert in the form
			elseif( array_key_exists('username', $_POST) && array_key_exists('email', $_POST) && array_key_exists('password', $_POST) && array_key_exists('rpassword', $_POST) && array_key_exists('team', $_POST) && array_key_exists('id', $_POST) ){
				//well, the user may have already changed some data and it must be validated

				//get the user's id from the form's hidden field - If this was not from an admin perspective, the user can only change it's own data. Check id saved in session.
				$id = trim($_POST['id']);
			
	  			//include validation tools
  				require_once('cookies/valida.php');
  		
  				//call general form validation function
  				$errors = validaFormModifica($_POST);
  		
  				//check validation result and act upon it
  				if ( !is_array( $errors) && !is_string($errors) ){
				
					require_once('cookies/configDb.php');
			
					//connected to the database
					$db = connectDB();
				
					//success?				
					if ( is_string($db) ){
						//error connecting to the database
						echo ("Fatal error! Please return later.");
						die();
					}
	
					//building query string
					$username = trim($_POST['username']);			
					$email = trim($_POST['email']);			
					$password = md5(trim($_POST['password']));
					$team = $_POST['team']	;		
							
					//check if email already exists - Prepared statement
					$query = "SELECT id_users,username,email,team,password FROM users WHERE email=? OR username=?";

					//prepare the statement				
					$statement = mysqli_prepare($db,$query);	
					if (!$statement ){
						//error preparing the statement. This should be regarded as a fatal error.
						echo "Something went wrong. Please try again later.";
						die();				
					}				
				
					//now bind the parameters by order of appearance
					$result = mysqli_stmt_bind_param($statement,'ss',$username,$email);			
					if ( !$result ){
						//error binding the parameters to the prepared statement. This is also a fatal error.
						echo "Something went wrong. Please try again later.";
						die();
					}
				
					//execute the prepared statement
					$result = mysqli_stmt_execute($statement);		
					if( !$result ) {
						//again a fatal error when executing the prepared statement
						echo "Something went very wrong. Please try again later.1";
						die();
					}
					
					//get the result set to further deal with it
					$result = mysqli_stmt_get_result($statement);
					if (!$result){
						//again a fatal error: if the result cannot be stored there is no going forward
						echo "Something went wrong. Please try again later.";	
						die();
					}
					elseif( mysqli_num_rows($result) == 0 || (mysqli_fetch_assoc($result))['id_users'] == $id){
						
						/*The email does not exist (this means that it is also different from the one the user has).
						 *Even that the password did not changed, there is no problem in updating the data.
						 */
						$query = "UPDATE users SET username=?, email=?, password=?, team=? WHERE id_users=?"; 
					
						//prepare the statement				
						$statement = mysqli_prepare($db,$query);
						if (!$statement ){
							//error preparing the statement. This should be regarded as a fatal error.
							echo "Something went wrong. Please try again later.";
							die();				
						}				
				
						//now bind the parameters by order of appearance
						$result = mysqli_stmt_bind_param($statement,'ssssi',$username, $email, $password, $team, $id);
						if ( !$result ){
							//error binding the parameters to the prepared statement. This is also a fatal error.
							echo "Something went wrong. Please try again later.";
							die();
						}
				
						//execute the prepared statement
						$result = mysqli_stmt_execute($statement);	
						if( !$result ) {
							//again a fatal error when executing the prepared statement
							echo "Something went very wrong. Please try again later.3";
							die();
						}
						else{
					
							//user registered - close db connection
							$result = closeDb($db);
								
							//user information updated
							
							header('Location:index.php');
							
							die();
						}
				}
				else{
					//the returned email does belong to the user that is having it's data updated
					$existingRecords['email'] = true;
					$existingRecords['username'] = true;	
				}
  			}
  			elseif( is_string($errors) ){
				  	//the function has received an invalid argument - this is a programmer error and must be corrected
				  	echo $errors;
				  	
				  	//so that there is no problem when displaying the form
				  	unset($errors);
  			}
  		}
  	}
  	else{
		//this page cannot be loaded without the id data.
		
		header('Location:index.php');
		die();  	
  	}

		//show if there is already either the same username or email in the user table on the database. This code can be placed anywhere the student desires. 
		if ( !empty($existingRecords) ){
			
			if ( $existingRecords['email'] ){
				//the email already exists in the database
				echo "The email already exists in our records.";				
			} elseif ( $existingRecords['username'] ){
				//the email already exists in the database
				echo "The username already exists in our records.";				
			}	
			elseif ( $existingRecords['email'] && $existingRecords['username']){
				//the email already exists in the database
				echo "The username and email already exists in our records.";				
			}			
		}
	  
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=9">
	<title>TF2 Trader's Hub</title>
	<link rel="shortcut icon" href="https://steamcdn-a.akamaihd.net/apps/tf2/blog/images/favicon.ico">
	<link rel="stylesheet" href="../TH/css/main.css">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>

<body>

	<body style="width:100%;margin:0;background-color:black">
		<div class="homepage">
			<div class="headerParent">
				<a class="headerLogo" href="index.php"></a>
				<div class="headerNavItems">
					<a class="navLink" href="index.php">
						Trade
					</a>
					<a class="navLink" href="index.php">
						Buy
					</a>
					<a class="navLink" href="index.php">
						Sell
					</a>
				</div>
			</div>
			<div class="mainProfileContent">
				<div id="profileContainer" class="userInfo">
					<div class=userInfoEditProfileContainer>
					<a class="userInfoUsername">
						<?php
						if (!empty($_SESSION) && array_key_exists("username", $_SESSION)) {
							echo $user['username'];
							
						}
						?>	
					</a>
					<input onclick="editProfile()" class="editProfileButton" type="submit" value="EDIT PROFILE">
					</div>
					<a>Member since December 22, 2021 </a>
					<a>
						<?php
						 if (!empty($_SESSION) && array_key_exists("email", $_SESSION)) {
							echo $user['email'];
						}
						?>
					<a>
						<?php
						 if (!empty($_SESSION) && array_key_exists("team", $_SESSION)) {
							echo $user['team'] . " Team";
						}
						?>
				</div>
				
				<div id="editProfileContainer" class="userInfo" style="display:none">
						<div class="userInfoEditProfileContainer">
						<form action="" method="POST" >
						<input class="loginInput" type="text" id="username" name="username" placeholder="Username" value="<?php
					
					if ( !empty($errors) && !$errors['username'][0] ){ 
						echo $_POST['username'];
						
						
						
					}
					elseif( !empty($user) ){
						echo $user['username'];
					}
						?>"><br>
						<?php
	  if ( !empty($errors) && $errors['username'][0] ){
		  echo $errors['username'][1] . "<br>";
	  }  		
  ?>
						</div>
						
						<input class="loginInput" type="text" id="email" name="email" placeholder="E-mail" value="<?php
  		
		  if ( !empty($errors) && !$errors['email'][0] ){ 
			  echo $_POST['email'];
		  }
		  elseif( !empty($user) ){
			  echo $user['email'];
		  }
	  
	  ?>"><br><?php
	  if ( !empty($errors) && $errors['email'][0] ){
		  echo $errors['email'][1] . "<br>";
	  }  		
  ?>
						<input class="loginInput" type="password" id="password" name="password" placeholder="New Password">
						<?php
  			if ( !empty($errors) && $errors['password'][0] ){
  				echo $errors['password'][1] . "<br>";
  			}  		
  		?><br>
						<input class="loginInput" type="password" id="rpassword" name="rpassword" placeholder="Repeat Password">
						<?php
  			if ( !empty($errors) && $errors['rpassword'][0] ){
  				echo $errors['rpassword'][1] . "<br>";
  			}  		
  		?>
  <br>
						<div style="text-align:center; padding-bottom:10px">
						<select class="teamSelect" name="team" id="team">
  						<option id="redTeam" value="RED">RED</option>
  						<option id="bluTeam" value="BLU">BLU</option>
						</select>
						</div><br>
								
  		<?php
  			//set up an hidden field to sustain the user's id throughout this process.
  			echo '<input type="hidden" name="id" value="' . $id . '"><br>';
  		?>
						<div style="text-align:center">
							<input onclick="saveProfile()" class="editProfileButton" type="submit" value="SAVE<?php 
							
			  						
											$_SESSION['username'] = $user['username'];
											$_SESSION['email'] = $user['email'];
											$_SESSION['team'] = $user['team'];
						
											
																
							?>">
							<input onclick="saveProfile()" class="editProfileButton" type="submit" value="CANCEL">
						</div>
						</form>
						</div>

						
						</div>
				</div>
			</div>
		</div>
		<script>
			let profileInfoBox = document.getElementById("profileContainer");
			let editProfileBox = document.getElementById("editProfileContainer");

			function editProfile() {
				if (profileInfoBox.style.display === "none") {
					profileInfoBox.style.display = "flex";
  				} else {
					profileInfoBox.style.display = "none";
					editProfileBox.style.display = "flex";
  				}
			}

			function saveProfile() {
				if (editProfileBox.style.display == "flex") {
					editProfileBox.style.display = "none";
					profileInfoBox.style.display = "flex";
				}
			}
		</script>
	</body>