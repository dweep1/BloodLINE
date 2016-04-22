<?php 

  /* === DATABASE CONNECTION === */
    include('dbaccess.php');
    /* === START SESSION === */
    session_start();

     include('SystemNotification.class.php');
     $sn = new SystemNotification();

     
     // Create database object
      $dbo = database::getInstance();
      // Blood Specimen query
      $sql = "SELECT COUNT(idBloodSpecimen)*10 as OCount FROM BloodSpecimen GROUP BY bloodSpec_bloodType = 'O' ";
      // Execute query 
      $dbo->doQuery($sql);
      // Load array
      $o = $dbo->loadObjectList();

        $data1 = $sn->checkStock($o["OCount"],'O');

      $sql2 = "SELECT COUNT(idBloodSpecimen)*10 as ACount FROM BloodSpecimen GROUP BY bloodSpec_bloodType = 'A' ";
      // Execute query 
      $dbo->doQuery($sql2);
      // Load array
      $A = $dbo->loadObjectList();

          $data2 = $sn->checkStock($A["ACount"],'A');

       $sql3 = "SELECT COUNT(idBloodSpecimen)*10 as BCount FROM BloodSpecimen GROUP BY bloodSpec_bloodType = 'B' ";
      // Execute query 
      $dbo->doQuery($sql3);
      // Load array
      $B = $dbo->loadObjectList();

          $data3 = $sn->checkStock($B["BCount"],'B');

       $sql4 = "SELECT COUNT(idBloodSpecimen)*10 as ABCount FROM BloodSpecimen GROUP BY bloodSpec_bloodType = 'AB' ";
      // Execute query 
      $dbo->doQuery($sql4);
      // Load array
      $AB = $dbo->loadObjectList();
          $data4 = $sn->checkStock($AB["ABCount"],'AB');


?>
<!DOCTYPE html>
<html >
  <head>
    
    <meta charset="UTF-8">
    <title>Blood Levels</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    

       
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.css'>
      <link rel="stylesheet" href="css/stylePopUp.css">
        <link rel="stylesheet" href="css/styleLevels.css">
         <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script src="js/indexLevels.js"></script>
         <script type="text/javascript">  $('#bubble').show();
  $('#bubble-close').click(function(){
      $('#bubble').hide();
      alert("Blood Stock Low");
    });
  </script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.js'></script>
<script src='http://d3js.org/d3.v3.min.js'></script>
<script src='http://bl.ocks.org/brattonc/raw/5e5ce9beee483220e2f6/e92e678341ca79fef669ec9bdbc7553845966222/liquidFillGauge.js'></script>

<script src="js/indexLevels.js"></script>
         <script type="text/javascript"> 
  $(document).ready(function() {
  loadLiquidGauge("liquidGaugeLava",<?php echo $o["OCount"]; ?>, "#d30000", 2500);
  loadLiquidGauge("liquidGaugeWater", <?php echo $AB["ABCount"]; ?>, "#d30000", 1000);
  loadLiquidGauge("liquidGaugeOil", <?php echo $A["ACount"]; ?>, "#d30000", 1500);
  loadLiquidGauge("liquidGaugeFuel", <?php echo $B["BCount"]; ?>, "#d30000", 3500, 0.1);
});
  </script>
    
    
  </head>

  <body>  


 <!--       <div class='bubble' id='bubble'>
  <a class='bubble-close' id='bubble-close'>x</a> -->
  <h1><p style='text-decoration:blink'>Blood Type <strong><?php echo "O"; ?></strong> stock LOW!</p></h1>
  <!-- <div class='fb-share-button' data-href='http://localhost/BloodLine%20SourceCode/urgentRecipientCases.html#' data-layout='button' data-mobile-iframe='false'></div> -->
<!-- </div> -->
    <div class="col-xs-12 col-md-4 col-lg-3">
  
      <h2>Blood Stock Levels</h2>
      <div class="liquidGauge"><svg class="liquidGauge" id="liquidGaugeLava"></svg><br /><h3>O</h3></div>
      <div class="liquidGauge"><svg class="liquidGauge" id="liquidGaugeWater"></svg><br /><h3>AB</h3></div>
      <div class="liquidGauge"><svg class="liquidGauge" id="liquidGaugeOil"></svg><br /><h3>A</h3></div>
      <div class="liquidGauge"><svg class="liquidGauge" id="liquidGaugeFuel"></svg><br /><h3>B</h3></div>
    </div>
  </div>

   
        
    
  </body>
</html>
