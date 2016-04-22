<?php

	 /* === DATABASE CONNECTION === */
	  include('dbaccess.php');
	  /* === START SESSION === */
	  session_start();

    if isset($_GET["id"])
    {
      $id = $_GET["id"];
    }
	  // Displays 10 most recent blood specimens
        $pictureID = "http://vignette2.wikia.nocookie.net/badcreepypasta/images/7/77/Pouring-concrete-on-roses-post_(1)-0.jpg/revision/latest?cb=20151216002821";
	  // Create database object
      $dbo = database::getInstance();
      // Blood Specimen query
      $sql = "SELECT * FROM BloodSpecimen WHERE idBloodSpecimen = '{$id}'";
      // Execute query 
      $dbo->doQuery($sql);
      
       // Generate profile for each recipient
    echo "<ul>";
  
     // Retrieve rows of results
    while ($row = $dbo->loadObjectList()){
      //echo "<ul>";
  //echo $rec;*/
    
       echo "<li><div class='item'>
          <div class='avatar' style='background-image: url(".$pictureID.")'></div>
          <div class='data'>ID: ".$row['idBloodSpecimen']."</br></br>
                            Blood Type: ".$row['bloodSpec_bloodType'].$row['bloodSpec_RH']."</br></br>
                            Components: ".$row['bloodSpec_componentsinfo']."</br>
                            Test Results: ".$row['bloodSpec_testResults']."</br>
                            Tested By: ".$row['bloodSpec_testedBy']."</br>
                            Date Processed: ".$row['bloodSpec_processDate']."<br>
                            Storage Location: ".$row['bloodSpec_storageLocation']."</br>
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