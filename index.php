<?php
    /* === DATABASE CONNECTION === */
    include('dbaccess.php');
    /* === START SESSION === */
    session_start();

     // Include UserLogin class
      include('UserLogin.control.php');
      // Create UserLogin object
      $user = new UserLogin();

      $msg = "";

       /* ================== NEW USER PANE ============= */
    
          // Create database object
          $dbo = database::getInstance();
          // Get how many records in UserLogin table
          $sql = "SELECT COUNT(*) as Usercount FROM UserLogin";
          // Execute query 
          $dbo->doQuery($sql);
          // Retrieve row of results
          $row = $dbo->loadObjectList();
          // Generate ID e.g 00000000001
          $num_padded = sprintf("%011d",$row["Usercount"]+1);
          $id = $num_padded;
     
    // Add new user button clicked
    if (isset($_POST["register"]))
    {
       // Get data from new user form
        $fname = $_POST["fname"]; // Get entered first name
        $lname = $_POST["lname"]; // Get entered last name
        $userType = $_POST["userType"]; // Get entered user type
        $password = $_POST["passWord"]; // Get entered password

        //Create username for new user
      $username = $fname . $lname;
      // Create record
      $rec = array($id,$username,$userType,$password);
        // Add user to database
        $user->addNew($rec);
        // Confirmation msg
        $msg = "New user ".$username." successfully added";
     
    }

    /* ================== LOGIN PANE ============= */
    $error = "";
    // Login button clicked
        if (isset($_POST["login"])) 
        {
            $username = $_POST["userName"]; // Get entered username
            $password = $_POST["passWord"]; // Get entered password

            // Authenicate user
            $login = $user->login_User($username,$password); // Redirects to respective dashboards

            if (!$login)
            {
                // Error
                $error = "Username and password do not match";
              
            }

        }

?>


<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Sign-Up/Login Form</title>
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
    
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css"> 
  </head>

  <body>

    <div id="header"> </div>
    <div class="form">
      
      <ul class="tab-group">
        <li class="tab active"><a href="#signup">Register</a></li>
        <li class="tab"><a href="#login">Log In</a></li>
      </ul>
      
      <div class="tab-content">
        <div id="signup">   
          <h1>New User</h1>
          
          <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
          <div class="top-row">
            <div class="field-wrap">
              <label>
                First Name<span class="req">*</span>
              </label>
              <input type="text" required autocomplete="off" name="fname"/>
            </div>
        
            <div class="field-wrap">
              <label>
                Last Name<span class="req">*</span>
              </label>
              <input type="text" required autocomplete="off" name="lname"/>
            </div>
          </div>

          <div class="top-row">
            <div class="field-wrap">
              <label>
              User Type: <span class="req">*</span>
              </label><br /><br />
            </div>

            <div class="field-wrap">
              <label><input class="radio" type="radio" name="userType" value="N"/> 
                Nurse
              </label><br />

              <label><input class="radio" type="radio" name="userType" value="L"/>
                Lab Technician
              </label><br />
            </div>
          </div>

          <div class="field-wrap">
            <label>
              Password<span class="req">*</span>
            </label>
            <input type="password"required autocomplete="off" name="passWord"/>
          </div>

           <p class="forgot"><a href="#"> <?php // If there are msgs, output them 
                echo $msg; 
              ?></a></p>
          <button name="register" type="submit" class="button button-block"/>Register</button>
          </form>
        </div>
       
        
        <div id="login">   
          <h1>Welcome Back!</h1>
          
          <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
          
          <div class="field-wrap">
            <label>
              Username<span class="req">*</span>
            </label>
            <input type="text"required autocomplete="off" name="userName"/>
          </div>

          <div class="field-wrap">
            <label>
              Password<span class="req">*</span>
            </label>
            <input type="password"required autocomplete="off" name="passWord"/>
          </div>
          
         
            <p class="forgot">
              <a href="#"> 
                <?php // If there are errors, output them 
                  echo $error;
                ?>
              </a>
            </p>
      
          
          <button name="login" type="submit" class="button button-block"/>Log In</button>
          
          </form>
        </div>
        
      </div><!-- tab-content -->
      
</div> <!-- /form -->
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

        <script src="js/index.js"></script>

    
    
    
  </body>
</html>
