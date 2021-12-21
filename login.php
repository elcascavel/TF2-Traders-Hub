<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
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
  
  <?php

  if(!empty ($_POST)){
    
    require_once('cookies/valida.php');

    $errors = validaFormLogin($_POST);

    if(!is_array($errors) && !is_string($errors)){

      require_once('cookies/configDb.php');


      $db = connectDB();


      if(is_string($db)){
          
        echo("Fatal error! Please return later.");
        die();
      }
      

      //building query string
      $username = trim($_POST['username']);
      $password = md5(trim($_POST['password']));


      //construct the intend query
			$query = "SELECT * FROM users WHERE username=? AND password=?";
  
  
      //prepare the statement				
      $statement = mysqli_prepare($db,$query);
				
      if (!$statement ){
      //error preparing the statement. This should be regarded as a fatal error.
        echo "Something went wrong. Please try again later.";
        die();				
      }				
           
      //now bind the parameters by order of appearance
      $result = mysqli_stmt_bind_param($statement,'ss',$username,$password); # 'ss' means that both parameters are expected to be strings.
           
      if ( !$result ){
        //error binding the parameters to the prepared statement. This is also a fatal error.
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
      elseif( mysqli_num_rows($result) == 1){
        //there is one user only with these credentials
               
        //open session
        session_start();
     
        //get user data
        $user = mysqli_fetch_assoc($result);
     
        //save username and id in session					
        $_SESSION['username'] = $user['username'];
        $_SESSION['id'] = $user['id_users'];
   
        //user registered - close db connection
        $result = closeDb($db);
     
        //send the user to another page
        header('Location:index.php');
      }
      else{
        echo "Invalid Username/Password";
        $result = closeDb($db);
      }
      }
      elseif( is_string($errors) ){
          //the function has received an invalid argument - this is a programmer error and must be corrected
          echo $errors;

          //so that there is no problem when displaying the form
          unset($errors);
      }
    }
  ?>
    <div class="homepage">
        <h1 class="loginHeader">LOGIN</h1>
        <div class="loginBreak">
            
        </div>
        <div class="loginFormContainer">
            <img class="loginLogo" src="../TH/img/logo.png"/>
            <form class="loginForm" action="" method="POST">
                <input class="loginInput" type="text" id="username" name="username" placeholder="Username"  value="<?php
  		
      if ( !empty($errors) && !$errors['username'][0] ){ #this is done to keep the value inputted by the user if this field is valid but others are not
        echo $_POST['username'];
      }  
    
    ?>"><br>
    <?php
      if ( !empty($errors) && $errors['username'][0] ){ # Equal to "if ( !empty($errors) && $errors['username'][0] == true ){" #presents an error message if this field has invalid content
        echo $errors['username'][1] . "<br>";
      }  		
    ?>
    <br>
                <input class="loginInput" type="password" id="password" name="password" placeholder="Password" ><br>
                <?php
  			if ( !empty($errors) && $errors['password'][0] ){
  				echo $errors['password'][1] . "<br>";
  			}  		
  		?>
      <br>
                <input class="loginButton" type="submit" value="LOGIN">
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
