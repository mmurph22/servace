<head>
	<link rel="stylesheet" type="text/css"  href="content.css" />
</head>
<h3>A List of Reported Wildlife Collisions on LocalWeb</h3>
<div id="showDiv" class="table_responsive">
<?php 
	require_once("db.php");
	
	// get collisions table, max 15 rows
	$sql = "Select * from collisions limit 15";
	$res = mysqli_query($con, $sql);
	if (!$res)
		die("Query Invalid" . mysqli_error($con));
	// valid return on query
?>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Report Date</th>
				<th>Species</th>
				<th>Gender</th>
				<th>Age Class</th>
				<th>Location</th>
				<th>Latitude</th>
				<th>Longitude</th>
				<th>Picture</th>
			</tr>
		</thead>
		<tbody>
		<?php
			$i = 0;
			while($row = mysqli_fetch_array($res))
			{
				$rstyle = "active";
				switch ($i%4)
				{
					case 0: {	$rstyle = "active"; break;}
					case 1: {	$rstyle = "success"; break;}
					case 2: {	$rstyle = "warning"; break;}
					case 3: {	$rstyle = "danger"; break;}
				};
				$rdate = strtotime($row["report_date"]);
				$display_date = date("m/d/Y h:i A", $rdate);
				print("<tr class=\" . $rstyle . \">");
				print("<td>" . $row["id"] . "</td>");
				print("<td>" . $display_date . "</td>");
				print("<td>" . $row["species"] . "</td>");
				print("<td>" . $row["gender"] . "</td>");
				print("<td>" . $row["age"] . "</td>");
				print("<td>" . $row["location"] . "</td>");
				print("<td>" . $row["latitude"] . "</td>");
				print("<td>" . $row["longitude"] . "</td>");
				print("<td><img alt='img' width=50 height=50 src='" . $row["img_url"] . "'/></td>");
				print("</tr>");
				$i++; // increment style 
			}	
		?>
		</tbody>
	</table>	
	
	
</div>
