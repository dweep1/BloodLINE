<?php  
	/* === DATABASE CONNECTION === */
	include('dbaccess.php');

	/* === START SESSION === */
	session_start();
	  
	$msg = ""; 

	if (!empty($_GET['idBloodSpecimen']))
	{
		$id = $_GET["idBloodSpecimen"];
		$pageLink = 'searchResult.php?id='.$id;
		header('Location: '.$pageLink.'');
	}
	elseif (isset($_GET['search_DRec']))
	{
		$id = $_GET["idDonor_TRN"];
		$pageLink = 'searchResult.php?id='.$id;
	header('Location: '.$pageLink.'');
	}
	elseif (isset($_GET['search_RRec']))
	{
		$id = $_GET["idRecipient_TRN"];
		$pageLink = 'searchResult.php?id='.$id;
	header('Location: '.$pageLink.'');
	}

	
?>

<!-- Menu Screen for BloodLINE Website (Lab Tech) -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<title>BloodLINE - Search Records</title>

	<link rel="stylesheet" type="text/css" href="page_design.css">
	<link rel="stylesheet" type="text/css" href="page_layout.css">
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
								if (isset($_SESSION["username"])) {echo $_SESSION["username"]; }
							?>
					    </li>		
						
						<li> <!--Logout --> 
							<a href="index.php">Logout
								<?php 
									if (isset($_SESSION["username"])) {session_destroy(); }// Unset all session variables
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
				<form name="form" action="<?= $_SERVER['PHP_SELF'] ?>" method="get">
					<table id = "search">
						<tr></tr><tr>
							<th></th>
							<th>SEARCH RECORDS</th>
							<th></th>
						</tr><tr></tr>

						<!-- <tr></tr><tr>
							<td>Blood Specimen Records: <input type="text" name="idBloodSpecimen" />
							<button type="submit" name="search_BSRec">Search by ID</button></td>
						</tr><tr></tr> -->
					
						<!-- <tr></tr><tr>
							<td>Donor Records: <input type="text" name="idDonor_TRN" />
							<button type="submit" name="search_DRec">Search by TRN</button></td>
						</tr><tr></tr> -->

						<tr></tr><tr>
							<td>Blood Specimen Records: <input type="text" name="idBloodSpecimen" />
							<button type="submit" onclick="loadBloodSpecimens(<?php echo $id; ?>)" name="search_BSRec">Search by ID</button></td>

							<td>Donor Records: <input type="text" name="idDonor_TRN" />
							<button type="submit" name="search_DRec">Search by TRN</button></td>

							<td>Recipient Records: <input type="text" name="idRecipient_TRN" />
							<button type="submit" name="search_RRec">Search by TRN</button></td>
						</tr><tr></tr>

						<tr></tr><tr>
							<td colspan="2">
								<div style="color:red;">
									<?php echo $msg; ?> <!-- If there are errors, output them as list items -->
    							</div>
    						</td>
						</tr><tr></tr><!--Error Message -->
					</table>
				</form>
			</div>
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
	<!-- <script type="text/javascript" src='BloodLINE.js'></script> -->
</body>

</html>
