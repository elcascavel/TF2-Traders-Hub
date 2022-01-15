<?php
require_once "cookies/configDb.php";
include("includes/header.php");
$owner = "";
$cardNumber = "";
$cvv = "";
$cardBrand = "";
$amount = "";

$db = connectDB();

$errors = array();
$message = "";

if (isset($_POST['wallet_button'])) {
    include("includes/header.php");
    require_once "config/config.php";
    require_once "validation.php";

    $errors = array(
        'owner' => array(false, "Invalid Name: it must have between $minOwner and $maxOwner chars and no special chars."),
        'cardnum' => array(false, "Invalid card number: it must have $minNum numbers and no special chars."),
        'cvv' => array(false, "Invalid CVV."),
        'cardname' => array(false, 'Please select a card.'),
        'amount' => array(false, 'Please select an amount.')
    );

    $flag = false;

    $owner = trim($_POST['owner']);

    if (!validateOwner($owner, $minOwner, $maxOwner)) {
        $errors['owner'][0] = true;
        $flag = true;
    } else {
        $_SESSION['owner'] = $owner;
    }

    $cardNumber = trim($_POST['cardnum']);

    if (!validateCardnum($cardNumber, $minNum, $maxNum)) {
        $errors['cardnum'][0] = true;
        $flag = true;
    } else {
        $_SESSION['cardnum'] = $cardNumber;
    }

    $cvv = trim($_POST['cvv']);

    if (!validateCVV($cvv, $mincvv, $maxcvv)) {
        $errors['cvv'][0] = true;
        $flag = true;
    } else {
        $_SESSION['cvv'] = $cvv;
    }

    $cardBrand = $_POST['cardname'];
    $amount = $_POST['amount'];

    if ( $flag == true ){
        return($errors);
    }
    
    
        $query = "INSERT INTO wallet (owner, cardnum, cvv, cardname, amount, id_users) VALUES (?,?,?,?,?,?)";

        $statement = mysqli_prepare($db, $query);

        if (!$statement) {
            echo "Error preparing card number statement.";
            die();
        }

        $result = mysqli_stmt_bind_param($statement, 'ssssdi', $owner, $cardNumber, $cvv, $cardBrand, $amount, $user['id_users']);
        if (!$result) {
            echo "Error binding prepared card number statement.";
            die();
        }

        $result = mysqli_stmt_execute($statement);

        if (!$result) {
            echo 'Prepared statement insert result cannot be executed.';
            die();
        }

        else {
            $result = closeDb($db);
            header("Location: wallet.php");
            
        }
    
}


?>