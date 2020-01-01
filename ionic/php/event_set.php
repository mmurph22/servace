<?php 
	
	// unsafe disable of CORS for local use ONLY
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT');
	header('Access-Control-Max-Age: 1000');
	
	header('content-type: application/json; charset=utf-8');
	
	require_once("db.php");
	require_once("func_ratings.php");
	
	// Event Information
	$venueid=0;
	$e_name="";
	$e_desc="";
	$e_stdate="";
	$e_sttime="";
	$e_enddate="";
	$e_endtime="";
	$e_numstaff=0.0;
	$e_ppp=0;
	
	if (isset($_GET['venueid'])) $venueid = intval($_GET['venueid']);
	else if (isset($_POST['venueid'])) $venueid = intval($_POST['venueid']);
	
	if (isset($_GET['ename'])) $e_name = $_GET['ename'];
	else if (isset($_POST['ename'])) $e_name = $_POST['ename'];
	
	if (isset($_GET['edesc'])) $e_desc = $_GET['edesc'];
	else if (isset($_POST['edesc'])) $e_desc = $_POST['edesc'];
	
	if (isset($_GET['estdate'])) $e_stdate = $_GET['estdate'];
	else if (isset($_POST['estdate'])) $e_stdate = $_POST['estdate'];
	
	if (isset($_GET['esttime'])) $e_sttime = $_GET['esttime'];
	else if (isset($_POST['esttime'])) $e_sttime = $_POST['esttime'];
	
	if (isset($_GET['eenddate'])) $e_enddate = $_GET['eenddate'];
	else if (isset($_POST['eenddate'])) $e_enddate = $_POST['eenddate'];
	
	if (isset($_GET['eendtime'])) $e_endtime = $_GET['eendtime'];
	else if (isset($_POST['eendtime'])) $e_endtime = $_POST['eendtime'];
	
	if (isset($_GET['enumstaff'])) $e_numstaff = floatval($_GET['enumstaff']);
	else if (isset($_POST['enumstaff'])) floatval($e_numstaff = $_POST['enumstaff']);
	
	if (isset($_GET['eppp'])) $e_ppp = intval($_GET['eppp']);
	else if (isset($_POST['eppp'])) $e_ppp = intval($_POST['eppp']);

	$desc = ""; // json return
	$error_code = 2; // default DB error code
	$err_sql = "";
	
	//echo("TEST{{{".$venueid." ".$e_name." ".$e_desc." ".$e_stdate." ".$e_sttime." ".$e_enddate." ".$e_endtime." ".$e_numstaff." ".$e_ppp."}}}");
	
	// create event in db
	if ((!empty($e_name) && is_string($e_name)) &&
		(!empty($e_desc) && is_string($e_desc)) &&
		(!empty($e_stdate) && is_string($e_stdate)) &&
		(!empty($e_sttime) && is_string($e_sttime)) &&
		(!empty($e_enddate) && is_string($e_enddate)) &&
		(!empty($e_endtime) && is_string($e_endtime)) &&
		(!empty($e_numstaff)) &&
		(!empty($e_ppp))
		) 
	{		
		// put info into database for Events
		$sql = "insert events(venueid, event_name, event_description, startdate, enddate, daystarttime, dayendtime, numstaff, badgepoints_pp) 
		values ($venueid,'$e_name','$e_desc','$e_stdate','$e_enddate','$e_sttime','$e_endtime', $e_numstaff, $e_ppp)";
		
		$res = mysqli_query($con, $sql);		
		if ($res){
			$error_code = 0; // success
		} else {
			$error_code = 2; // DB error
			$err_sql = mysqli_error($con);
		}
	}
	else {
		$error_code = 1; // incomplete 
	}
	
	// set error code description
	if ($error_code == 0) {// success
		$desc = $desc . "Event Registered successful.";
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