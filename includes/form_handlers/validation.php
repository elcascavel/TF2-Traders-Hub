<?php
function validateUsername($username, $min, $max)
{

    $exp = "/^[A-z0-9_]{" . $min . "," . $max . '}$/';

    if (!preg_match($exp, $username)) {
        return (false);
    } else {
        return (true);
    }
}

function validateEmail($email)
{

    //remove unwanted chars that maybe included in the email field content
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    //verify if the inputted email is according to validation standards
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return (false);
    } else {
        return (true);
    }
}

function validatePassword($data, $min, $max)
{

    $exp = "/^[A-z0-9_\\\*\-]{" . $min . "," . $max . '}$/';

    if (!preg_match($exp, $data)) {
        return (false);
    } else {
        return (true);
    }
}

function validateOwner($owner, $minUsername, $maxUsername)
{

    $exp = "/^[A-z]{" . $minUsername . "," . $maxUsername . '}$/';

    if (!preg_match($exp, $owner)) {
        return (false);
    } else {
        return (true);
    }
}

function validateCardnum($cardnum, $minNum, $maxNum)
{

    $exp = "/^[0-9]{" . $minNum . "," . $maxNum . '}$/';

    if (!preg_match($exp, $cardnum)) {
        return (false);
    } else {
        return (true);
    }
}

function validateCVV($cvv, $mincvv, $maxcvv)
{

    $exp = "/^[0-9]{" . $mincvv . "," . $maxcvv . '}$/';

    if (!preg_match($exp, $cvv)) {
        return (false);
    } else {
        return (true);
    }
}

function validateMessage($message, $minContact, $maxContact)
{

    $exp = "/^[A-z0-9., ]{" . $minContact . "," . $maxContact . '}$/';
    if (!preg_match($exp, $message)) {
        return (false);
    } else {
        return (true);
    }
}

function validateName($name, $minOwner, $maxOwner)
{

    $exp = "/^[A-z ]{" . $minOwner . "," . $maxOwner . '}$/';

    if (!preg_match($exp, $name)) {
        return (false);
    } else {
        return (true);
    }
}

function validateItemName($item_name, $minItemName, $maxItemName)
{
    $exp = "/^[A-z0-9 .'-]{" . $minItemName . "," . $maxItemName . '}$/';

    if (!preg_match($exp, $item_name)) {
        return (false);
    } else {
        return (true);
    }
}

function validateItemDescription($item_description, $minItemDesc, $maxItemDesc)
{
    $exp = "/^[A-z0-9., ]{" . $minItemDesc . "," . $maxItemDesc . '}$/';

    if (!preg_match($exp, $item_description)) {
        return false;
    } else {
        return true;
    }
}

function validateItemPrice($item_price)
{
    $exp = "(^[0-9.]+$|" . '^$)';

    if (!preg_match($exp, $item_price)) {
        return false;
    } else {
        return true;
    }
}
