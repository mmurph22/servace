<?php 
	
	// unsafe disable of CORS for local use ONLY
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT');
	header('Access-Control-Max-Age: 1000');
	
	header('content-type: application/json; charset=utf-8');
	
	require_once("db.php");
	require_once("func_ratings.php");
	
	// Volunteer Ratings information
	$volid=0;
	$eventid=0;
	$rating=0.0;
	
	if (isset($_GET['volid'])) $volid = intval($_GET['volid']);
	else if (isset($_POST['volid'])) $volid = intval($_POST['volid']);

	if (isset($_GET['eventid'])) $eventid = intval($_GET['eventid']);
	else if (isset($_POST['eventid'])) $eventid = intval($_POST['eventid']);
	
	if (isset($_GET['rating'])) $rating = $_GET['rating'];
	else if (isset($_POST['rating'])) $rating = $_POST['rating'];
	
	$desc = ""; // json return
	$error_code = 2; // default DB error code
	$err_sql = "";
	
	//echo("TEST{{{".$uname." ".$pwd." ".$fname." ".$lname." ".$email."}}}");
	
	if ((!empty($volid)) &&
		(!empty($eventid)) &&
		(!empty($rating)) && ($rating>0))
	{		
		// scroll through event's volunteer id, 
		// calculate, and save rate, one by one
		// use the previous query
		$sql = get_ratings_domain_sql($eventid);
		$res = mysqli_query($con, $sql);
		if ($res) {
			while($row = mysqli_fetch_array($res))
			{
				// put info into database			
				// determine the volunteers score for this event
				$v_score = get_servace_event_score(get_RATE_AVG(), get_RATE_MULT(), $rating, $row['badgepoints_pp'], $row['volperc']);
					
				// determine the new volunteer's total points
				$new_total_pts =  floatval($row['badgepoints']) + $v_score;
					
				// determine the new volunteer's servace level
				$new_servace_level = get_servace_level($new_total_pts, get_LEVELSIZE());
					
				// update query: volunteer's rating, new volunteer's points, new volunteer's level
				$sql_ve = "update volunteers_events set rating='". $rating . "' 
							where vid='". $volid ."' and eid='". $eventid ."';"; 
								
				$veres = mysqli_query($con, $sql_ve);		
				if ($veres){			
					// put info into database for volunteer
					$sql_v = "update volunteers 
					set badgepoints='" . intval($new_total_pts) . "', levelid='" . $new_servace_level . "' 
					where vid='". $volid ."';";

					$vres = mysqli_query($con, $sql_v);		
					if ($vres){
						$error_code = 0; // success
					} else {
						$error_code = 2; // DB error
						$err_sql = mysqli_error($con) . "->volunteers";
					}
				} else {
					$error_code = 2; // DB error
					$err_sql = mysqli_error($con) . "->volunteers_events";
				}
			}
		}
		else {
			$error_code = 2; // DB error
			$err_sql = mysqli_error($con) . "->get_ratings_domain_sql";
		}
	}
	else {
		$error_code = 1; // incomplete 
	}
	
	// set error code description
	if ($error_code == 0) {// success
		$desc = $desc . "Volunteer Rated on Event successful.";
	}
	else if ($error_code == 1) {// incomplete
		$desc = $desc . "Form not filled out completely. Try again.";
	}	
	else if ($error_code == 2) {// DB error
		$desc = $desc . "Error inserting into DB. " . $err_sql;
	}	
		
	// set json	error code
	$info["code"] = $error_code;
	$info["desc"] = $desc;
	echo json_encode($info);
?>