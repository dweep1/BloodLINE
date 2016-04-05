<?php	

	/* === CLASS FOR UserLogin TABLE === */

	class UserLogin extends Table
	{
		/* === ATTRIBUTES === */

		private $idUser = null; // primary key
		private $userName = null;
		private $userType = null;
		private $passWord = null;
		
		var $table = "UserLogin"; // Name of table

		/* === METHODS === */

		/**
		*	Constructor (Create object and add data to database table)
		*   
		*   @param  record
		*	@return none
		*/
		 function __construct($rec)
		{
			// Create associative array of key fields and data values
			$data =  array("idUser"=>$rec[0],"userName"=>$rec[1],"userType"=>$rec[2],"passWord"=>$rec[3]);
			// Bind values to object's attributes
			$this->bind($data);
			// Add new values to table in database
			$this->insert();
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
		
			//return $row;
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

			echo $sql;
			return $sql;

		}


	} // class

?>