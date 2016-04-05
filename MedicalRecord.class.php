<?php	

	/* === CLASS FOR MedicalRecord TABLE === */
if ( interface_exists('manageRecord') ) {
	class MedicalRecord extends Table implements manageRecord
	{
		/* === ATTRIBUTES === */

		private $idMedicalRecord = null; // primary key
		private $medicalRec_weight = null;
		private $medicalRec_height = null;
		private $medicalRec_bloodPressure = null;
		private $medicalRec_temperature = null;
		private $medicalRec_bloodIronLevel = null;
		private $medicalRec_time = null;
		private $medicalRec_date = null;
		private $medicalRec_medicalHistory = null;
		private $medicalRec_rejectionReason = null;

		var $table = "MedicalRecord"; // Name of table

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
			return "<br> Medical Record ID: ".$this->idMedicalRecord.
				   "<br> Weight: ".$this->medicalRec_weight.
				   "<br> Height: ".$this->medicalRec_height.
				   "<br> Blood Pressure: ".$this->medicalRec_bloodPressure.
				   "<br> Temperature: ".$this->medicalRec_temperature.
				   "<br> Blood Iron Level: ".$this->medicalRec_bloodIronLevel.
				   "<br> Time: ".$this->medicalRec_time.
				   "<br> Date: ".$this->medicalRec_date.
				   "<br> Medical History: ".$this->medicalRec_medicalHistory.
				   "<br> Rejection Reason: ".$this->medicalRec_rejectionReason;
		}

		/**
		*	Executes Select query on Table
		*   
		*   @param  idMedicalRecord
		*	@return matching record
		*/
		function select($idMedicalRecord) // Implementation 
		{
		    $this->idMedicalRecord = $idMedicalRecord;
			$dbo = database::getInstance(); // pass back that database object already created perhaps
			$sql = $this->buildQuery('select'); // what we want to do (select records)

			$dbo->doQuery($sql); // execute query statement
			$row = $dbo->loadObjectList(); //get list of all returned values as assoc array
		
			return $row;
		}

		/**
		*	Executes UPDATE query on Table
		*   
		*   @param  idMedicalRecord - primary key
		*	@return none
		*/
		function update($idMedicalRecord) // Implementation 
		{
			$this->idMedicalRecord = $idMedicalRecord;
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

				$sql = "select * from {$this->table} where idMedicalRecord = '{$this->idMedicalRecord}'";
			}
			elseif ($task == 'update')
				{ // Update the database entry and overwrite what's in that record
					$classVars = get_class_vars(get_class($this));
					$sql .= "UPDATE {$this->table} SET ";
					foreach($classVars as $key=>$value)
					{
						if($key == "idMedicalRecord"|| $key == "table") // ignore primary key and the name of leh table
						{
							continue; // skip over table name and primary key
						}

						$sql .= "{$key} = '{$this->$key}', ";

					}
					// strip off comma and space .substr() fro/ those values
					$sql = substr($sql,0,-2)." WHERE idMedicalRecord = '{$this->idMedicalRecord}'"; // update only  the record located at the primary key loaded into this object

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
			$data =  array("idMedicalRecord"=>$rec[0],"medicalRec_weight"=>$rec[1],"medicalRec_height"=>$rec[2],"medicalRec_bloodPressure"=>$rec[3],"medicalRec_temperature"=>$rec[4],"medicalRec_bloodIronLevel"=>$rec[5],"medicalRec_time"=>$rec[6],"medicalRec_date"=>$rec[7],"medicalRec_medicalHistory"=>$rec[8],"medicalRec_rejectionReason"=>$rec[9]);
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
			$data =  array("idMedicalRecord"=>$rec[0],"medicalRec_weight"=>$rec[1],"medicalRec_height"=>$rec[2],"medicalRec_bloodPressure"=>$rec[3],"medicalRec_temperature"=>$rec[4],"medicalRec_bloodIronLevel"=>$rec[5],"medicalRec_time"=>$rec[6],"medicalRec_date"=>$rec[7],"medicalRec_medicalHistory"=>$rec[8],"medicalRec_rejectionReason"=>$rec[9]);
			// Bind values to object's attributes
			$this->bind($data);
			// Add new updated values to table in database to location of given Primary key
			$this->update($rec[0]);
		}


		/**
		*	Search records in database table
		*   
		*   @param  idMedicalRecord - primary key
		*	@return matching records
		*/
		function searchRecord($idMedicalRecord)
		{
			$this->idMedicalRecord = $idMedicalRecord;
			$dbo = database::getInstance(); // pass back that database object already created perhaps
			
			$sql = "SELECT * FROM  BloodSpecimen JOIN Recipient_DonationRec_BloodSpec as RDB1 
			        JOIN Recipient JOIN Person as p1 JOIN Person as p2 JOIN Donor as d1 
			        JOIN {$this->table} JOIN Donor as d2 JOIN DonationRecord 
			        JOIN Recipient_DonationRec_BloodSpec as RDB2 
			        ON BloodSpecimen.idBloodSpecimen = RDB1.RDB_idBloodSpec
                    AND RDB1.RDB_idBloodSpec = Recipient.idRecipient_TRN AND Recipient.idRecipient_TRN = p1.idPerson_TRN
                    AND p1.idPerson_TRN <> p2.idPerson_TRN AND p2.idPerson_TRN = d1.idDonor_TRN 
                    AND d1.donor_medicalRec = {$this->table}.idMedicalRecord AND {$this->table}.idMedicalRecord = d2.donor_medicalRec
                    AND d2.donor_donationRec = DonationRecord.idDonationRecord AND DonationRecord.idDonationRecord = RDB2.RDB_idDonationRec
                    WHERE '{$this->idMedicalRecord}' = {$this->table}.idMedicalRecord";

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
		function viewRecord($idMedicalRecord)
		{
			$this->idMedicalRecord = $idMedicalRecord;
			$dbo = database::getInstance(); // pass back that database object already created perhaps

			// Execute select query on database giving current object data values
			$data = $this->select($idMedicalRecord);

			return $data; // list of all returned values as assoc array
		}

	} // class

} // interface

?>