<?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST, GET');
	header('Access-Control-Max-Age: 1000');

	header('content-type: application/json; charset=utf-8');
	require_once ("db.php");
	require_once("func_ratings.php");
	
	$q = 0;
	if (isset($_GET['eid']));
		$q = intval($_GET['eid']);
	
	// now get events info, based on selected venue
	$sql = "Select a.*, b.venue_name, SPACE(1) as vols_required  
			from events a
				inner join venues b on
				b.venueid = a.venueid
			where a.eventid = '" . $q . "'";
	$res = mysqli_query($con, $sql);
	if (!$res)
		die("Query Invalid" . mysqli_error($con));
	
	// valid return on query
	//$row = mysqli_fetch_array($res);
	$info = array();				
	while($row = mysqli_fetch_assoc($res)) {
		// add enhanced data
		$row["vols_required"]= get_actual_volunteers_required($row["eventid"]);
		
		array_push($info, $row);
	}
	echo json_encode($info);
?>