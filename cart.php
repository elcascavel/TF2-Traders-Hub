<!DOCTYPE html>
<html>
<?php
   
   include("includes/header.php");
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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="../TH/css/main.css">
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    </head>

    <body style="width:100%;margin:0;background: linear-gradient(165deg, #262f3e, #1a2129);
  background-attachment: fixed;">
        <div class="homepage">
            <div class="headerParentNonIndex">
                <a class ="headerLogo" href="index.php"></a>
                <div class="headerNavItems">
                    <a class="navLink" href="index.php">
                        Trade
                    </a>
                    <a class="navLink" href="buy.php">
                        Buy
                    </a>
                    <a class="navLink" href="index.php">
                        Sell
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
                   
                                echo '<div class="accountActionsButtonContainer">
                                <form action="profile.php" method="POST" name="formModifica">
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
           <div class="container" style="margin-top: 20px; margin-bottom: 20px; color:black;">
  <div class="row">
  <a href='buy.php'>
      <button class='btn btn-success'>Back to shop</button>
  </a>
        <div class="col">
            <br>
      
    <?php 

        $total=0;
        $output = "";

        $output.="
        <table class='table table-sm table-light table-hover table-bordered align-middle text-center'>
        <thead>
        <tr>
        <th style='display:none' scope='col'>ID</th>
        <th scope='col'>Name</th>
        <th scope='col'>Price</th>
        <th scope='col'>Quantity</th>
        <th scope='col'>Total Price</th>
        <th scope='col'>Action</th>
        </tr>
        </thead>
        ";

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
        $query = "SELECT * FROM cart WHERE id_users='{$userLoggedInID}'";
          
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
        
        while($row = mysqli_fetch_assoc($result))
          {   
                   
            $output.="
        <tr>
        <td style='display:none'>".$row['id']."</td>
        <td>".$row['name']."</td>
        <td>€".$row['price']."</td>
        <td>".$row['quantity']."</td>
        <td>€".number_format($row['price']*$row['quantity'],2)."</td>
        <td>
        
        <form action='cart.php' method='post'><input type='hidden' name='cart_id' value=" . $row['id_cart'] . ">
        <button type='submit' name='remove_button' class='btn btn-danger btn-block'>Remove</button></form></td>
        </tr>
        ";
        $total = $total + $row['quantity']* $row['price'];
     
          }
        

          $output .="
          
          <tr>
          <td colspan='2'></td>
          <td>Total Price</td>
          <td>€".number_format($total,2)."</td>
          <td>
          <form action='cart.php' method='post'>
          <button type='submit' name='clear_button' class='btn btn-warning btn-block'>Clear</button></form></td>
    
          <tr>
          <td colspan='3'></td>
          <td>€".number_format($total,2)."</td>
          <td>
          <form action='cart.php' method='post'>
        <button type='submit' name='pay_button' class='btn btn-success btn-block'>Pay</button></form></td>
    
        
          
          </tr>
          
          
          ";
          
      
  echo $output."</table>";

  if(isset($_POST['clear_button']))
  {
            
            $db = connectDB();
            $delete_query = "DELETE from cart WHERE id_users='{$userLoggedInID}'";
               $statement = mysqli_prepare($db, $delete_query);
           
               if (!$statement) {
                   echo "Error preparing statement. Try again later";
                   die();
               }
               //execute the prepared statement
           $result = mysqli_stmt_execute($statement);
                               
           if( !$result) {
               //again a fatal error when executing the prepared statement
               echo "Something went very wrong. Please try again later.2";
               die();
           }
        

          }
      
          if(isset($_POST['pay_button']))
            {
           
                if ($money > $total)
                {
               $query = "INSERT INTO inventory (name,item_image,id_users) SELECT name,item_image,id_users FROM cart WHERE id_users='{$userLoggedInID}'";
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
        
           $delete_query = "DELETE from cart WHERE id_users='{$userLoggedInID}'";
               $state = mysqli_prepare($db, $delete_query);
           
               if (!$state) {
                   echo "Error preparing statement. Try again later";
                   die();
               }
               //execute the prepared statement
           $res = mysqli_stmt_execute($state);
                               
           if( !$res) {
               //again a fatal error when executing the prepared statement
               echo "Something went very wrong. Please try again later.2";
               die();
           }
                   
          } 
          else{
              echo "ÉS POBRE POTA";
          }
        }
if(isset($_POST['remove_button']))
{
    
$query = "SELECT id_cart FROM cart WHERE id_users='{$userLoggedInID}'";

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

while($row = mysqli_fetch_assoc($result))
{

  foreach($row as $value)
  {

    if($value == $_POST['cart_id'])
{
  
  $db = connectDB();
  $delete_query = "DELETE from cart WHERE id_cart='{$value}'";
     $statement = mysqli_prepare($db, $delete_query);
 
     if (!$statement) {
         echo "Error preparing statement. Try again later";
         die();
     }
     //execute the prepared statement
 $result = mysqli_stmt_execute($statement);
                  
 if( !$result) {
     //again a fatal error when executing the prepared statement
     echo "Something went very wrong. Please try again later.2";
     die();
 }
  
}
}
}
  
}
      ?>
     </div>
          </div>
  </a>
</div>
<div class="footerArea">
                <div class="footerLogos">
                    <a href="https://www.valvesoftware.com/en/about"><img class="footerLogoImg" src="https://cdn.cloudflare.steamstatic.com/apps/dota2/images/dota_react/valve_logo.png"></a>
                    <a href="https://necm.utad.pt/"><img class="footerLogoImg" src="../TH/img/cmLogo.png"></a>
                </div>
                
                <div class="footerLegal">
Team Fortress is a trademark of Valve Corporation, TF2 Trader's Hub is a fan creation and is not affiliated with Valve or Steam.
                </div>
            </div> 
    </div>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
    </body>
</html>