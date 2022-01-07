<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

$timezone = date_default_timezone_set("Europe/London");

    $minUsername = 4;
    $maxUsername = 12;
    $minPassword = 8;
    $maxPassword = 48;
    $mincvv = 3;
    $maxcvv = 3;
    $minNum = 16;
    $maxNum = 16;
    $minOwner = 4;
    $maxOwner = 20;
    $minContact = 10;
    $maxContact = 300;

    $minItemName = 1;
    $maxItemName = 60;

    // db config values
    $host = "localhost";
    $username = "root";
	$password = "cm";
	$dbName = "trabalhoTeste";
?>