
<!-- Search Results Screen for BloodLINE Website (Lab Tech) -->

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

				