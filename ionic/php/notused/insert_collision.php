<?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST, GET');
	header('Access-Control-Max-Age: 1000');
	
	header('content-type: application/json; charset=utf-8');

	require_once("db.php");
	require_once("upload_func.php");
	
	// return data
	$error_code = null;
	$desc = "";
	$info = array();
	$imgURL = null;
	
	// STATIC VARS
	$imgurlkey = "imgURL";
	$imghtmlkey = "imgFile";
	$uploadskey = "uploads";
	$uploadsurikey = "uploadImgURI";
	
	
	// species dropdown
	$species = $_POST['species'];
	$alt_species = $_POST['txtSpecies'];
	// others selected: use alternate
	if ($species === "Others")
		$species = $alt_species;
	
	// other form data
	$gender = ucfirst($_POST['rbGender']);
	$age = ucfirst($_POST['rbAge']);
	$dt = $_POST['rpDate'];
	$location = $_POST['location'];
	$latitude = $_POST['lat'];
	$longitude = $_POST['lng'];
	
	// validate required inputs
	if (
		(!empty($species) && is_string($species)) &&
		(!empty($location) && is_string($location)) &&
		(isset($latitude) && is_numeric($latitude)) &&
		(isset($longitude) && is_numeric($longitude))
		)
	{
		// process uploaded file
		if (!empty($_FILES["imgFile"]["name"])) {
			$uploadResult = file_upload($imghtmlkey, $uploadskey);
			$imgURL = $uploadResult[$imgurlkey];
			$desc = $uploadResult["desc"];
		}
		if (!empty($_POST[$uploadsurikey])) {
			$imgURL = $_POST[$uploadsurikey];
			$desc = " uploadImgURI " + $imgURL;
		}
		
		$reportDate = date("Y-m-d H:i:s", strtotime($dt));
		// put collision info into database
		$sql = "insert collisions(species,gender,age,report_date,location,latitude,longitude,img_url) 
		values ('$species','$gender','$age',STR_TO_DATE('$reportDate','%Y-%m-%d %H:%i:%s'),'$location','$latitude','$longitude','$imgURL')";		
		$res = mysqli_query($con, $sql);
		if ($res){
			$error_code = 0;
			$desc = $desc . "<p>Collision Record entered into DB successfully.</p>";
		} else {
			$error_code = 2;
			$desc = $desc . "<p>Failure attempting to enter Collision Record into DB." . mysqli_error($con) . "</p>";
		}
	}
	else {
		$err_code = 1; // incomplete 
		$desc = $desc . "<p>Sorry!</p>";
		$desc = $desc . "<p>You didn't fill out the form completely. <a href='report_collision.html'>Try again?</a></p>";
	}
	
	// set json error code
	$info["code"] = $error_code;
	$info["desc"] = $desc;
	echo json_encode($info);

?>