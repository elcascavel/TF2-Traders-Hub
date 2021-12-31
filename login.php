<?php
  require 'config/config.php';
  require 'includes/form_handlers/login_handler.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TF2 Trader's Hub</title>
    <link
      rel="shortcut icon"
      href="https://steamcdn-a.akamaihd.net/apps/tf2/blog/images/favicon.ico"
    />
    <link rel="stylesheet" href="../TH/css/main.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">

    <link href="http://fonts.cdnfonts.com/css/tf2-build" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  </head>

  <body style="width: 100%; margin: 0; background-color: black">
    <div class="homepage">
        <h1 class="loginHeader">LOGIN</h1>
        <div class="loginBreak">
            
        </div>
        <div class="loginFormContainer">
            <img class="loginLogo" src="../TH/img/logo.png"/>
            <form class="loginForm" action="" method="POST">
                <input class="loginInput" type="text" id="log_username" name="log_username" placeholder="Username"  value="<?php
  		
      if ( !empty($errors) && !isset($errors['username'][0])){ #this is done to keep the value inputted by the user if this field is valid but others are not
        echo $_POST['username'];
      }  
    
    ?>"><br>
    <?php
      if ( !empty($errors) && isset($errors['username'][0])){ # Equal to "if ( !empty($errors) && $errors['username'][0] == true ){" #presents an error message if this field has invalid content
        echo $errors['username'][1] . "<br>";
      }  		
    ?>
    <br>
                <input class="loginInput" type="password" id="password" name="log_password" placeholder="Password" ><br>
                <?php
  			if ( !empty($errors) && isset($errors['password'][0])){
  				echo $errors['password'][1] . "<br>";
  			}  		
  		?>
      <br>
                <input class="loginButton" name= "login_button" type="submit" value="LOGIN">
                <div class="logSignUp">
                      Don't have an account yet? <a class="signUpLink" href="register.php">Sign Up</a>
                </div>
              </form>
              <img style="width:300px" src="../TH/img/demomanLogin.webp" data-aos="fade-left" data-aos-delay="200" data-aos-duration="1500"/>
        </div>
      <div class="footerArea">
        <div class="footerLogos">
          <a href="https://www.valvesoftware.com/en/about"
            ><img
              class="footerLogoImg"
              src="https://cdn.cloudflare.steamstatic.com/apps/dota2/images/dota_react/valve_logo.png"
          /></a>
          <a href="https://necm.utad.pt/"
            ><img class="footerLogoImg" src="../TH/img/cmLogo.png"
          /></a>
        </div>
        <div class="footerLegal">
          Team Fortress is a trademark of Valve Corporation, TF2 Trader's Hub is
          a fan creation and is not affiliated with Valve or Steam.
        </div>
      </div>
    </div>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
  </body>
</html>
