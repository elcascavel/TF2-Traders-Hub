<?php

$username = "";
$email = "";
$password = "";
$rpassword = "";
$team = "";
$date = "";
$errors = array();

if (isset($_POST['register_button'])) {
    require_once "config/config.php";
    require_once "validation.php";
    
    $errors = array('username' => array(false, "Invalid username: it must have between $minUsername and $maxUsername chars."),
								    'password' => array(false, "Invalid password: it must have between $minPassword and $maxPassword chars and special chars."),
								    'rpassword' => array(false, "Passwords mismatch."),
								    'email' => array(false,'Invalid email.'),
								    'team' => array(false,'Please select a team.')
								   );
    $flag = false;
    
    //Registration form values

    //validate username

    $username = strip_tags($_POST['username']); // Remove html tags
    $username = trim($username);

    if (!validateUsername($username, $minUsername, $maxUsername)) {
        $errors['username'][0] = true;
        $flag = true;
    }
    else {
        $_SESSION['username'] = $username;
    }

    $email = strip_tags($_POST['email']);
    $email = trim($email);

    if(!validateEmail($email)){
        $errors['email'][0] = true;
        $flag = true;				
    }
    else 
    {
        $_SESSION['email'] = $email;
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

    $team = $_POST['team'];

    $date = date("Y-m-d");

    //deal with the validation results
    if ( $flag == true ){
        //there are fields with invalid contents: return the errors array
        return($errors);
    }
}

if (!empty($_POST)) { 
    if (!is_array($errors && !is_string($errors))) {
        require_once('cookies/configDb.php');

        $db = connectDB();

        if (is_string ($db)) {
            echo ("Error connecting to database!");
            die();
        }

        $password = md5($password);

        $query = "SELECT username,email FROM users WHERE username=? OR email=?";

        $statement = mysqli_prepare($db, $query);

        if (!$statement) {
            echo "Error preparing statement. Try again later";
            die();
        }

        $result = mysqli_stmt_bind_param($statement, 'ss', $username, $email);

        if (!$result) {
            echo "Error binding parameters to prepared statement. Please try again later";
            die();
        }

        $result = mysqli_stmt_execute($statement);

        if (!$result) {
            echo "Error executing prepared statement.";
            die();
        }

        $result = mysqli_stmt_get_result($statement);

        if (!$result) {
            echo "Result of prepared statement cannot be stored.";
            die();
        } 
        else if (mysqli_num_rows($result) == 0) {
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
                echo "Result of prepared statement cannot be stored 2.";
                die();
            }
            else {
                $result = closeDb($db);
                header("Location: index.php");
                exit();
            }
        }
        else {
            $existingRecords = array('email' => false, 'username' => false);

            while ($row = mysqli_fetch_assoc($result)) {
                if ($row !== null && $row['username'] == $username) {
                    $existingRecords['username'] = true;
                }
                if ($row !== null && $row['email'] == $email) {
                    $existingRecords['email'] = true;
                }
            }
        }
    }
    else if (is_string($errors)) {
        echo $errors;
        unset($errors);
    }
}
?>