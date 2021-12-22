<!DOCTYPE html>
<html>
<?php
session_start();
if (!isset($_SESSION['username'])) {
	header("Location: index.php");
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
				<div class="userInfo">
					<a class="userInfoUsername">
						<?php
						if (!empty($_SESSION) && array_key_exists("username", $_SESSION)) {
							echo $_SESSION['username'];
						}
						?>
					</a>
					<a>Member since December 22, 2021</a>
					<a>
						<?php
						 if (!empty($_SESSION) && array_key_exists("team", $_SESSION)) {
							echo $_SESSION['team'] . " Team";
						}
						?>
				</div>     
			</div>
			<nav class="navProfileButtons">
					<ul >
						<li>
							<a>
								<div id="overviewButton" class="navButton">
									Overview
								</div>
							</a>
						</li>
						<li>
							<a>
								<div id="statsButton" class="navButton">
									Stats
								</div>
							</a>
						</li>
					</ul>
				</nav>
				<div class = "overviewContent">
						
				</div>
		</div>
	<script>
		let isClicked = false;
		document.getElementById("overviewButton").onclick = function() {
			if (isClicked == false) {
				document.getElementById("overviewButton").classList.toggle('navButtonSelected');
				isClicked = true;
			}
			
		}
		document.getElementById("statsButton").onclick = function() {
			if (isClicked == false) {
				document.getElementById("statsButton").classList.toggle('navButtonSelected');
				isClicked = true;
			}
		}
	</script>
	</body>