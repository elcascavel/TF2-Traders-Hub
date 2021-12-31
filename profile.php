<!DOCTYPE html>
<html>
<?php
session_start();
if (!isset($_SESSION['username'])) {
	header("Location: index.php");
}

require_once('cookies/configDb.php');
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
							echo $_SESSION['username'];
						}
						?>	
					</a>
					<input onclick="editProfile()" class="editProfileButton" type="submit" value="EDIT PROFILE">
					</div>
					<a>Member since December 22, 2021</a>
					<a>
						<?php
						 if (!empty($_SESSION) && array_key_exists("email", $_SESSION)) {
							echo $_SESSION['email'];
						}
						?>
					<a>
						<?php
						 if (!empty($_SESSION) && array_key_exists("team", $_SESSION)) {
							echo $_SESSION['team'] . " Team";
						}
						?>
				</div>
				
				<div id="editProfileContainer" class="userInfo" style="display:none">
						<div class="userInfoEditProfileContainer">
						<form action="" method="POST">
						<input class="loginInput" type="text" id="username" name="username" placeholder="Username" value="<?php
					
						if (!empty($_SESSION) && array_key_exists("username", $_SESSION)) 
						{	
							echo $_SESSION['username'];
						}
						?>"><br>
						</div>

						<input class="loginInput" type="text" id="email" name="email" placeholder="E-mail" value="<?php
					
						if (!empty($_SESSION) && array_key_exists("email", $_SESSION)) 
						{	
							echo $_SESSION['email'];
						}
						?>"><br>
						<input class="loginInput" type="password" id="password" name="password" placeholder="New Password" value=""><br>
						<input class="loginInput" type="rpassword" id="rpassword" name="rpassword" placeholder="Repeat Password" value=""><br>
						<div style="text-align:center; padding-bottom:10px">
						<select class="teamSelect" name="team" id="team">
  						<option id="redTeam" value="RED">RED</option>
  						<option id="bluTeam" value="BLU">BLU</option>
						</select>
						</div><br>
						
						<div style="text-align:center">
							<input onclick="saveProfile()" class="editProfileButton" type="submit" value="SAVE">
							<input onclick="saveProfile()" class="editProfileButton" type="submit" value="CANCEL">
						</div>
						</form>

						<form action="profile.php" method="POST">
						<div style="text-align:center; margin-top: 10px">
							<input class="editProfileButton" type="submit" name="closeAccount" id="closeAccount" value="DELETE ACCOUNT">
						</div>
						</form>
						</div>

						
						</div>
				</div>
			</div>
		</div>

		<?php
			if (isset($_POST['closeAccount'])) {
				header("Location: closeAccount.php");
			}
		?>
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