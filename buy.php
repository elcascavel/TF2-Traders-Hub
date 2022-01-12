<!DOCTYPE html>
<html>
<?php
  
   include("includes/header.php");
    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
    }

    if(isset($_POST['add_to_cart']))
    {
      
     
           $teste = $_POST['id'];
           $db = connectDB();
                       
          
               $sql = "INSERT INTO cart (name,price,id,item_image,id_users) SELECT shop.product,shop.price,shop.id,shop.item_image,users.id_users FROM (shop INNER JOIN users ON users.id_users='{$userLoggedInID}') WHERE id='{$teste}' ";
               $statement = mysqli_prepare($db, $sql);
                   
                   
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

    $output="";
    $nodata="";
   
    if(isset($_POST['search']))
    {
      
        $input=$_POST['input'];

        if(!empty($input))
        {
           
            $query="SELECT * FROM shop WHERE product LIKE '%$input%'";
          
       
            $result = mysqli_query($db,$query);

            $output.="";
            $nodata.="";
            

            if(mysqli_num_rows($result)< 1)
            {
                $nodata.= "<div class='alert alert-danger text-center' role='alert'>
                No items found!
              </div>";
            }
            else{
                while($row = mysqli_fetch_assoc($result))
                {
                   
                    if ($row['rarity'] == "Unusual") {
                        $itemRarity = "#8650AC";
                    }
                    else if ($row['rarity'] == "Unique"){
                        $itemRarity = "#FFD700";
                    }
                    else if ($row['rarity'] == "Genuine"){
                        $itemRarity = "#4D7455";
                    }
                    else {
                        $itemRarity = "#B2B2B2";
                    }
                    $output .= '<div class="col-lg-3 mb-3 d-flex align-items-stretch">
                    <div class="card" style="width: 18rem; background-color: #101822; padding-bottom:50px;">
                    
                         <form method="POST" action="buy.php">
                         
                         <img class="card-img-top" style="background-color: #071215" src="'.$row["item_image"].'">
                        <div class="card-body d-flex flex-column">
                        <h5 class="card-title" style="color:'.$itemRarity.'">'. $row["product"].'<span class="badge bg-dark">€'.number_format($row["price"],2).'</span></h5> 
                        <h6 class="card-subtitle text-white">'. $row['item_description'].'</h6>
                          <input type="hidden" name="product" value="'.$row['product'].'">
                          <input type="hidden" name="price" value="'.$row['price'].'">
                          <input type="hidden" name="id" value="'.$row['id'].'">
                          <input type="hidden" name="item_description" value="'.$row['item_description'].'">
                          
                          
                <div class="card-footer" style="position:absolute; bottom: 0;">
                          <div class="input-group">
                  <div class="input-group-prepend">
                  <input type="submit" name="add_to_cart" class="btn btn-success" value="Add to Cart">
                  </div>
             
                </div>
                </div>
                </div>
                        
                         
                        </form>
                        </div>
                        <br>
                        </div>
                        
                     ';
                     
                }

            }

        }  
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
                                       
                                            $db = connectDB();
    if (is_string ($db)) {
        echo ("Error connecting to database!");
        die();
    }

	$quer = "SELECT * FROM cart WHERE id_users='{$userLoggedInID}' ";
    $state = mysqli_prepare($db, $quer);

    if (!$state) {
        echo "Error preparing statement. Try again later";
        die();
    }

    $res = mysqli_stmt_execute($state);

    if (!$res) {
        echo "Error executing prepared statement.";
        die();
    }

    $res = mysqli_stmt_get_result($state);

    if (!$res) {
        echo "Result of prepared statement cannot be stored.";
        die();
    }
  
        $count=mysqli_num_rows($res);
    
    
    
                                            
                                           
                                            echo "<a style='margin-right: 18px' class='fas fa-shopping-cart fa-lg position-relative' href='cart.php'>
                                            <span class='position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger'>
    $count
    <span class='visually-hidden'>items in cart</span>
  </span></a>";

                                           
                                        
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
           <div class="container" style="margin-top: 20px; margin-bottom: 20px; color:black;">
           <form method="post">
                            <div class="row mb-2">
                                <div class="col-md-3">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="input" placeholder="Find your favorite item!" aria-label="Find your favorite item!" aria-describedby="button-addon2">
                                        <input type="submit" name="search" class="btn btn-success" value="Search">
                                    </div>
                                </div>
                            </div>
                        </form>
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
        if(empty($_POST['input'] ))
    {
     
        while($row = mysqli_fetch_assoc($result))
        { if ($row['rarity'] == "Unusual") {
            $itemRarity = "#8650AC";
        }
        else if ($row['rarity'] == "Unique"){
            $itemRarity = "#FFD700";
        }
        else if ($row['rarity'] == "Genuine"){
            $itemRarity = "#4D7455";
        }
        else {
            $itemRarity = "#B2B2B2";
        }
       
        ?>
        <div class="col-lg-3 mb-3 d-flex align-items-stretch">
    <div class="card" style="width: 18rem; background-color: #101822; padding-bottom:50px;">
    
         <form method="POST" action="buy.php">
         
         <img class="card-img-top" style="background-color: #071215" src="<?= $row['item_image'];?>" alt="">
        <div class="card-body d-flex flex-column">
        <h5 class="card-title" style="color: <?= $itemRarity?>"><?= $row['product'];?> <span class="badge bg-dark">€<?= number_format($row['price'],2);?></span></h5> 
        <h6 class="card-subtitle text-white"><?= $row['item_description'];?></h6>
          <input type="hidden" name="product" value="<?= $row['product']  ?>">
          <input type="hidden" name="id" value="<?= $row['id']  ?>">
          <input type="hidden" name="price" value="<?= $row['price']  ?>">
          <input type="hidden" name="item_description" value="<?= $row['item_description']  ?>">
          
          
<div class="card-footer" style="position:absolute; bottom: 0;">
          <div class="input-group">
  <div class="input-group-prepend">
  <input type="submit" name="add_to_cart" class="btn btn-success" value="Add to Cart">
  </div>
 
</div>
</div>
        </div>
         
        </form>
        </div>
        <br>
     </div>
       <?php } 
       
    
   
    }else{
       
        echo $output;
        
    }
       echo $nodata;
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