<?php
include("includes/header.php");
include("includes/form_handlers/settings_handler.php");

if (!isset($userLoggedIn)) {
	header("Location: index.php");
}

?>
<!DOCTYPE html>
<html>

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
			<div class="headerParentProfile">
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
			<div class="profileContainer">
				<?php if ($user['team'] == "RED") {
					$teamColor = "#B8383B";
				}
				else if ($user['team'] == "BLU") {
					$teamColor = "#5885A2";
				}
					echo "<h3 style=color:$teamColor;>$userLoggedIn</h3"; 
				?>
			</div>
			<div class="profileDetails">

					<form action="edit_account.php" method="POST" >
						<input class="loginInput" type="text" id="username" name="username" placeholder="Username" value="<?php
					
					if (!empty($errors) && isset($errors['username'][0])) { 
						echo $_POST['username'];
					}
					elseif( !empty($user) ){
						echo $user['username'];
					}
						?>"><br>
						
                        <input class="loginInput" type="text" id="email" name="email" placeholder="E-mail" value="<?php
  		
		  if (!empty($errors) && isset($errors['email'][0])){ 
			  echo $_POST['email'];
		  }
		  elseif( !empty($user) ){
			  echo $user['email'];
		  }
	  
	  ?>"><br>
      <input class="loginInput" type="password" id="password" name="password" placeholder="New Password">
						<br>
						<input class="loginInput" type="password" id="rpassword" name="rpassword" placeholder="Repeat Password">
					
  <br>
						<div style="text-align:center; padding-bottom:10px">
						<select class="teamSelect" name="team" id="team">
  						<option id="redTeam" value="RED">RED</option>
  						<option id="bluTeam" value="BLU">BLU</option>
						</select>
						</div><br>
						<?php if (isset($message)) { echo $message; } ?><br>
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
				</div>
				<div style="text-align:center; margin-top: 10px">
				<input class="editProfileButton" type="submit" name="saveAccount" id="saveAccount" value="SAVE">
				<input class="editProfileButton" type="submit" name="cancelAccount" id="cancelAccount" value="CANCEL">
				</div>
			</form>
		</div>
		</div>
		</div>
		</div>
		</div>

		<?php
		if (isset($_POST['cancelAccount'])) {
			header("Location: profile.php");
		}
		?>
	</body>