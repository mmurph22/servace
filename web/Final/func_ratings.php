<?php
	require_once("db.php");
	
	// GLOBALS FOR SCORING: could be defined a in more flexible way...
	function get_RATEENABLE_CTL_PREFIX() {
		return "vol_completed"; // prefix of control holding checkbox enabling/disabling rating for a volunteer	
	}
	function get_RATE_CTRL_PREFIX() {
		return "rate"; // prefix of control holding rate information
	}
	function get_LEVELSIZE() {
		return 100.0; // size of a single ServACE level in ServACE points
	}
	function get_RATE_MULT() {
		return 0.25; // meaning: for every rating point above/below average, add/subtrct this % amount from rating
	}
	function get_RATE_AVG() {
		return 3; // average rating: A volunteer receving this rating will get exactly the points alloted to the event. No more. No less.
	}
	function get_ADMIN_EMail($alt) {
		if ($alt == 'replyto')
			return "mmurph22@terpmail.umd.edu"; // ALTERNATE email address of email administrator
		else
			return "mikemurphytest@gmail.com"; // MAIN email address of email administrator
	}
	function get_ADMIN_Name($alt) {
		if ($alt == 'replyto')
			return "Mike Murphy"; // ALTERNATE email name of email administrator
		else
			return "MPM Administrator"; // MAIN email name of email administrator
	}
	function formattedDate($indate) {
		$ndt = new DateTime($indate);
		$fdate = date_format($ndt,"F j, Y"); // format dates to Mon dd, yyyy
		return $fdate;
	}
	function formattedTime($intime) {
		$ndt = new DateTime($intime);
		$ftime = date_format($ndt,"h:i A"); // format times to 00:00 AM|PM
		return $ftime;
	}
	
	// the query text used to define a domain of ratings for an event
	function get_ratings_domain_sql($event_id) {
		$sql = "select a.*, b.venue_name, c.*, d.*
		        from events a
		        	inner join venues b on
		        	b.venueid = a.venueid
		        	inner join volunteers_events c on
		        	c.eid = a.eventid
		        	inner join volunteers d on
		        	d.vid = c.vid
		        where a.eventid = '" . $event_id . "'
		     	order by d.lastname, d.firstname";
		return $sql;
	}
	
	// given a volunteer, get their current servace score
	function get_my_servace_score($volunteer_id)
	{
		require("db.php");
		
		// now get the vounteer's history
		$sql = "select a.*, b.*, c.*
				from volunteers_events a
					inner join volunteers b on
					b.vid = a.vid
					inner join events c on
					c.eventid = a.eid
				where a.vid = '". $volunteer_id ."'";
				
		$res = mysqli_query($con, $sql);
		if (!$res)
			die("Query Invalid" . mysqli_error($con));
		// valid return on query
		$servPTS = 0;
		while($row = mysqli_fetch_array($res))
		{
			$servPTS = $servPTS + get_servace_event_score(get_RATE_AVG(), get_RATE_MULT(), $row['rating'], $row['badgepoints_pp'], $row['volperc']);
		}	
		mysqli_close($con);
		return $servPTS;
	}
	
	// given a volunteer, ge their curent servace level
	function get_my_servace_level($volunteer_id)
	{
		$pts = get_my_servace_score($volunteer_id);
		return get_servace_level($pts, get_LEVELSIZE());
	}
	
	// get a servace score for a single event
	function get_servace_event_score($rate_avg, $rate_multiplier, $rate_vol, $event_ppp, $vol_perc)
	{
		// if rating is 0, then score is 0
		if ($rate_vol == 0) {
			$event_score = 0;
		}		
		else {
			// get the rate weighting
			$rate_weight = get_rate_weight($rate_avg, $rate_multiplier, $rate_vol);
			
			//event score = points per event * % of effort * performance weighting
			$event_score = ($event_ppp * ($vol_perc /100.0) * $rate_weight);
		}
		return $event_score;
	}
	
	// get weight applied to servace score
	function get_rate_weight($rate_avg, $rate_multiplier, $rate_vol)
	{
		// take the rate_avg. This is weighted as 1.0
		// The rate multiplier will scale rate_avg by this amount. This is the rate weight.	
		// get volunteer rating and multiply by weight
		$rate_weight = (1.0 + (($rate_vol - $rate_avg) * $rate_multiplier));
		return $rate_weight;
	}
	
	// given a servace score, get the "card" level
	function get_servace_level($pts, $levelsize) {
		$level = '2'; // default STRING
		
		// pts divided by levelsize gives the binning
		// Adding 2.0 starts bin at "card #2"
		if ($levelsize == 0) $levelsize = 1.0; // avoid DIVBY0
		$n_lev = ($pts / $levelsize) + 2.0;
		$i_lev = intval($n_lev);
		
		// face cards
		if ((10 <= $i_lev) && ($i_lev < 11)) {
			$level = '10';
		}
		else if ((11 <= $i_lev) && ($i_lev < 12)) {
			$level = 'J';
		}
		else if ((12 <= $i_lev) && ($i_lev < 13)) {
			$level = 'Q';
		}
		else if ((13 <= $i_lev) && ($i_lev < 14)) {
			$level = 'K';
		}
		else if (14 <= $i_lev) {
			$level = 'A';
		}
		else {
			$level = $i_lev;
		}
	
		// returned level
		return $level;
	}
	
	function get_actual_volunteers_required($eid) {
		require("db.php");
		
		// first, get a count of the actual required staff.
		// requested - already signed up
		$sql_count = "select a.eventid, a.numstaff, b.eid, b.volperc  
	       			  from events a
	  		        	  left join volunteers_events b on
	       				  b.eid = a.eventid
					  where a.eventid = '" . $eid . "'";
		$res = mysqli_query($con, $sql_count);
		if (!$res)
			die("Query Invalid" . mysqli_error($con));
	
		$r_ptr = 0;
		$s_required = 1;
		while ($row = mysqli_fetch_array($res)) {
			if ($r_ptr == 0) {
				$s_required = $row["numstaff"];
			}
			$a_vol = 0;
			if (isset($row["volperc"]))
				$a_vol = $row["volperc"] / 100.0;
			$s_required = $s_required - $a_vol;
			$r_ptr++;
		}
		if ($s_required < 0)
			$s_required = 0;
		
		return $s_required;
	}
?>