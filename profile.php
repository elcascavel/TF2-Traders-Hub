<?php
include "includes/header.php";

if (!isset($userLoggedIn)) {
    header("Location: index.php");
}

if (isset($_POST['closeAccount'])) {
    header("Location: close_account.php");
} else if (isset($_POST['editAccount'])) {
    header("Location: edit_account.php");
} else if (isset($_POST['adminPanel'])) {
    header("Location: admin.php");
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=9">
    <title>TF2 Trader's Hub</title>
    <link rel="shortcut icon" href="https://steamcdn-a.akamaihd.net/apps/tf2/blog/images/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../TH/css/main.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>

<body>

    <body style="width:100%;margin:0;background-color:#282a36">
        <div class="homepage">
            <div class="headerParentProfile">
                <a class="headerLogo" href="index.php"></a>
                <div class="headerNavItems">
                    <a class="navLink" href="trade.php">
                        Trade
                    </a>
                    <a class="navLink" href="buy.php">
                        Buy
                    </a>
                    <a class="navLink" href="contact.php">
                        Contact
                    </a>
                </div>
            </div>
            <?php
require 'config/config.php';
$db = connectDB();
if (is_string($db)) {
    echo ("Error connecting to database!");
    die();
}
?>
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col col-md-9 col-lg-7 col-xl-5">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-4">
                                <div class="d-flex text-black">
                                    <div class="flex-shrink-0">
                                        <img src="<?php echo $user['user_pic'] ?>" alt="Generic placeholder image"
                                            class="img-fluid" style="width: 180px; border-radius: 10px;">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <?php if ($user['team'] == "RED") {
    $teamColor = "#B8383B";
} else if ($user['team'] == "BLU") {
    $teamColor = "#5885A2";
}
echo "<h5 class='mb-1'>$userLoggedIn <span class='badge badge-pill' style='background:$teamColor; padding: .25em .45em;'>" . $user['team'] . "</span></h5>";
?>
                                        <p class="mb-2 pb-1" style="color: #2b2a2a;">Member since
                                            <?php echo date("jS F, Y", strtotime($user['signup_date'])); ?></p>
                                        <div class="d-flex justify-content-start rounded-3 p-2 mb-2"
                                            style="background-color: #efefef;">
                                            <?php echo $user['email'] . "<br>"; ?>
                                        </div>
                                        <div class="d-flex pt-1">
                                            <form action="profile.php" method="POST">
                                                <input class="btn btn-primary me-1 flex-grow-1" type="submit"
                                                    name="editAccount" id="editAccount" value="Edit Account">
                                                <input class="btn btn-danger flex-grow-1" type="submit"
                                                    name="closeAccount" id="closeAccount" value="Delete Account">
                                                <div class="row mt-2">
                                                    <div class="col text-center">
                                                        <?php
if ($userIsAdmin == 1) {
    echo "<input class='btn btn-outline-primary flex-grow-1' type='submit' name='adminPanel' id='adminPanel' value='Admin Panel'>";
}
?>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-5">
                    <h2>Items</h2>
                    <?php

if (isset($_POST['trade_button'])) {
    $value = $_POST['id_inv'];

    $query = "INSERT INTO trades (trade_itemName,trade_itemImage,id_user1,username1) SELECT inventory.name,inventory.item_image,inventory.id_users,users.username FROM (inventory INNER JOIN users ON users.username='{$userLoggedIn}') WHERE id_inv ='{$value}'";
    $statement = mysqli_prepare($db, $query);

    if (!$statement) {

        echo "Something went wrong. Please try again later.1";
        die();
    }

    $result = mysqli_stmt_execute($statement);

    if (!$result) {

        echo "Something went very wrong. Please try again later.26";
        die();
    }

    $delete_query = "DELETE from inventory WHERE id_inv=?";
    $statement = mysqli_prepare($db, $delete_query);

    if (!$statement) {
        echo "Error preparing statement. Try again later";
        die();
    }
    $result = mysqli_stmt_bind_param($statement, 'i', $value);

    if (!$result) {
        echo 'Error binding prepared login statement.';
        die();
    }

    $result = mysqli_stmt_execute($statement);

    if (!$result) {

        echo "Something went very wrong. Please try again later.21";
        die();
    }

}
$query = "SELECT * FROM inventory WHERE id_users = $userLoggedInID";

$result = mysqli_query($db, $query);

while ($row = mysqli_fetch_array($result)) {
    echo "
			<div class='col-md-2 mb-3 d-flex align-items-stretch'>
			<div class='card' style='width: 18rem; background-color: #101822; padding-bottom:50px;'>
			<form action='profile.php' method='POST'>
			<img class='card-img-top' style='background-color: #071215' src='" . $row["item_image"] . "'>
			<div class='card-body d-flex flex-column'>
			<h6 class='card-subtitle text-white text-center'>" . $row['name'] . "</h6>
			<div class='card-footer text-center' style='position:absolute; bottom:10px; margin-left: 0; margin-right: 0; left:0; right:0'>
			<input type='hidden' name='id_inv' value=" . $row['id_inv'] . ">
			<input type='submit' class='btn btn-primary' name='trade_button' value='Add to Trade'>
			</form>
			</div>
			</div>
			</div>
			</div>";
}
if (mysqli_num_rows($result) == 0) {
    echo "<div class='container w-50 text-center'><div class='alert alert-info' role='alert'>
				You have no items! Feel free to purchase some at our store!
			  </div></div>";
}
?>

                    <div class="row">
                        <h2 class="text-white" ; class="mt-5">User Ratings</h2>
                        <?php
$table = "";
$rating_query = "SELECT * FROM rating WHERE id_users='{$userLoggedInID}'";
$rating_result = mysqli_query($db, $rating_query);
$table .= "
        <table class='table table-hover table-light table-striped table-bordered align-middle text-center'>
        <thead>
        <tr>
        <th scope='col'>#Trade</th>
        <th scope='col'>Issued By</th>
        <th scope='col'>Rating</th>
        <th scope='col'>Feedback</th>
        </tr>
        </thead>
        ";
foreach ($rating_result as $rating) {
    $table .= "
            <tr>
            <td>" . $rating['id_trade'] . "</td>
            <td>" . $rating['username1'] . "</td>
            <td>" . $rating['rate'] . "★</td>
            <td>" . $rating['feedback'] . "</td>
            </tr>
            ";
}
echo $table . "</table>";
?>
                    </div>
                </div>
            </div>
        </div>
        <?php
include "footer.php";
?>
    </body>