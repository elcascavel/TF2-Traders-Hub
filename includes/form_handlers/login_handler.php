<?php

$errors = array();

if (isset($_POST['login_button'])) {
    require_once "config/config.php";
    require_once('cookies/configDb.php');
    $errors = array('username' => array(false, "Invalid username: it must have between $minUsername and $maxUsername chars."),
								    'password' => array(false, "Invalid password: it must have between $minPassword and $maxPassword chars and special chars."),
								    'rpassword' => array(false, "Passwords mismatch."),
								    'email' => array(false,'Invalid email.'),
								    'team' => array(false,'Please select a team.')
								   );

    $db = connectDB();

    $username = trim($_POST['log_username']);

    $_SESSION['log_username'] = $username;
    $password = md5(trim($_POST['log_password']));

    $query = "SELECT * FROM users WHERE username = ? AND password = ?";

    $statement = mysqli_prepare($db, $query);

    if (!$statement) {
        echo '<a class="errorMessage">Error preparing login statement.</a><br><br>';
        die();
    }

    $result = mysqli_stmt_bind_param($statement, 'ss', $username, $password);

    if (!$result) {
        echo '<a class="errorMessage">Error binding prepared login statement.</a><br><br>';
        die();
    }

    $result = mysqli_stmt_execute($statement);

    if (!$result) {
        echo '<a class="errorMessage">Prepared statement result cannot be executed.</a><br><br>';
        die();
    }

    $result = mysqli_stmt_get_result($statement);

    if (!$result){
          echo '<a class="errorMessage">Prepared statement result cannot be stored.</a><br><br>';
        die();
    }

    else if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        $_SESSION['username'] = $user['username'];

        $result = closeDb($db);

        header('Location:index.php');
        exit();
    }

    else {
        echo '<a class="errorMessage">Invalid Username/Password</a><br><br>';
      $result = closeDb($db);
    } 
}
else if( is_string($errors) ){
    
    echo $errors;

    
    unset($errors);
}
?>