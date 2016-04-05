<?php

	include('Database.class.php'); // class to set up database connection
	include('Table.class.php'); // class to set up database table functionality
	
	include_once('manageRecord.interface.php'); // Interface for table functionality

	define ("DB_HOST", "localhost"); // set database host

	define ("DB_USER", "root"); // set MySQL database user

	define ("DB_PASS",""); // set MySQL database password

	define ("DB_NAME","BloodLINE"); // set database name

	// Create database object
	$dbo = database :: getInstance();

	// Connect to server and select database
	$dbo->connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

?>
