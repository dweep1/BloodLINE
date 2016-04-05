<?php	

	/* === CLASS FOR Recipient_DonationRec_BloodSpec TABLE === */

	class Recipient_DonationRec_BloodSpec extends Table
	{
		/* === ATTRIBUTES === */

		private $RDB_idDonationRec = null; // primary keys
		private $RDB_idRecipient = null;
		private $RDB_idBloodSpec = null;

		var $table = "Recipient_DonationRec_BloodSpec"; // Name of table

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
		*	Constructor (Create object and add data to database table)
		*   
		*   @param  record
		*	@return none
		*/
		 function construct($rec)
		{
			// Create associative array of key fields and data values
			$data =  array("RDB_idDonationRec"=>$rec[0],"RDB_idRecipient"=>$rec[1],"RDB_idBloodSpec"=>$rec[2]);
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
			return "<br> Donation Record: ".$this->RDB_idDonationRec.
				   "<br> Recipient: ".$this->RDB_idRecipient.
				   "<br> Blood Specimen: ".$this->RDB_idBloodSpec;
		}


    	/**
		*	Add Recipient Object to Controller
		*   
		*   @param  record
		*	@return none
		*/
    	public function add_Recipient($rec)
		{
  			// Create recipient object
  			$r = new Recipient($rec);

  			// Set control id
  			$this->RDB_idRecipient = $r->idRecipient_TRN;

		}

		/**
		*	Add Donation Object to Controller
		*   
		*   @param  record
		*	@return none
		*/
    	/*public function add_DonationRecord($rec)
		{
  			// Create DonationRecord object
  			$dr = new DonationRecord($rec);

  			// Set control id
  			$this->RDB_idDonationRec = $dr->idDonationRecord;

		}*/

		/**
		*	Add BloodSpecimen Object to Controller
		*   
		*   @param  record
		*	@return none
		*/
    	public function add_BloodSpecimen($rec)
		{
  			// Create BloodSpecimen object
  			$bs = new BloodSpecimen($rec);

  			// Set control id
  			$this->RDB_idBloodSpec = $bs->idBloodSpecimen;

		}

		/**
		*	Executes Select query on Table
		*   
		*   @param  recipientid
		*	@return matching record
		*/
		function select($RDB_idRecipient) // Implementation 
		{
		   // empty
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

				$sql = "select * from {$this->table} where RDB_idBloodSpec = '{$this->RDB_idBloodSpec}'";
			}
			elseif ($task == 'update')
				{ // Update the database entry and overwrite what's in that record
					$classVars = get_class_vars(get_class($this));
					$sql .= "UPDATE {$this->table} SET ";
					foreach($classVars as $key=>$value)
					{
						if($key == "RDB_idBloodSpec"|| $key == "table") // ignore primary key and the name of leh table
						{
							continue; // skip over table name and primary key
						}

						$sql .= "{$key} = '{$this->$key}', ";

					}
					// strip off comma and space .substr() fro/ those values
					$sql = substr($sql,0,-2)." WHERE RDB_idBloodSpec = '{$this->RDB_idBloodSpec}'"; // update only  the record located at the primary key loaded into this object

				} //UPDATE FUNCTION

			echo $sql;
			return $sql;

		}


	} // class

?>