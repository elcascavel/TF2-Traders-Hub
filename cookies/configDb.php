<?php

// Connect to DB; Query DB (CRUD); disconnect DB
function connectDB(){
	
	include('config.php');

	$db = mysqli_connect($host, $username, $password, $dbName);

	if (!$db) {
   	//connection error
   	return(mysqli_connect_error());
	}
	else{
		return($db);	
	}
}

//close db connection
function closeDb($db){
	
	return(mysqli_close($db));
}
?>