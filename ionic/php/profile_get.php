<?php 
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST, GET');
	header('Access-Control-Max-Age: 1000');

	header('content-type: application/json; charset=utf-8');
	
	require_once("db.php");
	require_once("func_ratings.php");
	
	// get the volunteer selected
	$q = intval($_GET['q']);
	$sql = "Select *, 
				SPACE(1) as 's_level', 
				SPACE(1) as 's_score', 
				SPACE(1) as 's_card' 
			from volunteers where vid = '".$q."'";
	$res = mysqli_query($con, $sql);
	if (!$res)
		die("Query Invalid" . mysqli_error($con));
	// valid return on query
	//$row = mysqli_fetch_array($res);
	$info = array();				
	while($row = mysqli_fetch_assoc($res)) {
		// add enhanced data
		$servACE_level = get_my_servace_level($q);
		$servACE_score = get_my_servace_score($q);
		$servACE_card = getCardPath( $servACE_level, 'H');
		$row['s_level'] = $servACE_level;
		$row['s_score'] = $servACE_score;
		$row['s_card'] = $servACE_card;
		
		array_push($info, $row);
	}
	echo json_encode($info);
?>