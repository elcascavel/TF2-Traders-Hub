<!DOCTYPE html>
<html>
    <?php
     
     require 'config/config.php';
     require 'includes/form_handlers/contact_handler.php';
     require 'includes/header.php';
        
        if (!isset($_SESSION['username'])) {
         header("Location: index.php");
        }

    ?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=9">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TF2 Trader's Hub</title>
        <link rel="shortcut icon" href="https://steamcdn-a.akamaihd.net/apps/tf2/blog/images/favicon.ico">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/6d446694b5.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../TH/css/main.css">
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    </head>
    
    <body style="width:100%;margin:0;background-color:black">
        <div class="homepage">
            <div class="headerParentNonIndex">
                <a class ="headerLogo" href="index.php"></a>
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
                <div class="navSide">
                    <div class="navSideContent">
                        <a class="accountActions" href="login.php" >
                        
                        <?php 
                                if(!isset($_SESSION['username']))
                                {      
                                        echo "Login";
                                }
                                                    
                        ?>
                         </a>

                         <a class="accountActionsLogin">
                       <?php 
                       
                    
                       if(isset($userLoggedIn))
                       {
                               
                        if($money == 0)
                        {
                            echo "<h5>$userLoggedIn <span class='badge bg-success'>0€</span></h5>";
                        }else
                        {
                            echo "<h5>$userLoggedIn <span class='badge bg-success'>$money €</span></h5>"; 
                        }
                       }
                           ?>
                        </a>
                        
                        
                           
                        <?php
                        
                        require_once('cookies/configDb.php');
                          
                      //connected to the database
                      $db = connectDB();
                              
                      //success?				
                      if ( is_string($db) ){
                          //error connecting to the database
                          echo ("Fatal error! Please return later.");
                          die();
                      }
                      
                      //select all columns from all users in the table
                      $query = "SELECT id_users,username,email,team FROM users";
                        
                        //prepare the statement				
                      $statement = mysqli_prepare($db, $query);
                              
                      if (!$statement ){
                          //error preparing the statement. This should be regarded as a fatal error.
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
                            if( !empty ($_SESSION) && array_key_exists("username", $_SESSION))
                            {   
                                
                                while( $row = mysqli_fetch_assoc($result) ){
                                    if($row['username'] == $_SESSION['username']){
                                        echo '<div class="accountActionsButtonContainer">';

                                echo '<form action="profile.php" method="POST" name="formModifica">
                                <input type="hidden" value="' . $row['id_users'] . '" name="id">
                                <input class="profileActionButton profileActionAccountImg" type="submit" name="modificar" value="">
                            </form>
                                <a class="profileActionButton profileActionWalletImg" href="wallet.php"> </a>
                                <a class="profileActionButton profileActionLogoutImg" href="logout.php"> </a>
                                </div>';
                                    
                                    }  
                                }
                            }
                        ?>
                        

                        <a class="accountActions" href="register.php">
                        <?php
                        if (!isset($_SESSION['username'])) {
                            echo "Sign Up";
                        }
                                
                         ?>
                         </a>

                    </div>
                </div>
            </div>
        </div>
        <body style="width: 100%; margin: 0; background-color: black">
 	<div class="container">
		 <div class= "row justify-content-md-center">
			 <div class="col-md-auto">
			 <h1 class="loginHeader">Talk to Us</h1>
 		<div class="loginBreak"></div>
			 </div>
		 </div>
		 <div class="row justify-content-md-center">
 			<div class="col-lg-2">
		 		<img class="loginLogo" src="../TH/img/logo.png" />
			</div>
			<div class="col-md-auto text-center">
 			<form action="contact.php" method="POST">
				 <div class="form-floating">
				 <input class="form-control" type="text" id="floatingInput" name="name" placeholder="Name" value="<?php
					
					if (!empty($errors) && !isset($errors['name'][0])) 
					{ #this is done to keep the value inputted by the user if this field is valid but others are not	
						
						echo $_POST['name'];
					}
						?>"><br>
						<label for="floatingInput">Name</label>
				 </div>
 				<div class="form-floating">
 				<input class="form-control" type="email" id="floatingInput" name="email" placeholder="E-mail" value="<?php

				if (!empty($errors) && !isset($errors['email'][0]) ) 
				{
					echo $_POST['email'];	
				}
					?>"><br>
					<label for="floatingInput">Email</label>
				</div>
				<div class="form-floating">
  <textarea class="form-control" placeholder="Leave a message here" id="floatingTextarea2" name="message" style="height: 100px" value="<?php 
                if (!empty($errors) && !isset($errors['message'][0]) ) 
				{
					echo $_POST['message'];
				}
                ?>">
</textarea>
  <label for="floatingTextarea2">Send your message</label>
			</div>

				 <div class="row">
					 <div class="col-sm">
					<div style="display:<?php if (empty($errors)) {$style = "none"; $alertStyle="alert-success"; } elseif(!empty($errors)) {$style = "block"; $alertStyle="alert-warning";} echo $style;?>" class="alert <?php echo "$alertStyle ";?>  align-items-center" role="alert">
  <?php
  if (isset($text)) {
	echo $text;
}

				 if (!empty($errors)) {
                      # Equal to "if ( !empty($errors) && $errors['username'][0] == true ){" #presents an error message if this field has invalid content
					if (isset($errors['name']) && $errors['name'][0]==true)
					{
						echo $errors['name'][1] . '<br>';
					}

					if (isset($errors['email']) && $errors['email'][0]==true)
					{
						echo $errors['email'][1] . '<br>';
					}

					if (isset($errors['message']) && $errors['message'][0]==true)
					{
						echo $errors['message'][1] . '<br>';
					}

				}
				 ?>
</div>		 
					 </div>			 
				 </div>		 
 				<input class="btn btn-primary mt-2" type="submit" name="send_button" value="Send">
 				
 			</form>
			</div>
			<div class="col-md-auto">
 			<img style="width:300px" src="../TH/img/soldierRegister.png" data-aos="fade-left" data-aos-delay="200" data-aos-duration="1500" />
			</div>
			 </div>
			 <div class="row">
	<div class="col">
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
 		</div>
 	<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
 	<script>
 		AOS.init();
 	</script>
 </body>