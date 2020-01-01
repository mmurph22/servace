		<head>
			<link rel="stylesheet" type="text/css" href="content.css" />
			<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDjmQ4kGTwhJYW911DWwoVIVe_5rKig1jU"></script> -->
			<!-- This tag uses a key restricted to UMD site: for release -->
			 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCaPggewe6B3IKyAEQfBUAhvoYhW8THqUE"></script>
			<script>
				var map;
				var marker;
				var markers = [];
				
				function venueLocatorMap() {
					//alert ("Enter information about your venue"); // map won't start without this. must inspect
			        var maryland = {lat: 39.389336, lng: -77.038335}; //center
			        var mapOptions = {
						zoom: 8,
						mapTypeId : google.maps.MapTypeId.ROADMAP,
						center: maryland
					};
					var divmap = document.getElementById("mapCanvas_locateVenue");
			        if (divmap)
			        {
				        map = new google.maps.Map(divmap, mapOptions);
				         
				        infowindow = new google.maps.InfoWindow({
				          content: document.getElementById('form')
				        });
				
				        messagewindow = new google.maps.InfoWindow({
				          content: document.getElementById('vname')
				        }); 
	
				        google.maps.event.addListener(map, 'click', function(event) {	       		
				       		marker = new google.maps.Marker({
				            	position: event.latLng,
				            	map: map
				        	});			
				      
				        	google.maps.event.addListener(marker, 'click', function() {
				            	infowindow.open(map, marker);
				        	});
				           
				        	// copy the clicked position to the lat lon fields
				        	document.getElementById("vlat").value = marker.getPosition().lat();
				        	document.getElementById("vlon").value = marker.getPosition().lng();
				          
				      	});
			      	}
				}
				
			//NOT USED ****	
		      // Adds a marker to the map and push to the array.
		      function addMarker(location) {
		        var marker = new google.maps.Marker({
		          position: location,
		          map: map
		        });
		        markers.push(marker);
		      }
		
		      // Sets the map on all markers in the array.
		      function setMapOnAll(map) {
		        for (var i = 0; i < markers.length; i++) {
		          markers[i].setMap(map);
		        }
		      }
		
		      // Removes the markers from the map, but keeps them in the array.
		      function clearMarkers() {
		        setMapOnAll(null);
		      }
		
		      // Shows any markers currently in the array.
		      function showMarkers() {
		        setMapOnAll(map);
		      }
		
		      // Deletes all markers in the array by removing references to them.
		      function deleteMarkers() {
		        clearMarkers();
		        markers = [];
		      }
			//NOT USED ****		
				
				
				//window.addEventListener("load", venueLocatorMap, true);  //window.onload = init;  
				window.addEventListener("submit", venueLocatorMap, true);  //window.onsubmit = init;  
			</script>
			<script>
				function showVenue(str) {
				    if (str == "") {
				        document.getElementById("venueTable").innerHTML = "";
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
				                document.getElementById("venueTable").innerHTML = this.responseText;
						        if (str == 'create')
						        	venueLocatorMap();
				            }
				        };
				        if (str == 'create'){
				        	xmlhttp.open("GET","profile_venues_create.php",true);
				        }
				        else
				        	xmlhttp.open("GET","profile_venues_get.php?q="+str,true);
				        xmlhttp.send();
				    }
				}
			</script>
		</head>
		<body>
			<!--<div id="report" class="row alert alert-warning">-->
			<div class="row alert servace-alert">
				<div class="servace-banner">Venue Profiles</div>
				<form class="form-horizontal">
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
							<select class="form-control" name="v_users" onchange="showVenue(this.value)">
								<option value="">Select a venue:</option>
								<?php
									while($row = mysqli_fetch_array($res))
									{
										print ('<option value="'.$row["venueid"].'">'.$row["venue_name"].'</option>');	
									}
								?>
								<!--<option value="create"><strong>[Create Venue]</strong></option>-->
							</select>
						</div>
						<input class="btn btn-primary col-sm-2" type="button" id="addevent" value="Add Venue" onclick="showVenue('create')" />
					</div>
				</form>
				<br>
				<div id="venueTable"></div>	
			</div>
		</body>