<?php 

function file_upload($filekey, $uploadDir) {
	global $upload_errors;
		
	$error_code = null;
	$desc = null;
	$imgURL = null;
	$info = array();
	
	//validate file input
	if ((($_FILES[$filekey]["type"] == "image/gif") ||
		($_FILES[$filekey]["type"] == "image/jpeg") ||
		($_FILES[$filekey]["type"] == "image/jpg") ||
		($_FILES[$filekey]["type"] == "image/pjpeg") ||
		($_FILES[$filekey]["type"] == "image/x-png") ||
		($_FILES[$filekey]["type"] == "image/png")) &&
		($_FILES[$filekey]["size"] < 3000000)
		)
	{	
		// process files
		if ($_FILES[$filekey]["error"] > 0) {
			$error_code = $_FILES[$filekey]["error"];
			$desc = $upload_errors[$error_code];
		} else {
			// process here
			$filename = $_FILES[$filekey]["name"];
			$tmpname = $_FILES[$filekey]["tmp_name"];
			$destpath = "./uploads";
			$destfile = $destpath . "/" . $filename;
			
			if (file_exists($destfile)) {
				$error_code = -2;
				$desc = $upload_errors[$error_code];
			} 
			else {
				// move file to upload area
				if (move_uploaded_file($tmpname, $destfile)) {
					$error_code = 0;
					$desc = "<p>File " . $filename . " uploaded successfully.</p>";
					$imgURL = $destfile;
				}
				else {
					$error_code = $_FILES[$filekey]['error'];
					$desc = $upload_errors[$error_code];
				}
			}
		}
	}
	else {
		// error condition
		if ($_FILES[$filekey]["error"] > 0) {
			$error_code = $_FILES[$filekey]["error"];
			$desc = $upload_errors[$error_code];
		} else {
			$error_code = -1;
			$desc = "File upload error: Invalid file";
		}
	}
	
	$info["code"] = $error_code;
	$info["desc"] = $desc;
	$info["imgURL"] = $imgURL;
	return $info;	
}


?>