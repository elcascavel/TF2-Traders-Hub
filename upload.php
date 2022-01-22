<?php

    require_once "config/config.php";
    require_once('config/configDb.php');
    include("includes/header.php");
        
    $db = connectDB();

    if (isset($_FILES['profileAvatar'])) {
        uploadPicture($db, "profileAvatar", "UPDATE users SET user_pic = ? WHERE id_users = $userLoggedInID", "edit_account.php", false);
    }

    if (isset($_FILES['itemPicture'])) {
        uploadPicture($db, "itemPicture", "UPDATE shop SET item_image = ? WHERE id = {$_POST['product_id']}", "admin.php", true);
    }

function uploadPicture($database, $fileName, $query, $location, $filePixelCheck) {
    $filepath = $_FILES[$fileName]['tmp_name'];
    $fileSize = filesize($filepath);
    $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
    list($width, $height) = getimagesize($filepath);
    
    try {
        $filetype = finfo_file($fileinfo, $filepath);
        if (!$filetype) {
            throw new Exception('No file selected.');
        }
    }
    catch (Exception $e) {
        header("Location: $location");
    }

    if ($fileSize === 0) {
        die("The file is empty.");
    }

    if ($fileSize > 2097152) { // 2 MB (1 byte * 1024 * 1024 * 2 (for 2 MB))
        die("The file is too large");
    }

    if($filePixelCheck == true) {
        if ($width != 360 || $height != 360) {
            die("The file provided has different pixel dimensions than 360px");
        }
    }
    
    $allowedTypes = [
        'image/png' => 'png',
        'image/jpeg' => 'jpg',
    ];

    if (!in_array($filetype, array_keys($allowedTypes))) {
        die("File not allowed.");
    }

    $imageDirectory = "uploads";

    $filename = basename($filepath); // I'm using the original name here, but you can also change the name of the file here
    $extension = $allowedTypes[$filetype];
    $targetDirectory = __DIR__ . "/uploads"; // __DIR__ is the directory of the current PHP file

    $newFilepath = $targetDirectory . "/" . $filename . "." . $extension;

    $imageDirectory .= "/" . $filename . "." . $extension;
    if (!copy($filepath, $newFilepath)) { // Copy the file, returns false if failed
        die("Can't move file.");
    }
    unlink($filepath); // Delete the temp file

    $statement = mysqli_prepare($database, $query);

    if (!$statement) {
        echo "Error preparing statement.";
        die();
    }

    $result = mysqli_stmt_bind_param($statement, 's', $imageDirectory);
    if (!$result) {
        echo "Error binding prepared statement.";
        die();
    }

    $result = mysqli_stmt_execute($statement);

    if (!$result) {
        echo 'Prepared statement insert result cannot be executed.';
        die();
    }

    else {
        $result = closeDb($database);
        header("Location: $location");
        exit();
    }
}
?>