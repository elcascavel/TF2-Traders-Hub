<?php
require_once "cookies/configDb.php";
$name = "";
$email = "";
$message = "";
$date = "";
$alertStyle="";
$errors = array();


$db = connectDB();

if (isset($_POST['send_button'])) {
    include("includes/header.php");
    require_once "config/config.php";
    require_once "validation.php";
    
    $errors = array('name' => array(false, "Invalid Name: it must have between $minOwner and $maxOwner chars and no special chars."),
                    'email' => array(false,'Invalid email.'),
					'message' => array(false, "Write Something please."));
    $flag = false;
    


    $name = strip_tags($_POST['name']); // Remove html tags
    $name = trim($name);

    if (!validateName($name, $minOwner, $maxOwner)) {
        $errors['name'][0] = true;
        $flag = true;
    }

    $email = strip_tags($_POST['email']);
    $email = trim($email);

    if(!validateEmail($email)){
        $errors['email'][0] = true;
        $flag = true;				
    }
    $message = strip_tags($_POST['message']);
    $message = trim($message);

    if (!validateMessage($message, $minContact, $maxContact)) {
        $errors['message'][0] = true;
        $flag = true;
    }
    

    $date = date("Y-m-d");

 
    if ( $flag == true ){
        
        return($errors);
    }


        $query = "INSERT INTO contact (name, email, message, send_date, id_users) VALUES (?, ?, ?, ?,?)";

        $statement = mysqli_prepare($db, $query);

        if (!$statement) {
            echo "Error preparing statement. Try again later.";
            die();
        }

        $result = mysqli_stmt_bind_param($statement, 'ssssi', $name, $email, $message, $date, $user['id_users']);

        if (!$result) {
            echo "Error binding parameters to prepared statement. Please try again later.";
            die();
        }

        $result = mysqli_stmt_execute($statement);

        if (!$result) {
            echo "Result of prepared statement cannot be executed.1";
            die();
        }
     
            else {
                $result = closeDb($db);
                $alertStyle = "alert-success";
                $text = "Message Sent";
            }  
        }
?>