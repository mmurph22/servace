<head>
	<link rel="stylesheet" type="text/css" href="content.css" />
	<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDjmQ4kGTwhJYW911DWwoVIVe_5rKig1jU"></script> -->
	<!-- This tag uses a key restricted to UMD site: for release -->
	 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCaPggewe6B3IKyAEQfBUAhvoYhW8THqUE"></script>
	<script type="text/javascript">
		// Globals, used in multiple code blocks
		var _map;
		var _defaultLoc = new google.maps.LatLng(38.985978, -76.942564); 
		var _defaultPlace = "University of Maryland College Park";

 		// on load
		function init_test() {
			//alert("Show booking map init");
			//set up default map
		    var mapOptions = {
			      zoom: 16,
			      mapTypeId : google.maps.MapTypeId.ROADMAP,
			      center: _defaultLoc
		    };
		    _map = new google.maps.Map(document.getElementById('mapCanvas_booking'), mapOptions);
		    
    	    var point = new google.maps.LatLng(
              parseFloat(40.00),
              parseFloat(-75.00));
            _map.setCenter(point);
		}

        function initMap() {
        	//alert("Show booking map");
	        _map = new google.maps.Map(document.getElementById('mapCanvas_booking'), {
	          center: _defaultLoc,
	          zoom: 10
	        });
	        var infoWindow = new google.maps.InfoWindow;
	
	          // Change this depending on the name of your PHP or XML file
	         downloadUrl('booking_marker.xml', function(data) {
	            var xml = data.responseXML;
	            var markers = xml.documentElement.getElementsByTagName('marker');
	            
	            Array.prototype.forEach.call(markers, function(markerElem) {
	              var id = markerElem.getAttribute('id');
	              var name = markerElem.getAttribute('venue_name');
	              var event = markerElem.getAttribute('event_name');
	              var desc = markerElem.getAttribute('event_description');
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
	              text.textContent = event;
	              infowincontent.appendChild(text);
	              var marker = new google.maps.Marker({
	                map: _map,
	                position: point,
	                //animation: google.maps.Animation.BOUNCE, //cute!
	                //icon: 'images/chip.png'
	              });
	              marker.addListener('click', function() {
	                infoWindow.setContent(infowincontent);
	                infoWindow.open(_map, marker);
	              });
	              // center map on point
	              _map.setCenter(point);
	            });
	          });
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
		
		// main script
		window.addEventListener("load", initMap, false);  //window.onload = init;  
	</script>
	<script>
		function sendMail() {
	        if (window.XMLHttpRequest) {
	            // code for IE7+, Firefox, Chrome, Opera, Safari
	            xmlhttp = new XMLHttpRequest();
	        } else {
	            // code for IE6, IE5
	            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	        }
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	            	request.onreadystatechange = doNothing;
			     	//callback(request, request.status);
	                //document.getElementById("msg_response").innerHTML = this.responseText;
	            }
	        };
	        xmlhttp.open("POST","index.php?action=send_mail",true);
	        xmlhttp.send();
		}
		
		function compileEmail() {
			// compile message from tags
			emailmsg = getEmailBody();
			//alert ( emailmsg );
			
			// place message into textarea for posting
			document.getElementById("txtMessage").innerHTML = emailmsg;
			
			// getting email info (may not need)
			var to_name = document.getElementById("txtNameTo").value; 
			var to_addr = document.getElementById("txtEmailTo").value;
			var from_name = document.getElementById("txtName").value;
			var from_addr = document.getElementById("txtEmail").value;
			var from_subj = document.getElementById("txtSubject").value;
			var from_msg = emailmsg;
			var reply_name = document.getElementById("txtNameReply").value;
			var reply_addr = document.getElementById("txtEmailReply").value;
			
			//see demo msg: changing email
			document.getElementById("txtNameTo").value = from_name;
			document.getElementById("txtEmailTo").value = from_addr;
			to_name = document.getElementById("txtNameTo").value;
			to_addr = document.getElementById("txtEmailTo").value;
			//alert(from_name + "\n" + from_addr + "\n" + from_subj + "\n" + from_msg);

			// post message
			sendMail();
			
			// Demo popup
			var demomsg = "As this is demo software, we not not sending emails to true addresses.";
			demomsg = demomsg + "\n" + "Sending to Admin instead...";
			demomsg = demomsg + "\n" + "Email sent to " + to_name + "(" + to_addr + ")";
			alert(demomsg);
		}
		
		// parsing email from page
		// TBD
		function getEmailBody()
		{
			var emailmsg = "";
			emailmsg = emailmsg + document.getElementById("msg_hdr").innerHTML;
			emailmsg = emailmsg + document.getElementById("msg_event_hdr").innerHTML;
			emailmsg = emailmsg + document.getElementById("msg_event_table").innerHTML;
			emailmsg = emailmsg + document.getElementById("msg_POC_hdr").innerHTML;
			emailmsg = emailmsg + document.getElementById("msg_POC_table").innerHTML;
			emailmsg = emailmsg + document.getElementById("msg_footer").innerHTML;
			return emailmsg;
		}
</script>
</head>
<body>	
<?php  
	// Dynamically save volunteer info
	$action = null;
	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];
		
		//direct pages
		if ($action === 'bookings') {
			// create volunteer in db
			$eid = intval($_GET['eid']);			
			$vid = intval($_POST['v_users']);
			$v_perc = $_POST['signupperc'];

			if ((!empty($vid)) &&
				(!empty($eid)) &&
				(!empty($v_perc))
				) {
				// put info into database
				require_once("db.php");
				require("func_ratings.php");
				
				$sql = "insert volunteers_events (vid, eid, volperc) 
				values ($vid,$eid,$v_perc)";
								
				$res = mysqli_query($con, $sql);
				if (!$res)
					print ("<h4>Failure attempting to enter Volunteering Record into DB." . mysqli_error($con) . "</h4>");
				else {
					
					// google map support
					// Start XML file, for map support
					$dom = new DOMDocument("1.0");
					$node = $dom->createElement("markers");
					$parnode = $dom->appendChild($node);
					// google map support
				
					// print thank you directions page
					// first, query for meta information
					$sql = "Select a.*, b.*, c.*, d.*
							from events a
							     inner join venues b on
							     b.venueid = a.venueid
							     left join volunteers_events c on
							     c.eid = a.eventid
							     left join volunteers d on
							     d.vid = c.vid
							 where (a.eventid = ".$eid." and c.vid = ".$vid.")";
								 
					$res = mysqli_query($con, $sql);
					if (!$res)
						die("Query Invalid" . mysqli_error($con));
					// valid return on query
					$row = mysqli_fetch_array($res);
					
					// must calculate potential ServACE points
					$cur_points = $row["badgepoints"];
					$points_pp = $row["badgepoints_pp"];
					$volperc = $row["volperc"];
					$potential = $points_pp * ($volperc/ 100.0);
					
					// format date time
					$stdate = formattedDate($row["startdate"]);
					$sttime = formattedTime($row["daystarttime"]);
					$enddate = formattedDate($row["enddate"]);
					$endtime = formattedTime($row["dayendtime"]);
				
					/*date_format($date,"F j, Y"); F j, Y
					date_format($date,"h:i A"); h:i A
					*/
					
					// Add to XML document node
					$node = $dom->createElement("marker");
					$newnode = $parnode->appendChild($node);
					$newnode->setAttribute("id", $eid);
					$newnode->setAttribute("venue_name", $row['venue_name']);
					$newnode->setAttribute("event_name", $row['event_name']);
					$newnode->setAttribute("event_description", $row['event_description']);
					$newnode->setAttribute("venue_address", $row['address']);
					$newnode->setAttribute("lat", $row['latitude']);
					$newnode->setAttribute("lng", $row['longitude']);
					$dom->save("booking_marker.xml");// dump xml
					
					// mail support
					$sendto_addr = $row["email"]; // send to volunteer
					$sendto_name = $row["firstname"] . " " . $row["lastname"];
					$sendfrom_addr = get_ADMIN_EMail('primary'); // send from admin
					$sendfrom_name = get_ADMIN_Name('primary');
					$sendreply_addr = $row["pocemail"]; // reply to POC
					$sendreply_name = $row["pocname"];
					$sendfrom_subject = "A ServACE Volunteer has signed up for " . $row["event_name"]; // for subject
					$sendfrom_msg = ""; // extract from below
				?>
					
				<div class="row alert servace-alert">
					<div class="servace-banner">Volunteer's Next Steps</div>
						<div id="msg_hdr">
							<h4>Thank you, <?php print($sendto_name); ?> for volunteering for an event through ServACE.</h4>
							<br>
							<p>There is no powerful force in this world than a neighbor willing to help another neighbor. As you know, you will be earning valuable points to earn your stripes and "move up the deck"!
							For this event, you could earn an average of <?php print($potential); ?> ServACE points to go with the <?php print($cur_points); ?> points you already have earned, 
							but if you give above and beyond and your neighbor notices, those points may go higher. One day, they may call YOU a ServACE!
							</p>
						</div>
						<div class="row">
							<div class ="col-md-6 col-sm-6">
								<div class ="form-group">
									<p id="msg_event_hdr">You will be volunteering for the event:</p>
									<table id="msg_event_table">
										<tr><th class ="col-md-3 col-sm-3"><?php print($row["event_name"]); ?> at</th></tr>
										<tr><th class ="col-md-3 col-sm-3"><?php print($row["venue_name"]); ?></th></tr>
										<tr><th class ="col-md-3 col-sm-3"><?php print($row["address"]); ?></th></tr>
										<tr><th class ="col-md-3 col-sm-3">You have volunteered for <?php print($row["volperc"]); ?>% of this event time</tr></tr>
									</table>					
								</div>
								<p id="msg_POC_hdr">Event info and POC as follows:</p>
								<table id="msg_POC_table">
									<tr><th class ="col-md-3 col-sm-3">Name: </th><td><?php print($row["pocname"]); ?></td></tr>
									<tr><th class ="col-md-3 col-sm-3">Phone: </th><td><?php print($row["pocphone"]); ?></td></tr>
									<tr><th class ="col-md-3 col-sm-3">Email: </th><td><?php print($row["pocemail"]); ?></td></tr>
									<tr><th class ="col-md-3 col-sm-3">Starting Date: </th><td><?php print($stdate); ?></td></tr>
									<tr><th class ="col-md-3 col-sm-3">Ending Date: </th><td><?php print($enddate); ?></td></tr>
									<tr><th class ="col-md-3 col-sm-3">Daily Start at: </th><td><?php print($sttime); ?></td></tr>
									<tr><th class ="col-md-3 col-sm-3">Daily End at: </th><td><?php print($endtime); ?></td></tr>
								</table>
							</div>
							<div class ="col-md-6 col-sm-6">
								<div id="mapCanvas_booking">map here</div>
								<!--<img src="images/chips_numbers.png" /> <!-- placeholder, until map displays -->
								<button id="inform" name="inform" type="button" class="btn btn-info btn-lg" onclick="compileEmail()">Inform POC</button>
								<br><label id="msg_response"></label>
								
								<!-- HIDDEN CONTROLS FOR EMAIL! -->
								<input hidden type="text" id="txtName" name="txtName" value="<?php print($sendfrom_name); ?>" />
								<input hidden type="text" id="txtEmail" name="txtEmail" value="<?php print($sendfrom_addr); ?>" />
								<input hidden type="text" id="txtSubject" name="txtSubject" value="<?php print($sendfrom_subject); ?>" />
								<textarea style="display: none;" id="txtMessage" name="txtMessage" rows="6"><?php print($sendfrom_msg); ?></textarea>
								<input hidden type="text" id="txtEmailTo" name="txtEmailTo" value="<?php print($sendto_addr); ?>" />
								<input hidden type="text" id="txtNameTo" name="txtNameTo" value="<?php print($sendto_name); ?>" />
								<input hidden type="text" id="txtEmailReply" name="txtEmailReply" value="<?php print($sendreply_addr); ?>" />
								<input hidden type="text" id="txtNameReply" name="txtNameReply" value="<?php print($sendreply_name); ?>" />								
								<!-- HIDDEN CONTROLS FOR EMAIL! -->
							</div>

						</div>
						<div>
							<br><label id="msg_footer"><h4>Again, thank you for your ServACE! Hearts in Spades!</h4></label>
						</div>
					</div>
				</div>
				<?php
				}				 
			}
		}
	}	
?>
</body>