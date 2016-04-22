<?php

	  /* ===== All pages should include the following ========== */
	  /* === DATABASE CONNECTION === */
	  include('dbaccess.php');
	  /* === START SESSION === */
	  session_start();
	  /* =================== END OF INCLUDE ================ */


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
		if ($_SERVER['REQUEST_METHOD'] == 'POST') 
		{
    		$fname = $_POST["fname"]; // Get entered first name
    		$lname = $_POST["lname"]; // Get entered last name
    		$userType = $_POST["userType"]; // Get entered user type
    		$password = $_POST["password"]; // Get entered password

    		//Create username for new user
			$username = $fname . $lname;
			// Create record
			$rec = array($id,$username,$userType,$password);
    		// Add user to database
    		$user->addNew($rec);
    		// Confirmation msg
    		$msg = "New user ".$username." successfully added";


    	}
	 /* ====================END OF LOGIN ======================== */
	  /* ================== LOGIN PAGE ============= */
	    // Include UserLogin class
	  	include('UserLogin.control.php');
	    // Create UserLogin object
	    $user = new UserLogin();

	    // Get data from login form
	    $msg = "";
		// Login button clicked
		if ($_SERVER['REQUEST_METHOD'] == 'POST') 
		{
    		$username = $_POST["username"]; // Get entered username
    		$password = $_POST["password"]; // Get entered password

    		// Authenicate user
    		$login = $user->login_User($username,$password); // Redirects to respective dashboards

    		if (!$login)
    		{
    			// Error
        		$msg = "Username and password do not match";
    		}

    	}
	 /* ====================END OF LOGIN ======================== */

	 /* ================== DASHBOARD PAGE ============= */


	 /* ====================END OF DASHBOARD ======================== */

	 /* ==================== MANAGE BLOOD DONORS ======================== */
	 	

	    /* +++++++++++++++++ Add Person information ++++++++++++++++++++ */
	    include('Person.class.php');

	    $msg = "";
	    $errors = array();

    
        if($_SERVER['REQUEST_METHOD'] == 'POST')	
        {
        	// Get entered fields
         	$trn = $_POST['idPerson_TRN'];
       	 	$fname = $_POST['person_firstName'];
       	 	$lname = $_POST['person_lastName'];
         	$addr1 = $_POST['person_address1'];
         	$addr2 = $_POST['person_address2'];
         	$cell = $_POST['q9_cell[area]'].$_POST['q9_cell[phone]'];
       	 	$work = $_POST['q53_work[area]'].$_POST['q53_work[phone]'];
       	 	$home = $_POST['q52_home[area]'].$_POST['q52_home[phone]'];
         	$email = $_POST['person_email'];
         	$dob = $_POST['q54_dateOf[year]']."-".$_POST['q54_dateOf[month]']."-".$_POST['q54_dateOf[day]'];
         	$sex = $_POST['person_sex'];
       	 	$mStatus = $_POST['person_maritalStatus'];
         	$mname = $_POST['person_middleName'];

         	// Image handling
			$target_dir = "uploads/"; // directory where the file is going to be placed
			$target_file = $target_dir . basename($_FILES["image"]["name"]); // path of the file to be uploaded
			$uploadOk = 1; // flag to detmine if upload is successful
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION); // file extension of the file

			// Check if image file is a actual image or fake image
			if(isset($_POST["person_idPicture"])) {
    			$check = getimagesize($_FILES["image"]["tmp_name"]);
    			if($check !== false) {
        			$errors[] = "File is an image - " . $check["mime"] . ".";
        			$uploadOk = 1;
    			} else {
        			$errors[] = "File is not an image.";
        			$uploadOk = 0;
    			}
			}

			// Check file size
			if ($_FILES["image"]["size"] > 500000) {
    			$errors[] = "Sorry, your file is too large.";
    			$uploadOk = 0;
			}

			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
    			$errors[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    			$uploadOk = 0;
			}

			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
    			$errors[] = "Sorry, your file was not uploaded.";
				// if everything is ok, try to upload file
			} else {
    			if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        			$errors[] = "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
        			// Store to database, link to file
        			$idpic = $target_file;
    			} else {
        			$errors[] = "Sorry, there was an error uploading your file.";
    			}
			}

			 // Errors
		    if (empty($errors))
		    {         
          		
         		// Get values to be stored in database
         		$data = array($trn, $fname, $lname, $addr1, $addr2, $cell, $work, $home, $email, $dob, $sex, $idpic, $mStatus, $mname);
         		// store record to session variable
         		$_SESSION["person"] = $data;
         		
         	}
         	else
         	{
         		// If there are errors, output them as list items
    						echo "<ul>";
    						foreach ($errors as $error){
    							echo "<li>".$error."</li>";}
    						echo "</ul>";
    					
         	}
		   
         	
      	}/* +++++++++++++++ End of Add Person Information +++++++++++++++++++++ */

      	/* +++++++++++++++++ Add Medical Record ++++++++++++++++++++++ */

      	// Include Donor class
      	include('Donor.control.php');

      	$msg = "";

      		// Create database object
         	$dbo = database::getInstance();
         	// Get how many records in medical record table
         	$sql = "SELECT COUNT(*) as MRcount FROM MedicalRecord";
         	// Execute query 
         	$dbo->doQuery($sql);
         	// Retrieve row of results
         	$row = $dbo->loadObjectList();
         	// Generate ID e.g MR001
         	$num_padded = sprintf("%03d",$row["MRcount"]+1);
         	$id = "MR".$num_padded;

         	// Get today's date
       	 	$date = date("Y-m-d");
       	 

	   
    
        if($_SERVER['REQUEST_METHOD'] == 'POST')	
        {
        	// Get entered fields
    
       	 	$weight = $_POST['weight'];
       	 	$height = $_POST['height'];
         	$bp = $_POST['bp'];
         	$temp = $_POST['temp'];
         	$ironLevel = $_POST['ironLevel'];
       	 	$time = $_POST['time'];
         	$history = $_POST['history'];
         	$reason = $_POST['rejectionReason'];
         	
       		
         	// Create new Donor object
          	$donor = new Donor();
          	// Create Session Object of donor to pass to other pages
          	$_SESSION["donorObj"] = $donor;
         	// Get values to be stored in database
         	$data = array($id, $weight, $height, $bp, $temp, $ironLevel, $time, $date, $history, $reason);
         	// Add record to database
         	$donor->addMedicalRecord($data);
         	// Confirmation message
         	$msg = "Medical Record. ".$id." successfully added";

         }/* +++++++++++++ END OF ADD MEDICAL RECORD +++++++++++++++++++++++ */

         /* ++++++++++++++ ADD DONATION RECORD ++++++++++++++++++++++++++++ */
         // Include Donor class
      	include('Donor.control.php');
      	include('Recipient_DonationRec_BloodSpec.control.php');

      	$msg = "";

      		// Create database object
         	$dbo = database::getInstance();
         	// Get how many records in donation record table
         	$sql = "SELECT COUNT(*) as DRcount FROM DonationRecord";
         	// Execute query 
         	$dbo->doQuery($sql);
         	// Retrieve row of results
         	$row = $dbo->loadObjectList();
         	// Generate ID e.g DR001
         	$num_padded = sprintf("%03d",$row["DRcount"]+1);
         	$id = "DR".$num_padded;

         	// Get current user signed in 
         	$collectedBy = $_SESSION["userObj"]->loggedin_User;
         	// Get today's date
       	 	$date = date("Y-m-d");
	   
    
        if($_SERVER['REQUEST_METHOD'] == 'POST')	
        {
        	// Get entered fields
       	 	$location = $_POST['location'];
         	$quantity = $_POST['quantity'];
         	$type = $_POST['donortype'];
         	$bloodType = $_POST['bloodtype'];
            // If type = Replacement
            if (!empty($_POST['recipient']))
            {
            	$recipient = $_POST['recipient'];
            }
            else // type = voluntary
            {
            	// Choose random one from DB
            	$query = "SELECT idRecipient_TRN FROM Recipient WHERE compatibleWith LIKE '%{$bloodType}%' AND urgencyLevel = 1 AND idRecipient_TRN NOT IN (SELECT RDB_idRecipient FROM Recipient_DonationRec_BloodSpec) ORDER BY RAND() LIMIT 1";
            	// Execute query 
         		$dbo->doQuery($query);
         		// Retrieve row of results
         		$row3 = $dbo->loadObjectList();
         		// Get recipient id
         		$recipient = $row3["idRecipient_TRN"];
            }
         	
         	// Calculate expiration date *shelf life = 35 days *
       	 	$expiry = date('Y-m-d', strtotime($date. '+ 35 days'));
       		
         	// Get already created Donor object
          	$donor = $_SESSION["donorObj"];
            // Get values to be stored in database
         	$data = array($id, $date, $location, $quantity, $type, $collectedBy, $expiry);
         	// Add record to database
         	$donor->addDonationRecord($data);
         	// Confirmation message
         	$msg = "Donation Record. ".$id." successfully added";

         	/* Create corresponding blood specimen record */
         	// Get how many records in blood specimen table
         	$sql2 = "SELECT COUNT(*) as BScount FROM BloodSpecimen";
         	// Execute query 
         	$dbo->doQuery($sql2);
         	// Retrieve row of results
         	$row2 = $dbo->loadObjectList();
         	// Generate ID e.g BS001
         	$num_padded2 = sprintf("%03d",$row2["BScount"]+1);
         	$id2 = "BS".$num_padded2;
         	// Add default data to record
         	$rec = array($id2,"components","location","testresult",$bloodType,"testedBy","RH","TO BE TESTED");
         	// Create control object
         	$rdb = new Recipient_DonationRec_BloodSpec();
         	$rdb->addBloodSpecimen($rec);
         	// Create RDB record
         	$record = array($id,$recipient,$id2);
         	// Store RDB record
         	$rdb->construct($record);
         	// Confirmation message
         	$msg = "Blood Specimen Record. ".$id2." successfully added";
         }/* ++++++++++++ END OF ADD DONATION RECORD ++++++++++++++++++++ */

         /* ADD DONOR RECORD */

         // Get session variables
	    $nurseUI = $_SESSION["userObj"];
	    $personObj = $_SESSION["person"];
	    $donorObj = $_SESSION["donorObj"];

	    // Create record for donor control table
	    array_push($personObj,$donorObj->donor_medicalRec->idMedicalRecord,$donorObj->donor_donationRec->idDonationRecord);

	    // Add record to database
	    $nurseUI->addDonor($personObj);

	    // Confirmation message
         $msg = "Donor. ".$personObj[0]." successfully added";


         /* SEARCH DONOR RECORDS */
         if($_SERVER['REQUEST_METHOD'] == 'POST')
    	{
    		// Get ID to search by
    		 $trn = $_POST["trn"];
    		 $donorObj = $_SESSION["donorObj"];
    		 $row = $donorObj->searchRecord($trn);

    		 // Generate search results
    		 echo "Place Form template here";
    	}

    	/* EDIT DONOR RECORDS */
    	// Edit medical record
    	 $donorObj = $_SESSION["donorObj"];
    	 $donorObj->donor_medicalRec->editRecord($rec);
    	// Edit donation record
    	 $donorObj->donor_DonationRec->editRecord($rec);


	 /* ====================END OF MANAGE BLOOD DONORS ======================== */

	 /* ==================== MANAGE BLOOD RECIPIENTS ======================== */

	  /* +++++++++++++++++ Add Person information ++++++++++++++++++++ */
	    include('Person.class.php');

	    $msg = "";
	    $errors = array();

    
        if($_SERVER['REQUEST_METHOD'] == 'POST')	
        {
        	// Get entered fields
         	$trn = $_POST['TRN'];
       	 	$fname = $_POST['fname'];
       	 	$lname = $_POST['lname'];
         	$addr1 = $_POST['addr1'];
         	$addr2 = $_POST['addr2'];
         	$cell = $_POST['cell'];
       	 	$work = $_POST['work'];
       	 	$home = $_POST['home'];
         	$email = $_POST['email'];
         	$dob = $_POST['dob'];
         	$sex = $_POST['sex'];
       	 	$mStatus = $_POST['mStatus'];
         	$mname = $_POST['mname'];

         	// Image handling
			$target_dir = "uploads/"; // directory where the file is going to be placed
			$target_file = $target_dir . basename($_FILES["image"]["name"]); // path of the file to be uploaded
			$uploadOk = 1; // flag to detmine if upload is successful
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION); // file extension of the file

			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
    			$check = getimagesize($_FILES["image"]["tmp_name"]);
    			if($check !== false) {
        			$errors[] = "File is an image - " . $check["mime"] . ".";
        			$uploadOk = 1;
    			} else {
        			$errors[] = "File is not an image.";
        			$uploadOk = 0;
    			}
			}

			// Check file size
			if ($_FILES["image"]["size"] > 500000) {
    			$errors[] = "Sorry, your file is too large.";
    			$uploadOk = 0;
			}

			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
    			$errors[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    			$uploadOk = 0;
			}

			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
    			$errors[] = "Sorry, your file was not uploaded.";
				// if everything is ok, try to upload file
			} else {
    			if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        			$errors[] = "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
        			// Store to database, link to file
        			$idpic = $target_file;
    			} else {
        			$errors[] = "Sorry, there was an error uploading your file.";
    			}
			}

			 // Errors
		    if (empty($errors))
		    {         
          		
         		// Get values to be stored in database
         		$data = array($trn, $fname, $lname, $addr1, $addr2, $cell, $work, $home, $email, $dob, $sex, $idpic, $mStatus, $mname);
         		// store record to session variable
         		$_SESSION["person"] = $data;
         		
         	}
         	else
         	{
         		// If there are errors, output them as list items
    						echo "<ul>";
    						foreach ($errors as $error){
    							echo "<li>".$error."</li>";}
    						echo "</ul>";
    					
         	}
		   
         	
      	}/* +++++++++++++++ End of Add Person Information +++++++++++++++++++++ */

      	/* +++++++++++++++++ Add Recipient Info ++++++++++++++++++++++ */

      	// Include Recipient class
      	include('Recipient.class.php');

      	$msg = "";
  
    
        if($_SERVER['REQUEST_METHOD'] == 'POST')	
        {
        	// Get entered fields
    
       	 	$group = $_POST['bloodGroup'];
       	 	$quantity = $_POST['quanitityNeeded'];
         	$reason = $_POST['reason'];
         	$level = $_POST['urgencyLevel'];
         	$location = $_POST['location'];
       	 	$RH = $_POST['RH'];

       	
       	 	// Blood Type => Who can receive this type
       	 	$bloodTypes = array("O+"=>"O+,A+,B+,AB+","O-"=>"O+,O-,A+,A-,B+,B-,AB+,AB-","A+"=>"A+,AB+","A-"=>"A+,A-,AB+,AB-","B+"=>"B+,AB+","B-"=>"B+,B-,AB+,AB-","AB+"=>"AB+","AB-"=>"AB+,AB-");
       	 	// Entered blood type 
       	 	$bloodType = $group.$RH;
       	 	// Evaluate and calculate compatibleWith
       	 	foreach ($bloodTypes as $type=>$value) {
       	 		if ($bloodType === $type)
       	 		{
       	 			$compatibleWith = $value;
       	 		}
       	 	}
        	
               
         	 /* ADD Recipient RECORD */

         // Get session variables
	    $personObj = $_SESSION["person"];

	    // Create record for recipient table
	    array_push($personObj,$group,$quantity,$reason,$level,$location,$RH,$compatibleWith);

	    // Create control object
	    $recipient = new Recipient_DonationRec_BloodSpec();
	    // Add record to database
	    $recipient->addRecipient($personObj);

	    // Confirmation message
         $msg = "Recipient. ".$personObj[0]." successfully added";

         }/* +++++++++++++ END OF ADD Recipient RECORD +++++++++++++++++++++++ */


         /* SEARCH Recipient RECORDS */
         if($_SERVER['REQUEST_METHOD'] == 'POST')
    	{
    		// Get ID to search by
    		 $trn = $_POST["trn"];
    		 
    		  // Create recipient object
	    		$recipient = new Recipient();

	    		// Search
    		 $row = $recipient->searchRecord($trn);

    		 // Generate search results
    		 echo "Place Form template here";
    	}

    	/* EDIT Recipient RECORDS */
    	
    	 // Create recipient object
	    $recipient = new Recipient();

	    // Edit
    	 $recipient->editRecord($rec);

	 /* ====================END OF MANAGE BLOOD RECIPIENTS ======================== */

	  /* ==================== MANAGE BLOOD INVENTORY ======================== */

	  /* +++++++++++++++ UPDATE BLOOD SPECIMEN ++++++++++++ */
	    include('BloodSpecimen.class.php');

	    $msg = "";

	    // Get current user signed in 
         	$testedBy = $_SESSION["userObj"]->loggedin_User;
         // Get today's date
       	 	$date = date("Y-m-d");

	    if($_SERVER['REQUEST_METHOD'] == 'POST')	
        {
        	// Get entered fields
        	$id = $_POST['idBloodSpecimen'];
       	 	$components = $_POST['componentsInfo'];
       	 	$location = $_POST['storageLocation'];
         	$results = $_POST['testResults'];
         	$type = $_POST['bloodType'];
         	$RH = $_POST['RH'];
       	 	$status = $_POST['status'];

	    	// Create blood specimen object
	    	$bloodSpecimen = new BloodSpecimen();
	    	// Crete record
	    	$rec = array($id,$components,$location,$results,$type,$RH,$testedBy,$date,$status);
	    	// Update
	    	$bloodSpecimen->editRecord($rec);
	    	// Confirmation message
         $msg = "Blood Specimen. ".$id." successfully updated";
	    	// Show update
	    	$data = $bloodSpecimen->viewRecord($id);
		}

		/* SEARCH BLOOD SPECIMENS */

		  include('BloodSpecimen.class.php');

		   if($_SERVER['REQUEST_METHOD'] == 'POST')
    	{
    		// Get ID to search by
    		 $id = $_POST["idBloodSpecimen"];
    		 
    		  // Create blood specimen object
	    		$bs = new BloodSpecimen();

	    		// Search
    		 $row = $bs->searchRecord($id);

    		 // View
    		 $row2 = $bs->viewRecord($id);

    		 // Generate search results
    		 echo "Place Form template here";
    	}

	  /* ====================END OF MANAGE BLOOD INVENTORY ======================== */

	  /* 
?>
