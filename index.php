<!DOCTYPE html>
<html>
    <?php
        include("includes/header.php");
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

    <body style="width:100%;margin:0;background-color:black">
        <div class="homepage">
            <div class="headerParent">
                <a class ="headerLogo" href="index.php"></a>
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
                                echo $userLoggedIn;
                        }
                            ?>
                        </a>
                        
                        
                           
                        <?php
                            if( !empty ($_SESSION) && array_key_exists("username", $_SESSION))
                            {   echo '<div class="accountActionsButtonContainer">
                                <a class="profileActionButton profileActionAccountImg" href="profile.php"> </a>
                                <a class="profileActionButton profileActionWalletImg" href="wallet.php"> </a>
                                <a class="profileActionButton profileActionLogoutImg" href="logout.php"> </a>
                                </div>';
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
            <div class= "backgroundHeader">
                <div class="backgroundVideoContainer">
                    <video class="backgroundVideo" autoplay="" preload="auto" loop="" playsinline muted>
                        <source type="video/mp4" src="../TH/img/video.mp4">
                    </video>
                </div>
                <div class="quoteContainer" data-aos="fade-right" data-aos-delay="500" data-aos-duration="2500">
                    <div>
                        <div class="quote">
                            Trade, buy or sell TF2 skins
                        </div>
                        <div class="quoteCredits">
                            TF2 Trader's Hub is safe and efficient.
                        </div>
                    </div>
                </div>
                <div class="headerFade"></div>
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