<?php	

	/* === CLASS FOR BloodSpecimen TABLE === */
	if ( interface_exists('manageRecord') ) {

	class BloodSpecimen extends Table implements manageRecord
	{
		/* === ATTRIBUTES === */

		private $idBloodSpecimen = null; // primary key
		private $bloodSpec_componentsinfo = null;
		private $bloodSpec_storageLocation = null;
		private $bloodSpec_testResults = null;
		private $bloodSpec_bloodType = null;
		private $bloodSpec_RH = null;
		private $bloodSpec_testedBy = null;
		private $bloodSpec_processDate = null;
		private $bloodSpec_status = null;

		var $table = "BloodSpecimen"; // Name of table

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
			return "<br> Blood Spcimen ID: ".$this->idBloodSpecimen.
				   "<br> Components Information: ".$this->bloodSpec_componentsinfo.
				   "<br> Storage Location: ".$this->bloodSpec_storageLocation.
				   "<br> Test Results: ".$this->bloodSpec_testResults.
				   "<br> Blood Type: ".$this->bloodSpec_bloodType.
				   "<br> RH: ".$this->bloodSpec_RH.
				   "<br> Tested By: ".$this->bloodSpec_testedBy.
				   "<br> Process Date: ".$this->bloodSpec_processDate;
		}

		/**
		*	Executes Select query on Table
		*   
		*   @param  idBloodSpecimen
		*	@return matching record
		*/
		function select($idBloodSpecimen) // Implementation 
		{
			$this->idBloodSpecimen = $idBloodSpecimen;
			$dbo = database::getInstance(); // pass back that database object already created perhaps
			$sql = $this->buildQuery('select'); // what we want to do (select records)

			$dbo->doQuery($sql); // execute query statement
			$row = $dbo->loadObjectList(); //get list of all returned values as assoc array
			/*foreach ($row as $key=>$value)
			{
				if ($key == "idBloodSpecimen")  //particular entry
				{
					continue; //skip over it
				}
				$this->$key = $value; // whatever the field is that we are getting back from the database 
				// we want to assign the variable in thet table object whatever that value is that we're getting back
				// from the database
			}*/
			return $row;
		}


		/**
		*	Executes UPDATE query on Table
		*   
		*   @param  idBloodSpecimen - primary key
		*	@return none
		*/
		function update($idBloodSpecimen) // Implementation 
		{
			$this->idBloodSpecimen = $idBloodSpecimen;
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

				$sql = "select * from {$this->table} where idBloodSpecimen = '{$this->idBloodSpecimen}'";
			}
			elseif ($task == 'update')
				{ // Update the database entry and overwrite what's in that record
					$classVars = get_class_vars(get_class($this));
					$sql .= "UPDATE {$this->table} SET ";
					foreach($classVars as $key=>$value)
					{
						if($key == "idBloodSpecimen"|| $key == "table") // ignore primary key and the name of leh table
						{
							continue; // skip over table name and primary key
						}

						$sql .= "{$key} = '{$this->$key}', ";

					}
					// strip off comma and space .substr() fro/ those values
					$sql = substr($sql,0,-2)." WHERE idBloodSpecimen = '{$this->idBloodSpecimen}'"; // update only  the record located at the primary key loaded into this object

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
			$data =  array("idBloodSpecimen"=>$rec[0],"bloodSpec_componentsinfo"=>$rec[1],"bloodSpec_storageLocation"=>$rec[2],"bloodSpec_testResults"=>$rec[3],"bloodSpec_bloodType"=>$rec[4],"bloodSpec_RH"=>$rec[5],"bloodSpec_testedBy"=>$rec[6],"bloodSpec_processDate"=>$rec[7],"bloodSpec_status"=>$rec[8]);
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
			$data =  array("idBloodSpecimen"=>$rec[0],"bloodSpec_componentsinfo"=>$rec[1],"bloodSpec_storageLocation"=>$rec[2],"bloodSpec_testResults"=>$rec[3],"bloodSpec_bloodType"=>$rec[4],"bloodSpec_RH"=>$rec[5],"bloodSpec_testedBy"=>$rec[6],"bloodSpec_processDate"=>$rec[7],"bloodSpec_status"=>$rec[8]);
			// Bind values to object's attributes
			$this->bind($data);
			// Add new updated values to table in database to location of given Primary key
			$this->update($rec[0]);
		}


		/**
		*	Search records in database table
		*   
		*   @param  idBloodSpecimen - primary key
		*	@return matching records
		*/
		function searchRecord($idBloodSpecimen)
		{
			$this->idBloodSpecimen = $idBloodSpecimen;
			$dbo = database::getInstance(); // pass back that database object already created perhaps
			
			$sql = "SELECT * FROM {$this->table} JOIN Recipient_DonationRec_BloodSpec as RDB1 
			        JOIN Recipient JOIN Person as p1 JOIN Person as p2 JOIN Donor as d1 
			        JOIN MedicalRecord JOIN Donor as d2 JOIN DonationRecord 
			        JOIN Recipient_DonationRec_BloodSpec as RDB2 
			        ON {$this->table}.idBloodSpecimen = RDB1.RDB_idBloodSpec
                    AND RDB1.RDB_idBloodSpec = Recipient.idRecipient_TRN AND Recipient.idRecipient_TRN = p1.idPerson_TRN
                    AND p1.idPerson_TRN <> p2.idPerson_TRN AND p2.idPerson_TRN = d1.idDonor_TRN 
                    AND d1.donor_medicalRec = MedicalRecord.idMedicalRecord AND MedicalRecord.idMedicalRecord = d2.donor_medicalRec
                    AND d2.donor_donationRec = DonationRecord.idDonationRecord AND DonationRecord.idDonationRecord = RDB2.RDB_idDonationRec
                    WHERE '{$this->idBloodSpecimen}' = {$this->table}.idBloodSpecimen";

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
		function viewRecord($idBloodSpecimen)
		{
			$this->idBloodSpecimen = $idBloodSpecimen;
			$dbo = database::getInstance(); // pass back that database object already created perhaps

			// Execute select query on database giving current object data values
			$data = $this->select($idBloodSpecimen);

			return $data; // list of all returned values as assoc array
		}


	}

}
?>