		<head>
			<link rel="stylesheet" type="text/css" href="content.css" />	
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
			<script>
				function showEventVols(str) {
				    if (str == "") {
				        document.getElementById("eventVolTable").innerHTML = "";
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
				                document.getElementById("eventVolTable").innerHTML = this.responseText;
				            }
				        };
				        xmlhttp.open("GET","rate_volunteers_get.php?q="+str,true);
				        xmlhttp.send();
				    }
				}
				function updateTextRating(inctl, intype, settype, val) {
					// get numerical id from inctl
					var l = intype.length;
					var id = inctl.substring(l);
					// get text ctl
					var setctl = settype+id;
					
	        		document.getElementById(setctl).innerHTML= val; 
	    		}
	    
	    		function sendRatingData()
				{
					var vol_array = [];
					var rate_array = [];
					var table = document.getElementById('rateTable');
					var ln = table.rows.length;
					for(var r=1; r<ln; r++) //skip first row as it's header'
					{
						// get volunteer id
						var vid = table.rows[r].cells[0].innerHTML;	// volunteer id
						
						// get rating (must check for 'Volunteered' check box)
						var rate = 0; // initial rating if unchecked
						var chk_fldname = 'comp' + vid.toString();
						var chk_fld = document.getElementById(chk_fldname);
						if (chk_fld.checked) {
						
							var rate_fldname = 'rate' + vid.toString();
							var rate_fld = document.getElementById(rate_fldname);
							rate = rate_fld.value;	// rating
						}
						//capture data
						vol_array.push(vid);
						rate_array.push(rate);
					}
					// DEBUG
					for(var $r=0; $r<rate_array.length; $r++)
						alert(vol_array[$r] + " = " + rate_array[$r]);
					
					// save to session
					if (window.XMLHttpRequest) {
			            // code for IE7+, Firefox, Chrome, Opera, Safari
			            xmlhttp = new XMLHttpRequest();
			        } else {
			            // code for IE6, IE5
			            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			        }
			        // POST as JSON
			        xmlhttp.open( "POST", "index.php?action=postrate" );
					xmlhttp.setRequestHeader( "Content-Type", "application/json" );
					xmlhttp.send( JSON.stringify(vol_array) );
			        
			        
			
					
					
					//$.post("index.php?action=postrate", { vol_array: vol_array }, function(response) { console.log(response); });
					//$.post("index.php?action=postrate", { rate_array: rate_array }, function(response) { console.log(response); });
					
					//sessionStorage.setItem('vol_array', vol_array);
					//sessionStorage.setItem('rate_array', rate_array);
					//sessionStorage.setItem('selected_event', eventid);
					
					//window.location.href = "index.php?action=postrate";
				}
			
				function sendRatingData2D()
				{
					var rate_array = {};
					var table = document.getElementById('rateTable');
					var ln = table.rows.length;
					for(var r=1; r<ln; r++) //skip first row as it's header'
					{
						// get volunteer id
						var vid = table.rows[r].cells[0].innerHTML;	// volunteer id
						var vid_fld = vid.toString();
						
						// get rating (must check for 'Volunteered' check box)
						var rate = 0; // initial rating if unchecked
						var chk_fldname = 'comp' + vid.toString();
						var chk_fld = document.getElementById(chk_fldname);
						if (chk_fld.checked) {
						
							var rate_fldname = 'rate' + vid.toString();
							var rate_fld = document.getElementById(rate_fldname);
							rate = rate_fld.value;	// rating
						}
						//capture data
						//rate_array['rate_array'].push({"vol_id":vid_fld,"rate":rate});
						rate_array[vid_fld] = rate;
						
						//alert (vid_fld + ":" + rate_array[vid_fld]);
					}
					
					// save to session
					if (window.XMLHttpRequest) {
			            // code for IE7+, Firefox, Chrome, Opera, Safari
			            xmlhttp = new XMLHttpRequest();
			        } else {
			            // code for IE6, IE5
			            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			        }
			        xmlhttp.onreadystatechange = function() {
			            if (this.readyState == 4 && this.status == 200) {
			                //document.getElementById("eventVolTable").innerHTML = this.responseText;
			            }
			        };
			        
			        // POST as JSON
			        var str_arr = "rate_array=" + JSON.stringify(rate_array);
			        alert ( str_arr );
			        xmlhttp.open( "POST", "index.php?action=postrate", true );
					xmlhttp.setRequestHeader( "Content-Type", "application/json" );
					xmlhttp.send( str_arr );
					
					
					//$.post("index.php?action=postrate", { vol_array: vol_array }, function(response) { console.log(response); });
					//$.post("index.php?action=postrate", { rate_array: rate_array }, function(response) { console.log(response); });
					
					//sessionStorage.setItem('vol_array', vol_array);
					//sessionStorage.setItem('rate_array', rate_array);
					//sessionStorage.setItem('selected_event', eventid);
					
					window.location.href = "index.php?action=postrate";
				}
			</script>
		</head>
		<body>
			<!--<div id="report" class="row alert alert-warning">-->
			<div class="row alert servace-alert">
				<div class="servace-banner">Rate Event Volunteers</div>
				<form class="form-horizontal">
					<?php 
						require_once("db.php");
						
						// get corelated volunteers to events table
						$sql = "Select a.*, b.venue_name 
								from events a
     								inner join venues b on
     								b.venueid = a.venueid
								order by b.venue_name, a.event_name";
						$res = mysqli_query($con, $sql);
						if (!$res)
							die("Query Invalid" . mysqli_error($con));
					?>
					<div class="form-group">;
						<label class="control-label col-sm-3" for="desc">Select Event to Rate Volunteers:</label>
						<div class="col-sm-7">
							<select class="form-control" name="events_rate" onchange="showEventVols(this.value);">
								<option value="">Select an Event:</option>
								<?php
									while($row = mysqli_fetch_array($res))
									{
										print ('<option value="'.$row["eventid"].'">'.$row["venue_name"].' -- '.$row["event_name"].'</option>');	
									}
								?>
							</select>
						</div>
					</div>
				</form>
				<br>
				<div id="eventVolTable"></div>	
			</div>
		</body>
