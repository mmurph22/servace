<?php  
	function create_volunteer() {
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
	}	
?>