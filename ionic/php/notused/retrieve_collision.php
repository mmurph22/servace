<?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST, GET');
	header('Access-Control-Max-Age: 1000');
	
	header('content-type: application/json; charset=utf-8');

	require_once("db.php");

	$sql = "select * from collisions order by report_date desc limit 15";
	$res = mysqli_query($con, $sql);
	if (!$res)
		die("Invalid Query: " . mysqli_error($con));
	
	$info = array();
	while($row = mysqli_fetch_assoc($res)) {
		
		array_push($info, $row);
	}
	echo json_encode($info);
?>