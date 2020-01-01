<?php 
	
	// unsafe disable of CORS for local use ONLY
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT');
	header('Access-Control-Max-Age: 1000');
	
	header('content-type: application/json; charset=utf-8');
	
	require_once("db.php");
	require_once("func_ratings.php");
	
	// login credentials
	$role=3; // set role to Coordinator
	$uname="";
	$pwd="";
	if (isset($_GET['uname']))
		$uname = $_GET['uname'];
	else if (isset($_POST['uname']))
		$uname = $_POST['uname'];
	
	if (isset($_GET['pwd']))
		$pwd = $_GET['pwd'];
	else if (isset($_POST['pwd']))
		$pwd = $_POST['pwd'];
	
	// Coordinator profile
	$pocname="";
	$email="";
	$phone="";
	if (isset($_GET['pocname']))
		$pocname = $_GET['pocname'];
	else if (isset($_POST['pocname']))
		$pocname = $_POST['pocname'];
	
	if (isset($_GET['email']))
		$email = $_GET['email'];
	else if (isset($_POST['email']))
		$email = $_POST['email'];
	
	if (isset($_GET['phone']))
		$phone = $_GET['phone'];
	else if (isset($_POST['phone']))
		$phone = $_POST['phone'];
	
	// Venue Profile
	$venue="";
	$location="";
	$lat="";
	$lng="";
	
	if (isset($_GET['venue']))
		$venue = $_GET['venue'];
	else if (isset($_POST['venue']))
		$venue = $_POST['venue'];

	if (isset($_GET['location']))
		$location = $_GET['location'];
	else if (isset($_POST['location']))
		$location = $_POST['location'];
	
	if (isset($_GET['lat']))
		$lat = $_GET['lat'];
	else if (isset($_POST['lat']))
		$lat = $_POST['lat'];
	
	if (isset($_GET['lng']))
		$lng = $_GET['lng'];
	else if (isset($_POST['lng']))
		$lng = $_POST['lng'];
	
	$desc = ""; // json return
	$error_code = 2; // default DB error code
	$err_sql = "";
	
	//echo("TEST{{{".$uname." ".$pwd." ".$pocname." ".$email." ".$phone." ".$venue." ".$location." ".$lat." ".$lng."}}}");
	
	if ((!empty($uname)) &&
		(!empty($pwd)) &&
		(!empty($pocname)) &&
		(!empty($email)) &&
		(!empty($phone)) &&
		(!empty($venue)) &&
		(!empty($location)) &&
		(!empty($lat)) &&
		(!empty($lng)))
	{
		// do not allow duplicate usernames
		if (does_user_exist($uname) == 0) {
			
			// put info into database for login
			$sql = "insert into logins (username, userpwd, roleid) values ('$uname', '$pwd', '$role')";
							
			$lres = mysqli_query($con, $sql);		
			if ($lres){
				// get id generated for new login
				$last_id = mysqli_insert_id($con);
				
				// put info into database for Venue
				$sql = "insert venues(venue_name, address, pocname, pocemail, pocphone, latitude, longitude, loginid) 
				values ('$venue','$location','$pocname','$email','$phone',$lat,$lng,$last_id)";
				
				$res = mysqli_query($con, $sql);		
				if ($res){
					$error_code = 0; // success
				} else {
					$error_code = 2; // DB error
					$err_sql = mysqli_error($con) . "->venues";
				}
			} else {
				$error_code = 2; // DB error
				$err_sql = mysqli_error($con) . "->logins";
			}
		} else {
			$error_code = 3; // Duplicate login error
		}
	}
	else {
		$error_code = 1; // incomplete 
	}
	
	// set error code description
	if ($error_code == 0) {// success
		$desc = $desc . "Coordinator Registered successful.";
	}
	else if ($error_code == 1) {// incomplete
		$desc = $desc . "Form not filled out completely. Try again.";
	}	
	else if ($error_code == 2) {// DB error
		$desc = $desc . "Error inserting into DB. " . $err_sql;
	}		
	else if ($error_code == 3) {// duplicate error
		$desc = $desc . "Login already exists. Try again.";
	}	
		
	// set json	error code
	$info["code"] = $error_code;
	$info["desc"] = $desc;
	echo json_encode($info);
?>