<?php
session_start();

//there are different actions for the login and register users scripts only
$currentScript = basename($_SERVER['PHP_SELF'], '.php');

//is this the login script?
if ( $currentScript == "login" || $currentScript == "registerUsers"){

	//present the navbar with different options for either login or register
	if( $currentScript == 'login'){
		echo '<div class="topnav">
				<a class="active" href="registerUsers.php">Register</a>
			</div>';
	}
	else{
		echo '<div class="topnav">
				<a class="active" href="login.php">Login</a>
			</div>';
	}	
	
	//is the user authenticated?
	if ( !empty ($_SESSION) && array_key_exists("username", $_SESSION) ){
		
		//clear any existing status codes
		unset ($_SESSION['code']);
		
		//it must be redirect to the welcome page	
		header('Location:index.php');
		die();			
	}
	elseif(!empty($_SESSION) && array_key_exists("code", $_SESSION)){
		
		//it is not, but there is an error message to show
	 	require_once('errorCodes.php');
	 	echo getErrorMessage($_SESSION['code']) . "<br>";
		
		//clear any existing status codes
		unset ($_SESSION['code']); 	
	}
		
}
else{
	//it is any other script

	//is the user authenticated?	
	if( empty($_SESSION) || !array_key_exists("username", $_SESSION) ){
				
		//It is not! Set up the proper error message and send the user to the login page
		$_SESSION['code'] = 1;
		
		//login.php must be able to deal with errors to present the user with the appropriated error message
		header('Location:login.php');
		die();
	}
	else{
		
		//it is! Present the navigation bar	
		echo '<div class="topnav">
				<a class="active" href="welcome.php">List Users</a>
  				<a href="logout.php">Logout</a>
			</div>';
	
		
		if( !empty($_SESSION) && array_key_exists("code", $_SESSION) ) {
	 		
			//if it is code 1 it must be cleared as the user is authenticated
			if ($_SESSION['code'] == 1){
				unset($_SESSION['code']);			
			}
			else{	 		
	 			//the user was sent here with an error code. Show the proper error message
	 			require_once('errorCodes.php');
	 			echo getErrorMessage($_SESSION['code']) . "<br>";

				//clear all error codes before proceeding	 			
	 			unset($_SESSION['code']);
	 		}
		}	 
	}
}