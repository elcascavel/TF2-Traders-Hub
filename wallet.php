<?php
require 'config/config.php';
require 'includes/form_handlers/wallet_handler.php';
require 'includes/header.php';

if (!isset($userLoggedIn)) {
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
		<div class="row justify-content-md-center">
			<div class="col-md-auto">
			<h1 class="loginHeader">ADD FUNDS</h1>
		<div class="loginBreak"></div>
			</div>
		</div>
		<div class="row justify-content-md-center">
			<div class="col-lg-2">
			<a href="index.php"> <img class="loginLogo" src="../TH/img/logo.png" /></a>
			</div>
			<div class="col-md-auto text-center">
			<form action="" method="POST">
				<div class="form-floating">

				<input class="form-control" type="text" id="owner" name="owner" placeholder="Card Holder Name" value="<?php

if (!empty($errors) && !isset($errors['owner'][0])) { #this is done to keep the value inputted by the user if this field is valid but others are not
	echo $_POST['owner'];
}

?>"><br> 
<label for="owner">Card Holder Name</label>
</div>
<div class="form-floating">
				<input class="form-control" type="text" id="cardnum" name="cardnum" placeholder="Card Number" value="<?php

if (!empty($errors) && isset($errors['cardnum'][0])) {
	echo $_POST['cardnum'];
}

?>"><br>
<label for="cardnum">Card Number</label>
</div>
<div class="form-floating">
				<input class="form-control" type="text" id="cvv" name="cvv" placeholder="cvv" value="<?php

if (!empty($errors) && isset($errors['cvv'][0])) {
	echo $_POST['cvv'];
}

?>"><br>
<label for="cvv">CVV</label>
</div>
<div class="row">
<div class="col-sm">
<select class="form-select form-select-sm" name="cardname" id="team">
						<option id="visa" name="cardname" value="Visa">Visa</option>
						<option id="mastercard" name="cardname" value="MasterCard">MasterCard</option>
					</select>
</div>
<div class="col-sm">
<select class="form-select form-select-sm" name="amount" id="team">
						<option id="eu5" name="amount" value="5">Add 5,--€</option>
						<option id="eu10" name="amount" value="10">Add 10,--€</option>
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
					if (isset($errors['owner']) && $errors['owner'][0]==true)
					{
						echo $errors['owner'][1] . '<br>';
					}

					if (isset($errors['cardnum']) && $errors['cardnum'][0]==true)
					{
						echo $errors['cardnum'][1] . '<br>';
					}

					if (isset($errors['cvv']) && $errors['cvv'][0]==true)
					{
						echo $errors['cvv'][1] . '<br>';
					}

					if(isset($errors['cardname']) && $errors['cardname'][0]==true)
					{
						echo $errors['cardname'][1] . '<br>';
					}

					if(isset($errors['amount']) && $errors['amount'][0]==true)
					{
						echo $errors['amount'][1] . '<br>';
					}
				}
				 ?>
</div>
			</div>
			</div>
			<div class="row">
<div class="col">
				<?php
				echo "<div class='input-group justify-content-center'>
				<input class='btn btn-primary' name='wallet_button' type='submit' value='Validate'>
				<span class='input-group-text'>€ $money</span>
			  </div>"
				?>
</div>
				</div>
			</form>
			</div>

			<?php


if(isset($_POST['wallet_button']))
{
	if($_POST['amount']=="5")
	{
		$amount = "5";
	$query = "UPDATE users SET money = money +'{$amount}' WHERE id_users='{$userLoggedInID}'";
	$statement = mysqli_prepare($db, $query);
				   
				   
		   if (!$statement ){
			   //error preparing the statement. This should be regarded as a fatal error.
			   echo "Something went wrong. Please try again later.1";
			   die();				
		   }				
				   
		   //execute the prepared statement
		   $result = mysqli_stmt_execute($statement);
							   
		   if( !$result ) {
			   //again a fatal error when executing the prepared statement
			   echo "Something went very wrong. Please try again later.2";
			   die();
		   }
	}
	if($_POST['amount']=="10")
	{
		$amount = "10";
	$query = "UPDATE users SET money = money +'{$amount}' WHERE id_users='{$userLoggedInID}'";
	$statement = mysqli_prepare($db, $query);
				   
				   
		   if (!$statement ){
			   //error preparing the statement. This should be regarded as a fatal error.
			   echo "Something went wrong. Please try again later.1";
			   die();				
		   }				
				   
		   //execute the prepared statement
		   $result = mysqli_stmt_execute($statement);
							   
		   if( !$result ) {
			   //again a fatal error when executing the prepared statement
			   echo "Something went very wrong. Please try again later.2";
			   die();
		   }
	}
	
	
		}

 



?>

			<img style="width:300px" src="../TH/img/soldierRegister.png" data-aos="fade-left" data-aos-delay="200" data-aos-duration="1500" />
		</div>
<div class="row">
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
	</div>
	<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
	<script>
		AOS.init();
	</script>
</body>

</html>