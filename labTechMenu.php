<?php  
	/* === DATABASE CONNECTION === */
	include('dbaccess.php');

	/* === START SESSION === */
	session_start();

	include('SystemNotification.class.php');
     $sn = new SystemNotification();

     $criticalLevel = 50;
     // Create database object
      $dbo = database::getInstance();
      // Blood Specimen query
      $sql = "SELECT COUNT(idBloodSpecimen)*40 as OCount FROM BloodSpecimen  WHERE bloodSpec_bloodType = 'O' GROUP BY bloodSpec_bloodType";
      // Execute query 
      $dbo->doQuery($sql);
      // Load array
      $O = $dbo->loadObjectList();

      $data1 = $sn->checkStock($O["OCount"],'O');
      if($O["OCount"] <= $criticalLevel)
      {
      	 $low = $O["OCount"]; 
      	 $type = 'O';
      }

      $sql2 = "SELECT COUNT(idBloodSpecimen)*40 as ACount FROM BloodSpecimen  WHERE bloodSpec_bloodType = 'A' GROUP BY bloodSpec_bloodType";
      // Execute query 
      $dbo->doQuery($sql2);
      // Load array
      $A = $dbo->loadObjectList();

      $data2 = $sn->checkStock($A["ACount"],'A');
      if($A["ACount"] <= $criticalLevel)
      {
      	 $low = $A["ACount"]; 
      	 $type = 'A';
      }

       $sql3 = "SELECT COUNT(idBloodSpecimen)*40 as BCount FROM BloodSpecimen  WHERE bloodSpec_bloodType = 'B'GROUP BY bloodSpec_bloodType";
      // Execute query 
      $dbo->doQuery($sql3);
      // Load array
      $B = $dbo->loadObjectList();

       $data3 = $sn->checkStock($B["BCount"],'B');
       if($B["BCount"] <= $criticalLevel)
      {
      	 $low = $B["BCount"];
      	 $type = 'B';
      }


       $sql4 = "SELECT COUNT(idBloodSpecimen)*40 as ABCount FROM BloodSpecimen  WHERE bloodSpec_bloodType = 'AB' GROUP BY bloodSpec_bloodType";
      // Execute query 
      $dbo->doQuery($sql4);
      // Load array
      $AB = $dbo->loadObjectList();
      $data4 = $sn->checkStock($AB["ABCount"],'AB');
       if($AB["ABCount"] <= $criticalLevel)
      {
      	 $low = $AB["ABCount"]; 
      	 $type = "AB";
      }
?>

<!-- Menu Screen for BloodLINE Website (Lab Tech) -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>BloodLINE - Lab Tech Menu</title>

	<script type="text/javascript" src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

	<script src="js/indexLevels.js"></script>
	<script type="text/javascript" src='BloodLINE.js'></script>

	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.css'>
    <link rel="stylesheet" type="text/css" href="css/stylePopUp.css">
    <link rel="stylesheet" type="text/css" href="css/styleLevels.css">
    <link rel="stylesheet" type="text/css" href="page_design.css">
	<link rel="stylesheet" type="text/css" href="page_layout.css">
    
    <script type="text/javascript">
     	$(document).ready(function() {
     		$('#bubble').show();
     		$('#bubble-close').click(function() {
     			$('#bubble').hide();
     			alert("Blood Stock Low");
     		});
     	}
  	</script>

	<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.js'></script>
	<script src='http://d3js.org/d3.v3.min.js'></script>
	<script src='http://bl.ocks.org/brattonc/raw/5e5ce9beee483220e2f6/e92e678341ca79fef669ec9bdbc7553845966222/liquidFillGauge.js'></script>

    <script type="text/javascript"> 
  		$(document).ready(function() {
  			loadLiquidGauge("liquidGaugeLava",<?php echo $O["OCount"]; ?>, "#d30000", 2500);
  			loadLiquidGauge("liquidGaugeWater", <?php echo $AB["ABCount"]; ?>, "#d30000", 1000);
  			loadLiquidGauge("liquidGaugeOil", <?php echo $A["ACount"]; ?>, "#d30000", 1500);
  			loadLiquidGauge("liquidGaugeFuel", <?php echo $B["BCount"]; ?>, "#d30000", 3500, 0.1);
		});
  	</script>

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
						<li> <!--UserType -->
							<?php
         							echo "Lab Tech";			
							?>
						</li>

						<li>
							<a href=" 
								<?php 
									if (isset($_SESSION["username"])) echo "labTechMenu.php";
								?>"
							>
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
				<!-- <h1>Blood Specimen</h1> -->
				<form name="form" action="<?= $_SERVER['PHP_SELF'] ?>" method="get">
					<table id = "stock">
						<tr></tr><tr>
							<td><div class="liquidGauge"><svg class="liquidGauge" id="liquidGaugeLava"></svg><br /><h3>O</h3></div></td>
							<td><div class="liquidGauge"><svg class="liquidGauge" id="liquidGaugeWater"></svg><br /><h3>AB</h3></div></td>
							<td><div class="liquidGauge"><svg class="liquidGauge" id="liquidGaugeOil"></svg><br /><h3>A</h3></div></td>
							<td><div class="liquidGauge"><svg class="liquidGauge" id="liquidGaugeFuel"></svg><br /><h3>B</h3></div></td>
						</tr><tr></tr>
					</table>

					<table id = "alert">
						<tr>
							<td style="<?php if (empty($low)) {echo "display:none;";}?> color:red;"><marquee><strong>LOW BLOOD STOCK ALERT!</strong></marquee></td>
							<td style="<?php if (empty($low)) {echo "display:none;";}?> color:red;">Blood Stock <strong><?php echo $type; ?></strong> BELOW CRITICAL LEVEL</td>
						</tr>

						<tr>
							<td style="<?php if (empty($low)) {echo "display:none;";}?>"><button><a href="#" onclick="">Ignore</a></button></td>
							<td style="<?php if (empty($low)) {echo "display:none;";}?>"><button><a href="urgentRecipientCases.html">Share</a></button></td>
						</tr>
					</table>

					<table id = "menu">
						<tr></tr><tr>
							<th>BLOOD SPECIMEN</th>
						</tr><tr></tr>

						<tr></tr><tr>
							<td><button><a href="addBloodSpecimenRec.php?id=BS003&type=B">Update</a></button><td>
						</tr><tr></tr>
						
						<!-- <tr></tr>
						<tr><td><button><a href="#">Update</a></button><td></tr><tr></tr> -->

						<tr></tr><tr>
							<td><button><a href="searchAll.php">Search</a></button><td>
						</tr><tr></tr>
					</table>
				</form>
			</div><!--End container-form-->

			<ul class="bg-bubbles">
				<li></li><li></li><li></li><li></li><li></li>
				<li></li><li></li><li></li><li></li><li></li>
			</ul>

			<div class="footer-wrap" style="margin-top: 12.5%">
				<div class="container-fluid">
					<div class="footer">
						<span>&copy; Copyright 2016 | BloodLINE | All rights reserved.</span>
					</div>
				</div>
			</div> <!--End footer-wrap-->
		</div><!--End wrapper-->
	</div><!--End page-wrap-->
	<script type="text/javascript" src='js/index2.js'></script>
</body>

</html>
