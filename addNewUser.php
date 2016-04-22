<?php

	 /* === DATABASE CONNECTION === */
	  include('dbaccess.php');
	  /* === START SESSION === */
	  session_start();

	   /* ================== NEW USER PAGE ============= */
	    // Include UserLogin class
	  	include('UserLogin.control.php');
	    // Create UserLogin object
	    $user = new UserLogin();

	    // Get data from new user form
	    $msg = "";

      		// Create database object
         	$dbo = database::getInstance();
         	// Get how many records in UserLogin table
         	$sql = "SELECT COUNT(*) as Usercount FROM UserLogin";
         	// Execute query 
         	$dbo->doQuery($sql);
         	// Retrieve row of results
         	$row = $dbo->loadObjectList();
         	// Generate ID e.g 00000000001
         	$num_padded = sprintf("%011d",$row["Usercount"]+1);
         	$id = $num_padded;
	   
		// Add new user button clicked
		
    		$fname = $_POST["fname"]; // Get entered first name
    		$lname = $_POST["lname"]; // Get entered last name
    		$userType = $_POST["userType"]; // Get entered user type
    		$password = $_POST["passWord"]; // Get entered password

    		//Create username for new user
			$username = $fname . $lname;
			// Create record
			$rec = array($id,$username,$userType,$password);
    		// Add user to database
    		$user->addNew($rec);
    		// Confirmation msg
    		$msg = "New user ".$username." successfully added";

 ?>