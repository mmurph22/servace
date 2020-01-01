		<head>
			<link rel="stylesheet" type="text/css" href="content.css" />
			<script>
				function showUser(str) {
				    if (str == "") {
				        document.getElementById("userTable").innerHTML = "";
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
				                document.getElementById("userTable").innerHTML = this.responseText;
				            }
				        };
				        if (str == 'create')
				        	xmlhttp.open("GET","profile_vols_create.php",true);
				        else
				        	xmlhttp.open("GET","profile_vols_get.php?q="+str,true);
				        xmlhttp.send();
				    }
				}
			</script>
		</head>
		<body>
			<div class="row alert servace-alert">
				<div class="servace-banner">ServACE Profiles</div>
				<form class="form-horizontal">
					<?php 
						require_once("db.php");
						
						// get collisions table, max 15 rows
						$sql = "Select * from volunteers order by lastname, firstname";
						$res = mysqli_query($con, $sql);
						if (!$res)
							die("Query Invalid" . mysqli_error($con));
					?>
					<div class="form-group">;
						<label class="control-label col-sm-2" for="desc">Select Profile:</label>
						<div class="col-sm-8">
							<select class="form-control" name="v_users" onchange="showUser(this.value)">
								<option value="">Select a profile:</option>
								<?php
									while($row = mysqli_fetch_array($res))
									{
										print ('<option value="'.$row["vid"].'">'.$row["firstname"].' '.$row["lastname"].'</option>');	
									}
								?>
								<option value="create">[Create Profile]</option>
							</select>
						</div>
					</div>
				</form>
				<br>
				<div id="userTable"></div>	
			</div>
		</body>