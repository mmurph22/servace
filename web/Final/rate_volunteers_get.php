<head>
	<link rel="stylesheet" type="text/css" href="content.css" />
</head>
<body>
		<?php
	require_once ("db.php");
	require_once ("func_ratings.php");
	
	// get the volunteer selected
	session_start();
	
	$eid = -1;
	if (isset($_GET['q'])) {
		$eid = intval($_GET['q']);
		$_SESSION['selected_event'] = $eid;
	}
	$sql = get_ratings_domain_sql($eid);
	$res = mysqli_query($con, $sql);
	if (!$res)
		die("Query Invalid" . mysqli_error($con));
	// valid return on query
		?>
	<form class="form-horizontal" method="post" action="index.php?action=postrate" enctype="multipart/form-data">
		<table class="table table-hover" id="rateTable">
			<tr>
				<th hidden>eid</th>
				<th hidden>vid</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Percentage of Event Covered</th>
				<th>Volunteered</th>
				<th></th> <!-- rating number -->
				<th>Rating</th>
			</tr>
			<tbody>
			<?php
				while($row = mysqli_fetch_array($res))
				{
					$r_suf = get_RATE_CTRL_PREFIX();
					$r_en_suf = get_RATEENABLE_CTL_PREFIX();
					$vid = $row["vid"];
					$eid = $row["eventid"];
			?>
					<tr class='active'>					
						<td hidden><?php print($eid); ?></td>
						<td hidden><?php print($vid); ?></td>
						<td><?php print($row["firstname"]); ?></td>
						<td><?php print($row["lastname"]); ?></td>
						<td><?php print($row["volperc"] . "%"); ?></td>
						<td><input <?php print('id="'. $r_en_suf . $vid . '" name="'. $r_en_suf . $vid . '"'); ?> type="checkbox"></td> 
						<td><label <?php print('id="ratetxt' . $vid . '" name="ratetxt' . $vid . '"'); ?>>3</label>
						<td><input <?php print('id="'. $r_suf . $vid . '" name="' . $r_suf . $vid . '"'); ?> type="range" min="1" max="5" onchange="updateTextRating(this.name,'rate','ratetxt',this.value);"></td>
					</tr>
			<?php
				}
				mysqli_close($con);
			?>
			</tbody>
		</table>
		<div class=" col-sm-10 col-xs-10" >
			<input class="btn btn-default col-sm-2" type="reset" id="cancel" value="Cancel" />
			<input class="btn btn-primary col-sm-2" type="submit" id="submit" value="Submit Ratings" />
			<!--<input class="btn btn-default col-sm-2 col-offset-sm-2" type="button" id="back" value="Back" href="index.php?action=helpout"; />
			<input class="btn btn-primary col-sm-2 col-offset-sm-2" type="button" id="sendrate" value="Submit Ratings" onclick="sendRatingData2D();"/> -->
		</div>
	</form>
</body>