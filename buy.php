<!DOCTYPE html>
<html>
<?php
   
   include("includes/header.php");
    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
    }

    if(isset($_POST['add_to_cart']))
    {
        
        if(isset($_SESSION['cart']))
        {
            $session_array_id=array_column($_SESSION['cart'],"id");
                           
          if(!in_array($_GET['id'],$session_array_id))
          {
           

           $count= count($_SESSION['cart']);
           $session_array = array('id' => $_GET['id'],
           "product" => $_POST['product'],   
           "desc" => $_POST['desc'],
           "price" => $_POST['price'],
           "rarity" => $_POST['rarity'],
           "quantity" => $_POST['quantity'] );
           $_SESSION['cart'][$count] =  $session_array;
          
          }

        }else
        {
            $session_array = array('id' => $_GET['id'],
                                   "product" => $_POST['product'],   
                                   "desc" => $_POST['desc'],
                                   "price" => $_POST['price'],
                                   "rarity" => $_POST['rarity'],
                                   "quantity" => $_POST['quantity'] );

            $_SESSION['cart'][0] =  $session_array;
            
        }
    }
    ?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=9">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TF2 Trader's Hub</title>
        <link rel="shortcut icon" href="https://steamcdn-a.akamaihd.net/apps/tf2/blog/images/favicon.ico">
        <link rel="stylesheet" href="../TH/css/main.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    </head>

    <body style="width:100%;margin:0;background-color:black">
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
                       
                    
                        if( !empty ($_SESSION) && array_key_exists("username", $_SESSION))
                        {   
                                
                                echo $_SESSION['username'];
                                
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
  
  
    <?php  
      require 'config/config.php';
      $db = connectDB();
    if (is_string ($db)) {
        echo ("Error connecting to database!");
        die();
    }
      
        $query = "SELECT * FROM shop";
        $result = mysqli_query($db,$query);

        while($row = mysqli_fetch_assoc($result))
        {?>
        <div class="col">
    <div class="card" style="width: 18rem;">
    
         <form method="POST" action="buy.php?id=<?=$row['id'] ?>">
         
         <img class="card-img-top" src="https://www.lagzero.net/wp-content/uploads/2009/08/tf2_heavy.jpg" alt="">
        
         <h2 class="card-title"><?= $row['product'];?></h2> 
          <p class="card-text"><?= $row['desc'];?></p>
          <p class="card-text"><?= $row['rarity'];?></p> 
          <h4><?= number_format($row['price'],2);?>$</h2>  
          <input type="hidden" name="product" value="<?= $row['product']  ?>">
          <input type="hidden" name="price" value="<?= $row['price']  ?>">
          <input type="hidden" name="desc" value="<?= $row['desc']  ?>">
          <input type="hidden" name="rarity" value="<?= $row['rarity']  ?>">
          <input type="number" name="quantity" value="1"><br><br>
          <input type="submit" name="add_to_cart" class="btn btn-primary" value="ADD TO CART">
        </form>
        
       
        </div>
        <br>
     </div>
  
       <?php }
      

      
      
      ?>
    
        
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