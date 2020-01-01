<form class="form-horizontal" method="post" action="manage_events_create.php?action=create_event" enctype="multipart/form-data">
<?php
	require_once("db.php");
	// get events info, based on selected venue
	$q = intval($_GET['q']);
	print('<input hidden id="vid" name="vid" type="number" value="'.$q.'" />');
?>
	<div class="form-group">
		<label class="control-label col-sm-2 col-xs-2" for="desc">Event Name:</label>
		<div class="col-sm-10" >
			<input class="form-control" type="text" id="ename" name="ename" placeholder="Event Name"/>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2 col-xs-2" for="desc">Event Description:</label>
		<div class="col-sm-10" >
			<input class="form-control" type="text" id="edesc" name="edesc" placeholder="Description of Event"/>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2 col-xs-2" for="desc">Start Date:</label>
		<div class="col-sm-10" >
			<input class="form-control" type="date" id="estdate" name="estdate" />
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2 col-xs-2" for="desc">End Date:</label>
		<div class="col-sm-10" >
			<input class="form-control" type="date" id="eenddate" name="eenddate" />
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2 col-xs-2" for="desc">Start Time: </label>
		<div class="col-sm-10" >
			<input class="form-control" type="time" id="esttime" name="esttime"/>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2 col-xs-2" for="desc">End Time: </label>
		<div class="col-sm-10" >
			<input class="form-control" type="time" id="eendtime" name="eendtime"/>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2 col-xs-2" for="desc">Number of Staff Needed:</label>
		<div class="col-sm-10" >
			<input class="form-control" type="number" id="enumstaff" name="enumstaff" min="1.0" step="0.25" placeholder="Total Manpower Needed"/>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2 col-xs-2" for="desc">Numer of ServACE Awarded per Staff:</label>
		<div class="col-sm-10" >
			<input class="form-control" type="number" id="epointspp" name="epointspp" min="1" step="1" max="200" placeholder="Average Number of ServACE points a volunteer could earn (max 200)"/>
		</div>
	</div>
	<div class="col-sm-offset-2 col-sm-10 col-xs-offset-2 col-xs-10" >
		<input class="btn btn-default col-sm-2" type="reset" id="cancel" value="Cancel" />
		<input class="btn btn-primary col-sm-2" type="submit" id="submit" value="Submit" />
	</div>
</form>
<?php  
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
?>