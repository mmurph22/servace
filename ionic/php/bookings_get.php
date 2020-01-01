<?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST, GET');
	header('Access-Control-Max-Age: 1000');

	header('content-type: application/json; charset=utf-8');

	// get volunteer in db
	// CORS issue above blocking posting of data from localhost
	if (isset($_GET['eid']))
		$eid = intval($_GET['eid']);
	else if (isset($_POST['eid']))
		$eid = intval($_POST['eid']);
	
	if (isset($_GET['vid']))
		$vid = intval($_GET['vid']);
	else if (isset($_POST['vid']))
		$vid = intval($_POST['vid']);
	
	if (isset($_GET['vperc']))
		$v_perc = $_GET['vperc'];
	else if (isset($_POST['vperc']))
		$v_perc = $_POST['vperc'];

	if ((!empty($vid)) &&
		(!empty($eid)) &&
		(!empty($v_perc))
		) 
	{
		// put info into database
		require_once("db.php");
		require("func_ratings.php");
		
		// print thank you directions page
		// first, query for meta information
		$sql = "Select a.*, b.*, c.*, d.*
				from events a
					 inner join venues b on
					 b.venueid = a.venueid
					 left join volunteers_events c on
					 c.eid = a.eventid
					 left join volunteers d on
					 d.vid = c.vid
				 where (a.eventid = ".$eid." and c.vid = ".$vid.")";
					 
		$res = mysqli_query($con, $sql);
		if (!$res)
			die("Query Invalid" . mysqli_error($con));
		// valid return on query
		//$row = mysqli_fetch_array($res);
		$info = array();				
		while($row = mysqli_fetch_assoc($res)) {
			// add enhanced data
			//???		
			array_push($info, $row);
		}
		echo json_encode($info);
	}
?>