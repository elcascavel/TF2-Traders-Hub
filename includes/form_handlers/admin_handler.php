<?php
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

    $itemName = "";
    $itemDesc = "";
    $itemRarity = "";
    $itemPrice = "";
    $itemImage = "";

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

    if (isset($_POST["addItem_button"])) {
        require_once "validation.php";
        require_once "config/config.php";
        $itemName = strip_tags($_POST['item-name']);

        if (!validateItemName($itemName, $minItemName, $maxItemName)) {
            $alertMessage = "Invalid item name!";
            $alertType = "alert-danger";
            $alertTrigger = true;
        }
        else {
            $itemDesc = strip_tags($_POST['item-description']);
            $itemRarity = strip_tags($_POST['item-rarity']);
            $itemPrice = strip_tags($_POST['item-price']);
    
            if(!addItem($db, $itemName, $itemDesc, $itemRarity, $itemPrice, $alertMessage)) {
                $alertType = "alert-danger";
                $alertTrigger = true;
            }
            else {
                header("Location: admin.php");
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
            closeDb($database);
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
            closeDb($database);
            return true;
        }
        else {
            $alertText = "Error deleting user with ID $id.";
            return false;
        }
    }

    function addItem($database, &$item_name, &$item_desc, &$item_rarity, &$item_price, &$alertText) 
    {
        // Check if item already exists
        $query = "SELECT product FROM shop WHERE product = ?";
        $statement = mysqli_prepare($database, $query);

        if (!$statement) {
            echo "Error preparing statement. Try again later";
            die();
        }
    
        $result = mysqli_stmt_bind_param($statement, 's', $item_name);

        if (!$result) {
            echo "Error binding parameters to prepared statement. Please try again later";
            die();
        }

        $result = mysqli_stmt_execute($statement);

        if (!$result) {
            echo "Error executing prepared statement.";
            die();
        }
    
        $result = mysqli_stmt_get_result($statement);
    
        if (!$result) {
            echo "Result of prepared statement cannot be stored.";
            die();
        }

        if (mysqli_num_rows($result) != 0) {
            $alertText = "Item name is already in our records!";
            $result = closeDb($database);
            return false;
        }
        // If not add item
        else {
            $insert_query = "INSERT INTO shop (product, item_description, rarity, price) VALUES (?, ?, ?, ?)";
            
            $statement = mysqli_prepare($database, $insert_query);

            if (!$statement) {
                echo "Error preparing insertion statement.";
                die();
            }
    
            $result = mysqli_stmt_bind_param($statement, 'sssd', $item_name, $item_desc, $item_rarity, $item_price);
    
            if (!$result) {
                echo "Error binding parameters to prepared statement. Please try again later.";
                die();
            }

            $result = mysqli_stmt_execute($statement);

            if (!$result) {
                echo "Result of prepared statement cannot be executed.";
                die();
            }

            else {
                return true;
            }
        }
        
    }
?>