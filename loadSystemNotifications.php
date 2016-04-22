<?php

	 /* === DATABASE CONNECTION === */
	  include('dbaccess.php');
	  /* === START SESSION === */
	  session_start();

        //Class
        include('SystemNotification.class.php')

	  // Displays 10 most recent blood specimens

	  // Create database object
      $dbo = database::getInstance();
      // 
      $sql = "SELECT idBloodSpecimen,bloodSpec_bloodType,bloodSpec_testedBy,bloodSpec_status FROM BloodSpecimen ORDER BY idBloodSpecimen DESC LIMIT 11";
      // Execute query 
      $dbo->doQuery($sql);
      // Retrieve row of results
      $row = $dbo->loadObjectList();
      
      
?>