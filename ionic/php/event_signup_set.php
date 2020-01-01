<?php 
	
	// unsafe disable of CORS for local use ONLY
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT');
	header('Access-Control-Max-Age: 1000');
	
	header('content-type: application/json; charset=utf-8');
	
	require_once("db.php");
	require_once("func_ratings.php");
	
	// create volunteer in db
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
	
	$desc = ""; // json return
	if ((!empty($vid)) &&
		(!empty($eid)) &&
		(!empty($v_perc))
		) 
	{
		// query if this volunteer already signed up
		$vol_signups = 0;
		$dupl_sql = "select count(*) from volunteers_events 
			where eid='".$eid."' and vid='".$vid."'";
		//echo ("********" . $dupl_sql . "********");
			
		$dupl_res = mysqli_query($con, $dupl_sql);
		$dupl_row = mysqli_fetch_row($dupl_res); 
		$vol_signups = $dupl_row[0];
		//echo("Volunteer signups =============> " . $vol_signups);
		
		if ($vol_signups == 0)
		{
			// put info into database
			$sql = "insert volunteers_events (vid, eid, volperc) 
			values ($vid,$eid,$v_perc)";
							
			$res = mysqli_query($con, $sql);		
			if ($res){
				$error_code = 0;
				$desc = $desc . "Volunteer Signup successful.";
			} else {
				$error_code = 2; // cannot enter DB
				$desc = $desc . "Database specific Failure on Signup. " . mysqli_error($con);
			}
		}
		else
		{
			$error_code = 3; // duplicate sign up 
			$desc = $desc . "Volunteer already Signed up for Event";
		}
	}
	else {
		$error_code = 1; // incomplete 
		$desc = $desc . "Form not filled out completely. Try again.";
	}
		
	// set json	error code
	$info["code"] = $error_code;
	$info["desc"] = $desc;
	echo json_encode($info);
?>