<?php
    function validaFormModifica ($data) {
        require_once('config.php');

        $errors = array('password' => array(false, "Invalid password: it must have between $minPassword and $maxPassword chars and special chars."),
								    'rpassword' => array(false, "Passwords mismatch."),
								    'email' => array(false,'Invalid email.')
								   );

		$flag = false;

        if (!is_array($data) || count(array_intersect(array_keys($errors), array_keys($data) ) ) < sizeof($errors)) {
            return("This function needs a parameter with the following format: array(\"password\"=> \"value\", \"rpassword\"=> \"value\", \"email\"=> \"value\"");
			die();
        }

        $data['password'] = trim($data['password']);
		$data['rpassword'] = trim($data['rpassword']);
		$data['email'] = trim($data['email']);

        if (!validatePassword($data['password'], $minPassword, $maxPassword)) {
            $errors['password'][0] = true;
            $flag = true;
        }

        else if ($data['rpassword'] != $data['password']) {
            $errors['rpassword'][0] = true;
            $flag = true;
        }

        if (!validateEmail($data['email'])) {
            $errors['email'][0] = true;
            $flag = true;
        }

        if ($flag == true) {
            return($errors);
        }
        else {
            return true;
        }
    }

     function validaFormLogin ($data){//include the web application configuration file to have boundaries to be able to validate fields
     require_once('config.php');
     
     $errors = array('username' => array(false, "Invalid username: it must have between $minUsername and $maxUsername chars."),
                         'password' => array(false, "Invalid password: it must have between $minPassword and $maxPassword chars and special chars."),
                         );	
     
     $flag = false;		
             
     /* Check if the imputed data is according what is expected for this function
      * In short, $data must have at least the necessary fields to enable their validation.
      */
     if ( !is_array($data) || count (array_intersect(array_keys($errors), array_keys($data) ) ) < sizeof($errors) ){
         return("This function needs a parameter with the following format: array(\"username\"=> \"value\", \"password\"=> \"value\")");
         die();
     }			
 
     $data['username'] = trim($data['username']);
     $data['password'] = trim($data['password']);
         
     //validate username
     if( !validateUsername($data['username'], $minUsername, $maxUsername) ){
         $errors['username'][0] = true;
         $flag = true;				
     }
     //validate password
     if( !validatePassword($data['password'], $minPassword, $maxPassword) ){
         $errors['password'][0] = true;
         $flag = true;				
     }
     
     //deal with the validation results
     if ( $flag == true ){
         //there are fields with invalid contents: return the errors array
         return($errors);
     }
     else{
         //all fields have valid contents
         return(true);				
     }
 }

    function validaFormRegisto ($data) {
        require_once('config.php');

        $errors = array('username' => array(false, "Invalid username: it must have between $minUsername and $maxUsername chars."),
								    'password' => array(false, "Invalid password: it must have between $minPassword and $maxPassword chars and special chars."),
								    'rpassword' => array(false, "Passwords mismatch."),
								    'email' => array(false,'Invalid email.'),
								    'team' => array(false,'Please select a team.')
								   );

				$flag = false;

                if ( !is_array($data) || count (array_intersect(array_keys($errors), array_keys($data) ) ) < sizeof($errors) ){
					return("This function needs a parameter with the following format: array(\"username\"=> \"value\", \"password\"=> \"value\", \"rpassword\"=> \"value\", \"email\"=> \"value\", [optional] \"team\"=> \"value\")");
					die();
				}

                $data['username'] = trim($data['username']);
				$data['password'] = trim($data['password']);
				$data['rpassword'] = trim($data['rpassword']);
				$data['email'] = trim($data['email']);

                //validate username
				if( !validateUsername($data['username'], $minUsername, $maxUsername) ){
					$errors['username'][0] = true;
					$flag = true;				
				}
			
				//check if team is selected
				if ( !array_key_exists('team', $data)){
					$errors['team'][0] = true;
					$flag = true;
				}		
				
				//check password
				if( !validatePassword($data['password'], $minPassword, $maxPassword) ){
					$errors['password'][0] = true;
					$flag = true;				
				}
				elseif( $data['rpassword'] != $data['password']){
					$errors['rpassword'][0] = true;
					$flag = true;
				}
				
				if( !validateEmail($data['email'])){
					$errors['email'][0] = true;
					$flag = true;				
				}
				
				//deal with the validation results
				if ( $flag == true ){
					//there are fields with invalid contents: return the errors array
					return($errors);
				}
				else{
					//all fields have valid contents
					return(true);				
				}
    }

    function validateUsername($username, $min, $max){
				
        $exp = "/^[A-z0-9_]{" . $min . "," . $max .'}$/';			
                                
        if( !preg_match($exp, $username )){
            return (false);				
        }else {
            return(true);
        }
    }

    function validatePassword($data, $min, $max){
        
        $exp = "/^[A-z0-9_\\\*\-]{" . $min . "," . $max .'}$/';			
            
        if( !preg_match($exp, $data)){
            return (false);				
        }else {
            return(true);
        }
    }

    function validateEmail($email){
        
        //remove unwanted chars that maybe included in the email field content
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        
        //verify if the inputted email is according to validation standards
        if( !filter_var($email, FILTER_VALIDATE_EMAIL)){
            return (false);				
        }else {
            return(true);
        }
    }

function validaPayment ($data) {
        require_once('config.php');

        $errors = array('owner' => array(false, "Invalid Name: it must have between $minOwner and $maxOwner chars ando no special chars."),
								    'cardnum' => array(false, "Invalid Card Number: it must have $minNum numbers and no special chars."),
								    'cvv' => array(false, "Invalid CVV."),
								    'cardname' => array(false,'Please select a Card.'),
								    'amount' => array(false,'Please select an Amount.')
								   );

				$flag = false;

                if ( !is_array($data) || count (array_intersect(array_keys($errors), array_keys($data) ) ) < sizeof($errors) ){
					return("This function needs a parameter with the following format: array(\"owner\"=> \"value\", \"cardnum\"=> \"value\", \"cvv\"=> \"value\", \"cardname\"=> \"value\", \"amount\"=> \"value\")");
					die();
				}

                $data['owner'] = trim($data['owner']);
				$data['cardnum'] = trim($data['cardnum']);
				$data['cvv'] = trim($data['cvv']);
				

                
				if( !validateOwner($data['owner'], $minUsername, $maxUsername) ){
					$errors['owner'][0] = true;
					$flag = true;	
                    if ( $flag == true ){
                      
                        return("pila5");
                    }			
				}
			
			
				if ( !array_key_exists('amount', $data)){
					$errors['amount'][0] = true;
					$flag = true;
                    if ( $flag == true ){
                       
                        return("pila");
                    }	
				}
                
                if ( !array_key_exists('cardname', $data)){
					$errors['cardname'][0] = true;
					$flag = true;
                    if ( $flag == true ){
                       
                        return("pila3");
                    }	
				}	
				
				
				if( !validateCardnum($data['cardnum'],$minNum, $maxNum) ){
					$errors['cardnum'][0] = true;
					$flag = true;	
                    if ( $flag == true ){
                        
                        return("pila1");
                    }				
				}
				
                if( !validateCVV($data['cvv'],$mincvv, $maxcvv) ){
					$errors['cvv'][0] = true;
					$flag = true;	
                    if ( $flag == true ){
                        
                        return("pila2");
                    }	
                    			
				}
				
				
				if ( $flag == false ){
					
					return(true);
				}
				
    }

    function validateOwner($owner, $minUsername, $maxUsername){
				
        $exp = "/^[A-z]{" . $minUsername . "," . $maxUsername .'}$/';			
                                
        if( !preg_match($exp, $owner )){
            return (false);				
        }else {
            return(true);
        }
    }

    function validateCardnum($cardnum, $minNum, $maxNum){
        
        $exp = "/^[0-9]{" . $minNum . "," . $maxNum .'}$/';			
            
        if( !preg_match($exp, $cardnum)){
            return (false);				
        }else {
            return(true);
        }
    }

    function validateCVV($cvv, $mincvv, $maxcvv){
        
        $exp = "/^[0-9]{" . $mincvv . "," . $maxcvv .'}$/';			
            
        if( !preg_match($exp, $cvv)){
            return (false);				
        }else {
            return(true);
        }
    }
?>