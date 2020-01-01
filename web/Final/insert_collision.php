<h3> Report a Wildlife Collision </h3>
<?php
	require_once("db.php");
	
	// species dropdown
	$species = $_POST['species'];
	$alt_species = $_POST['txtSpecies'];
	// others selected: use alternate
	if ($species === "Others")
		$species = $alt_species;
	
	// other form data
	$gender = ucfirst($_POST['rbGender']);
	$age = ucfirst($_POST['rbAge']);
	$dt = $_POST['reportdt'];
	$location = $_POST['desc'];
	$latitude = $_POST['Lat'];
	$longitude = $_POST['Lon'];
	$imgURL = null;
	
	// validate required inputs
	if (
		(!empty($species) && is_string($species)) &&
		(!empty($location) && is_string($location)) &&
		(isset($latitude) && is_numeric($latitude)) &&
		(isset($longitude) && is_numeric($longitude))
		) {
		
		//validate file input
		if ((($_FILES["imgFile"]["type"] == "image/gif") ||
			($_FILES["imgFile"]["type"] == "image/jpeg") ||
			($_FILES["imgFile"]["type"] == "image/jpg") ||
			($_FILES["imgFile"]["type"] == "image/png")) &&
			($_FILES["imgFile"]["size"] < 1000000)
			){	
			// process uploaded file
			if ($_FILES["imgFile"]["error"] > 0)
				print ("<h3>File Upload Error: " . $_FILES["imgFile"]["error"] . "</h3>");
			else {
				// process file
				$filename = $_FILES["imgFile"]["name"];
				$tmpname = $_FILES["imgFile"]["tmp_name"];
				$destpath = "./uploads";
				$destfile = $destpath . "/" . $filename;
				// check if file exists
				if (file_exists($destfile)) {
					print ("<h3>File Upload Error: " . $filename . " already exists.</h3>");
				}
				else {
					// move file to upload area
					if (move_uploaded_file($tmpname, $destfile))
					{
						$imgURL = $destfile;
						//print ($imgURL); // temporary
						print("<h3>File " . $filename . " uploaded successfully.</h3>");
						
						// put collision info into database
						$sql = "insert collisions(species,gender,age,report_date,location,latitude,longitude,img_url) 
						values ('$species','$gender','$age','$dt','$location',$latitude,$longitude,'$imgURL')";
						/*$sql = "insert collisions(species,gender,age,location,latitude,longitude,img_url) values 
						('$species','$gender','$age','$location',$latitude,$longitude,'$imgURL')";*/
						
						$res = mysqli_query($con, $sql);
						if ($res){
							print ("<h4>Collision Record entered into DB successfully.</h4>");
						} else {
							print ("<h4>Failure attempting to enter Collision Record into DB." . mysqli_error($con) . "</h4>");
						}
					}
					else {
						print("<h3>File Upload Error: " . "File cannot be moved.</h3>");
					}
				}
			}
			// show valid data report
?>
			<link rel="stylesheet" type="text/css" href="reports.css" />
			<div id="report_entry">
				<h3>Your Reported Incident</h3>		
				<table>
					<tr><th>Species</th><td><?php print($species) ?></td></tr>
					<!--<tr><th>Date-Time</th><td><?php print($date) ?></td></tr>-->
					<tr><th>Location</th><td><?php print($location) ?></td></tr>
					<tr><th>Latitude</th><td><?php print($latitude) ?></td></tr>
					<tr><th>Longitude</th><td><?php print($longitude) ?></td></tr>
					<tr><th>Gender</th><td><?php print($gender) ?></td></tr>
					<tr><th>Age</th><td><?php print($age) ?></td></tr>
				</table>
			</div>
<?php
		}
		else {
			print("<h3>File upload error : Invalid File</h3>");
		}
	}
	else {
		// show error report
?>
		<h3>Sorry</h3>
		<h3>You did not fill out the form completely. 
			<a href="index.php?action=report_collision">Try again?</a></h3>;
<?php
	}
?>