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

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="../TH/css/main.css">
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
  
  
        <div class="col">
        <h2>Item</h2>
    <?php 

        $total=0;
        $output = "";

        $output.="
        <table class='table bordered table-striped'>
        <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total Price</th>
        </tr>
        ";

      if(!empty($_SESSION['cart']))
      {
          foreach($_SESSION['cart'] as $key => $value)
          {
            $output.="
        <tr>
        <td>".$value['id']."</td>
        <td>".$value['product']."</td>
        <td>".$value['price']."</td>
        <td>".$value['quantity']."</td>
        <td>".number_format($value['price']*$value['quantity'],2)."</td>
        <td>
        <a href='cart.php?action=remove&id=".$value['id']."'>
        <button class='btn btn-danger btn-block'>Remove</button>
        </a>
        </tr>
        ";

        $total = $total + $value['quantity']* $value['price'];
          }


          $output .="
          
          <tr>
          <td colspan='3'></td>
          <td>Total Price</td>
          <td>".number_format($total,2)."</td>
          <td>
                <a href='cart.php?action=clearall'>
                    <button class='btn btn-warning'>Clear</button>
                </a>
          </td>
          
               
          
          
          </tr>
          
          
          ";
      }
     
      echo  "<a href='buy.php'>
      <button class='btn btn-success'>Back to shop</button>
  </a>";
  echo $output;

      if(isset($_GET['action']))
      {
          if($_GET['action']=="clearall")
          {
            unset($_SESSION['cart']);

          }
          if($_GET['action']=="remove")
          {
            foreach($_SESSION['cart'] as $key => $value)
            {
          
              if($value['id'] == $_GET['id'])
          {
            unset($_SESSION['cart'][$key]);
          }
      }
    }
}
      ?>
     </div>
  
       
    
        
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