<?php
		/* === CONNECTION === */
		include('dbaccess.php');

		/* === CLASSES === */
		include('UserLogin.control.php');

		session_start(); // Start Session

  		$msg = "";

        if($_SERVER['REQUEST_METHOD'] == 'POST')	
        {
        	 $username = $_POST["username"]; // Get entered username
    		 $password = $_POST["password"]; // Get entered password

    		 if ($username == '' || $password == '') 
    		 {
        		$msg = "You must enter all fields";
        	 } 
        	 else 
        	 {
        	   	// Create userLogin object
        	 	$login = new UserLogin();
        	   	// Authenticate user
        	 	$login_success = $login->login_User($username,$password);
        	 	if (!$login_success)
        	 	{
        	 		// Error
        			$msg = "Username and password do not match";
        		}
        	}
        }

?>

<!-- HomePage for BloodLINE Website -->

<div id="logon">
		<form name="userlogin" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
			<div class="login">
				<div style="color:red;"><?php echo "<b>".$msg."</b>";?></div> <!-- Error Message -->
				<input type="text" placeholder="username" name="username"><br>
				<input type="password" placeholder="password" name="password"><br>
				<input type="submit" value="Login">
				<div style="color:blue;"><a href='#'><br>Forgot Username/Password?</a></div> 
			</div>
		</form>