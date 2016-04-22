
<!-- Search Results Screen for BloodLINE Website (Lab Tech) -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<title>BloodLINE - Search Results</title>

	<link rel="stylesheet" type="text/css" href="page_design.css">
	<link rel="stylesheet" type="text/css" href="page_layout.css">
	<link rel="stylesheet" href="css/normalizeSlider.css">

    
        <link rel="stylesheet" href="css/styleSlider.css">
	<!-- <link rel="stylesheet" type="text/css" href="css/style-hp.css"> -->
	
	<script type="text/javascript" src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	<!--<script> $(document).ready(function(){
				setInterval(function(){
					$("#inbox").load("loadBloodSpecimens.php");
				}, 2000); // AUTO LoAD inbox messages
			}); 
	</script>-->
</head>

<body>
	<div class="page-wrap">

		<div class="header">
			<div class="topbar">
				<label id="label">
					<span>
						<span>Dashboard</span>
					</span>
				</label>
				<div>
					<span>
						<span><img src="logo.png" style="padding-top: 10px"></img></span>
					</span>
				</div>
			</div><!--End top-bar-->
		</div><!--End header-->

		<div id="nav-wrap" >
			<div class="container-fluid">
				<div class="desktop-nav">
					<ul>
						<li>
							<a href="
							<?php 
								if (isset($_SESSION["userType"]))
								{
									// Link to different menu page based on user type
         							if ($_SESSION["userType"] == 'N'){
         								$homeLink = 'labTechMenu.php';
         							}
         							elseif ($_SESSION["userType"] == 'L') {
         								$homeLink = 'nurseMenu.php';
         							}

         							echo $homeLink;
								}
							?>">
								Home
					 		</a>  <!--Home (Redirects to respesctive Main Menu screen based on logged in User's type) -->
						</li>


						<li> <!--UserName -->
							<?php 
								if (isset($_SESSION["username"])) echo $_SESSION["username"]; 
							?>
					    </li>		
						
						<li> <!--Logout --> 
							<a href="index.php">Logout
								<?php 
									if (isset($_SESSION["username"])) session_destroy(); // Unset all session variables
								?>
					 		</a>  
						</li>	
					</ul>
				</div>
			</div>
		</div><!--End nav-wrap-->

		<div class="wrapper" >
			<div class="container-form">
				 <div class='slider-wrap'>
  <div class='slider' id='sliders'>
  					<?php

	 /* === DATABASE CONNECTION === */
	  include('dbaccess.php');
	  /* === START SESSION === */
	  session_start();

    if (isset($_GET["id"]))
    {
      $id = $_GET["id"];
    }
	  // Displays 10 most recent blood specimens
        $pictureID = "http://www.baby-today.ru/wp-content/uploads/2012/11/gemoglobin.jpg";
	  // Create database object
      $dbo = database::getInstance();
      // Blood Specimen query
      $sql = "SELECT * FROM BloodSpecimen WHERE idBloodSpecimen = '{$id}'";
      // Execute query 
      $dbo->doQuery($sql);
      
       // Generate profile for each blood specimen
    echo "<ul>";
  
     // Retrieve rows of results
    while ($row = $dbo->loadObjectList()){
      //echo "<ul>";
  //echo $rec;*/
    
       echo "<li><div class='item'>
          <div class='avatar' style='background-image: url(".$pictureID.")'></div>
          <div class='data'>ID: ".$row['idBloodSpecimen']."</br></br>
                            Blood Type: ".$row['bloodSpec_bloodType'].$row['bloodSpec_RH']."</br></br>
                            Components: ".$row['bloodSpec_componentsInfo']."</br></br>
                            Test Results: ".$row['bloodSpec_testResults']."</br></br>
                            Tested By: ".$row['bloodSpec_testedBy']."</br></br>
                            Date Processed: ".$row['bloodSpec_processDate']."</br></br>
                            Storage Location: ".$row['bloodSpec_storageLocation']."</br></br>
                            Status: ".$row['bloodSpec_status']."</br></br>
  
          </div>
          <a href='addBloodSpecimenRec.php?id=".$row["idBloodSpecimen"]."&type=".$row["bloodSpec_bloodType"]."'>
            <div class='view-profile'>UPDATE</div>
          </a>
        </div>
      </li>";
    //echo "</ul>";
  }
   
   // }
    echo "</ul>";
?>

				</div>
  <!-- <a class='slider-arrow sa-left' href='#'>
    <i class='fa fa-angle-left'></i>
  </a>
  <a class='slider-arrow sa-right' href='#'>
    <i class='fa fa-angle-right'></i>
  </a> -->
 
</div>
			</div><!--End container-form-->

			<ul class="bg-bubbles">
				<li></li><li></li><li></li><li></li><li></li>
				<li></li><li></li><li></li><li></li><li></li>
			</ul>

			<div class="footer-wrap" style="margin-top: 42%">
				<div class="container-fluid">
					<div class="footer">
						<span>&copy; Copyright 2016 | BloodLINE | All rights reserved.</span>
					</div>
				</div>
			</div> <!--End footer-wrap-->
		</div><!--End wrapper-->
	</div><!--End page-wrap-->
	<script type="text/javascript" src='js/index2.js'></script>
	<!-- <script type="text/javascript" src='BloodLINE.js'></script> -->
	<!-- <script src="js/indexSlider.js"></script> -->
</body>

</html>
