<?php
	header("Access-Control-Allow-Origin: *");
	
	include 'details.php';
	
	//Load variables
	if(isset($_GET['user_id'])) {
		$user_id = $_GET["user_id"];
		$post_id = $_GET["post_id"];
		$post_content = $_GET["post_content"];
	}
	
	//Connect to our database
	$mysqli = new mysqli($location, $user, $password, $database);

	
	mysqli_query($mysqli, "INSERT INTO `likes`(`user_id`, `post_id`, `post_content`) VALUES ($user_id, '$post_id', '$post_content')");

?>
