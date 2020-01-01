<head>
	<link rel="stylesheet" type="text/css" href="content.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDjmQ4kGTwhJYW911DWwoVIVe_5rKig1jU"></script>--> 
	<!-- This tag uses a key restricted to UMD site: for release -->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCaPggewe6B3IKyAEQfBUAhvoYhW8THqUE"></script>
	<script type="text/javascript">
		// Globals, used in multiple code blocks
		var _map;
		var _markers = null;
		var _defaultLoc = new google.maps.LatLng(38.985978, -76.942564); 
		var _defaultPlace = "University of Maryland College Park";
		
		// on load
		function init() {
			//set up default map
		    var mapOptions = {
			      zoom: 16,
			      mapTypeId : google.maps.MapTypeId.ROADMAP,
			      center: _defaultLoc
		    };
		    _map = new google.maps.Map(document.getElementById("mapCanvas"), mapOptions);
		}
		    
		function clearMarkers() {
			var markers = _map.markers;
			for (var i = 0; i < markers.length; i++) {
  				markers[i].setMap(null);
			}
			_markers = new Array();
		}
		
		//https://stackoverflow.com/questions/19304574/center-set-zoom-of-map-to-cover-all-visible-markers?rq=1&utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa
		function centerMapOnMarkers()
		{
			console.log("centerMapOnMarkers");
			var bounds = new google.maps.LatLngBounds();
			var mks = _markers; //_map.markers;
			console.log(mks.length);
			for(i=0;i<mks.length;i++) {
			    bounds.extent(mks[i].getPosition());
			    console.log(bounds);
			}
			if (mks.length > 0)
			{
				//center the map to the geometric center of all markers
				_map.setCenter(bounds.getCenter());
				
				// now fit/zoom the map
				_map.fitBounds(bounds);
				
				//remove one zoom level to ensure no marker is on the edge.
				_map.setZoom(_map.getZoom()-1); 
				
				// set a minimum zoom 
				// if you got only 1 marker or all markers are on the same address map will be zoomed too much.
				if(_map.getZoom()> 15){
				  _map.setZoom(15);
				}
				
				//Alternatively this code can be used to set the zoom for just 1 marker and to skip redrawing.
				//Note that this will not cover the case if you have 2 markers on the same address.
				if(mks.length == 1){
				    _map.setMaxZoom(15);
				    _map.fitBounds(bounds);
				    _map.setMaxZoom(Null)
				}
			}
		}

        function initMap() {
	        _map = new google.maps.Map(document.getElementById('mapCanvas'), {
	          center: new google.maps.LatLng(39.563276,-76.207977),
	          //center: new google.maps.LatLng(40,-75),
	          zoom: 10
	        });
	        var infoWindow = new google.maps.InfoWindow;
	
	          // Change this depending on the name of your PHP or XML file
	          //downloadUrl('https://storage.googleapis.com/mapsdevsite/json/mapmarkers2.xml', function(data) {
	        _markers = new Array();
	        
	        console.log("Initialize");
	        console.log(_markers);
	        //x=0;
	        downloadUrl('event_markers.xml', function(data) {
	            var xml = data.responseXML;
	            var markers = xml.documentElement.getElementsByTagName('marker');
	               
	            Array.prototype.forEach.call(markers, function(markerElem) {
	              var id = markerElem.getAttribute('id');
	              var name = markerElem.getAttribute('venue_name');
	              var event = markerElem.getAttribute('event_name');
	              var address = markerElem.getAttribute('venue_address');
	              var point = new google.maps.LatLng(
	                  parseFloat(markerElem.getAttribute('lat')),
	                  parseFloat(markerElem.getAttribute('lng')));
	                  
	              var infowincontent = document.createElement('div');
	              var strong = document.createElement('strong');
	              strong.textContent = name;
	              infowincontent.appendChild(strong);
	              infowincontent.appendChild(document.createElement('br'));
	
	              var text = document.createElement('text');
	              text.textContent = address;
	              infowincontent.appendChild(text);
	              var marker = new google.maps.Marker({
	                map: _map,
	                position: point,
	                //animation: google.maps.Animation.BOUNCE, //cute!
	                //icon: 'images/chip.png'
	              });
	              _markers.push(marker);
	              console.log(_markers);      
	              marker.addListener('click', function() {
	                infoWindow.setContent(infowincontent);
	                infoWindow.open(_map, marker);
	              });
	              //x++;
	            });
	         });
	         
			 // center map on points
	         //centerMapOnMarkers();
        }
		
		function downloadUrl(url,callback) {
			 var request = window.ActiveXObject ?
			     new ActiveXObject('Microsoft.XMLHTTP') :
			     new XMLHttpRequest;
			
			 request.onreadystatechange = function() {
			   if (request.readyState == 4) {
			     request.onreadystatechange = doNothing;
			     callback(request, request.status);
			   }
			 };
			 request.open('GET', url, true);
			 request.send(null);
		}
		function doNothing(){}
		
		function initMapChain()
		{
			$.when(initMap()).then(centerMapOnMarkers()); // not operational
		}
		
		// main script
		window.addEventListener("load", initMap, false);  //window.onload = init;  
	</script>
</head>
<body>
	<div class="row alert servace-alert">
		<div class="servace-banner">ServACE Opportunities</div>
		<div class="col-sm-12" >
			<div id="mapCanvas" class="servace_map"></div>
		</div>
	<!--<div id="report" class="row alert alert-warning">-->

		<form class="form-horizontal" method="post" action="index.php?action=signup" enctype="multipart/form-data">
			<?php
				//session_start(); 
				require_once("db.php");
				require_once("func_ratings.php");
				//require_once("phpsqlajax_dbinfo.php");

				// Start XML file, create parent node
				$dom = new DOMDocument("1.0");
				$node = $dom->createElement("markers");
				$parnode = $dom->appendChild($node);
				
				// get list of events
				$sql = "Select b.eventid, a.venue_name, a.address, b.event_name, b.startdate, b.enddate, a.pocname, a.latitude, a.longitude
						from venues a
						inner join events b on
						b.venueid = a.venueid
						order by a.venue_name, b.startdate";
				$res = mysqli_query($con, $sql);
				if (!$res)
					die("Query Invalid" . mysqli_error($con));
				// valid return on query
			?>
			<table class="table table-hover">
				<thead>
					<tr>
						<!--<th>EventID</th>  for testing only -->
						<th>Venue</th>
						<th>Event</th>
						<th>Start Date</th>
						<th>End Date</th>
						<th>POC Name</th>
						<th>Action</th>
						<!--<th>x</th>-->
						<!--<th>y</th>-->
					</tr>
				</thead>
				<tbody>
				<?php
					while($row = mysqli_fetch_array($res))
					{
						$vols_required = get_actual_volunteers_required($row["eventid"]);
						$sdate = strtotime($row["startdate"]);
						$edate = strtotime($row["enddate"]);
						$now = new DateTime();
						$rstyle = "success";
						if ($edate < $now->getTimestamp()) {
							$rstyle = "warning";
						}

						$ds_date = formattedDate($row["startdate"]);
						$de_date = formattedDate($row["enddate"]);
						
						print("<tr class=\" . $rstyle . \">");
						//print("<td id='eid" . $row["eventid"] ."'>" . $row["eventid"] . "</td>"); // for testing only
						print("<td>" . $row["venue_name"] . "</td>");
						print("<td>" . $row["event_name"] . "</td>");
						print("<td>" . $ds_date . "</td>");
						print("<td>" . $de_date . "</td>");
						print("<td>" . $row["pocname"] . "</td>");
						if ($vols_required>0) {
							print("<td>" . '<a href="index.php?action=signup&eid=' . $row["eventid"] . '">Sign Up</a>' . "</td>");
						} else {
							print("<td> Covered </td>");
						}
						//print("<td>" . $row["latitude"] . "</td>");
						//print("<td>" . $row["longitude"] . "</td>");
						print("</tr>");
						
						// Add to XML document node
						$node = $dom->createElement("marker");
						$newnode = $parnode->appendChild($node);
						$newnode->setAttribute("id", $row['eventid']);
						$newnode->setAttribute("venue_name", $row['venue_name']);
						$newnode->setAttribute("event_name", $row['event_name']);
						$newnode->setAttribute("venue_address", $row['address']);
						$newnode->setAttribute("lat", $row['latitude']);
						$newnode->setAttribute("lng", $row['longitude']);
					}
					$dom->save("event_markers.xml");// dump xml
						
				?>
				</tbody>
			</table>
		</form>
	</div>
</body>
		