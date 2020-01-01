<html>
	<head>
		<link rel="stylesheet" type="text/css" href="content.css" />
	</head>
	<body>
		<?php
		require_once ("db.php");
		require_once("func_ratings.php");
		
		$q = 0;
		if (isset($_GET['eid']));
			$q = intval($_GET['eid']);
		
		// first, get a count of the actual required staff.
		// requested - already signed up
		$sql_count = "select a.eventid, a.numstaff, b.eid, b.volperc  
	       			  from events a
	  		        	  left join volunteers_events b on
	       				  b.eid = a.eventid
					  where a.eventid = '" . $q . "'";
		$res = mysqli_query($con, $sql_count);
		if (!$res)
			die("Query Invalid" . mysqli_error($con));

		$s_required = get_actual_volunteers_required($q);
		$max_assign = intval($s_required * 100);
		if ($max_assign > 100)
			$max_assign = 100;
	
		// now get all the volunteer names
		$volunteers = array();
		//$sql = "Select * from volunteers order by lastname, firstname";
		//filter out users already volunteered
		$sql = "select * from volunteers a
					where (select count(*) from volunteers_events
					where vid = a.vid and eid = '" . $q . "') = 0 
					order by a.lastname, a.firstname";
		$res = mysqli_query($con, $sql);
		if (!$res)
			die("Query Invalid" . mysqli_error($con));
		while ($row = mysqli_fetch_array($res)) {
			$idx = $row["vid"];
			$volunteers[$idx] = $row["firstname"].' '.$row["lastname"];
		}
	
		// now get events info, based on selected venue
		$sql = "Select a.*, b.venue_name  
	       		from events a
	       			inner join venues b on
	       			b.venueid = a.venueid
				where a.eventid = '" . $q . "'";
		$res = mysqli_query($con, $sql);
		if (!$res)
			die("Query Invalid" . mysqli_error($con));
		// valid return on query
		$row = mysqli_fetch_array($res);
		
	?>
		<div class="row alert servace-alert">
			<div class="servace-banner">Sign Up</div>
			<form class="form-horizontal" method="post" action="index.php?action=bookings&eid=<?php print($q); ?>" enctype="multipart/form-data">
				<input hidden name="q" type="number" value="'.$q.'" />
				<div class="form-group container-fluid">
					<div class="row">
						<div class ="col-md-6 col-sm-6">
							<table class="table table-hover"> 
								<tr class="alert"><th>Venue</th><td><?php print($row["venue_name"]); ?></td></tr>
								<tr class='alert'><th>Event</th><td><?php print($row["event_name"]); ?></td></tr>
								<tr class='alert'><th>Description</th><td><?php print($row["event_description"]); ?></td></tr>
								<tr class='alert'><th>Start Date</th><td><?php print(formattedDate($row["startdate"])); ?></td></tr>
								<tr class='alert'><th>End Date</th><td><?php print(formattedDate($row["enddate"])); ?></td></tr>
								<tr class='alert'><th>Daily Start Time</th><td><?php print(formattedTime($row["daystarttime"])); ?></td></tr>
								<tr class='alert'><th>Daily End Time</th><td><?php print(formattedTime($row["dayendtime"])); ?></td></tr>
								<tr class='alert'><th>ServACE Points Available</th><td><?php print($row["badgepoints_pp"]); ?></td></tr>
								<?php
								if ($s_required > 0) { ?>
									<!-- Get Volunteer Dropdown -->
									<tr class='alert'><th>Number Of Required Staff</th><td><?php print($s_required); ?></td></tr>
									<tr class='alert'><th>Volunteering</th>
										<td><select class="form-control" name="v_users">
											<?php 
											foreach ($volunteers as $key => $value) {
												print ('<option value="'.$key.'">'.$value.'</option>');	
											}
											?>
										</select></td>
									<tr class='alert'><th>Percentage Time of Availability</th>
										<td><input class="form-control" type="number" id="signupperc" name="signupperc" min="0" max="<?php print($max_assign); ?>" step="5" value="<?php print($max_assign); ?>" placeholder="Percentage Event Availability"/></td>
									</tr>
								<?php } else { ?>
									<tr class='alert'><th>Number Of Required Staff</th><td>None Required.</td></tr>
									<tr class='alert'><th>Volunteering</th><td>Thanks Anyway!</td></tr>
									<tr class='alert'><th>Percentage Time of Availability</th><td><input class="form-control" readonly type="number" id="signupperc" name="signupperc" value="0" /></td></tr>								
								<?php } 
								mysqli_close($con);
								?>
							</table>
						</div>
						<div class ="col-md-6 col-sm-6">
							<img id="imagerate" height="300" alt="images/chips_aces.png" src="images/chips_aces.png" />
						</div>
					</div>
				</div>
				<div class="col-sm-offset-2 col-sm-10 col-xs-offset-2 col-xs-10" >
					<input class="btn btn-default col-sm-2" type="reset" id="cancel" value="Cancel" />
					<input class="btn btn-primary col-sm-2" type="submit" id="submit" value="Volunteer" <?php if ($s_required <= 0) { ?> disabled <?php } ?>  />
				</div>
			</form>
		</div>
	</body>
</html>