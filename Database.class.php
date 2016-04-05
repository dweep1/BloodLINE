<?php

	/* ==== CLASS TO SET UP A DATABASE OBJECT AND MYSQLi CONNECTION === */

	class Database
	{
		/* === ATTRIBUTES === */

		private $host;   // Server connecting to
		private $user;   // Database user
		private $pass;   // Password for database user
		private $dbName; // Name of database

		private static $instance; // Instance of itself

		private $connection = null;  //Stores the active connection
		private $results = null;
		private $numRows = null;

		/* === METHODS === */

		/**
		*	Constructor
		*   
		*   @param  none
		*	@return none
		*/
		private function __construct()
		{

		}

		/**
		*	Creates an instance of a Database object
		*   Returns the *Singleton* instance of this class.
		*   @param  
		*	@return an instance itself
		*/
		// Singleton, if an object has already been created don't create another it's just going to pass it back
		// SAVES On resources , (static) can be called without an instance of the database object
		// If it hasn't created an instance of itself then run it's ouwn constructor
		// Helps to minimize the issue with multiple database connections
		static function getInstance() 
		{
			if(!self::$instance)
			{
				self::$instance = new self();
			}
			return self::$instance;

		}

		/**
		*	Connects to Database
		*   
		*   @param  hostName userName passWord dbName String
		*	@return none
		*/
		function connect($host, $user, $pass, $dbName)
		{
			$this->host = $host;
			$this->user = $user;
			$this->pass = $pass;
			$this->dbName = $dbName;

			$this->connection = new mysqli($this->host, $this->user,$this->pass,$this->dbName);
			// Check connection
			if($this->connection->connect_errno > 0)
			{
   				 die('Unable to connect to database [' . $this->connection->connect_error . ']');
			}

		}

		/**
		*	Executes query on Database
		*   
		*   @param  sqlStatement String
		*	@return none
		*/
		public function doQuery($sql)
		{
			$this->results = $this->connection->query($sql);
			if($this->results === false) 
			{
  				trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $this->connection->error, E_USER_ERROR);
			} 
			/*else 
			{
  				$this->numRows = mysqli_num_rows($this->results);
			}*/

		}

		/**
		*	Loads data from Database into an associative array
		*   
		*   @param 
		*	@return 
		*/
		public function loadObjectList()
		{
			$obj = "No Results";
			if($this->results)
			{
				$obj = mysqli_fetch_assoc($this->results);
			}
			return $obj;
		}

	}

?>