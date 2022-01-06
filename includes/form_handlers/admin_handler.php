<?php
    include("includes/header.php");
    require_once "cookies/configDb.php";

    $errorTrigger = false;
    $errorMessage = "";

    $db = connectDB();

    $user_query = "SELECT * FROM users";
    $shop_query = "SELECT * FROM shop";

    $user_result = mysqli_query($db, $user_query);
    $shop_result = mysqli_query($db, $shop_query);

    if (isset($_POST['id'])) {
        $user_id = $_POST['id'];
        if (isset($_POST['setAdmin'])) {
            if(updateAdminStatus($db, $user_id)) 
            {
                header("Location: admin.php");
            }
            else 
            {
                $errorTrigger = true;
                $errorMessage = "Error updating admin status of user with id $user_id";
            }
        }
        else if (isset($_POST['deleteUser'])) 
        {
            if(deleteUser($db, $user_id)) 
            {
                header("Location: admin.php");
            }
            else 
            {
                $errorTrigger = true;
                $errorMessage = "Error deleting user with id $user_id";
            }
        }
    }
    
    function updateAdminStatus($database, $id) 
    {
        $adminStatus_query = mysqli_query($database, "SELECT is_admin FROM users WHERE id_users = $id");
        $checkAdminStatus = mysqli_fetch_assoc($adminStatus_query);

        if ($checkAdminStatus['is_admin'] == 0) {
            $updateUser = mysqli_query($database, "UPDATE users SET is_admin = 1 WHERE id_users = $id");
        }

        else if ($checkAdminStatus['is_admin'] == 1) {
            $updateUser = mysqli_query($database, "UPDATE users SET is_admin = 0 WHERE id_users = $id");
        }

        if ($updateUser) {
            mysqli_close($database);
            return true;
            
        }
        else {
            return false;
        }
    }

    function deleteUser($database, $id) 
    {
        $user_id = $_POST['id'];

        $deleteUser = mysqli_query($database, "DELETE from users WHERE id_users = $id");

        if ($deleteUser) {
            mysqli_close($database);
            return true;
        }
        else {
            return false;
        }
    }
?>