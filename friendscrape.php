	<?php
	header("Access-Control-Allow-Origin: *");
	
	include 'details.php';
	
	//Load variables
	if(isset($_GET['friends'])) {
		$friends = $_GET["friends"];
	}
	
	$friends = json_decode(urldecode($friends));
	
	
	//Connect to our database
	$mysqli = new mysqli($location, $user, $password, $database);

	$query = "SELECT `id` FROM `profiles`";
	$result = mysqli_query($mysqli, $query);
	$existing_profiles = array();
	
	//Load into an array $existing_profiles[i]['id'] will return a given id
	while ($row = $result->fetch_assoc()) {
	  $existing_profiles[] = $row;
	}
	
	//Loop through our imported profile IDs, filter repeats
	for ($i = 0; $i < count($friends); $i++) {
		//Clear our variables for this loop
		$found = false;
		$json = false;
		
		//Loop through existing profiles, do we find a repeat?
		for ($q = 0; $q < count($existing_profiles); $q++) {
			if ($friends[$i] == $existing_profiles[$q]['id']) {
				$found = true;
				break;
			}
		}
		
		//If this iteration hasnt been found, add it 
		if ($found == false) {
			//We need to get the details and import them to our database
			$json = file_get_contents('https://graph.facebook.com/' . $friends[$i]);
			
			if ($json) {
				$profile = json_decode($json, true);
				
				$profileid = $profile['id'];
				$profilefirst = $profile['first_name'];
				$profilelast = $profile['last_name'];
				$profileuser = $profile['username'];
				
				//Catch people without usernames
				if (!profileuser) {
					$profileuser = $profile['name'];
				}
				
				//Add the profile to the database
				mysqli_query($mysqli, "INSERT INTO `profiles`(`id`, `first_name`, `last_name`, `username`) VALUES ('$profileid', '$profilefirst', '$profilelast', '$profileuser')");
				
				//Put the picture in our library
				file_put_contents("pictures/" . $profileid . ".jpg", file_get_contents("https://graph.facebook.com/" . $profileid . "/picture?type=large"));
				
			}
			
		}
	}
	

?>
