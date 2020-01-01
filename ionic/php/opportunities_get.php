<?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST, GET');
	header('Access-Control-Max-Age: 1000');
	
	header('content-type: application/json; charset=utf-8');
	
	//session_start(); 
	require_once("db.php");
	require_once("func_ratings.php");
	//require_once("phpsqlajax_dbinfo.php");
	
	// get list of events
	$sql = "Select b.eventid, a.venue_name, a.address, b.event_name, b.startdate, b.enddate, a.pocname, a.latitude, a.longitude, SPACE(1) as vols_required
			from venues a
			inner join events b on
			b.venueid = a.venueid
			order by a.venue_name, b.startdate";
	$res = mysqli_query($con, $sql);
	if (!$res)
		die("Query Invalid" . mysqli_error($con));
	// valid return on query
	$info = array();				
	while($row = mysqli_fetch_assoc($res)) {
		// add enhanced data
		$row["vols_required"]= get_actual_volunteers_required($row["eventid"]);
		
		array_push($info, $row);
	}
	echo json_encode($info);
	
?>
