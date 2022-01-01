<?php
require_once "cookies/configDb.php";
$username = "";
$email = "";
$password = "";
$rpassword = "";
$team = "";
$date = "";
$errors = array();
$message = "";

$db = connectDB();

if (isset($_POST['register_button'])) {
    include("includes/header.php");
    require_once "config/config.php";
    require_once "validation.php";
    
    $errors = array('username' => array(false, "Invalid username: it must have between $minUsername and $maxUsername chars."),
								    'password' => array(false, "Invalid password: it must have between $minPassword and $maxPassword chars and special chars."),
								    'rpassword' => array(false, "Passwords mismatch."),
								    'email' => array(false,'Invalid email.'),
								    'team' => array(false,'Please select a team.')
								   );
    $flag = false;
    $existingRecord = false;
    
    //Registration form values

    //validate username

    $username = strip_tags($_POST['username']); // Remove html tags
    $username = trim($username);

    if (!validateUsername($username, $minUsername, $maxUsername)) {
        $errors['username'][0] = true;
        $flag = true;
    }

    $email = strip_tags($_POST['email']);
    $email = trim($email);

    if(!validateEmail($email)){
        $errors['email'][0] = true;
        $flag = true;				
    }
    
    $password = strip_tags($_POST['password']);
    $password = trim($password);
    $rpassword = strip_tags($_POST['rpassword']);
    $rpassword = trim($rpassword);

    if(!validatePassword($password, $minPassword, $maxPassword) ){
        $errors['password'][0] = true;
        $flag = true;				
    }
    
    if($rpassword != $password){
        $errors['rpassword'][0] = true;
        $flag = true;
    }

    $password = md5($password);

    $team = $_POST['team'];

    $date = date("Y-m-d");

    //deal with the validation results
    if ( $flag == true ){
        //there are fields with invalid contents: return the errors array
        return($errors);
    }

    if(!checkField($db, $username, $email, "users", "username", "email")) {
        $query = "INSERT INTO users (username, email, password, team, signup_date) VALUES (?, ?, ?, ?, ?)";

        $statement = mysqli_prepare($db, $query);

        if (!$statement) {
            echo "Error preparing statement. Try again later.";
            die();
        }

        $result = mysqli_stmt_bind_param($statement, 'sssss', $username, $email, $password, $team, $date);

        if (!$result) {
            echo "Error binding parameters to prepared statement. Please try again later.";
            die();
        }

        $result = mysqli_stmt_execute($statement);

        if (!$result) {
            echo "Result of prepared statement cannot be executed.";
            die();
        }
        else {
            $result = closeDb($db);

            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;

            header("Location: index.php");
            exit();
        }
    }
}


function checkField($database, $field, $field2, $table, $column1, $column2) {
    $query = "SELECT username, email FROM $table WHERE $column1=? OR $column2=?";

    $statement = mysqli_prepare($database, $query);

    if (!$statement) {
        echo "Error preparing $column1 or $column2 statement.";
        die();
    }

    $result = mysqli_stmt_bind_param($statement, 'ss', $field, $field2);

    if (!$result) {
        echo "Error binding prepared $column1 or $column2 statement.";
        die();
    }

    $result = mysqli_stmt_execute($statement);

    if (!$result) {
        echo "Prepared statement result cannot be executed.";
        die();
    }

    $result = mysqli_stmt_get_result($statement);

    if (!$result){
        echo 'Prepared statement result cannot be stored.';
        die();
    }

    if (mysqli_num_rows($result) != 0) {
        global $message;
        $message = "<a class='errorMessage'>Username or email is already in our records!</a><br><br>";
        $result = closeDb($database);
        return true;
    }
    else {
        return false;
    }
}
?>