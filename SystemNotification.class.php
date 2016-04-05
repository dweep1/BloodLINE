<?php	

	/* === CLASS FOR SystemNotifcation OBJECTS === */

	class SystemNotification
	{
		/* === ATTRIBUTES === */

		private $idNotification = null; 
		private $criticalLevel = null; 
		private $timeElapsed = null;
		private $timeInterval = null;

		/* === METHODS === */

		/**
		*	Constructor (Create object and add data to database table)
		*   
		*   @param  record
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
			return "<br> ID: ".$this->idNotification;
		}

		/**
		*	Determines if enough time has elapsed
		*   
		*   @param  timeInterval
		*	@return none
		*/
		function checkTime($timeInterval)
		{
			return "<br> ID: ".$this->idNotification;
		}

		/**
		*	Counts the stock of each blood type
		*   
		*   @param  none
		*	@return none
		*/
		function count_stockBloodType()
		{
			$dbo = database::getInstance(); // pass back that database object already created perhaps
			$sql = "select * from BloodStockView"; // what we want to do (select records)
			$dbo->doQuery($sql); // execute query statement
			$row = $dbo->loadObjectList(); //get list of all returned values as assoc array
			// Array of key value pairs - bloodtype+rhesus --> stock
			foreach ($row as $key=>$value)
			{
				$this->checkStock($value,$key); // check stock of each blood type
			}
		}


		/**
		*	Determines if a blood stock is below the set critical level
		*   
		*   @param  stock,type,RH
		*	@return none
		*/
		function checkStock($stock,$type,$RH)
		{
			if ($stock <= $this->criticalLevel)
			{
				$this->notify_lowStock($type,$RH); // notify users
			}
		}

		/**
		*	Notifies users of low blood stock
		*   
		*   @param  stock,type,RH
		*	@return none
		*/
		function notify_lowStock($stock,$type,$RH)
		{
			// Create pop up using html,css, javascript 
			if (mouseclick = "SHARE")
			{
				$this->notify_socialMedia($type,$RH);
			}
		}


		/**
		*	Notifies the public of low stock and recipients in need
		*   
		*   @param  type,RH
		*	@return none
		*/
		function notify_socialMedia($type,$RH)
		{
			// Create post of low stock type
			// Post to Facebook

			// Get recipients with low type and RH
			$dbo = database::getInstance(); // pass back that database object already created perhaps
			$sql = "select * from Recipient where recipient_bloodGroup = {$type} AND recipient_RH = {$RH} AND recipient_urgencyLevel = 1 "; // what we want to do (select records)
			$dbo->doQuery($sql); // execute query statement
			$row = $dbo->loadObjectList(); //get list of all returned values as assoc array

			//Create post of recipient to Facebook

		}




	} // class

?>