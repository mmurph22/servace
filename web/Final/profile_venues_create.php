<head>
	
	<link rel="stylesheet" type="text/css" href="content.css" />
	<!--
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDjmQ4kGTwhJYW911DWwoVIVe_5rKig1jU"></script>
	 This tag uses a key restricted to UMD site: for release
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCaPggewe6B3IKyAEQfBUAhvoYhW8THqUE"></script>
			<script>
				function initMap_venues() {
					alert("start venue map");
			        var maryland = {lat: 38.4419, lng: -76.1419};
			        var mapOptions = {
						zoom: 13,
						mapTypeId : google.maps.MapTypeId.ROADMAP,
						center: maryland
					};
			        map = new google.maps.Map(document.getElementById("mapCanvas_locateVenue"), mapOptions);
			
			/*
			        infowindow = new google.maps.InfoWindow({
			          content: document.getElementById('form')
			        });
			
			        messagewindow = new google.maps.InfoWindow({
			          content: document.getElementById('message')
			        });
			
			        google.maps.event.addListener(map, 'click', function(event) {
			          marker = new google.maps.Marker({
			            position: event.latLng,
			            map: map
			          });
					
			          google.maps.event.addListener(marker, 'click', function() {
			            infowindow.open(map, marker);
			          });
			        });
			        */
			    }
			      
				window.addEventListener("load", initMap_venues, true);  //window.onload = init;  
				window.addEventListener("submit", initMap_venues, true);  //window.onsubmit = init;  
			</script>
		-->
</head>
<body>
<form class="form-horizontal" method="post" action="index.php?action=create_venue" enctype="multipart/form-data">
	<div class="form-group container-fluid">
		<div class="row">
			<div class ="col-md-6 col-sm-6">
				<div class="form-group">
					<label class="control-label col-sm-2 col-xs-2" for="desc">Venue Name:</label>
					<div class="col-sm-10" >
						<input class="form-control" type="text" id="vname" name="vname" placeholder="Enter Venue Name"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2 col-xs-2" for="desc">Venue Address:</label>
					<div class="col-sm-10" >
						<input class="form-control" type="text" id="vaddr" name="vaddr" placeholder="Enter Venue Address"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2 col-xs-2" for="desc">POC Name:</label>
					<div class="col-sm-10" >
						<input class="form-control" type="text" id="pocname" name="pocname" placeholder="Enter POC's Name"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2 col-xs-2" for="desc">POC Email:</label>
					<div class="col-sm-10" >
						<input class="form-control" type="email" id="pocemail" name="pocemail" placeholder="Enter POC's Email"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2 col-xs-2" for="desc">POC Phone:</label>
					<div class="col-sm-10" >
						<input class="form-control" type="text" id="pocphone" name="pocphone" placeholder="Enter POC's Phone"/>
					</div>
				</div>
				<!-- BEGIN: replace this with button and map control -->
				<div class="form-group">
					<label class="control-label col-sm-2 col-xs-2" for="desc">Latitude:</label>
					<div class="col-sm-10" >
						<input class="form-control" type="number" id="vlat" name="vlat" min="-90" max="90" step="any" placeholder="Enter Latitude"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2 col-xs-2" for="desc">Longitude:</label>
					<div class="col-sm-10" >
						<input class="form-control" type="number" id="vlon" name="vlon" min="-180" max="180" step="any" placeholder="Enter Longitude"/>
					</div>
				</div>
				<!-- END: replace this with button and map control -->
			</div>
			<div class ="col-md-6 col-sm-6">
				<label class="control-label" for="desc">To set the Venue location, click on the map:</label>
				<div id="mapCanvas_locateVenue" class="servace_map" />
			</div>
		</div>
	</div>
	
	<div class="col-sm-offset-2 col-sm-10 col-xs-offset-2 col-xs-10" >
		<input class="btn btn-default col-sm-2" type="reset" id="cancel" value="Cancel" />
		<input class="btn btn-primary col-sm-2" type="submit" id="submit" value="Submit" />
	</div>
</form>
</body>