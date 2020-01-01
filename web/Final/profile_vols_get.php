		<head>
			<link rel="stylesheet" type="text/css" href="content.css" />
			<script type="text/javascript">
			</script>
			<?php
				
				function getCardPath($num, $suit)
				{
					$card = null;
					// return this
					$card_suf = ".png";
					$card_mid = "_of_";
					$card_suitf = "2";

					// all other cards
					$card_suit = null;
					switch ($suit)
					{
						case 'H': {
							$card_suit = "hearts";
							break;
						}
						case 'S': {
							$card_suit = "spades";
							break;
						}
						case 'C': {
							$card_suit = "clubs";
							break;
						}
						case 'D': {
							$card_suit = "diamonds";
							break;
						}
						// joker suits
						case 'R': {
							$card_suit = "red";
							break;
						}
						case 'B': {
							$card_suit = "black";
							break;
						}
					}

					$card_num = $num;
					switch ($num)
					{
						case 'J': {
							$card_num = "jack";
							$card_suit = $card_suit .  $card_suitf;
							break;
						}
						case 'Q': {
							$card_num = "queen";
							$card_suit = $card_suit . $card_suitf;
							break;
						}
						case 'K': {
							$card_num = "king";
							$card_suit = $card_suit . $card_suitf;
							break;
						}
						case 'A': {
							$card_num = "ace";
							//$card_suit = $card_suit . $card_suitf; // no suffix
							break;
						}
						case '0': {
							$card_num = "_joker";
							break;
						}
					}
	
					// put together card
					if ($num == '0')// joker
					{
						$card = $card_suit . $card_num . $card_suf;
					} else// all others
					{
						$card = $card_num . $card_mid . $card_suit . $card_suf;
					}
					return $card;
				}
			?>
		</head>
		<body>
			<?php 
				require_once("db.php");
				require_once("func_ratings.php");
				
				// get the volunteer selected
				$q = intval($_GET['q']);
				$sql = "Select * from volunteers where vid = '".$q."'";
				$res = mysqli_query($con, $sql);
				if (!$res)
					die("Query Invalid" . mysqli_error($con));
				// valid return on query
				$row = mysqli_fetch_array($res);
				if ($row)
				{
					$servACE_level = get_my_servace_level($q);
					$servACE_score = get_my_servace_score($q);
					$servACE_card = getCardPath( $servACE_level, 'H');
					//print($servACE_card);
			?>
					<div class="form-group container-fluid">
						<div class="row">
							<div class ="col-md-5 col-sm-5">
								<table class="table table-hover"> 
									<tr class='alert'><th>First Name</th><td><?php print($row["firstname"]); ?></td></tr>
									<tr class='alert'><th>Last Name</th><td><?php print($row["lastname"]); ?></td></tr>
									<tr class='alert'><th>Email</th><td><?php print($row["email"]); ?></td></tr>
									<!--<tr class='alert'><th>ServACE Level</th><td><?php print($row["levelid"]); ?></td></tr>
									<tr class='alert'><th>ServACE Points</th><td><?php print($row["badgepoints"]); ?></td></tr>-->
									<tr class='alert'><th>ServACE Level</th><td><?php print($servACE_level); ?></td></tr>
									<tr class='alert'><th>ServACE Points</th><td><?php print($servACE_score); ?></td></tr>
								</table>
							</div>
							<div class="form-group">
								<div class ="col-md-1 col-sm-1">
									<img id="imagerate" height="150" alt="images/cards/red_joker.png" src="images/cards/<?php print($servACE_card); ?>" />
								</div>
								<div class ="col-md-4 col-sm-4">
									<img id="imaagerate_table" height="150" src="images/poker_table_icon.png" />
								</div>
								<div class ="col-md-2 col-sm-2">
									<!--<label id="comingsoon" align="right">Redeem ServACE points. Coming Soon</label>-->
									<a id="cashin_servace" href="http://www.amazon.com">
										<img id="comingsoon" align="right" height="75" src="images/redeem.PNG" />
										<img id="imagerate_cashin" align="right" width="200" height="65" alt="images/chipcash.png" src="images/bigchips.png" />
									</a>
								</div>
							</div>
						</div>
					</div>
			<?php } ?>
			<!-- volunteer history -->
			<div class="form-group">
				<table id="usereventlist" class="table table-hover col-sm-8 col-xs-8">
					<tr>
						<th>Venue</th>
						<th>Event</th>
						<th>Start Date</th>
						<th>End Date</th>			
						<th>ServACE Points</th>
					</tr>
					<tbody>
				<?php
					require_once("func_ratings.php");
	
					function getACEScore($pts, $rating, $perc)
					{	
						return (get_servace_event_score(3, 0.25, $rating, $pts, $perc));
					}
				
					// now get the vounteer's history
					$sql = "select a.*, b.*, c.*, d.venue_name
							from events a
							     inner join volunteers_events b on
							     b.eid = a.eventid
							     inner join volunteers c on
							     c.vid = b.vid
							     inner join venues d on
							     d.venueid = a.venueid
							where c.vid = '".$q."'";
					$res = mysqli_query($con, $sql);
					if (!$res)
						die("Query Invalid" . mysqli_error($con));
					// valid return on query
					while($row = mysqli_fetch_array($res))
					{
						$servPTS = getACEScore($row['badgepoints_pp'], $row['rating'], $row['volperc']);
						print('<tr class="active">');
						print("<td>" . $row["venue_name"] . "</td>");
						print("<td>" . $row["event_name"] . "</td>");
						print("<td>" . formattedDate($row["startdate"]) . "</td>");
						print("<td>" . formattedDate($row["enddate"]) . "</td>");
						print("<td>" . $servPTS . "</td>");
						print('</tr>');
					}
				?>
					</tbody>
				</table>
			</div>
		</body>






