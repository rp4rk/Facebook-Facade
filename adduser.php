<?php
	header("Access-Control-Allow-Origin: *");
	
	include 'details.php';
	
	//Load variables
	if(isset($_GET['user_id'])) {
		$user_id = $_GET["user_id"];
		$first_name = $_GET["f_name"];
		$last_name = $_GET["l_name"];
		$username = $_GET["username"];
	}
	
	//Connect to our database
	$mysqli = new mysqli($location, $user, $password, $database);

	
	mysqli_query($mysqli, "INSERT INTO `users`(`id`, `first_name`, `last_name`, `username`) VALUES ($user_id, '$first_name', '$last_name', '$username')");

?>
