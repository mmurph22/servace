<form class="form-horizontal" method="post" action="profile_vols_create.php?action=create_volunteer" enctype="multipart/form-data">
	<div class="form-group">
		<label class="control-label col-sm-2 col-xs-2" for="desc">First Name:</label>
		<div class="col-sm-10" >
			<input class="form-control" type="text" id="fname" name="fname" placeholder="Enter your First Name"/>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2 col-xs-2" for="desc">Last Name:</label>
		<div class="col-sm-10" >
			<input class="form-control" type="text" id="lname" name="lname" placeholder="Enter your Last Name"/>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2 col-xs-2" for="desc">Email:</label>
		<div class="col-sm-10" >
			<input class="form-control" type="email" id="email" name="email" placeholder="Enter your Email as a user name"/>
		</div>
	</div>
	<div class="col-sm-offset-2 col-sm-10 col-xs-offset-2 col-xs-10" >
		<input class="btn btn-default col-sm-2" type="reset" id="cancel" value="Cancel" />
		<input class="btn btn-primary col-sm-2" type="submit" id="submit" value="Submit" />
	</div>
</form>
<?php  
	// Dynamically generate main content
	$action = null;
	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];
		
		//direct pages
		if ($action === 'create_volunteer') {
			// create volunteer in db
			$firstname = $_POST['fname'];
			$lastname = $_POST['lname'];
			$email = $_POST['email'];
			if ((!empty($firstname) && is_string($firstname)) &&
				(!empty($lastname) && is_string($lastname)) &&
				(!empty($email) && is_string($email))
			) {
				// put info into database
				require_once("db.php");
				
				$sql = "insert volunteers(firstname, lastname, email) 
				values ('$firstname','$lastname','$email')";
				
				$res = mysqli_query($con, $sql);
				
				header("Location: index.php?action=vol_profile");
				if (!$res){
					print ("<h4>Failure attempting to enter Volunteer Record into DB." . mysqli_error($con) . "</h4>");
				}
			}
		}
	}	
?>