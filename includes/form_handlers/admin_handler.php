<?php
    include("includes/header.php");
    require_once "cookies/configDb.php";
    $db = connectDB();

    $user_query = "SELECT * FROM users";
    $shop_query = "SELECT * FROM shop";

    $user_result = mysqli_query($db, $user_query);
    $shop_result = mysqli_query($db, $shop_query);
?>