<?php
    include("includes/header.php");
    require_once "cookies/configDb.php";
    $db = connectDB();

    $user_query = "SELECT * FROM users";
    $shop_query = "SELECT * FROM shop";

    $user_result = mysqli_query($db, $user_query);
    $shop_result = mysqli_query($db, $shop_query);

    if (isset($_GET['id'])) {
        updateAdminStatus($db);
    }
    

    function updateAdminStatus($database) 
    {
        $user_id = $_GET['id'];

        $adminStatus_result = mysqli_query($database, "SELECT is_admin FROM users WHERE id_users = $user_id");
        $checkAdminStatus = mysqli_fetch_assoc($adminStatus_result);

        if ($checkAdminStatus['is_admin'] == 0) {
            $updateUser = mysqli_query($database, "UPDATE users SET is_admin = 1 WHERE id_users = $user_id");
        }

        else if ($checkAdminStatus['is_admin'] == 1) {
            $updateUser = mysqli_query($database, "UPDATE users SET is_admin = 0 WHERE id_users = $user_id");
        }

        if ($updateUser) {
            mysqli_close($database);
            header("Location: admin.php");
        }
        else {
            echo "Error updating user.";
        }
    }
?>