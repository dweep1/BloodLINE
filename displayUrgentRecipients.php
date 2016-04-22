<?php

  /* === DATABASE CONNECTION === */
    include('dbaccess.php');
    /* === START SESSION === */
    session_start();

    // Include Recipient class
    include('Recipient.class.php');

    // Create database object
    $dbo = database::getInstance();
    // Get all most urgent recipients
    $sql = "SELECT Person.person_firstName as fname, Person.person_lastName as lname, Person.person_idPicture as pictureID ,recipient_bloodGroup,recipient_RH, recipient_quantityNeeded, recipient_reason, recipient_location,recipient_compatibleWith FROM Recipient JOIN Person ON Recipient.idRecipient_TRN = Person.idPerson_TRN WHERE Recipient.recipient_urgencyLevel = 1";
    // Execute query 
    $dbo->doQuery($sql);
   
  /*foreach ($rows as $key=>$value)
      {
        
        echo "{$key}-->{$value}<br>";
      }*/

    // Generate profile for each recipient
    //echo "<ul>";
   
  echo "<ul>";
     // Retrieve rows of results
    while ($row = $dbo->loadObjectList()){

  //echo $rec;*/
    
       echo "<li><div class='item'>
          <div class='avatar' style='background-image: url(".$row['pictureID'].")'></div>
          <div class='data'>Recipient: ".$row['fname']." ".$row['lname']."</br></br>
                            Blood Type: ".$row['recipient_bloodGroup'].$row['recipient_RH']."</br></br>
                            Needs: ".$row['recipient_quantityNeeded']."ml of blood </br></br>
                            Reason: ".$row['recipient_reason']."</br></br>
                            Hospital Location: ".$row['recipient_location']."</br></br>
                            CompatibleWith: ".$row['recipient_compatibleWith']."</br></br>
          </div>
          <a href='http://nbts.gov.jm/collection-centres/'>
            <div class='view-profile'>DONATE!</div>
          </a>
        </div></br>
      </li></br>";
   
  }
  echo "</ul>";
   
   // }
    //echo "</ul>";



?>

