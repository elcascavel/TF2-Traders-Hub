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
					<a class="navLink" href="buy.php">
						Buy
					</a>
					<a class="navLink" href="sell.php">
						Sell
					</a>
				</div>
			</div>
			<?php  
      	require 'config/config.php';
      	$db = connectDB();
    	if (is_string ($db)) {
        	echo ("Error connecting to database!");
        	die();
    	}
        ?>
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-md-9 col-lg-7 col-xl-5">
        <div class="card" style="border-radius: 15px;">
          <div class="card-body p-4">
            <div class="d-flex text-black">
              <div class="flex-shrink-0">
                <img src="<?php echo $user['user_pic']?>" alt="Generic placeholder image" class="img-fluid" style="width: 180px; border-radius: 10px;">
              </div>
              <div class="flex-grow-1 ms-3">
			  <?php if ($user['team'] == "RED") {
					$teamColor = "#B8383B";
				}
				else if ($user['team'] == "BLU") {
					$teamColor = "#5885A2";
				}
					echo "<h5 class='mb-1'>$userLoggedIn <span class='badge badge-pill' style='background:$teamColor; padding: .25em .45em;'>". $user['team'] ."</span></h5>";
				?>
                <p class="mb-2 pb-1" style="color: #2b2a2a;">Member since <?php echo date("jS F, Y", strtotime($user['signup_date'])); ?></p>
                <div class="d-flex justify-content-start rounded-3 p-2 mb-2" style="background-color: #efefef;">
					<?php echo $user['email'] . "<br>"; ?>
                </div>
                <div class="d-flex pt-1">
				<form action="profile.php" method="POST">
					<input class="btn btn-primary me-1 flex-grow-1" type="submit" name="editAccount" id="editAccount" value="Edit Account">
					<input class="btn btn-danger flex-grow-1" type="submit" name="closeAccount" id="closeAccount" value="Delete Account">
					<div class="row mt-2">
						<div class="col text-center">
					<?php
						if ($userIsAdmin == 1) {
							echo "<input class='btn btn-outline-primary flex-grow-1' type='submit' name='adminPanel' id='adminPanel' value='Admin Panel'>";
						}
					 ?>
					</div>
					</div>
				</form>
                </div>
              </div>
            </div>
          </div>
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
		else if (isset($_POST['adminPanel'])) {
			header("Location: admin.php");
		}
		?>
	</body>