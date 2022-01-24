<?php

$errors = array();

$toastClass = "hide";
$toastMessage = "";

if (isset($_POST['login_button'])) {
    require_once "config/config.php";
    require_once 'config/configDb.php';

    $errors = array('username' => array(false, "Invalid username / password. This username may already exist. Make sure your caps lock is off.")
    );

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

    if (!$result) {
        echo 'Prepared statement result cannot be stored.';
        die();
    } else if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = $user['is_admin'];
        $_SESSION['id_users'] = $user['id_users'];

        $result = closeDb($db);

        header('Location:index.php');
        exit();
    } else {
        $errors['username'][0] = true;
        $toastClass = "fade show";
        return $errors;
        $result = closeDb($db);
    }
} else if (is_string($errors)) {
    echo $errors;
    unset($errors);
}
