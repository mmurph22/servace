<html>
<head>
	<link rel="stylesheet" type="text/css" href="content.css" />
	<script type="text/javascript">
		function showTasks(eid, create) {
		    if (eid == "") {
		        document.getElementById("taskTable").innerHTML = "";
		        return;
		    } else { 
		        if (window.XMLHttpRequest) {
		            // code for IE7+, Firefox, Chrome, Opera, Safari
		            xmlhttp = new XMLHttpRequest();
		        } else {
		            // code for IE6, IE5
		            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		        }
		        xmlhttp.onreadystatechange = function() {
		            if (this.readyState == 4 && this.status == 200) {
		                document.getElementById("taskTable").innerHTML = this.responseText;
		            }
		        };
		       
		        if (create == true)
		        	xmlhttp.open("GET","manage_tasks_create.php?q="+eid,true);
		        else
					xmlhttp.open("GET","manage_tasks_get.php?q="+eid,true);
					
		        xmlhttp.send();
		    }
		}
	</script>
</head>
<body>

<?php 
	require_once("db.php");
	
	// get events info, based on selected venue
	$q = 1;
	if (isset($_GET['q']));
		$q = intval($_GET['q']);
	
	$sql = "Select a.*, b.*
       		from events a
       			inner join venues b on
       			b.venueid = a.venueid
			where b.venueid = '" . $q . "'";
	
	$res = mysqli_query($con, $sql);
	if (!$res)
		die("Query Invalid" . mysqli_error($con));
	// valid return on query
?>

<?php
	require_once("func_ratings.php");
	
		// Event table: One row
	print('<table id="eventlist" class="table table-hover">');
		print('<tr>');
			print('<th>Event</th>');
			print('<th>Description</th>');
			print('<th>Start Date</th>');
			print('<th>End Date</th>');			
			print('<th>Daily Start Time</th>');
			print('<th>Daily End Time</th>');
			print('<th>Number of Required Staff</th>');
			print('<th>ServACE Points per Staff</th>');
		print('</tr>');
		print('<tbody>');
	while ($row = mysqli_fetch_array($res)) {
			// Event table: multirow 
			print("<tr class='active'>");
				$eid = $row["eventid"];
				//$gettask = "location.href='manage_tasks_get.php?q=".$eid."'";
				$gettask = "manage_tasks_get.php?q=".$eid;
				$addtask = "manage_tasks_create.php?q=".$eid;
				
				print("<td>" . $row["event_name"] . "</td>");
				print("<td>" . $row["event_description"] . "</td>");
				print("<td>" . formattedDate($row["startdate"]) . "</td>");
				print("<td>" . formattedDate($row["enddate"]) . "</td>");
				print("<td>" . formattedTime($row["daystarttime"]) . "</td>");
				print("<td>" . formattedTime($row["dayendtime"]) . "</td>");
				print("<td>" . $row["numstaff"] . "</td>");
				print("<td>" . $row["badgepoints_pp"] . "</td>");
                      
			print("</tr>");
	}
		print('</tbody>');
	print('</table>');
	mysqli_close($con);
?>	
	<br/>
	<div id="taskTable"></div>	

</body>
</html>