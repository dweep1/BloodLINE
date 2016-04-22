<?php	

	/* === CLASS FOR SystemNotifcation OBJECTS === */

	class SystemNotification
	{
		/* === ATTRIBUTES === */

		private $idNotification = null; 
		private $criticalLevel = 60; 
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
			$this->$timeElapsed = time() - $this->$timeElapsed;
			if ($this->$timeElapsed == $timeInterval)
			{
				$this->count_stockBloodType();
			}
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
			$sql = "SELECT COUNT(idBloodSpecimen) as typeCount, bloodSpec_bloodType as type FROM BloodSpecimen GROUP BY bloodSpec_bloodType"; // what we want to do (select records)
			$dbo->doQuery($sql); // execute query statement
			 while ($row = $dbo->loadObjectList()) //get list of all returned values as assoc array
			// Array of key value pairs - bloodtype+rhesus --> stock
			{
				$this->checkStock($row["typeCount"],$row["type"]); // check stock of each blood type
			}
		}


		/**
		*	Determines if a blood stock is below the set critical level
		*   
		*   @param  stock,type,RH
		*	@return none
		*/
		function checkStock($stock,$type)
		{
			
			if ($stock <= $this->criticalLevel)
			{
				return $this->notify_lowStock($type); // notify users
			}
			else
			{
				return $stock;
			}

		}

		/**
		*	Notifies users of low blood stock
		*   
		*   @param  stock,type,RH
		*	@return none
		*/
		function notify_lowStock($type)
		{
			// Create pop up using html,css, javascript 
		
			$code = array("echo"=>"<div class='bubble' id='bubble'>
  <a class='bubble-close' id='bubble-close'>x</a>
  <p style='text-decoration:blink'>Blood Type <strong>".$type."</strong> stock LOW!</p>".$this->notify_socialMedia($type)["button"]."
</div>");

			return $code;  
		}


		/**
		*	Notifies the public of low stock and recipients in need
		*   
		*   @param  type,RH
		*	@return none
		*/
		function notify_socialMedia($type)
		{
			// Create post of low stock type
			// Post to Facebook

			return array("button"=>"<div class='fb-share-button' data-href='http://localhost/BloodLine%20SourceCode/urgentRecipientCases.html#' data-layout='button' data-mobile-iframe='false'></div>");

		}




	} // class

?>