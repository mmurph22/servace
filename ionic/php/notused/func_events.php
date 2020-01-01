<?php  
	function create_event() {
		// Dynamically generate main content
		$action = null;
		if (isset($_REQUEST['action'])) {
			$action = $_REQUEST['action'];
			
			//direct pages
			if ($action === 'create_event') {
				// create volunteer in db
				$vid = intval($_POST['vid']);
				$e_name = $_POST['ename'];
				$e_desc = $_POST['edesc'];
				$e_stdate = $_POST['estdate'];
				$e_sttime = $_POST['esttime'];
				$e_enddate = $_POST['eenddate'];
				$e_endtime = $_POST['eendtime'];
				$e_numstaff = $_POST['enumstaff'];
				$e_ppp = $_POST['epointspp'];
				if ((!empty($e_name) && is_string($e_name)) &&
					(!empty($e_desc) && is_string($e_desc)) &&
					(!empty($e_stdate) && is_string($e_stdate)) &&
					(!empty($e_sttime) && is_string($e_sttime)) &&
					(!empty($e_enddate) && is_string($e_enddate)) &&
					(!empty($e_endtime) && is_string($e_endtime)) &&
					(!empty($e_numstaff)) &&
					(!empty($e_ppp))
					) {
					// put info into database
					require_once("db.php");
					
					$sql = "insert events(venueid, event_name, event_description, startdate, enddate, daystarttime, dayendtime, numstaff, badgepoints_pp) 
					values ($vid,'$e_name','$e_desc','$e_stdate','$e_enddate','$e_sttime','$e_endtime', $e_numstaff, $e_ppp)";
					
					$res = mysqli_query($con, $sql);
					if (!$res)
						print ("<h4>Failure attempting to enter Event Record into DB." . mysqli_error($con) . "</h4>");
					else
						header("Location: index.php?action=event_manage");
					 
				}
			}
		}	
	}
?>