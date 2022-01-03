<?php
    include("includes/header.php");
    require_once "cookies/configDb.php";
    $db = connectDB();

    $query = "SELECT username FROM users";
    $shop_query = "SELECT product FROM shop";

    $result = mysqli_query($db, $query);
    $shop_result = mysqli_query($db, $shop_query);
?>