<?php

	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST, GET');
	header('Access-Control-Max-Age: 1000');

	header('content-type: application/json; charset=utf-8');
	
	require_once("db.php");
	require_once("func_ratings.php");

	// now get the venue's history
	$venueid="";
	if (isset($_GET['venueid']))
		$venueid = $_GET['venueid'];
	else if (isset($_POST['venueid']))
		$venueid = $_POST['venueid'];
	
	$sql = "Select a.*, b.*, SPACE(1) as vols_assigned
		from events a
			inner join venues b on
			b.venueid = a.venueid
		where b.venueid = '" . $venueid . "'";

	$res = mysqli_query($con, $sql);
	if (!$res)
		die("Query Invalid" . mysqli_error($con));
	
	$info = array();
	while($row = mysqli_fetch_assoc($res)) {
		// add enhanced data
		$row["vols_assigned"]= get_actual_volunteers_assigned($row["eventid"]);
		
		array_push($info, $row);
	}
	echo json_encode($info);
?>