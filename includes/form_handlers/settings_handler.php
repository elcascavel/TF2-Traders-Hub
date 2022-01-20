<?php
include "includes/header.php";
require_once "config/config.php";
require_once "validation.php";

$errors = array('username' => array(false, "Invalid username: it must have between $minUsername and $maxUsername chars."),
    'password' => array(false, "Invalid password: it must have between $minPassword and $maxPassword chars and special chars."),
    'rpassword' => array(false, "Passwords mismatch."),
    'email' => array(false, 'Invalid email.'),
    'team' => array(false, 'Please select a team.'),
);
$flag = false;
$existingRecords['username'] = false;
$existingRecords['email'] = false;

$db = connectDB();
$message = "";

if (isset($_POST['saveAccount'])) {
    include "includes/header.php";
    require_once "config/config.php";
    require_once "validation.php";

    $username = $_POST['username'];
    $email = $_POST['email'];

    if (!validateUsername($username, $minUsername, $maxUsername)) {
        $errors['username'][0] = true;
        $flag = true;
    }

    if ($username == $user['username']) {
        $existingRecord['username'] = true;
    }

    if (!validateEmail($email)) {
        $errors['email'][0] = true;
        $flag = true;
    }

    if ($email == $user['email']) {
        $existingRecord['email'] = true;
    }

    $team = $_POST['team'];

    if ($flag == true) {
        return ($errors);
    }

    if (!isset($existingRecord['username'])) {
        if (!checkField($db, $username, "users", "username")) {
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

            $message = "";
        }
    }

    if (!isset($existingRecord['email'])) {
        if (!checkField($db, $email, "users", "email")) {
            $query = "UPDATE users SET email = ? WHERE email = ?";
            $statement = mysqli_prepare($db, $query);

            if (!$statement) {
                echo 'Error preparing email statement.';
                die();
            }

            $result = mysqli_stmt_bind_param($statement, 'ss', $email, $user['email']);

            if (!$result) {
                echo 'Error binding prepared email statement.';
                die();
            }

            $result = mysqli_stmt_execute($statement);

            if (!$result) {
                echo 'Prepared statement result cannot be executed.';
                die();
            } else {
                $user['email'] = $email;
                $_SESSION['email'] = $email;

                $message = "";
            }
        }
    }

    $team_query = "UPDATE users SET team = ? WHERE username = ?";
    $statement = mysqli_prepare($db, $team_query);

    if (!$statement) {
        echo 'Error preparing team statement.';
        die();
    }

    $result = mysqli_stmt_bind_param($statement, 'ss', $team, $user['username']);

    if (!$result) {
        echo 'Error binding prepared team statement.';
        die();
    }

    $result = mysqli_stmt_execute($statement);

    if (!$result) {
        echo 'Prepared statement result cannot be executed.';
        die();
    } else {
        $message = "";
    }
}

if (isset($_POST['change_password'])) {
    $password = strip_tags($_POST['password']);
    $password = trim($password);
    $rpassword = strip_tags($_POST['rpassword']);
    $rpassword = trim($rpassword);

    if (!validatePassword($password, $minPassword, $maxPassword)) {
        $errors['password'][0] = true;
        $flag = true;
    }

    if ($rpassword != $password) {
        $errors['rpassword'][0] = true;
        $flag = true;
    }

    if ($flag == true) {
        return ($errors);
    }

    $password = md5($password);

    $query = "UPDATE users SET password = ? WHERE username = ?";
    $statement = mysqli_prepare($db, $query);

    if (!$statement) {
        echo 'Error preparing password statement';
        die();
    }

    $result = mysqli_stmt_bind_param($statement, 'ss', $password, $user['username']);

    if (!$result) {
        echo 'Error binding prepared password statement.';
        die();
    }

    $result = mysqli_stmt_execute($statement);

    if (!$result) {
        echo 'Prepared statement result cannot be executed.';
        die();
    } else {
        $message = "";
    }
}

function checkField($database, $field, $table, $column)
{
    $query = "SELECT * FROM $table WHERE $column = ?";

    $statement = mysqli_prepare($database, $query);

    if (!$statement) {
        echo "Error preparing $column statement.";
        die();
    }

    $result = mysqli_stmt_bind_param($statement, 's', $field);

    if (!$result) {
        echo "Error binding prepared $column statement.";
        die();
    }

    $result = mysqli_stmt_execute($statement);

    if (!$result) {
        echo "Prepared statement result cannot be executed.";
        die();
    }

    $result = mysqli_stmt_get_result($statement);

    if (!$result) {
        echo 'Prepared statement result cannot be stored.';
        die();
    }

    if (mysqli_num_rows($result) != 0) {
        global $message;
        $message = "<a class='errorMessage'>$column already in use!</a>";
        $result = closeDb($database);
        return true;
    } else {
        return false;
    }
}
