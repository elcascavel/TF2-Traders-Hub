<?php
include("includes/header.php");

if(!isset($userLoggedIn)) {
	header("Location: index.php");
}

if (isset($_POST['cancel'])) {
    header("Location: profile.php");
}

if (isset($_POST['closeAccount'])) {
    require_once('cookies/configDb.php');
    $db = connectDB();

    $close_query = "DELETE users,wallet FROM wallet INNER JOIN users ON wallet.id_users = users.id_users WHERE wallet.id_users=?";
    $statement = mysqli_prepare($db, $close_query);

    if (!$statement) {
        echo "Error preparing statement. Try again later";
        die();
    }

    $result = mysqli_stmt_bind_param($statement, 's', $userLoggedIn);

        if (!$result) {
            echo "Error binding parameters to prepared statement. Please try again later";
            die();
        }

        $result = mysqli_stmt_execute($statement);

        if (!$result) {
            echo "Error executing prepared statement.";
            die();
        }
        $result = closeDb($db);
        session_destroy();
        header("Location: index.php");
}

?>

<div>
    <h4>Close Account</h4>

    Are you sure you want to close your account, <?php echo $userLoggedIn;?>?<br><br>

    <form action="close_account.php" method="POST">
        <input type="submit" name="closeAccount" id="closeAccount" value="Close it!">
        <input type="submit" name="cancel" value="No, take me back!">
    </form>
</div>