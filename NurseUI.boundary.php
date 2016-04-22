<?php	
	/* === CLASS FOR NurseUI VIEW === 
	include('Donor.control.php');*/


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
         	$_SESSION["username"] = $this->loggedIn_User;
         	$_SESSION["userType"] = 'N';
         	$_SESSION["userObj"] = serialize($this);
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
			echo "<div class='wrapper' style='height:90%'>
			<div class='container-form'>
				<a href='#' onclick='?> if (isset({$_SESSION["userObj"]})) unserialize({$_SESSION["userObj"]})->manage_BloodDonors(); <?php'<h1>Manage Blood Donors</h1>
				<form name='form' action='<?= {$_SERVER['PHP_SELF']} ?>' method='get'>
					<table id = 'search'>
					<tr></tr><tr><td><button name='addNewRec' id='addNewRec'><a href='addDonorRec.php'>Add New Record</a></button><td></tr><tr></tr>
					<tr></tr><tr><td><button name='updExtgRec' id='updExtgRec'><a href='updateDonorRec.php'>Update Records</a></button><td></tr><tr></tr>
					<tr></tr><tr><td><button name='srchExtgRec' id='srchExtgRec'><a href='searchDonorRec.php'>Search Records</a></button><td></tr><tr></tr>
					</table>
				</form>
			</div> ";
		}

		/**
		*	Interface to manage Recipient records
		*   
		*   @param  none
		*	@return none
		*/
		function manage_BloodRecipients()
		{
			echo "<div class='wrapper' style='height:90%'>
			<div class='container-form'>
				<a href='#' onclick='?> if (isset({$_SESSION["userObj"]})) unserialize({$_SESSION["userObj"]})->manage_BloodRecipients(); <?php'<h1>Manage Blood Donors</h1>
				<form name='form' action='<?= {$_SERVER['PHP_SELF']} ?>' method='get'>
					<table id = 'search2'>
					<tr></tr><tr><td><button name='addNewRec' id='addNewRec2'><a href='addRecipientRec.php'>Add New Record</a></button><td></tr><tr></tr>
					<tr></tr><tr><td><button name='updExtgRec' id='updExtgRec2'><a href='updateRecipientRec.php'>Update Records</a></button><td></tr><tr></tr>
					<tr></tr><tr><td><button name='srchExtgRec' id='srchExtgRec2'><a href='searchRecipientRec.php'>Search Records</a></button><td></tr><tr></tr>
					</table>
				</form>
			</div> ";

		}

		/**
		*	Add Donor record
		*   
		*   @param  none
		*	@return none
		*/
		function add_Donor($data)
		{
			// Create new Donor object
			$donor = new Donor();
			// Add record to database
			$donor->addNew($data);
		}
	}

?>