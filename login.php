<?php

	 /* === DATABASE CONNECTION === */
	  include('dbaccess.php');
	  /* === START SESSION === */
	  session_start();

	    /* ================== LOGIN PAGE ============= */
        // Include UserLogin class
        include('UserLogin.control.php');
        // Create UserLogin object
        $user = new UserLogin();

        // Get data from login form
        $msg = "";
        // Login button clicked
        if ($_SERVER['REQUEST_METHOD'] == 'POST') 
        {
            $username = $_POST["username"]; // Get entered username
            $password = $_POST["password"]; // Get entered password

            // Authenicate user
            $login = $user->login_User($username,$password); // Redirects to respective dashboards

            if (!$login)
            {
                // Error
                $msg = "Username and password do not match";
            }

        }

 ?>