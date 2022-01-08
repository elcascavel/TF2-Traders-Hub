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
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>TF2 Trader's Hub</title>
	<link rel="shortcut icon" href="https://steamcdn-a.akamaihd.net/apps/tf2/blog/images/favicon.ico">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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
			</div>
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-sm-2 col-md-2 col-xl-2 text-center">
					<form method="post" action="upload.php" enctype="multipart/form-data">
						<img src="<?php echo $user['user_pic']?>" alt="Generic placeholder image" class="img-fluid" style="width: 180px; border-radius: 10px;">
  						<input class="form-control form-control-sm mt-2" id="formFileSm" type="file" name="profileAvatar">
						<input class="btn btn-primary btn-sm mt-2" type="submit" value="Change Avatar">
						</form>
					</div>
					<div class="col-xs-4 col-md-3">
			<form action="edit_account.php" method="POST">
  <div class="form-group">
  <input class="form-control" type="text" id="username" name="username" placeholder="Username" value="<?php
					
					if (!empty($errors) && isset($errors['username'][0])) { 
						echo $_POST['username'];
					}
					elseif( !empty($user) ){
						echo $user['username'];
					}
						?>"><br>
    <input class="form-control" type="text" id="email" name="email" placeholder="E-mail" value="<?php
  		
		  if (!empty($errors) && isset($errors['email'][0])){ 
			  echo $_POST['email'];
		  }
		  elseif( !empty($user) ){
			  echo $user['email'];
		  }
	  ?>"><br>
  </div>
  <div class="form-group">
    <input type="password" class="form-control" type="password" id="password" name="password" placeholder="Password"><br>
	<input type="password" class="form-control" type="password" id="rpassword" name="rpassword" placeholder="Repeat Password"><br>
  </div>
  <div class="form-group">
    <select class="form-control" name="team" id="team">
      <option id="redTeam" value="RED">RED</option>
      <option id="bluTeam" value="BLU">BLU</option>
    </select>
  </div>
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
						<div class="d-flex justify-content-center">
						<input class="btn btn-primary mx-2" type="submit" name="saveAccount" id="saveAccount" value="Save">
	<input class="btn btn-danger" type="submit" name="cancelAccount" id="cancelAccount" value="Cancel">
						</div>
  
</form>
</div>
					</div>
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