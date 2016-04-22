<?php	

	/* === VIEWS === */
	include('NurseUI.boundary.php');
	include('LabTechUI.boundary.php');

	/* === CLASS FOR UserLogin TABLE === */
	if ( interface_exists('manageRecord') ) {

	class UserLogin extends Table implements manageRecord
	{
		/* === ATTRIBUTES === */

		private $idUser = null; // primary key
		private $userName = null;
		private $userType = null;
		private $passWord = null;
		
		var $table = "UserLogin"; // Name of table

		/* === METHODS === */

		/**
		*	Constructor 
		*   
		*   @param  
		*	@return none
		*/
		 function __construct()
		{
			
		}

		/**
		*	Getters
		*   
		*   @param  none
		*	@return none
		*/
	
		public function __get($property) 
		{
            if (property_exists($this, $property))
            {
                return $this->$property;
            }
    	}


    	/**
		*	Setters
		*   
		*   @param  none
		*	@return none
		*/
    	public function __set($property, $value)
		{
  			if (property_exists($this, $property)) {
    			$this->$property = $value;
  			}
		}

		/**
		*	Print object
		*   
		*   @param  none
		*	@return none
		*/
		function __toString()
		{
			return "<br> User ID: ".$this->idUser.
				   "<br> Username: ".$this->userName.
				   "<br> User Type: ".$this->userType.
				   "<br> Password: ".$this->passWord;
		}


		/**
		*	User Authentication
		*   
		*   @param  username,password
		*	@return none
		*/
		function login_User($user,$pass)
		{

			$dbo = database::getInstance(); // pass back that database object already created perhaps
			
			$sql = "SELECT * FROM {$this->table} 
                    WHERE  userName = '{$user}'";

			$dbo->doQuery($sql); // execute query statement

			$row = $dbo->loadObjectList(); //get list of all returned values as assoc array
			
			/* Encrypt password entered */
			// Get salt appended
			//$salt = substr($row["passWord"], -1);
			// Cooncatenate to password entered by user
			//$digest = $pass.$salt;
			// Compute digest of this concatanated string
			//$encPassword = md5($digest);
			// Compare to what is in database
			if ($row["passWord"] === $pass)
			{
				/* Login succesful */
				// Link to different ui based on user type
				if ($row["userType"] === 'N')
				{	
					// Nurse UI
					$ui = new NurseUI($user);
				}
				else if ($row["userType"] === 'L')
				{
					// Lab Tech UI
					$ui = new LabTechUI($user);
				}
			}
			else
			{
				return False;
			}


		}

  
		/**
		*	Executes Select query on Table
		*   
		*   @param  primary key
		*	@return matching record
		*/
		function select($idUser) // Implementation 
		{
		    $this->idUser = $idUser;
			$dbo = database::getInstance(); // pass back that database object already created perhaps
			$sql = $this->buildQuery('select'); // what we want to do (select records)

			$dbo->doQuery($sql); // execute query statement
			$row = $dbo->loadObjectList(); //get list of all returned values as assoc array

			foreach ($row as $key=>$value)
			{
				if ($key == "idUser")  //particular entry
				{
					continue; //skip over it
				}
				$this->$key = $value; // whatever the field is that we are getting back from the database 
				// we want to assign the variable in thet table object whatever that value is that we're getting back
				// from the database
			}
		
			return $row;
		}



		/**
		*	Creates sql query statements
		*   
		*   @param  task - what we want to do whether we want to store info or load it
		*	@return none
		*/
		function buildQuery($task)
		{
			$sql = "";
			if ($task == 'insert')
			{
					$keys = "";
					$values = "";
					$classVars = get_class_vars(get_class($this)); // getting the (dynamic) variables we created in our class pass our className of object
					// get the variables of whatever class I am
					$sql .= "Insert into {$this->table}"; // whatever the table name is we're going to be inserting our record into it
					foreach ($classVars as $key=>$value) //Create an associative array of all the variables that we have in the class
					{
						if ($key == "table")
						{
							continue; //skip it cause we don't want to be storing the table name inside of the table
						}
						//it will be a comma separated list
						$keys.= "{$key},";
						$values .= "'{$this->$key}',";
					}
					//Strip off commas .substr()
					$sql .= "(".substr($keys,0,-1).") Values(".substr($values,0,-1).")";
					//Insert into table (attributes/fields) Values ('','','');
			}
			elseif($task == 'select')
			{

				$sql = "select * from {$this->table} where idUser = '{$this->idUser}'";
			}
			elseif ($task == 'update')
				{ // Update the database entry and overwrite what's in that record
					$classVars = get_class_vars(get_class($this));
					$sql .= "UPDATE {$this->table} SET ";
					foreach($classVars as $key=>$value)
					{
						if($key == "idUser"|| $key == "table") // ignore primary key and the name of leh table
						{
							continue; // skip over table name and primary key
						}

						$sql .= "{$key} = '{$this->$key}', ";

					}
					// strip off comma and space .substr() fro/ those values
					$sql = substr($sql,0,-2)." WHERE idUser = '{$this->idUser}'"; // update only  the record located at the primary key loaded into this object

				} //UPDATE FUNCTION

			return $sql;

		}

		/* ==== INTERFACE FUNCTIONS === */

		/**
		*	Add records to database table
		*   
		*   @param  record
		*	@return none
		*/
		function addNew($rec)
		{
			// Create associative array of key fields and data values
			$data =  array("idUser"=>$rec[0],"userName"=>$rec[1],"userType"=>$rec[2],"passWord"=>$rec[3]);
			// Bind values to object's attributes
			$this->bind($data);
			// Add new values to table in database
			$this->insert();
		}

		/**
		*	Update record in database table
		*   
		*   @param  record
		*	@return none
		*/
		function editRecord($rec)
		{
			// Create associative array of key fields and data values
			$data =  array("idUser"=>$rec[0],"userName"=>$rec[1],"userType"=>$rec[2],"passWord"=>$rec[3]);
			// Bind values to object's attributes
			$this->bind($data);
			// Add new updated values to table in database to location of given Primary key
			$this->update($rec[0]);
		}


		/**
		*	Search records in database table
		*   
		*   @param  primary key
		*	@return matching records
		*/
		function searchRecord($userName)
		{
			$this->userName = $userName;
			$dbo = database::getInstance(); // pass back that database object already created perhaps
			
			$sql = "SELECT * FROM {$this->table} 
                    WHERE '{$this->userName}' = {$this->table}.userName";

			$dbo->doQuery($sql); // execute query statement

			$row = $dbo->loadObjectList(); //get list of all returned values as assoc array
			
			return $row;
		}

		/**
		*	View records in database table
		*   
		*   @param  primary key
		*	@return none
		*/
		function viewRecord($userName)
		{
			$this->userName = $userName;
			$dbo = database::getInstance(); // pass back that database object already created perhaps

			// Execute select query on database giving current object data values
			$data = $this->select($userName);

			return $data; // list of all returned values as assoc array
		}



	} // class

} // interface

?>