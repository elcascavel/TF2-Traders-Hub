<!DOCTYPE html>
<html>
    <?php

include "includes/header.php";

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=9">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TF2 Trader's Hub</title>
        <link rel="shortcut icon" href="https://steamcdn-a.akamaihd.net/apps/tf2/blog/images/favicon.ico">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/6d446694b5.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../TH/css/main.css">
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    </head>

    <body style="width:100%;margin:0;background-color:#282a36">
        <div class="homepage">
            <div class="headerParentNonIndex">
                <a class ="headerLogo" href="index.php"></a>
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
                <div class="navSide">
                    <div class="navSideContent">
                        <a class="accountActions" href="login.php" >

                        <?php
if (!isset($_SESSION['username'])) {
    echo "Login";
}

?>
                         </a>

                         <a class="accountActionsLogin">
                       <?php

if (isset($userLoggedIn)) {

    if ($money == 0) {
        echo "<h5>$userLoggedIn <span class='badge bg-success'>0€</span></h5>";
    } else {
        echo "<h5>$userLoggedIn <span class='badge bg-success'>$money €</span></h5>";
    }
}
?>
                        </a>



                        <?php

require_once 'config/configDb.php';

//connected to the database
$db = connectDB();

//success?
if (is_string($db)) {
    //error connecting to the database
    echo ("Fatal error! Please return later.");
    die();
}

//select all columns from all users in the table
$query = "SELECT id_users,username,email,team FROM users";

//prepare the statement
$statement = mysqli_prepare($db, $query);

if (!$statement) {
    //error preparing the statement. This should be regarded as a fatal error.
    echo "Something went wrong. Please try again later.";
    die();
}

//execute the prepared statement
$result = mysqli_stmt_execute($statement);

if (!$result) {
    //again a fatal error when executing the prepared statement
    echo "Something went very wrong. Please try again later.";
    die();
}

//get the result set to further deal with it
$result = mysqli_stmt_get_result($statement);

if (!$result) {
    //again a fatal error: if the result cannot be stored there is no going forward
    echo "Something went wrong. Please try again later.";
    die();
}
if (!empty($_SESSION) && array_key_exists("username", $_SESSION)) {

    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['username'] == $_SESSION['username']) {
            echo '<div class="accountActionsButtonContainer">';

            echo '<form action="profile.php" method="POST" name="formModifica">
                                <input type="hidden" value="' . $row['id_users'] . '" name="id">
                                <input class="profileActionButton profileActionAccountImg" type="submit" name="modificar" value="">
                            </form>
                                <a class="profileActionButton profileActionWalletImg" href="wallet.php"> </a>
                                <a class="profileActionButton profileActionLogoutImg" href="logout.php"> </a>
                                </div>';

        }
    }
}
?>


                        <a class="accountActions" href="register.php">
                        <?php
if (!isset($_SESSION['username'])) {
    echo "Sign Up";
}

?>
                         </a>

                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <?php
if (isset($_POST['add_offer'])) {
    $_SESSION['id_trade'] = $_POST['id_trade'];
    header("Location: inventory.php");
}
if (isset($_POST['remove_trade'])) {
    $value = $_POST['id_trade'];
    $query = "INSERT INTO inventory (name,item_image,id_users,username) SELECT trade_itemName,trade_itemImage,id_user1,username1 FROM trades  WHERE id_trade ='{$value}'";
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
    $delete_query = "DELETE from trades WHERE id_trade=?";
    $statement = mysqli_prepare($db, $delete_query);

    if (!$statement) {
        echo "Error preparing statement0. Try again later";
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

if (isset($_POST['remove_button'])) {
    $value = $_POST['id_trade'];
    $query = "INSERT INTO inventory (name,item_image,id_users,username) SELECT offer_itemName,offer_itemImage,id_user2,username2 FROM trades  WHERE id_trade ='{$value}'";
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
    $query = "UPDATE trades SET offer_itemName= 'none',
                                    offer_itemImage='uploads/default_item_image',
                                    id_user2 = '0',
                                    username2 = 'none'
                   WHERE id_trade =?";

    $statement = mysqli_prepare($db, $query);

    if (!$statement) {
        echo "Error preparing statement7. Try again later";
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

if (isset($_POST['refuse_button'])) {
    $value = $_POST['id_trade'];
    $query = "INSERT INTO inventory (name,item_image,id_users,username) SELECT offer_itemName,offer_itemImage,id_user2,username2 FROM trades  WHERE id_trade ='{$value}'";
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
    $query = "UPDATE trades SET offer_itemName= 'none',
                                    offer_itemImage='uploads/default_item_image',
                                    id_user2 = '0',
                                    username2 = 'none'
                   WHERE id_trade =?";

    $statement = mysqli_prepare($db, $query);

    if (!$statement) {
        echo "Error preparing statement4. Try again later";
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

if (isset($_POST['accept_button'])) {

    $rate = $_POST['star']; // Remove html tags
    $feedback = strip_tags($_POST['feedback']); // Remove html tags
    $feedback = trim($feedback);
    $value = $_POST['id_trade'];
    $query = "INSERT INTO inventory (name,item_image,id_users,username) SELECT offer_itemName,offer_itemImage,id_user1,username1 FROM trades  WHERE id_trade ='{$value}'";
    $statement = mysqli_prepare($db, $query);

    if (!$statement) {

        echo "Something went wrong. Please try again later.1";
        die();
    }

    $result = mysqli_stmt_execute($statement);

    if (!$result) {

        echo "Something went very wrong. Please try again later.265";
        die();
    }

    $query = "INSERT INTO inventory (name,item_image,id_users,username) SELECT trade_itemName,trade_itemImage,id_user2,username2 FROM trades  WHERE id_trade ='{$value}'";
    $statement = mysqli_prepare($db, $query);

    if (!$statement) {

        echo "Something went wrong. Please try again later.1";
        die();
    }

    $result = mysqli_stmt_execute($statement);

    if (!$result) {

        echo "Something went very wrong. Please try again later.262";
        die();
    }

    $query = "INSERT INTO rating (username1,id_users,id_trade) SELECT username1,id_user2,id_trade FROM trades  WHERE id_trade ='{$value}'";
    $statement = mysqli_prepare($db, $query);

    if (!$statement) {

        echo "Something went wrong. Please try again later.1";
        die();
    }

    $result = mysqli_stmt_execute($statement);

    if (!$result) {

        echo "Something went very wrong. Please try again later.261";
        die();
    }

    $query = "UPDATE rating SET rate= ?, feedback=? WHERE id_trade ='{$value}'";
    $statement = mysqli_prepare($db, $query);

    if (!$statement) {
        echo "Error preparing statement. Try again later.1";
        die();
    }

    $result = mysqli_stmt_bind_param($statement, 'ss', $rate, $feedback);

    if (!$result) {
        echo "Error binding parameters to prepared statement. Please try again later.";
        die();
    }

    $result = mysqli_stmt_execute($statement);

    if (!$result) {
        echo "Result of prepared statement cannot be executed.";
        die();
    }

    $query = "DELETE FROM trades WHERE id_trade=?";

    $statement = mysqli_prepare($db, $query);

    if (!$statement) {
        echo "Error preparing statement2. Try again later";
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

$query = "SELECT * FROM trades ";

$statement = mysqli_prepare($db, $query);

if (!$statement) {

    echo "Something went wrong. Please try again later.";
    die();
}

$result = mysqli_stmt_execute($statement);

if (!$result) {

    echo "Something went very wrong. Please try again later.";
    die();
}

$result = mysqli_stmt_get_result($statement);

if (!$result) {

    echo "Something went wrong. Please try again later.";
    die();
}

while ($row = mysqli_fetch_assoc($result)) {

    echo "
            <div class='row pb-4'>
            <div class='col-md-4 d-flex justify-content-center'>
			<div class='card' style='width: 18rem; background-color: #101822; padding-bottom:50px;'>
			<form action='trade.php' method='POST'>
			<img class='card-img-top' style='background-color: #071215' src='" . $row["trade_itemImage"] . "'>
			<div class='card-body d-flex flex-column'>
			<h6 class='card-subtitle text-white text-center mb-2'>" . $row['trade_itemName'] . "</h6><br>
            <h6 class='card-subtitle text-white text-center'>User: " . $row['username1'] . "</h6>
			<div class='card-footer text-center' style='position:absolute; bottom:10px; margin-left: 0; margin-right: 0; left:0; right:0'>
			<input type='hidden' name='id_trade' value=" . $row['id_trade'] . ">
            <input type='hidden' name='id_user1' value=" . $row['id_user1'] . ">";
    if ($userLoggedInID == $row['id_user1'] && $row['id_user2'] == '0') {

        echo "<input type='submit' class='btn btn-danger' name='remove_trade' value='Send to inventory'>";
    } elseif ($row['id_user2'] != '0' && $userLoggedInID == $row['id_user1']) {
        echo "<div class='modal fade' id='ratingModal' tabindex='-1' aria-labelledby='ratingModalLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title'>Rate this transaction</h5>
        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body text-center'>
            <div class='stars'>
                <form action='trade.php' method='POST'> <input class='star star-5' id='star-5' type='radio' name='star' value='5' /> <label class='star star-5' for='star-5'></label> <input class='star star-4' id='star-4' type='radio' name='star' value='4' /> <label class='star star-4' for='star-4'></label> <input class='star star-3' id='star-3' type='radio' name='star' value='3' checked='checked'/> <label class='star star-3' for='star-3' ></label> <input class='star star-2' id='star-2' type='radio' name='star'value='2' /> <label class='star star-2' for='star-2'></label> <input class='star star-1' id='star-1' type='radio' name='star' value='1' /> <label class='star star-1' for='star-1'></label>
            </div>
            <div class='mb-3'>
  <label for='ratingTextArea' class='form-label' >Let us know what you think...</label>
  <textarea class='form-control' id='ratingTextArea' name='feedback' rows='2'></textarea>
</div>
      </div>
      <div class='modal-footer'>
        <input type='submit' class='btn btn-primary' name='accept_button' value='Submit'>
        </form>
      </div>
    </div>
  </div>
</div>
           <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#ratingModal'>
           Accept Offer
         </button> ";
        echo "<input type='submit' class='btn btn-danger' name='refuse_button' value='Refuse Offer'>";

    }

    echo "
			</form>

            </div>
			</div>
			</div>
			</div>

            <div class='col-md-4 d-flex justify-content-center align-items-center'>
            <i class='fas fa-people-arrows fa-8x' style='color:#6272a4'></i>
            </div>

            <div class='col-md-4 d-flex justify-content-center'>
			<div class='card' style='width: 18rem; background-color: #101822; padding-bottom:50px;'>
			<form action='trade.php' method='POST'>
			<img class='card-img-top' style='background-color: #071215' src='" . $row["offer_itemImage"] . "'>
			<div class='card-body d-flex flex-column'>
			<h6 class='card-subtitle text-white text-center mb-2'>" . $row['offer_itemName'] . "</h6><br>
            <input type='hidden' name='id_trade' value=" . $row['id_trade'] . ">
            <h6 class='card-subtitle text-white text-center'>User: " . $row['username2'] . "</h6>
			<div class='card-footer text-center' style='position:absolute; bottom:10px; margin-left: 0; margin-right: 0; left:0; right:0'>
			<input type='hidden' name='id_user2' value=" . $row['id_user2'] . ">";
    if ($userLoggedInID != $row['id_user1'] && $row['offer_itemName'] == 'none') {

        echo '<form action="" method="POST">
           <input type="hidden" name="id_trade" value="' . $row['id_trade'] . '" />
           <input type="submit" class="btn btn-primary" name="add_offer" value="Add Offer">
       </form>';
    }
    if ($row['username2'] == $userLoggedIn) {
        echo "<input type='submit' class='btn btn-danger' name='remove_button' value='Remove Offer'>";
    }

    echo "
			</form>

			</form>
            </div>
            </div>
			</div>
			</div>
			</div>"
    ;
}
?>
</div>

<?php
include "footer.php";
?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
    </body>
</html>