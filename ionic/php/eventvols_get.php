<?php 
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST, GET');
	header('Access-Control-Max-Age: 1000');

	header('content-type: application/json; charset=utf-8');
	
	require_once("db.php");
	require_once("func_ratings.php");
	
	// get the venue selected
	$eventid="";
	if (isset($_GET['eventid']))
		$eventid = $_GET['eventid'];
	else if (isset($_POST['eventid']))
		$eventid = $_POST['eventid'];
	
	$sql = get_ratings_domain_sql($eventid);
	
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