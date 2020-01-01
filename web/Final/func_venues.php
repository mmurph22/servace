<?php  
	// Dynamically generate main content
	$action = null;
	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];
		
		//direct pages
		if ($action === 'create_venue') {
			// create volunteer in db
			$v_name = $_POST['vname'];
			$v_addr = $_POST['vaddr'];
			$poc_name = $_POST['pocname'];
			$poc_email = $_POST['pocemail'];
			$poc_phone = $_POST['pocphone'];
			$v_lat = $_POST['vlat'];
			$v_lon = $_POST['vlon'];
			if ((!empty($v_name) && is_string($v_name)) &&
				(!empty($v_addr) && is_string($v_addr)) &&
				(!empty($poc_name) && is_string($poc_name)) &&
				(!empty($poc_email) && is_string($poc_email)) &&
				(!empty($poc_phone) && is_string($poc_phone)) &&
				(!empty($v_lat) ) &&
				(!empty($v_lon) )
			) {
				// put info into database
				require_once("db.php");
				
				$sql = "insert venues(venue_name, address, pocname, pocemail, pocphone, latitude, longitude) 
				values ('$v_name','$v_addr','$poc_name','$poc_email','$poc_phone',$v_lat,$v_lon)";
				
				$res = mysqli_query($con, $sql);
				
				if (!$res){
					print ("<h4>Failure attempting to enter Venue Record into DB." . mysqli_error($con) . "</h4>");
				}
				else {
					print('<div class="jumbotron">');
					print('<h3>Created New venue: ' . $v_name . '</h3>');
					print('</div>');
				}
				//header("Location: index.php?action=helpout");
				mysqli_close($con);
			}
		}
	}	
?>