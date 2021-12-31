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
