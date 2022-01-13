<?php
    require_once "cookies/configDb.php";
    require_once "config/config.php";

    $db = connectDB();

    $user_query = "SELECT * FROM users";
    $shop_query = "SELECT * FROM shop";
    $contact_query = "SELECT * FROM contact";

    $user_result = mysqli_query($db, $user_query);
    $shop_result = mysqli_query($db, $shop_query);
    $contact_result = mysqli_query($db, $contact_query);

    $item_array = mysqli_fetch_assoc($shop_result);

    $itemName = "";
    $itemDesc = "";
    $itemRarity = "";
    $itemPrice = "";
    $itemImage = "";

    $toastClass = "hide";
    $toastMessage = "";

    $errors = array('item_name' => array(false, "Invalid item name: it must have between $minItemName and $maxItemName characters."),
								    'item_description' => array(false, "Invalid item description: it must have between $minItemDesc and $maxItemDesc characters."),
                                    'item_price' => array(false, "Invalid price tag. Make sure it's not empty.")
								   );

                                   $flag = false;

    if (isset($_POST['returnProfile'])) {
        header("Location: profile.php");
    }

    if (isset($_POST['id'])) {
        $user_id = $_POST['id'];

        if (isset($_POST['setAdmin'])) {
            if(updateAdminStatus($db, $userLoggedInID, $user_id))
            {
                header("Location: admin.php");
            }
            else 
            {
                $alertType = "alert-danger";
            }
        }
        else if (isset($_POST['deleteUser'])) 
        {
            if(deleteUser($db, $userLoggedInID, $user_id)) 
            {
                header("Location: admin.php");
            }
            else 
            {
                $alertType = "alert-danger";
            }
        }
    }

    if (isset($_POST["addItem_button"])) {
        require_once "validation.php";
        require_once "config/config.php";
        $itemName = strip_tags($_POST['item-name']);

        if (!validateItemName($itemName, $minItemName, $maxItemName)) {
            $errors['item_name'][0] = true;
            $flag = true;
        }
        else {
            $itemDesc = strip_tags($_POST['item-description']);
            $itemRarity = strip_tags($_POST['item-rarity']);
            $itemPrice = strip_tags($_POST['item-price']);
    
            if(!addItem($db, $itemName, $itemDesc, $itemRarity, $itemPrice)) {
            }
            else {
                header("Location: admin.php");
            }
        }  
    }

    if (isset($_POST['item_id'])) {
        require_once "validation.php";
        require_once "config/config.php";
        $item_id = $_POST['item_id'];
        if (isset($_POST['updateItem_button'])) {

        $itemName = strip_tags($_POST['item-name']);

        if (!validateItemName($itemName, $minItemName, $maxItemName)) {
            $errors['item_name'][0] = true;
            $flag = true;
        }

        $itemDesc = strip_tags($_POST['item-description']);

        if (!validateItemDescription($itemDesc, $minItemDesc, $maxItemDesc)) {
            $errors['item_description'][0] = true;
            $flag = true;
        }

        $itemRarity = strip_tags($_POST['item-rarity']);

        $itemPrice = strip_tags($_POST['item-price']);

        if (!validateItemPrice($itemPrice)) {
            $errors['item_price'][0] = true;
            $flag = true;
        }

        if ($flag == true ){
            $toastClass = "show";
            return($errors);
        }

        if (!editItem($db, $item_id, $itemName, $itemDesc, $itemRarity, $itemPrice)) 
        {
            die();
        }

        else 
        {
            header("Location: admin.php");
        }

        }
        else if (isset($_POST['deleteItem_button'])) {
            if (!deleteItem($db, $item_id)) {
                die();
            }
            else {
                header("Location: admin.php");
            }
        }
    }

    if (isset($_POST['message_id'])) {
        $message_id = $_POST['message_id'];

        if (isset($_POST['readMessage_button'])) {
            if (!readMessage($db, $message_id)) {
                echo $db->error;
                die();
            }
            else {
                header("Location: admin.php");
            }
        }
    }
    
    function updateAdminStatus($database, &$loggedInID, $id) 
    {
        $adminStatus_query = mysqli_query($database, "SELECT is_admin FROM users WHERE id_users = $id");
        $checkAdminStatus = mysqli_fetch_assoc($adminStatus_query);

        if ($loggedInID == $id) {
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
            return false;
        }
    }

    function deleteUser($database, &$loggedInID, $id) 
    {
        if ($loggedInID == $id) {
            return false;
        }

        $deleteUser = mysqli_query($database, "DELETE from users WHERE id_users = $id");

        if ($deleteUser) {
            closeDb($database);
            return true;
        }
        else {
            return false;
        }
    }

    function addItem($database, &$item_name, &$item_desc, &$item_rarity, &$item_price) 
    {
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
                closeDb($database);
                return true;
            }
        }

    function editItem($database, $item_id, &$item_name, &$item_desc, &$item_rarity, &$item_price) 
    {
        $item_query = "UPDATE shop SET product = ?, item_description = ?, rarity = ?, price = ? WHERE id = $item_id";
        $statement = mysqli_prepare($database, $item_query);

        if (!$statement) {
            echo "Error preparing update item statement. " . mysqli_error($database);
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
            closeDb($database);
            return true;
        }
    }

    function deleteItem($database, $id)
    {
        $deleteItem = mysqli_query($database, "DELETE from shop WHERE id = $id");

        if ($deleteItem) {
            closeDb($database);
            return true;
        }
        else {
            return false;
        }
    }

    function readMessage($database, $message_id) 
    {
        $readMessage = mysqli_query($database, "DELETE from contact WHERE id_message = $message_id");

        if ($readMessage) {
            closeDb($database);
            return true;
        }
        else {
            return false;
        }
    }
?>