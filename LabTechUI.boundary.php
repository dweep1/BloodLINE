<?php	
	/* === CLASS FOR LabTechUI VIEW === */

	class LabTechUI 
	{
		/* === ATTRIBUTES === */

		private $loggedIn_User = null;
		

		/* === METHODS === */

		/**
		*	Constructor 
		*   
		*   @param  
		*	@return none
		*/
		 function __construct($user)
		{
			$this->loggedIn_User = $user;

			// Start Session
         	session_start();
			// Assign session variables
         	$_SESSION["username"] = $this->loggedIn_User;
			// Redirect to respective page			
			$pageLink = 'labTechMenu.php';
			header('Location: '.$pageLink.'');
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
		*	Interface to manage Blood Specimen records
		*   
		*   @param  none
		*	@return none
		*/
		function manage_BloodInventory()
		{
			// Add / Update functionality

			// Search / View functionality
		}

		

?>