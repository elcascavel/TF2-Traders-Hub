<?php
    include("includes/header.php");
    require_once "cookies/configDb.php";

    $alertTrigger = false;
    $alertMessage = "";
    $alertType = "";

    $db = connectDB();

    $user_query = "SELECT * FROM users";
    $shop_query = "SELECT * FROM shop";

    $user_result = mysqli_query($db, $user_query);
    $shop_result = mysqli_query($db, $shop_query);

    $user_array = mysqli_fetch_assoc($user_result);

    if (isset($_POST['returnProfile'])) {
        header("Location: profile.php");
    }

    if (isset($_POST['id'])) {
        $user_id = $_POST['id'];

        if (isset($_POST['setAdmin'])) {
            if(updateAdminStatus($db, $userLoggedInID, $userLoggedIn, $user_id, $alertMessage))
            {
                header("Location: admin.php");
            }
            else 
            {
                $alertType = "alert-danger";
                $alertTrigger = true;
            }
        }
        else if (isset($_POST['deleteUser'])) 
        {
            if(deleteUser($db, $userLoggedInID, $userLoggedIn, $user_id, $alertMessage)) 
            {
                header("Location: admin.php");
            }
            else 
            {
                $alertType = "alert-danger";
                $alertTrigger = true;
            }
        }
    }
    
    function updateAdminStatus($database, &$loggedInID, &$username, $id, &$alertText) 
    {
        $adminStatus_query = mysqli_query($database, "SELECT is_admin FROM users WHERE id_users = $id");
        $checkAdminStatus = mysqli_fetch_assoc($adminStatus_query);

        if ($loggedInID == $id) {
            $alertText = "You can't remove your own admin status, ". $username."!";
            return false;
        }

        else if ($checkAdminStatus['is_admin'] == 0) {
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
            $alertText = "Error updating admin status of user with ID $id.";
            return false;
        }
    }

    function deleteUser($database, &$loggedInID, &$username, $id, &$alertText) 
    {
        if ($loggedInID == $id) {
            $alertText = "You can't delete your own account, ". $username."! You can do that from your profile.";
            return false;
        }

        $deleteUser = mysqli_query($database, "DELETE from users WHERE id_users = $id");

        if ($deleteUser) {
            mysqli_close($database);
            return true;
        }
        else {
            $alertText = "Error deleting user with ID $id.";
            return false;
        }
    }
?>