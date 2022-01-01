<?php
include("includes/header.php");

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
					<a>Member since <?php echo date("jS F, Y", strtotime($user['signup_date'])); ?></a>
					<?php echo $user['email'] . "<br>"; ?>
					<?php echo "Team " . $user['team']?>
				</div>
			</form>

			<form action="profile.php" method="POST">
				<div style="text-align:center; margin-top: 10px">
				<input class="editProfileButton" type="submit" name="editAccount" id="editAccount" value="EDIT ACCOUNT">
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
			header("Location: close_account.php");
		}
		else if (isset($_POST['editAccount'])) {
			header("Location: edit_account.php");
		}
		?>
	</body>