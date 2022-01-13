<?php 
    require_once "cookies/configDb.php";
    require_once "config/config.php";

    $db = connectDB();

$shop_query = "SELECT * FROM shop";
$shop_result = mysqli_query($db, $shop_query);
?>