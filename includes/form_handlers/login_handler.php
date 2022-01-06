<?php

$errors = array();
$message = "";

if (isset($_POST['login_button'])) {
    require_once "config/config.php";
    require_once('cookies/configDb.php');

    $db = connectDB();

    $username = trim($_POST['log_username']);

    $_SESSION['log_username'] = $username;
    $password = md5(trim($_POST['log_password']));

    $query = "SELECT * FROM users WHERE username = ? AND password = ?";

    $statement = mysqli_prepare($db, $query);

    if (!$statement) {
        echo 'Error preparing login statement.';
        die();
    }

    $result = mysqli_stmt_bind_param($statement, 'ss', $username, $password);

    if (!$result) {
        echo 'Error binding prepared login statement.';
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

    else if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = $user['is_admin'];
        $_SESSION['id_users'] = $user['id_users'];

        $result = closeDb($db);

        header('Location:index.php');
        exit();
    }

    else {
        $message = 'The username or password was incorrect.<br>Please try again (make sure your caps lock is off).';
        $result = closeDb($db);
    } 
}
else if (is_string($errors)){
    echo $errors;
    unset($errors);
}
?>