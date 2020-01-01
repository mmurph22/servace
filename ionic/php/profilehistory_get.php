<?php

	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST, GET');
	header('Access-Control-Max-Age: 1000');

	header('content-type: application/json; charset=utf-8');
	
	require_once("db.php");
	require_once("func_ratings.php");

	// now get the volunteer's history
	$q = intval($_GET['q']);
	$sql = "select a.*, b.*, c.*, d.venue_name, SPACE(1) as 's_pts'
			from events a
				 inner join volunteers_events b on
				 b.eid = a.eventid
				 inner join volunteers c on
				 c.vid = b.vid
				 inner join venues d on
				 d.venueid = a.venueid
			where c.vid = '".$q."'";
	$res = mysqli_query($con, $sql);
	if (!$res)
		die("Query Invalid" . mysqli_error($con));
	
	$info = array();
	while($row = mysqli_fetch_assoc($res)) {
		// add enhanced data
		$row['s_pts'] = getACEScore($row['badgepoints_pp'], $row['rating'], $row['volperc']);
		
		array_push($info, $row);
	}
	echo json_encode($info);
?>