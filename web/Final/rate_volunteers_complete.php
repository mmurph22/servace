<div class="row alert servace-alert">
		<div class="servace-banner">Volunteers Rated. Event Complete.</div>
<?php  
	// Dynamically generate main content
	//session_start();
	
	require_once("func_ratings.php");
	require_once("db.php");
		
	// globals
	$rate_pre = get_RATE_CTRL_PREFIX();
	$rate_en_pre = get_RATEENABLE_CTL_PREFIX();
	
	// event id
	$eid = -1;
	if (isset($_SESSION['selected_event'])) {
		$eid = intval($_SESSION['selected_event']);
	}
	
	// scroll through event's volunteer id, 
	// calculate, and save rate, one by one
	// use the previous query
	$sql = get_ratings_domain_sql($eid);
	$res = mysqli_query($con, $sql);
	if (!$res)
		die("Query Invalid" . mysqli_error($con));	 
	
	while($row = mysqli_fetch_array($res))
	{
		$vid = $row['vid']; // volunteer id
		$v_rate_ctl = $rate_pre . $vid;
		$v_enabled_ctl = $rate_en_pre . $vid;
		
		$rating = -1; // rating for volunteer
		if (isset($_POST[$v_rate_ctl]))
			$rating = $_POST[$v_rate_ctl];
		
		$rating_enabled = ""; // did volunteer show up? If not rating = 0
		if (isset($_POST[$v_enabled_ctl]))
			$rating_enabled = $_POST[$v_enabled_ctl];
		else {
			$rating_enabled = "vol skipped out!";
			$rating = 0;
		}
		//print('<h4>eid:' .$eid. '  vid:'.$vid.'  rating:'.$rating.'  en:'.$rating_enabled.'</h4>');	
	
		if ((!empty($vid)) &&
			(!empty($eid)) &&
			(!empty($rating) || ($rating==0))) 
		{
			// put info into database			
 			// determine the volunteers score for this event
			$v_score = get_servace_event_score(get_RATE_AVG(), get_RATE_MULT(), $rating, $row['badgepoints_pp'], $row['volperc']);
				
			// determine the new volunteer's total points
			$new_total_pts =  floatval($row['badgepoints']) + $v_score;
				
			// determine the new volunteer's servace level
			$new_servace_level = get_servace_level($new_total_pts, get_LEVELSIZE());
				
			// update query: volunteer's rating, new volunteer's points, new volunteer's level
			$sql_u = "update volunteers_events set rating='". $rating . "' 
						where vid='". $vid ."' and eid='". $eid ."';"; 
			//print($sql_u);
			$res_u = mysqli_query($con, $sql_u);
			if (!$res_u)
				print ("<h4>Failure attempting to enter Volunteering Rating into DB." . mysqli_error($con) . "</h4>");
			
			$sql_u = "update volunteers 
						set badgepoints='" . intval($new_total_pts) . "', levelid='" . $new_servace_level . "' 
						where vid='". $vid ."';";
			//print($sql_u);
			$res_u = mysqli_query($con, $sql_u);
			if (!$res_u)
				print ("<h4>Failure attempting to enter Volunteering Rating into DB." . mysqli_error($con) . "</h4>");
			else {
				print ('<h4>Posted rating of '.$row['firstname'].' '.$row['lastname'].' for efforts on '.$row['event_name'].'</h4>');
			}
		}
	}
	mysqli_close($con);
?>
	<!-- Write thank you page here -->
	<h2>Thank you for providing your feedback. Our ServACE volunteers appreciate it.</h2>
</div>

