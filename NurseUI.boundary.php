<?php	
	/* === CLASS FOR NurseUI VIEW === */

	class NurseUI 
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
         	$_SESSION["userObj"] = $this;
			// Redirect to respective page			
			$pageLink = 'nurseMenu.php';
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
		*	Interface to manage Donor records
		*   
		*   @param  none
		*	@return none
		*/
		function manage_BloodDonors()
		{
			// Add/update Functionality

			// Search/View functionality
		}

		/**
		*	Interface to manage Recipient records
		*   
		*   @param  none
		*	@return none
		*/
		function manage_BloodRecipients()
		{
			// Add/update Functionality

			// Search/View functionality

		}

		/**
		*	Add Donor record
		*   
		*   @param  none
		*	@return none
		*/
		function add_Donor()
		{
			// Create new Donor object
			$donor = new Donor();
			// Get values to be stored in database
			$data = array();
			// Add record to database
			$donor->addNew($data);
		}

?>