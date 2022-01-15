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

	<body style="width:100%;margin:0;background-color:#282a36">
		<div class="homepage">
			<div class="headerParentProfile">
				<a class="headerLogo" href="index.php"></a>
				<div class="headerNavItems">
					<a class="navLink" href="trade.php">
						Trade
					</a>
					<a class="navLink" href="buy.php">
						Buy
					</a>
					<a class="navLink" href="contact.php">
                        Contact
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
					<div class='container'>
	<div class="row justify-content-center mt-5">
		<h2>Items</h2>
			<?php
           $id=$_SESSION['id_trade'];
           
			if(isset($_POST['trade_button']))
			{
				$value = $_POST['id_inv'];


				$query = "UPDATE trades SET offer_itemName=(SELECT name FROM inventory

                WHERE id_inv = '{$value}'),
                                offer_itemImage = (SELECT item_image FROM inventory
                
                WHERE id_inv = '{$value}'),
                               id_user2 = (SELECT id_users FROM inventory
                
                WHERE id_inv = '{$value}'),
                                username2 = (SELECT username FROM inventory
                
                WHERE id_inv = '{$value}')
                
                WHERE
                id_trade='{$id}'";
           		$statement = mysqli_prepare($db, $query);
          
               
      			 if (!$statement ){
          
         		  echo "Something went wrong. Please try again later.1";
          		 die();				
      			 }		
	
     
       			$result = mysqli_stmt_execute($statement);
                           
      				 if( !$result ) {
           
         				echo "Something went very wrong. Please try again later.26";
          				die();
      				 }

					   
					   $delete_query = "DELETE from inventory WHERE id_inv=?";
					   $statement = mysqli_prepare($db, $delete_query);
         
             if (!$statement) {
                 echo "Error preparing statement. Try again later";
                 die();
             }
             $result = mysqli_stmt_bind_param($statement, 'i', $value);
        
            if (!$result) {
                echo 'Error binding prepared login statement.';
                die();
            }
            
         $result = mysqli_stmt_execute($statement);
                          
         if( !$result) {
             
             echo "Something went very wrong. Please try again later.21";
             die();
         }
         header("Location:trade.php");

			}
			$query = "SELECT * FROM inventory WHERE id_users = $userLoggedInID";

			$result = mysqli_query($db,$query);

			while($row = mysqli_fetch_array($result))
			{
			echo "
			<div class='col-lg-3 mb-3 d-flex align-items-stretch'>
			<div class='col'>
			<div class='card' style='width: 18rem; background-color: #101822; padding-bottom:50px;'>
			<form action='inventory.php' method='POST'>
			<img class='card-img-top' style='background-color: #071215' src='".$row["item_image"]."'>
			<div class='card-body d-flex flex-column'>
			<h6 class='card-subtitle text-white text-center'>". $row['name']."</h6>
			<div class='card-footer text-center' style='position:absolute; bottom:10px; margin-left: 0; margin-right: 0; left:0; right:0'>
			<input type='hidden' name='id_inv' value=" . $row['id_inv'] . ">
			<input type='submit' class='btn btn-primary' name='trade_button' value='Add to Trade'>
			</form>
			</div>
			</div>
			</div>
			</div>
			</div>";
			}
		?>
		</div>
		</div>
	</body>