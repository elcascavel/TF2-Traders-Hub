<?php  
require 'config/config.php';

if (isset($_SESSION['username'])) {
    require_once('cookies/configDb.php');
	$userLoggedIn = $_SESSION['username'];
    $userIsAdmin = $_SESSION['is_admin'];
    $userLoggedInID = $_SESSION['id_users'];

    $db = connectDB();
    if (is_string ($db)) {
        echo ("Error connecting to database!");
        die();
    }

	$query = "SELECT * FROM users WHERE username=?";
    $statement = mysqli_prepare($db, $query);

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

    $result = mysqli_stmt_get_result($statement);

    if (!$result) {
        echo "Result of prepared statement cannot be stored.";
        die();
    }

	$user = mysqli_fetch_array($result);

    $sql = "SELECT SUM(amount) from wallet WHERE id_users = " . $user['id_users'];
    $result = $db->query($sql);
  
    $row = mysqli_fetch_array($result);
   
    $money = $row['SUM(amount)'];


    

    $query = "UPDATE users SET money =(SELECT SUM(amount) FROM wallet WHERE id_users ='{$user['id_users']}') WHERE id_users=" . $user['id_users'] ;
    $statement = mysqli_prepare($db, $query);
                   
                   
           if (!$statement ){
               //error preparing the statement. This should be regarded as a fatal error.
               echo "Something went wrong. Please try again later.1";
               die();				
           }				
                   
           //execute the prepared statement
           $result = mysqli_stmt_execute($statement);
                               
           if( !$result ) {
               //again a fatal error when executing the prepared statement
               echo "Something went very wrong. Please try again later.2";
               die();
           }
        
  
           $sql = "SELECT money FROM users WHERE id_users=" . $user['id_users'];
           $result = $db->query($sql);
           
           $row = mysqli_fetch_array($result);
           
           $money = $row['money'];
    
}

?>