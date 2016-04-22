<?php

  /* === DATABASE CONNECTION === */
    include('dbaccess.php');
    /* === START SESSION === */
    session_start();

   echo "<!DOCTYPE html>
<html >
  <head>
    <meta charset='UTF-8'>
    <title>Urgent Recipient Cases</title>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    
    <link rel='stylesheet' href='css/normalizeSlider.css'>

    
        <link rel='stylesheet' href='css/styleSlider.css'>

    
    
    
  </head>

  <body>

    <div class='slider-wrap'>
  <div class='slider' id='sliders'>";

    // Create database object
    $dbo = database::getInstance();
    // Get all most urgent recipients
    $sql = "SELECT Person.person_firstName as fname, Person.person_lastName as lname, Person.person_idPicture as pictureID ,recipient_bloodGroup,recipient_RH, recipient_quantityNeeded, recipient_reason, recipient_location,recipient_compatibleWith FROM Recipient JOIN Person ON Recipient.idRecipient_TRN = Person.idPerson_TRN WHERE Recipient.recipient_urgencyLevel = 1";
    // Execute query 
    $dbo->doQuery($sql);
    // Retrieve rows of results
    $row = $dbo->loadObjectList();

  /*foreach ($row as $key=>$value)
      {
        
        echo "{$key}-->{$value}<br>";
      }*/
    // Generate profile for each recipient
    echo "<ul>";
    $i = 0;
    /*foreach ($rows as $row[$i])
    {*/
       echo "<li><div class='item'>
          <div class='avatar' style='background-image: url(".$row['pictureID'].")'></div>
          <div class='data'>Recipient: ".$row['fname']." ".$row['lname']."</br>
                            Blood Type: ".$row['recipient_bloodGroup'].$row['recipient_RH']."</br>
                            Needs: ".$row['recipient_quantityNeeded']."ml of blood </br>
                            Reason: ".$row['recipient_reason']."</br>
                            Hospital Location: ".$row['recipient_location']."</br>
                            CompatibleWith: ".$row['recipient_compatibleWith']."</br>
          </div>
          <a href='http://nbts.gov.jm/collection-centres/'>
            <div class='view-profile'>DONATE!</div>
          </a>
        </div>
      </li>";
   
   // }
    echo "</ul>";

    echo "</div>
  <a class='slider-arrow sa-left' href='#'>
    <i class='fa fa-angle-left'></i>
  </a>
  <a class='slider-arrow sa-right' href='#'>
    <i class='fa fa-angle-right'></i>
  </a>
</div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://lfox.me/CDN/js/lbSlider/jquery.lbslider.js'></script>

        <script src='js/indexSlider.js'></script>

    
    
    
  </body>
</html>
";

?>


  