		<head>
			<link rel="stylesheet" type="text/css" href="content.css" />
		</head>
		<body>
					<?php 
						require_once("db.php");
						
						// get the volunteer selected
						$q = intval($_GET['q']);
						$sql = "Select * from venues where venueid = '".$q."'";
						$res = mysqli_query($con, $sql);
						if (!$res)
							die("Query Invalid" . mysqli_error($con));
						// valid return on query
					?>
					<table class="table table-hover">
						<tr>
							<th>Name</th>
							<th>Address</th>
							<th>POC Name</th>
							<th>POC Email</th>
							<th>POC Phone</th>
							<th>Lat</th>
							<th>Lon</th>
						</tr>
						<tbody>
						<?php
							while($row = mysqli_fetch_array($res))
							{
								print("<tr class='active'>");
								print("<td>" . $row["venue_name"] . "</td>");
								print("<td>" . $row["address"] . "</td>");
								print("<td>" . $row["pocname"] . "</td>");
								print("<td>" . $row["pocemail"] . "</td>");
								print("<td>" . $row["pocphone"] . "</td>");
								print("<td>" . $row["latitude"] . "</td>");
								print("<td>" . $row["longitude"] . "</td>");
								print("</tr>");
							}
							mysqli_close($con);	
						?>
						</tbody>
					</table>
			</body>