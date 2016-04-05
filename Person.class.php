<?php	

	/* === CLASS FOR Person TABLE === */

	if ( interface_exists('manageRecord') ) {

	class Person extends Table implements manageRecord
	{
		/* === ATTRIBUTES === */

		private $idPerson_TRN = null; // primary keys
		private $person_firstName = null;
		private $person_lastName = null;
		private $person_address1 = null;
		private $person_address2 = null;
		private $person_cellNo= null;
		private $person_workNo = null;
		private $person_homeNo = null;
		private $person_email = null;
		private $person_dob = null;
		private $person_sex = null;
		private $person_idPicture = null;
		private $person_maritalStatus = null;
		private $person_middleName = null;

		var $table = "Person"; // Name of table

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
			return "<br> TRN: ".$this->idPerson_TRN;
		}


		/**
		*	Executes Select query on Table
		*   
		*   @param  primary key
		*	@return matching record
		*/
		function select($idPerson_TRN) // Implementation 
		{
		    $this->idPerson_TRN = $idPerson_TRN;
			$dbo = database::getInstance(); // pass back that database object already created perhaps
			$sql = $this->buildQuery('select'); // what we want to do (select records)

			$dbo->doQuery($sql); // execute query statement
			$row = $dbo->loadObjectList(); //get list of all returned values as assoc array
		
			return $row;
		}

		/**
		*	Executes UPDATE query on Table
		*   
		*   @param primary key
		*	@return none
		*/
		function update($idPerson_TRN) // Implementation 
		{
			$this->idPerson_TRN = $idPerson_TRN;
			$dbo = database::getInstance(); // pass back that database object already created perhaps
			$sql = $this->buildQuery('update'); // what we want to do (update records)

			$dbo->doQuery($sql); // execute query statement
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

				$sql = "select * from {$this->table} where idPerson_TRN = '{$this->idPerson_TRN}'";
			}
			elseif ($task == 'update')
				{ // Update the database entry and overwrite what's in that record
					$classVars = get_class_vars(get_class($this));
					$sql .= "UPDATE {$this->table} SET ";
					foreach($classVars as $key=>$value)
					{
						if($key == "idPerson_TRN"|| $key == "table") // ignore primary key and the name of leh table
						{
							continue; // skip over table name and primary key
						}

						$sql .= "{$key} = '{$this->$key}', ";

					}
					// strip off comma and space .substr() fro/ those values
					$sql = substr($sql,0,-2)." WHERE idPerson_TRN = '{$this->idPerson_TRN}'"; // update only  the record located at the primary key loaded into this object

				} //UPDATE FUNCTION

			echo $sql;
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
			$data =  array("idPerson_TRN"=>$rec[0],"person_firstName"=>$rec[1],"person_lastName"=>$rec[2],"person_address1"=>$rec[3],"person_address2"=>$rec[4],"person_cellNo"=>$rec[5],"person_workNo"=>$rec[6],"person_homeNo"=>$rec[7],"person_email"=>$rec[8],"person_dob"=>$rec[9],"person_sex"=>$rec[10],"person_idPicture"=>$rec[11],"person_maritalStatus"=>$rec[12],"person_middleName"=>$rec[13]);
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
			$data =  array("idPerson_TRN"=>$rec[0],"person_firstName"=>$rec[1],"person_lastName"=>$rec[2],"person_address1"=>$rec[3],"person_address2"=>$rec[4],"person_cellNo"=>$rec[5],"person_workNo"=>$rec[6],"person_homeNo"=>$rec[7],"person_email"=>$rec[8],"person_dob"=>$rec[9],"person_sex"=>$rec[10],"person_idPicture"=>$rec[11],"person_maritalStatus"=>$rec[12],"person_middleName"=>$rec[13]);
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
		function searchRecord($idPerson_TRN)
		{
			$this->idPerson_TRN = $idPerson_TRN;
			$dbo = database::getInstance(); // pass back that database object already created perhaps
			
			$sql = "SELECT * FROM  BloodSpecimen JOIN Recipient_DonationRec_BloodSpec as RDB1 
			        JOIN Recipient JOIN {$this->table} as p1 JOIN {$this->table} as p2 JOIN Donor as d1 
			        JOIN MedicalRecord JOIN Donor as d2 JOIN DonationRecord 
			        JOIN Recipient_DonationRecord_BloodSpec as RDB2 
			        ON BloodSpecimen.idBloodSpecimen = RDB1.RDB_idBloodSpec
                    AND RDB1.RDB_idBloodSpec = Recipient.idRecipient_TRN AND Recipient.idRecipient_TRN = p1.idPerson_TRN
                    AND p1.idPerson_TRN <> p2.idPerson_TRN AND p2.idPerson_TRN = d1.idDonor_TRN 
                    AND d1.donor_medicalRec = MedicalRecord.idMedicalRecord AND MedicalRecord.idMedicalRecord = d2.donor_medicalRec
                    AND d2.donor_donationRec = DonationRecord.idDonationRecord AND DonationRecord.idDonationRecord = RDB2.RDB_idDonationRec
                    WHERE '{$this->idPerson_TRN}' = p1.idPerson_TRN OR '{$this->idPerson_TRN}' = p2.idPerson_TRN ";

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
		function viewRecord($idPerson_TRN)
		{
			$this->idPerson_TRN = $idPerson_TRN;
			$dbo = database::getInstance(); // pass back that database object already created perhaps

			// Execute select query on database giving current object data values
			$data = $this->select($idPerson_TRN);

			return $data; // list of all returned values as assoc array
		}



	} // class

} // interface
?>