<form class="form-horizontal" method="post" action="profile_venues_create.php?action=create_task" enctype="multipart/form-data">
<?php
	require_once("db.php");
	// get events info, based on selected venue
	$e = intval($_GET['eid']);
	print('<input hidden id="eid" name="eid" type="number" value="'.$e.'" />');
?>
	<div class="form-group">
		<label class="control-label col-sm-2 col-xs-2" for="desc">Task Summary:</label>
		<div class="col-sm-10" >
			<input class="form-control" type="text" id="tname" name="tname" placeholder="Summary of Task"/>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2 col-xs-2" for="desc">Task Description:</label>
		<div class="col-sm-10" >
			<input class="form-control" type="text" id="tdesc" name="tdesc" placeholder="Description of Task"/>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2 col-xs-2" for="desc">Number Of Staff:</label>
		<div class="col-sm-10" >
			<input class="form-control" type="number" id="tstaff" name="tstaff" min="1" max="90" placeholder="Enter Number of Staff Needed"/>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2 col-xs-2" for="desc">Percentage of Staff Time:</label>
		<div class="col-sm-10" >
			<input class="form-control" type="number" id="tperctime" name="tperctime" min="0" max="100" placeholder="Enter Percentage of Event Time for Task"/>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2 col-xs-2" for="desc">Baseline ServACE Points to Earn:</label>
		<div class="col-sm-10" >
			<input class="form-control" type="number" id="tspoints" name="tspoints" min="0" placeholder="Enter Average ServACE points earned"/>
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
		if ($action === 'create_task') {
			// create volunteer in db
			$eid = intval($_POST['eid']);
			$t_name = $_POST['tname'];
			$t_desc = $_POST['tdesc'];
			$t_staff = $_POST['tstaff'];
			$t_perc = $_POST['tperctime'];
			$t_points = $_POST['tspoints'];
			if ((!empty($t_name) && is_string($t_name)) &&
				(!empty($t_desc) && is_string($t_desc)) &&
				(!empty($t_staff) ) &&
				(!empty($t_perc) ) &&
				(!empty($t_points) )
			) {
				// put info into database
				require_once("db.php");
				
				$sql = "insert tasks(venue_name, address, pocname, pocemail, pocphone, latitude, longitude) 
				values ('$v_name','$v_addr','$poc_name','$poc_email','$poc_phone',$v_lat,$v_lon)";
				
				$res = mysqli_query($con, $sql);
				
				header("Location: index.php?action=venue_profile");
				if (!$res){
					print ("<h4>Failure attempting to enter Volunteer Record into DB." . mysqli_error($con) . "</h4>");
				}
			}
		}
	}	
?>