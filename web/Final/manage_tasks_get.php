<head>
	<link rel="stylesheet" type="text/css" href="content.css" />
</head>
<body>
<?php 
	require_once("db.php");
	
	// get events info, based on selected venue
	$q = intval($_GET['q']);
	$sql = "Select a.*, b.*, c.*  
       		from tasks a
       			inner join events b on
       			b.eventid = a.eventid
       			inner join venues c on
       			c.venueid = b.venueid
			where c.venueid = '" . $q . "'";
			
	$res = mysqli_query($con, $sql);
	if (!$res)
		die("Query Invalid" . mysqli_error($con));
	// valid return on query

	$r_num = 0;
	while ($row = mysqli_fetch_array($res)) {
		if ($r_num == 0)
		{
			// Event table: One row
			print('<table id="eventlist" class="table table-hover">');
				print('<tr>');
					print('<th>Venue</th>');
					print('<th>Event</th>');
					print('<th>Description</th>');
					print('<th>Start Date</th>');
					print('<th>Start Time</th>');
					print('<th>End Date</th>');
					print('<th>End Time</th>');
				print('</tr>');
				print('<tbody>');
				print("<tr class='active'>");
					print("<td>" . $row["venue_name"] . "</td>");
					print("<td>" . $row["event_name"] . "</td>");
					print("<td>" . $row["event_description"] . "</td>");
					print("<td>" . $row["startdate"] . "</td>");
					print("<td>" . $row["daystarttime"] . "</td>");
					print("<td>" . $row["enddate"] . "</td>");
					print("<td>" . $row["dayendtime"] . "</td>");
				print("</tr>");
				print('</tbody>');
			print('</table>');
		}
		if ($r_num == 0)
		{
			// Task Table: Header one row
			print('<table id="tasklist" class="table table-hover">');
				print('<tr>');
					print('<th>Task Summary</th>');
					print('<th>Description</th>');
					print('<th>Number of Staff</th>');
					print('<th>Percentage of Event Time</th>');
					print('<th>ServACE Points</th>');
				print('</tr>');
				print('<tbody>');
		}
				// Task Table: Many rows
				print("<tr class='active'>");
					print("<td>" . $row["task_name"] . "</td>");
					print("<td>" . $row["task_description"] . "</td>");
					print("<td>" . $row["numstaff"] . "</td>");
					print("<td>" . $row["eventperc"] . "</td>");
					print("<td>" . $row["badgepoints"] . "</td>");
				print('</tr>');
						
			// increment row counter
			$r_num++;
	}
				print('</tbody>');
			print('</table>');
	mysqli_close($con);
?>
	<div class="col-sm-offset-2 col-sm-10 col-xs-offset-2 col-xs-10" >
		<input class="btn btn-default col-sm-2" type="reset" id="cancel" value="Cancel" />
		<input class="btn btn-primary col-sm-2" type="submit" id="submit" value="Add Task" />
	</div>
	
</body>