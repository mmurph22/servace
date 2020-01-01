		<head>
			<link rel="stylesheet" type="text/css" href="content.css" />
			<script type="text/javascript">
				function showEvents(str, create) {
				    if (str == "") {
				        document.getElementById("eventTable").innerHTML = "";
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
				                document.getElementById("eventTable").innerHTML = this.responseText;
				            }
				        };
				        
				        if (create == true)
				        	xmlhttp.open("GET","manage_events_create.php?q="+str,true);
				        else
							xmlhttp.open("GET","manage_events_get.php?q="+str,true);
							
				        xmlhttp.send();
				    }
				}
			</script>
		</head>
		<body>
			<!--<div id="report" class="row alert alert-warning">-->
			<div class="row alert servace-alert">
				<div class="servace-banner">Event Profiles</div>
				<form class="form-horizontal" method="post" action="manage_events_create.php?action=create_event" enctype="multipart/form-data">
					<?php 
						require_once("db.php");
						
						// get collisions table, max 15 rows
						$sql = "Select * from venues";
						$res = mysqli_query($con, $sql);
						if (!$res)
							die("Query Invalid" . mysqli_error($con));
					?>
					<div class="form-group">;
						<label class="control-label col-sm-2" for="desc">Select Venue:</label>
						<div class="col-sm-6">
							<select class="form-control" name="v_users" onchange="showEvents(this.value, false)">
								<option value="">Select a venue:</option>
								<?php
									while($row = mysqli_fetch_array($res))
									{
										print ('<option value="'.$row["venueid"].'">'.$row["venue_name"].'</option>');
									}
								?>
							</select>
						</div>
						<input class="btn btn-primary col-sm-2" type="button" id="addevent" value="Add Event to Venue" onclick="showEvents(v_users.value, true)" />
					</div>
				</form>
				<br>
				<div id="eventTable"></div>	
			</div>
		</body>