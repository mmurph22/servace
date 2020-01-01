<?php 
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST, GET');
	header('Access-Control-Max-Age: 1000');

	header('content-type: application/json; charset=utf-8');
	
	require_once("db.php");
	require_once("func_ratings.php");
	
	// get the venue selected
	$venueid="";
	if (isset($_GET['venueid']))
		$venueid = $_GET['venueid'];
	else if (isset($_POST['venueid']))
		$venueid = $_POST['venueid'];
	
	$sql = "Select * from venues where venueid = '".$venueid."'";
	
	$res = mysqli_query($con, $sql);
	if (!$res)
		die("Query Invalid" . mysqli_error($con));
	// valid return on query
	//$row = mysqli_fetch_array($res);
	$info = array();				
	while($row = mysqli_fetch_assoc($res)) {
		// add enhanced data
		
		array_push($info, $row);
	}
	echo json_encode($info);
?>