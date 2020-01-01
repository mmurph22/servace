<h3>Directions Page</h3>
<?php  
	// Dynamically save volunteer info
	$action = null;
	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];
		
		//direct pages
		if ($action === 'directions') {
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
				
				$sql = "insert volunteers_events (vid, eid, volperc) 
				values ($vid,$eid,$v_perc)";
								
				$res = mysqli_query($con, $sql);
				if (!$res)
					print ("<h4>Failure attempting to enter Volunteering Record into DB." . mysqli_error($con) . "</h4>");
				else {
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
						
					?>
					<div class="jumbotron">
						<p>Thank you, <?php print($row["firstname"] . " " . $row["lastname"]); ?> for volunteering for an event through ServACE. There is no powerful force in this world than a neighbor willing to help another neighbor.</p>
						<p>As you know, you will be earning valuable points to earn your stripes and "move up the deck"!</p>
						<p>For this event, you could earn an average of <?php print($potential); ?> ServACE points to go with the <?php print($cur_points); ?> points you already have earned, but if you give above and beyond and your neighbor notices, those points may go higher. One day, they may call YOU a ServACE!</p>	
						<br>
						<p>You will be volunteering at:</p>
						<h4><?php print($row["venue_name"]); ?></h4>
						<h4><?php print($row["address"]); ?></h4>
						<br>
						<p>Point of Contact is:</p>
						<p>Name: </p><h4><?php print($row["pocname"]); ?></h4>
						<p>Phone: </p><h4><?php print($row["pocphone"]); ?></h4>
						<p>Email: </p><h4><?php print($row["pocemail"]); ?></h4>
						<br>
						<p>Event: </p><h4><?php print($row["event_name"]); ?></h4>
						<h4>You have volunteered for <?php print($row["volperc"]); ?>% of this event time</h4>
						<br>
						<p>Description: </p><h4><?php print($row["event_description"]); ?></h4>
						<p>Starting Date: </p><h4><?php print($row["startdate"]); ?></h4>
						<p>Ending Date: </p><h4><?php print($row["enddate"]); ?></h4>
						<p>Daily Start at: </p><h4><?php print($row["daystarttime"]); ?></h4>
						<p>Daily End at: </p><h4><?php print($row["dayendtime"]); ?></h4>
						<br>
						<p>Again, thank you for volunteering through ServACE! Hearts in Spades!</p>
					</div>
					<?php
				}				 
			}
		}
	}	
?>