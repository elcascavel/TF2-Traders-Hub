<?php
include("./cookies/header.php");

if (isset($_POST['cancel'])) {
    header("Location: profile.php");
}

if (isset($_POST['closeAccount'])) {
    $close_query = mysqli_query($con, "DELETE from users WHERE username = '$userLoggedIn'");
    session_destroy();
    header("Location: register.php");
}

?>

<div>
    <h4>Close Account</h4>

    Are you sure you want to close your account?<br><br>
    <?php echo $userLoggedIn;?>

    <form action="closeAccount.php" method="POST">
        <input type="submit" name="closeAccount" id="closeAccount" value="Close it!">
        <input type="submit" name="cancel" value="No, take me back!">
    </form>
</div>