<?php
require 'config/config.php';
require 'includes/form_handlers/login_handler.php';
require 'includes/header.php';

if (isset($userLoggedIn)) {
  header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=9" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TF2 Trader's Hub</title>
  <link rel="shortcut icon" href="https://steamcdn-a.akamaihd.net/apps/tf2/blog/images/favicon.ico" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <link rel="stylesheet" href="../TH/css/main.css" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">

  <link href="http://fonts.cdnfonts.com/css/tf2-build" rel="stylesheet">

  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>

<body style="width: 100%; margin: 0; background-color: black">
    <div class="container">
      <div class="row justify-content-md-center">
        <div class="col-md-auto">
          <h1 class="loginHeader">LOGIN</h1>
          <div class="loginBreak">
          </div>
        </div>
      </div>
      <div class="row justify-content-md-center">
          <div class="col-lg-2">
          <img class="loginLogo" src="../TH/img/logo.png" />
          </div>
            <div class="col-md-auto text-center">
            <form action="" method="POST">
            <div class="form-floating">
            <input class="form-control" type="text" name="log_username" placeholder="Username" id="floatingInput" value="<?php

if (!empty($errors) && !isset($errors['username'][0])) { #this is done to keep the value inputted by the user if this field is valid but others are not
  echo $_POST['username'];
}
?>"><br>
  <label for="floatingInput">Username</label>
</div>
              <div class="form-floating">
              <input class="form-control" type="password" id="floatingInput" name="log_password" placeholder="Password"><br>
              <label for="floatingInput">Password</label>
              </div>
              <div style="display:<?php if ($message == null) {$style = "none"; } else {$style = "block";} echo $style;?>" class="alert alert-warning align-items-center" role="alert">
              <?php if (isset($message)) {
                echo $message;
              } ?>
              </div>
              <input class="btn btn-success" name="login_button" type="submit" value="Login">
              <div class="logSignUp">
                Don't have an account yet? <a class="signUpLink" href="register.php">Sign Up</a>
              </div>
            </form>
            </div>
            <div class="col-md-auto">
            <img style="width:300px" src="../TH/img/demomanLogin.webp" data-aos="fade-left" data-aos-delay="200" data-aos-duration="1500" />
            </div>   
      </div>
      <div class="row">
        <div class="col">
          <footer class="footerArea fixed-bottom">
            <div class="footerLogos">
              <a href="https://www.valvesoftware.com/en/about"><img class="footerLogoImg" src="https://cdn.cloudflare.steamstatic.com/apps/dota2/images/dota_react/valve_logo.png" /></a>
              <a href="https://necm.utad.pt/"><img class="footerLogoImg" src="../TH/img/cmLogo.png" /></a>
            </div>
            <div class="footerLegal">
              Team Fortress is a trademark of Valve Corporation, TF2 Trader's Hub is
              a fan creation and is not affiliated with Valve or Steam.
            </footer>
          </div>
        </div>
      </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
</body>

</html>