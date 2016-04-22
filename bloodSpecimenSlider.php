<?php 

  /* === DATABASE CONNECTION === */
    include('dbaccess.php');
    /* === START SESSION === */
    session_start();

     
     // Create database object
      $dbo = database::getInstance();
      // Blood Specimen query
      $sql = "SELECT COUNT(idBloodSpecimen)*10 as OCount FROM BloodSpecimen GROUP BY bloodSpec_bloodType = 'O' ";
      // Execute query 
      $dbo->doQuery($sql);
      // Load array
      $O = $dbo->loadObjectList();

       $sql2 = "SELECT COUNT(idBloodSpecimen)*10 as ACount FROM BloodSpecimen GROUP BY bloodSpec_bloodType = 'A' ";
      // Execute query 
      $dbo->doQuery($sql2);
      // Load array
      $A = $dbo->loadObjectList();

       $sql3 = "SELECT COUNT(idBloodSpecimen)*10 as BCount FROM BloodSpecimen GROUP BY bloodSpec_bloodType = 'B' ";
      // Execute query 
      $dbo->doQuery($sql3);
      // Load array
      $B = $dbo->loadObjectList();

       $sql4 = "SELECT COUNT(idBloodSpecimen)*10 as ABCount FROM BloodSpecimen GROUP BY bloodSpec_bloodType = 'AB' ";
      // Execute query 
      $dbo->doQuery($sql4);
      // Load array
      $AB = $dbo->loadObjectList();
      


?>
<!DOCTYPE html>
<html >
  <head>
    
    <meta charset="UTF-8">
    <title>Blood Specimens</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    
    <link rel="stylesheet" href="css/normalizeSlider.css">

    
        <link rel="stylesheet" href="css/styleSlider.css">

       
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.css'>

        <link rel="stylesheet" href="css/styleLevels.css">
    
    
  </head>

  <body>
 

   <!--  <div class='slider-wrap'>
  <div class='slider' id='sliders'>
    <ul>
      <li>
        <div class='item'>
          <div class='avatar'></div>
          <div class='data'>Avatar Name</div>
          <a href='#'>
            <div class='view-profile'>View Profile</div>
          </a>
        </div>
      </li>
      <li>
        <div class='item'>
          <div class='avatar'></div>
          <div class='data'>Avatar Name</div>
          <a href='#'>
            <div class='view-profile'>View Profile</div>
          </a>
        </div>
      </li>
      <li>
        <div class='item'>
          <div class='avatar'></div>
          <div class='data'>Avatar Name</div>
          <a href='#'>
            <div class='view-profile'>View Profile</div>
          </a>
        </div>
      </li>
      <li>
        <div class='item'>
          <div class='avatar'></div>
          <div class='data'>Avatar Name</div>
          <a href='#'>
            <div class='view-profile'>View Profile</div>
          </a>
        </div>
      </li>
      <li>
        <div class='item'>
          <div class='avatar'></div>
          <div class='data'>Avatar Name</div>
          <a href='#'>
            <div class='view-profile'>View Profile</div>
          </a>
        </div>
      </li>
    </ul>
  </div>
  <a class='slider-arrow sa-left' href='#'>
    <i class='fa fa-angle-left'></i>
  </a>
  <a class='slider-arrow sa-right' href='#'>
    <i class='fa fa-angle-right'></i>
  </a> -->
  
    <div class="col-xs-12 col-md-4 col-lg-3">
      <h2>Blood Stock Levels</h2>
      <div class="liquidGauge"><svg class="liquidGauge" id="liquidGaugeLava"></svg><br /><h3>O</h3></div>
      <div class="liquidGauge"><svg class="liquidGauge" id="liquidGaugeWater"></svg><br /><h3>AB</h3></div>
      <div class="liquidGauge"><svg class="liquidGauge" id="liquidGaugeOil"></svg><br /><h3>A</h3></div>
      <div class="liquidGauge"><svg class="liquidGauge" id="liquidGaugeFuel"></svg><br /><h3>B</h3></div>
    </div>
  </div>

  <script src="js/indexLevels.js"></script>
<!--    <script> $(document).ready(function() {
  loadLiquidGauge("liquidGaugeLava",<?php echo $O["OCount"]; ?>, "#f00", 2500);
  loadLiquidGauge("liquidGaugeWater", <?php echo $AB["ABCount"]; ?>, "#00f", 1000);
  loadLiquidGauge("liquidGaugeOil", <?php echo $A["ACount"]; ?>, "#444", 1500);
  loadLiquidGauge("liquidGaugeFuel", <?php echo $B["BCount"]; ?>, "#cb3", 3500, 0.1);
});</script> -->
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://lfox.me/CDN/js/lbSlider/jquery.lbslider.js'></script>
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
        <script src="js/indexSlider.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.js'></script>
<script src='http://d3js.org/d3.v3.min.js'></script>
<script src='http://bl.ocks.org/brattonc/raw/5e5ce9beee483220e2f6/e92e678341ca79fef669ec9bdbc7553845966222/liquidFillGauge.js'></script>
    
  </body>
</html>
