<?php
	// localhost settings
	/*
	$host = "localhost";
	$uname = "root";
	$pwd = "1qazXSW@";
	$dbname = "sandbox";
	*/
	
	// geogthemis settings
	
	$host = "geogthemis001.umd.edu";
	$uname = "mmurph22";
	$pwd = "u25@mpsgis";
	$dbname = "mmurph22";
	
	 
	 $con = mysqli_connect($host, $uname, $pwd, $dbname);
	 if (!$con)
	 	die("Data connection Error: " . mysqli_errno());
?>
