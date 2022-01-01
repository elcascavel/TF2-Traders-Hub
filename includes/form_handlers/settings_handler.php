<?php
if (isset($_POST['saveAccount'])) {
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

    $db = connectDB();

    $username = $_POST['username'];
    $email = $_POST['email'];

    if (!validateUsername($username, $minUsername, $maxUsername)) {
        $errors['username'][0] = true;
        $flag = true;
    }

    if ($username == $user['username']) {
        return;
    }

    if(!validateEmail($email)){
        $errors['email'][0] = true;
        $flag = true;				
    }

    //deal with the validation results
    if ( $flag == true ){
        //there are fields with invalid contents: return the errors array
        return($errors);
    }

    $query = "SELECT * FROM users WHERE username = ?";

    $statement = mysqli_prepare($db, $query);

    if (!$statement) {
        echo 'Error preparing username statement.';
        die();
    }

    $result = mysqli_stmt_bind_param($statement, 's', $username);

    if (!$result) {
        echo 'Error binding prepared username statement.';
        die();
    }

    $result = mysqli_stmt_execute($statement);

    if (!$result) {
        echo 'Prepared statement result cannot be executed.';
        die();
    }

    $result = mysqli_stmt_get_result($statement);

    if (!$result){
        echo 'Prepared statement result cannot be stored.';
        die();
    }

    if (mysqli_num_rows($result) != 0) {
        $message = '<a class="errorMessage">Username already in use!</a><br><br>';
        $result = closeDb($db);
    }

    else {
        $query = "UPDATE users SET username = ? WHERE username = ?";
        $statement = mysqli_prepare($db, $query);

        if (!$statement) {
            echo 'Error preparing username statement.';
            die();
        }

        $result = mysqli_stmt_bind_param($statement, 'ss', $username, $userLoggedIn);

        if (!$result) {
            echo 'Error binding prepared username statement.';
            die();
        }

        $result = mysqli_stmt_execute($statement);

        if (!$result) {
            echo 'Prepared statement result cannot be executed.';
            die();
        }

        $userLoggedIn = $username;
        $_SESSION['username'] = $username;

        $result = closeDb($db);
        $message = "";
    } 
}

?>