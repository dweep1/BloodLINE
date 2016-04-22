<?php

  /* === DATABASE CONNECTION === */
    include('dbaccess.php');
    /* === START SESSION === */
    session_start();

     /* +++++++++++++++++ Add Person information ++++++++++++++++++++ */
      //include('Person.class.php');

      $msg = "";
      $errors = array();

    
        if($_SERVER['REQUEST_METHOD'] == 'POST')  
        {
          // Get entered fields
          $trn = $_POST['idPerson_TRN'];
          $fname = $_POST['person_firstName'];
          $lname = $_POST['person_lastName'];
          $addr1 = $_POST['person_address1'];
          $addr2 = $_POST['person_address2'];
          $cell = $_POST['q9_cell[area]'].$_POST['q9_cell[phone]'];
          $work = $_POST['q53_work[area]'].$_POST['q53_work[phone]'];
          $home = $_POST['q52_home[area]'].$_POST['q52_home[phone]'];
          $email = $_POST['person_email'];
          $dob = $_POST['q54_dateOf[year]']."-".$_POST['q54_dateOf[month]']."-".$_POST['q54_dateOf[day]'];
          $sex = $_POST['person_sex'];
          $mStatus = $_POST['person_maritalStatus'];
          $mname = $_POST['person_middleName'];

          // Image handling
      $target_dir = "uploads/"; // directory where the file is going to be placed
      $target_file = $target_dir . basename($_FILES["image"]["name"]); // path of the file to be uploaded
      $uploadOk = 1; // flag to detmine if upload is successful
      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION); // file extension of the file

      // Check if image file is a actual image or fake image
      if(isset($_POST["person_idPicture"])) {
          $check = getimagesize($_FILES["image"]["tmp_name"]);
          if($check !== false) {
              $errors[] = "File is an image - " . $check["mime"] . ".";
              $uploadOk = 1;
          } else {
              $errors[] = "File is not an image.";
              $uploadOk = 0;
          }
      }

      // Check file size
      if ($_FILES["image"]["size"] > 500000) {
          $errors[] = "Sorry, your file is too large.";
          $uploadOk = 0;
      }

      // Allow certain file formats
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
          $errors[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
          $uploadOk = 0;
      }

      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
          $errors[] = "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
      } else {
          if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
              $errors[] = "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
              // Store to database, link to file
              $idpic = $target_file;
          } else {
              $errors[] = "Sorry, there was an error uploading your file.";
          }
      }

       // Errors
        if (empty($errors))
        {         
              
            // Get values to be stored in database
            $data = array($trn, $fname, $lname, $addr1, $addr2, $cell, $work, $home, $email, $dob, $sex, $idpic, $mStatus, $mname);
            // store record to session variable
            $_SESSION["person"] = $data;
            
          }
          else
          {
            // If there are errors, output them as list items
                echo "<ul>";
                foreach ($errors as $error){
                  echo "<li>".$error."</li>";}
                echo "</ul>";
              
          }
       
          
        }/* +++++++++++++++ End of Add Person Information +++++++++++++++++++++ */

        /* +++++++++++++++++ Add Medical Record ++++++++++++++++++++++ */

        // Include Donor class
        //include('Donor.control.php');

        $msg = "";

          // Create database object
          $dbo = database::getInstance();
          // Get how many records in medical record table
          $sql = "SELECT COUNT(*) as MRcount FROM MedicalRecord";
          // Execute query 
          $dbo->doQuery($sql);
          // Retrieve row of results
          $row = $dbo->loadObjectList();
          // Generate ID e.g MR001
          $num_padded = sprintf("%03d",$row["MRcount"]+1);
          $id = "MR".$num_padded;

          // Get today's date
          $date = date("Y-m-d");
         

     
    
        if($_SERVER['REQUEST_METHOD'] == 'POST')  
        {
          // Get entered fields
    
          $weight = $_POST['weight'];
          $height = $_POST['height'];
          $bp = $_POST['bp'];
          $temp = $_POST['temp'];
          $ironLevel = $_POST['ironLevel'];
          $time = $_POST['time'];
          $history = $_POST['history'];
          $reason = $_POST['rejectionReason'];
          
          
          // Create new Donor object
            $donor = new Donor();
            // Create Session Object of donor to pass to other pages
            $_SESSION["donorObj"] = $donor;
          // Get values to be stored in database
          $data = array($id, $weight, $height, $bp, $temp, $ironLevel, $time, $date, $history, $reason);
          // Add record to database
          $donor->addMedicalRecord($data);
          // Confirmation message
          $msg = "Medical Record. ".$id." successfully added";

         }/* +++++++++++++ END OF ADD MEDICAL RECORD +++++++++++++++++++++++ */

         /* ++++++++++++++ ADD DONATION RECORD ++++++++++++++++++++++++++++ */
         // Include Donor class
        include('Donor.control.php');
        include('Recipient_DonationRec_BloodSpec.control.php');

        $msg = "";

          // Create database object
          $dbo = database::getInstance();
          // Get how many records in donation record table
          $sql = "SELECT COUNT(*) as DRcount FROM DonationRecord";
          // Execute query 
          $dbo->doQuery($sql);
          // Retrieve row of results
          $row = $dbo->loadObjectList();
          // Generate ID e.g DR001
          $num_padded = sprintf("%03d",$row["DRcount"]+1);
          $id = "DR".$num_padded;

          // Get current user signed in 
          $collectedBy = $_SESSION["username"];
          // Get today's date
          $date = date("Y-m-d");
     
    
        if($_SERVER['REQUEST_METHOD'] == 'POST')  
        {
          // Get entered fields
          $location = $_POST['location'];
          $quantity = $_POST['quantity'];
          $type = $_POST['donortype'];
          $bloodType = $_POST['bloodtype'];
            // If type = Replacement
            if (!empty($_POST['recipient']))
            {
              $recipient = $_POST['recipient'];
            }
            else // type = voluntary
            {
              // Choose random one from DB
              $query = "SELECT idRecipient_TRN FROM Recipient WHERE compatibleWith LIKE '%{$bloodType}%' AND urgencyLevel = 1 AND idRecipient_TRN NOT IN (SELECT RDB_idRecipient FROM Recipient_DonationRec_BloodSpec) ORDER BY RAND() LIMIT 1";
              // Execute query 
            $dbo->doQuery($query);
            // Retrieve row of results
            $row3 = $dbo->loadObjectList();
            // Get recipient id
            $recipient = $row3["idRecipient_TRN"];
            }
          
          // Calculate expiration date *shelf life = 35 days *
          $expiry = date('Y-m-d', strtotime($date. '+ 35 days'));
          
          // Get already created Donor object
            $donor = $_SESSION["donorObj"];
            // Get values to be stored in database
          $data = array($id, $date, $location, $quantity, $type, $collectedBy, $expiry);
          // Add record to database
          $donor->addDonationRecord($data);
          // Confirmation message
          $msg = "Donation Record. ".$id." successfully added";

          /* Create corresponding blood specimen record */
          // Get how many records in blood specimen table
          $sql2 = "SELECT COUNT(*) as BScount FROM BloodSpecimen";
          // Execute query 
          $dbo->doQuery($sql2);
          // Retrieve row of results
          $row2 = $dbo->loadObjectList();
          // Generate ID e.g BS001
          $num_padded2 = sprintf("%03d",$row2["BScount"]+1);
          $id2 = "BS".$num_padded2;
          // Add default data to record
          $rec = array($id2,"components","location","testresult",$bloodType,"testedBy","RH","TO BE TESTED");
          // Create control object
          $rdb = new Recipient_DonationRec_BloodSpec();
          $rdb->addBloodSpecimen($rec);
          // Create RDB record
          $record = array($id,$recipient,$id2);
          // Store RDB record
          $rdb->construct($record);
          // Confirmation message
          $msg = "Blood Specimen Record. ".$id2." successfully added";
         }/* ++++++++++++ END OF ADD DONATION RECORD ++++++++++++++++++++ */

         /* ADD DONOR RECORD */

         // Get session variables
      $nurseUI = $_SESSION["userObj"];
      $personObj = $_SESSION["person"];
      $donorObj = $_SESSION["donorObj"];

      // Create record for donor control table
      array_push($personObj,$donorObj->donor_medicalRec->idMedicalRecord,$donorObj->donor_donationRec->idDonationRecord);

      // Add record to database
      $nurseUI->addDonor($personObj);

      // Confirmation message
        // $msg = "Donor. ".$personObj[0]." successfully added";*/



?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="alternate" type="application/json+oembed" href="https://www.jotform.com/oembed/?format=json&amp;url=http%3A%2F%2Fwww.jotform.com%2Fform%2F61097210605852" title="oEmbed Form"><link rel="alternate" type="text/xml+oembed" href="https://www.jotform.com/oembed/?format=xml&amp;url=http%3A%2F%2Fwww.jotform.com%2Fform%2F61097210605852" title="oEmbed Form">
<meta property="og:title" content="Clone of Donation Record" >
<meta property="og:url" content="http://www.jotform.co/form/61097210605852" >
<meta property="og:description" content="Please click the link to complete this form.">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="HandheldFriendly" content="true" />
<!-- <title>Clone of Donation Record</title> -->
<title>Donor Record</title>
<link href="https://cdn.jotfor.ms/static/formCss.css?3.3.12685" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="https://cdn.jotfor.ms/css/styles/nova.css?3.3.12685" />
<link type="text/css" media="print" rel="stylesheet" href="https://cdn.jotfor.ms/css/printForm.css?3.3.12685" />
<style type="text/css">
    .form-label-left{
        width:180px !important;
    }
    .form-line{
        padding-top:12px;
        padding-bottom:12px;
    }
    .form-label-right{
        width:180px !important;
    }
    body, html{
        margin:0;
        padding:0;
        background:false;
        /*background:#EDBBBB;*/
    }

    .form-all{
        margin:0px auto;
        padding-top:0px;
        width:800px;
        /*background: #EDBBBB;*/
        color:#555 !important;
        font-family:"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Verdana, sans-serif;
        font-size:14px;
    }
    .form-radio-item label, .form-checkbox-item label, .form-grading-label, .form-header{
        color: #555;
    }
</style>

<style type="text/css" id="form-designer-style">
    /* Injected CSS Code */

@font-face {
font-family: 'NexaLight';
src: url('//shots.jotform.com/elton/fonts/NexaLight.eot?') format('eot'),
url('//shots.jotform.com/elton/fonts/NexaLight.otf')  format('opentype'),
url('//shots.jotform.com/elton/fonts/NexaLight.woff') format('woff'),
url('//shots.jotform.com/elton/fonts/NexaLight.ttf')  format('truetype'),
url('//shots.jotform.com/elton/fonts/NexaLight.svg#NexaLight') format('svg');
}@font-face {
font-family: 'NexaBold';
src: url('//shots.jotform.com/elton/fonts/NexaBold.eot?') format('eot'),
url('//shots.jotform.com/elton/fonts/NexaBold.otf')  format('opentype'),
url('//shots.jotform.com/elton/fonts/NexaBold.woff') format('woff'),
url('//shots.jotform.com/elton/fonts/NexaBold.ttf')  format('truetype'),
url('//shots.jotform.com/elton/fonts/NexaBold.svg#NexaBold') format('svg');
}* { -webkit-font-smoothing:antialiased; moz-font-smoothing:antialiased; -ms-font-smoothing:antialiased; -o-font-smoothing:antialiased; font-smoothing:antialiased; }html, body, .form-all, .jotform-form {
height: 98%;
}
.form-all * {
-moz-box-sizing: border-box;
-webkit-box-sizing: border-box;
box-sizing: border-box;
}.form-all{
font-family: 'NexaLight', sans-serif;
position: relative;
height:100%;
}.form-section {
width: 100%;
position: relative;
top: 12%;
}.form-header-group {
background: transparent;
border: none;
padding: 24px 0;
margin: 12px 36px 18px;
border:none;
text-align: center;
}h2.form-header {
font-family: 'NexaBold', sans-serif;
font-size: 48px;
}.form-subHeader {
font-family: 'NexaLight', sans-serif;
border-top: none;
font-size: 22px;
line-height: 0.1em;
}.form-textbox, .form-textarea, .form-dropdown, .form-radio-other-input, .form-checkbox-other-input, .form-captcha input {
font-family: 'NexaLight', sans-serif;
color: #000;
border: 1px solid #C7C7C7;
box-shadow: none;
outline:none;
}.form-line-active{
background: #FFFFE0 !important;
-o-transition:color .4s ease-out, background .2s ease-in;
-ms-transition:color .4s ease-out, background .2s ease-in;
-moz-transition:color .4s ease-out, background .2s ease-in;
-webkit-transition:color .4s ease-out, background .2s ease-in;
transition:color .4s ease-out, background .5s ease-in;
}
.form-line-active input:focus, .form-line-active textarea:focus {
box-shadow:none;
}/*--make first section static--*/
.form-all > ul.form-section:first-child, .form-all > div + div + ul.form-section{
display: block !important;
}/* ...all buttons */
.form-pagebreak-back, .form-pagebreak-next, .form-submit-button, .form-submit-reset, .form-submit-print {
background: #61CA1B !important;
border: 0;
border-radius: 0;
box-shadow: none;
color: #FFF;
text-shadow: none;
text-transform: uppercase;
font-family: NexaLight, verdana;
padding: 8px 12px 4px 12px;
outline:none;
filter:none;
-o-transition:color .2s ease-out, background .2s ease-in;
-ms-transition:color .2s ease-out, background .2s ease-in;
-moz-transition:color .2s ease-out, background .2s ease-in;
-webkit-transition:color .2s ease-out, background .2s ease-in;
/* ...and now override with proper CSS property */
transition:color .2s ease-out, background .5s ease-in;
position: relative;
}.form-pagebreak-back:hover, .form-pagebreak-next:hover, .form-submit-button:hover, .form-submit-reset:hover, .form-submit-print:hover {
background: #438F10 !important;
filter: none;
}
.form-pagebreak-back:active, .form-pagebreak-next:active, .form-submit-button:active, .form-submit-reset:active, .form-submit-print:active{
box-shadow: none;
margin-top: 1px;
filter: none;
}.form-submit-button{
padding: 12px 16px 10px 16px;
font-size: 18px !important;
margin-top: 12px;
}
.form-submit-button:active {
margin-top: 13px;
}button#backToForm, .qq-upload-button {
border: 0;
border-radius: 0;
box-shadow: none;
color: #FFF;
text-shadow: none;
text-transform: uppercase;
font-family: NexaLight, verdana;
outline: none;
filter: none;
}
button#checkButton {
top: 95px;
position: relative;
z-index: 1111;
border-radius: 0;
border: none;
text-shadow: none;
color: #fff;
box-shadow: none;
outline: none;
background: #FF8484 !important;
padding: 10px !important;
position: relative;
left: 88px;
}

#previewContainer #previewButtons {
    margin: 0 auto !important;
    text-align: center;
}
button#backToForm{
background: #FF8484 !important;
}
.qq-upload-button {
background: #FFA84C !important;
padding: 8px 12px 8px 12px;
}
.qq-upload-button:hover{
filter:none;
background: #FFA84C !important;
}
#checkSubmissionList .form-input {
max-width: 400px !important;
}
.check-submission-button{
background: #FF8484 !important;
border: 0 !important;
border-radius: 0 !important;
box-shadow: none !important;
color: #FFF !important;
text-shadow: none !important;
filter: none !important;
outline:none;
position: relative;
text-transform: uppercase;
}
.check-submission-button:hover{
filter:none;
}/* ...colored summary buttons */
#id_1 ul{
list-style-type: none;
}#id_1 ul li{
font-family: 'NexaBold', sans-serif;
width: 40px;
height: 36px;
float: left;
text-align: center;
font-size: 24px;
padding:4px;
font-weight: bold;
color: #fff;
}#id_1 ul li {
background: #f37560;
}
#id_1 ul li+li {
background: #f89e43;
}
#id_1 ul li+li+li {
background: #fed85f;
}
#id_1 ul li+li+li+li {
background: #d3de24;
}
#id_1 ul li+li+li+li+li {
background: #8cc63f;
}
#id_1 ul li+li+li+li+li+li {
background: #72cdda;
}
#id_1 ul li+li+li+li+li+li+li {
background: #4773b9;
}
#id_1 ul li+li+li+li+li+li+li+li {
background: #5a52a3;
}
#id_1 ul li+li+li+li+li+li+li+li+li {
background: #be539f;
}
#id_1 ul li+li+li+li+li+li+li+li+li+li {
background: #ed66a6;
}
#id_1 ul li+li+li+li+li+li+li+li+li+li+li {
background: #f37560;
}
#id_1 ul li+li+li+li+li+li+li+li+li+li+li+li {
background: #f89e43;
}
#id_1 ul li+li+li+li+li+li+li+li+li+li+li+li+li {
background: #fed85f;
}
#id_1 ul li+li+li+li+li+li+li+li+li+li+li+li+li+li {
background: #d3de24;
}
#id_1 ul li+li+li+li+li+li+li+li+li+li+li+li+li+li+li {
background: #8cc63f;
}
#id_1 ul li+li+li+li+li+li+li+li+li+li+li+li+li+li+li+li {
background: #72cdda;
}span.labels {
position: relative;
font-size: 12px;
top: -112px;
left: 21px;
top: -80px9;
left: -6px9;
color: black;
font-family: NexaLight;
font-weight: normal;
-webkit-transform: rotate(330deg);
-moz-transform: rotate(330deg);
-o-transform: rotate(330deg);
-ms-transform: rotate(330deg);
transform: rotate(330deg);
writing-mode: lr-tb;
margin-left: -20px;
display: inline-block;
text-align: left;
width: 180px;
}@media screen and (-ms-high-contrast: active), (-ms-high-contrast: none) {
span.labels {
top: -80px;
left: -6px;
}
}div#text_1 {
display: table;
margin: 0 auto;
}
li#id_1, li#id_46 {
padding: 140px 36px 100px 36px;
}.form-pagebreak {
border-top: none;
background: transparent;
width: 100%;
}
.form-pagebreak-back-container, .form-pagebreak-next-container {
width: 48% !important;
}
.form-pagebreak-back-container{
}.form-pagebreak-back-container button {
float: right;
}
.form-pagebreak-next-container button {
float: left;
}button#form-pagebreak-next_4 {
margin-left: -34px;
}.form-line {
margin: 0 auto;
width: 100%;
padding: 12px 160px;
}/*----black dots-----*/
.form-header:before,.form-header:after  {
content: " ";
height: 25px;
width: 25px;
/*background: #000;*/
background: #d30000;
position: absolute;
}
.form-header:before  {
margin-left: -44px;
margin-top: 18px;
}
.form-header:after  {
margin-left: 16px;
margin-top: 18px;
}/*----progress bar-----*/
.progressbar-control {
position: relative !important;
top: 0 !important;
left: 0 !important;
padding: 0 !important;
border-radius: 0 !important;
border: 1px solid #FFFFFF !important;
background: #F7F7F7 !important;
}.progressbar-control .item-bar {
border-radius: 0 !important;
top: 0px !important;
height: 100% !important;
padding: 0px !important;
margin: 0 !important;
}
.progressbar-control .item-bar.blue {
border: none;
background: rgb(0, 235, 0);
}
.progressBarContainer > div {
margin: 0 auto;
font-family: NexaLight, verdana;
}
.progressBarSubtitle {
padding: 3px;
width: 100%;
text-align: center;
}
.progressBarContainer.fixed {
position: fixed !important;
top: 0 !important;
background: #FFF !important;
left: 0 !important;
padding: 0 !important;
}
div#progressBarWidget {
width: 100% !important;
height: 8px !important;
}
.progressBarContainer {
width: 100% !important;
height: 45px !important;
}.progressbar-control .item-bar.blue{
border: none !important;
background: #00EB00 !important;
}
button#form-pagebreak-back_4 {
display: block !important;
}li#id_45 {
height: 0;
}
div#checkSubmission {
padding-top: 70px;
position:relative;
z-index:1;
}
/*---mobile----*/
@media only screen and (max-width:40em){
span.labels{
display: none;
}
li#id_1, li#id_1 ul {
padding-bottom: 0 !important;
padding-top: 30px !important;
}
.form-all {
width: 90%;
}
.form-pagebreak {margin: 0;}
.form-section {
top: 0;
}
div#progressBarWidget {
height: 20px !important;
}
.form-subHeader {
font-size: 18px;
line-height: 1.1em;
}
h2.form-header {
font-size: 34px;
line-height: 1em;
}
button#form-pagebreak-next_4 {
margin-left: -30px;
}
.form-line, .form-line.form-line-column {
width: 96%;
}
ul#checkSubmissionList {
padding: 0;
}
#checkSubmissionList .form-input {
max-width: 100% !important;
}
button#checkButton {
width: 100%;
left: 0;
}
li#id_45 {
height: auto;
}
.form-header:after, .form-header:before{
display:none;
}
.form-section{
overflow-x:hidden;
}
}.progressjs-progress {
width: 100% !important;
height: 4px !important;
background: transparent  !important;
}
.progressjs-inner {
background: #61CA1B !important;
}
.form-pagebreak {
position: relative;
z-index: 11;
}
button#checkButton {
top: 71px;
position:relative;
z-index: 1111;
}
#stage li#id_45 {
height: auto;
}
li#id_47, li#id_50 {
display: none;
}
#checkSubmission div#previewContainer ul li.html {
display: none;
}
    /* Injected CSS Code */
</style>

<script src="https://cdn.jotfor.ms/file-uploader/fileuploader.js?v=3.3.12685"></script>
<script src="https://cdn.jotfor.ms/static/prototype.forms.js" type="text/javascript"></script>
<script src="https://cdn.jotfor.ms/static/jotform.forms.js?3.3.12685" type="text/javascript"></script>
<script src="https://js.jotform.com/vendor/postMessage.js?3.3.12685" type="text/javascript"></script>
<script src="https://js.jotform.com/WidgetsServer.js" type="text/javascript"></script>
<script type="text/javascript">
   JotForm.setConditions([{"action":[{"id":"action_0_1461107950697","visibility":"Hide","isError":false,"field":"81"}],"id":"1461107786715","index":"0","link":"Any","priority":"0","terms":[{"id":"term_0_1461107950697","field":"77","operator":"equals","value":"Voluntary","isError":false}],"type":"field"}]);
   JotForm.init(function(){
      JotForm.calendarMonths = ["January","February","March","April","May","June","July","August","September","October","November","December"];
      JotForm.calendarDays = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];
      JotForm.calendarOther = {"today":"Today"};
      JotForm.setCalendar("54", false, false);
      setTimeout(function() {
          $('input_71').hint(' Street # & Name/Apt #');
       }, 20);
      setTimeout(function() {
          $('input_72').hint('City &/ Parish');
       }, 20);
      setTimeout(function() {
          $('input_7').hint('ex: myname@example.com');
       }, 20);
      setTimeout(function() {
          $('input_82').hint('180.5');
       }, 20);
      setTimeout(function() {
          $('input_18').hint('5.5');
       }, 20);
      setTimeout(function() {
          $('input_24').hint('120/80');
       }, 20);
      setTimeout(function() {
          $('input_61').hint(' 97.8');
       }, 20);
      setTimeout(function() {
          $('input_60').hint(' 13.5');
       }, 20);
      JotForm.setCustomHint( 'input_88', 'None' );
      setTimeout(function() {
          $('input_56').hint('350.5');
       }, 20);
      JotForm.setCustomHint( 'input_89', 'None' );
	JotForm.clearFieldOnHide="disable";
      setTimeout(function() {
          JotForm.initMultipleUploads();
      }, 2);
	JotForm.onSubmissionError="jumpToFirstError";
   });
</script>
</head>
<body>
<!-- <form class="jotform-form" action="https://submit.jotform.co/submit/61097210605852/" method="post" enctype="multipart/form-data" name="form_61097210605852" id="61097210605852" accept-charset="utf-8"> -->
<form class="jotform-form" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" name="form_61097210605852" id="61097210605852" accept-charset="utf-8">
  <input type="hidden" name="formID" value="61097210605852" />
  <div class="form-all">
    <ul class="form-section page-section">
      <li id="cid_3" class="form-input-wide" data-type="control_head">
        <div class="form-header-group">
          <div class="header-text httac htvam">
            <h2 id="header_3" class="form-header">
              Donor Record
            </h2>
          </div>
        </div>
      </li>
      <li class="form-line" data-type="control_text" id="id_1">
        <div id="cid_1" class="form-input-wide">
          <div id="text_1" class="form-html">
            <ul>
              <li>
                1 
                <span class="labels">
                  Personal Information
                </span>
              </li>
              <li>
                2 
                <span class="labels">
                  Medical Information
                </span>
              </li>
              <li>
                3 
                <span class="labels">
                  Donation Information
                </span>
              </li>
            </ul>
          </div>
        </div>
      </li>
      <li id="cid_14" class="form-input-wide" data-type="control_pagebreak">
        <div class="form-pagebreak">
          <div class="form-pagebreak-back-container">
            <button type="button" class="form-pagebreak-back " id="form-pagebreak-back_14">
              Back
            </button>
          </div>
          <div class="form-pagebreak-next-container">
            <button type="button" class="form-pagebreak-next " id="form-pagebreak-next_14">
              Next
            </button>
          </div>
        </div>
      </li>
    </ul>
    <ul class="form-section page-section" style="display:none;">
      <li class="form-line" data-type="control_text" id="id_75">
        <div id="cid_75" class="form-input-wide">
          <div id="text_75" class="form-html">
            <p style="text-align:center;"><strong>Donor Record - Personal Information</strong></p>
          </div>
        </div>
      </li>
      <li class="form-line jf-required" data-type="control_textbox" id="id_10">
        <label class="form-label form-label-right form-label-auto" id="label_10" for="input_10">
          TRN
          <span class="form-required">
            *
          </span>
        </label>
        <div id="cid_10" class="form-input jf-required">
          <!-- <input type="text" class=" form-textbox validate[required]" data-type="input-textbox" id="input_10" name="q10_trn" size="20" value="" /> -->
          <input type="text" class=" form-textbox validate[required]" data-type="input-textbox" id="input_10" name="idPerson_TRN" size="20" value="" />
        </div>
      </li>
      <li class="form-line jf-required" data-type="control_fullname" id="id_5">
        <label class="form-label form-label-right form-label-auto" id="label_5" for="input_5">
          First &amp; Last Name(s)
          <span class="form-required">
            *
          </span>
        </label>
        <div id="cid_5" class="form-input jf-required">
          <span class="form-sub-label-container" style="vertical-align: top">
            <!-- <input class="form-textbox validate[required]" type="text" size="10" name="q5_firstamp[first]" id="first_5" /> -->
            <input class="form-textbox validate[required]" type="text" size="10" name="person_firstName" id="first_5" />
            <label class="form-sub-label" for="first_5" id="sublabel_first" style="min-height: 13px;"> First Name </label>
          </span>
          <span class="form-sub-label-container" style="vertical-align: top">
            <!-- <input class="form-textbox validate[required]" type="text" size="15" name="q5_firstamp[last]" id="last_5" /> -->
             <input class="form-textbox validate[required]" type="text" size="15" name="person_lastName" id="last_5" />
            <label class="form-sub-label" for="last_5" id="sublabel_last" style="min-height: 13px;"> Last Name </label>
          </span>
        </div>
      </li>
      <li class="form-line" data-type="control_textbox" id="id_73">
        <label class="form-label form-label-right form-label-auto" id="label_73" for="input_73"> Middle Name(s) </label>
        <div id="cid_73" class="form-input jf-required">
         <!--  <input type="text" class=" form-textbox" data-type="input-textbox" id="input_73" name="q73_middleNames" size="20" value="" /> -->
         <input type="text" class=" form-textbox" data-type="input-textbox" id="input_73" name="person_middleName" size="20" value="" />
        </div>
      </li>
      <li class="form-line" data-type="control_dropdown" id="id_74">
        <label class="form-label form-label-right form-label-auto" id="label_74" for="input_74"> Marital Status </label>
        <div id="cid_74" class="form-input jf-required">
          <!-- <select class="form-dropdown" style="width:150px" id="input_74" name="q74_maritalStatus"> -->
          <select class="form-dropdown" style="width:150px" id="input_74" name="person_maritalStatus">
            <option value="">  </option>
            <option value="Single" selected="selected"> Single </option>
            <option value="Married"> Married </option>
            <option value="Divorced"> Divorced </option>
            <option value="Widowed"> Widowed </option>
          </select>
        </div>
      </li>
      <li class="form-line jf-required" data-type="control_datetime" id="id_54">
        <label class="form-label form-label-right form-label-auto" id="label_54" for="input_54">
          Date of Birth
          <span class="form-required">
            *
          </span>
        </label>
        <div id="cid_54" class="form-input jf-required">
          <span class="form-sub-label-container" style="vertical-align: top">
           <!--  <input class="form-textbox validate[required]" id="month_54" name="q54_dateOf[month]" type="tel" size="2" maxlength="2" value="" /> -->
           <input class="form-textbox validate[required]" id="month_54" name="q54_dateOf[month]" type="tel" size="2" maxlength="2" value="" />
            <span class="date-separate">
              &nbsp;-
            </span>
            <label class="form-sub-label" for="month_54" id="sublabel_month" style="min-height: 13px;"> Month </label>
          </span>
          <span class="form-sub-label-container" style="vertical-align: top">
            <!-- <input class="form-textbox validate[required]" id="day_54" name="q54_dateOf[day]" type="tel" size="2" maxlength="2" value="" /> -->
            <input class="form-textbox validate[required]" id="day_54" name="q54_dateOf[day]" type="tel" size="2" maxlength="2" value="" />
            <span class="date-separate">
              &nbsp;-
            </span>
            <label class="form-sub-label" for="day_54" id="sublabel_day" style="min-height: 13px;"> Day </label>
          </span>
          <span class="form-sub-label-container" style="vertical-align: top">
            <!-- <input class="form-textbox validate[required]" id="year_54" name="q54_dateOf[year]" type="tel" size="4" maxlength="4" value="" /> -->
            <input class="form-textbox validate[required]" id="year_54" name="q54_dateOf[year]" type="tel" size="4" maxlength="4" value="" />
            <label class="form-sub-label" for="year_54" id="sublabel_year" style="min-height: 13px;"> Year </label>
          </span>
          <span class="form-sub-label-container" style="vertical-align: top">
            <img class="showAutoCalendar" alt="Pick a Date" id="input_54_pick" src="https://cdn.jotfor.ms/images/calendar.png" align="absmiddle" />
            <label class="form-sub-label" for="input_54_pick" style="min-height: 13px;">  </label>
          </span>
        </div>
      </li>
      <li class="form-line" data-type="control_radio" id="id_80">
        <label class="form-label form-label-right form-label-auto" id="label_80" for="input_80"> Gender </label>
        <div id="cid_80" class="form-input jf-required">
          <div class="form-single-column">
            <span class="form-radio-item" style="clear:left;">
              <span class="dragger-item">
              </span>
              <!-- <input type="radio" class="form-radio" id="input_80_0" name="q80_gender" value="Female" /> -->
              <input type="radio" class="form-radio" id="input_80_0" name="person_sex" value="Female" />
              <label id="label_input_80_0" for="input_80_0"> Female </label>
            </span>
            <span class="form-radio-item" style="clear:left;">
              <span class="dragger-item">
              </span>
              <!-- <input type="radio" class="form-radio" id="input_80_1" name="q80_gender" value="Male" /> -->
              <input type="radio" class="form-radio" id="input_80_1" name="person_sex" value="Male" />
              <label id="label_input_80_1" for="input_80_1"> Male </label>
            </span>
            <span class="form-radio-item" style="clear:left;">
              <span class="dragger-item">
              </span>
              <!-- <input type="radio" class="form-radio" id="input_80_2" name="q80_gender" value="Other" /> -->
              <input type="radio" class="form-radio" id="input_80_2" name="person_sex" value="Other" checked="checked" /> 
              <label id="label_input_80_2" for="input_80_2"> Other </label>
            </span>
          </div>
        </div>
      </li>
      <li class="form-line jf-required" data-type="control_textbox" id="id_71">
        <label class="form-label form-label-right form-label-auto" id="label_71" for="input_71">
          Address 1
          <span class="form-required">
            *
          </span>
        </label>
        <div id="cid_71" class="form-input jf-required">
          <!-- <input type="text" class=" form-textbox validate[required]" data-type="input-textbox" id="input_71" name="q71_address171" size="20" value="" /> -->
          <input type="text" class=" form-textbox validate[required]" data-type="input-textbox" id="input_71" name="person_address1" size="20" value="" /> 
        </div>
      </li>
      <li class="form-line jf-required" data-type="control_textbox" id="id_72">
        <label class="form-label form-label-right form-label-auto" id="label_72" for="input_72">
          Address 2
          <span class="form-required">
            *
          </span>
        </label>
        <div id="cid_72" class="form-input jf-required">
          <!-- <input type="text" class=" form-textbox validate[required]" data-type="input-textbox" id="input_72" name="q72_address2" size="20" value="" /> -->
          <input type="text" class=" form-textbox validate[required]" data-type="input-textbox" id="input_72" name="person_address2" size="20" value="" />
        </div>
      </li>
      <li class="form-line jf-required" data-type="control_phone" id="id_9">
        <label class="form-label form-label-right form-label-auto" id="label_9" for="input_9">
          Cell
          <span class="form-required">
            *
          </span>
        </label>
        <div id="cid_9" class="form-input jf-required">
          <span class="form-sub-label-container" style="vertical-align: top">
           <!--  <input class="form-textbox validate[required]" type="tel" name="q9_cell[area]" id="input_9_area" size="3"> -->
           <input class="form-textbox validate[required]" type="tel" name="q9_cell[area]" id="input_9_area" size="3">
            <span class="phone-separate">
              &nbsp;-
            </span>
            <label class="form-sub-label" for="input_9_area" id="sublabel_area" style="min-height: 13px;"> Area Code </label>
          </span>
          <span class="form-sub-label-container" style="vertical-align: top">
            <!-- <input class="form-textbox validate[required]" type="tel" name="q9_cell[phone]" id="input_9_phone" size="8"> -->
            <input class="form-textbox validate[required]" type="tel" name="q9_cell[phone]" id="input_9_phone" size="8">
            <label class="form-sub-label" for="input_9_phone" id="sublabel_phone" style="min-height: 13px;"> Phone Number </label>
          </span>
        </div>
      </li>
      <li class="form-line jf-required" data-type="control_phone" id="id_53">
        <label class="form-label form-label-right form-label-auto" id="label_53" for="input_53">
          Work
          <span class="form-required">
            *
          </span>
        </label>
        <div id="cid_53" class="form-input jf-required">
          <span class="form-sub-label-container" style="vertical-align: top">
            <!-- <input class="form-textbox validate[required]" type="tel" name="q53_work[area]" id="input_53_area" size="3"> -->
            <input class="form-textbox validate[required]" type="tel" name="q53_work[area]" id="input_53_area" size="3">
            <span class="phone-separate">
              &nbsp;-
            </span>
            <label class="form-sub-label" for="input_53_area" id="sublabel_area" style="min-height: 13px;"> Area Code </label>
          </span>
          <span class="form-sub-label-container" style="vertical-align: top">
            <!-- <input class="form-textbox validate[required]" type="tel" name="q53_work[phone]" id="input_53_phone" size="8"> -->
            <input class="form-textbox validate[required]" type="tel" name="q53_work[phone]" id="input_53_phone" size="8">
            <label class="form-sub-label" for="input_53_phone" id="sublabel_phone" style="min-height: 13px;"> Phone Number </label>
          </span>
        </div>
      </li>
      <li class="form-line jf-required" data-type="control_phone" id="id_52">
        <label class="form-label form-label-right form-label-auto" id="label_52" for="input_52">
          Home
          <span class="form-required">
            *
          </span>
        </label>
        <div id="cid_52" class="form-input jf-required">
          <span class="form-sub-label-container" style="vertical-align: top">
            <!-- <input class="form-textbox validate[required]" type="tel" name="q52_home[area]" id="input_52_area" size="3"> -->
            <input class="form-textbox validate[required]" type="tel" name="q52_home[area]" id="input_52_area" size="3">
            <span class="phone-separate">
              &nbsp;-
            </span>
            <label class="form-sub-label" for="input_52_area" id="sublabel_area" style="min-height: 13px;"> Area Code </label>
          </span>
          <span class="form-sub-label-container" style="vertical-align: top">
            <!-- <input class="form-textbox validate[required]" type="tel" name="q52_home[phone]" id="input_52_phone" size="8"> -->
            <input class="form-textbox validate[required]" type="tel" name="q52_home[phone]" id="input_52_phone" size="8">
            <label class="form-sub-label" for="input_52_phone" id="sublabel_phone" style="min-height: 13px;"> Phone Number </label>
          </span>
        </div>
      </li>
      <li class="form-line jf-required" data-type="control_email" id="id_7">
        <label class="form-label form-label-right form-label-auto" id="label_7" for="input_7">
          E-mail
          <span class="form-required">
            *
          </span>
        </label>
        <div id="cid_7" class="form-input jf-required">
          <!-- <input type="email" class=" form-textbox validate[required, Email]" id="input_7" name="q7_email7" size="30" value="" /> -->
          <input type="email" class=" form-textbox validate[required, Email]" id="input_7" name="person_email" size="30" value="" />
        </div>
      </li>
      <li class="form-line" data-type="control_fileupload" id="id_29">
        <label class="form-label form-label-right form-label-auto" id="label_29" for="input_29"> Picture ID </label>
        <div id="cid_29" class="form-input jf-required">
          <div class="qq-uploader-buttonText-value">
            Upload a File
          </div>
          <!-- <input class="form-upload-multiple" type="file" id="input_29" name="q29_pictureId[]" multiple="multiple" file-accept="pdf, doc, docx, xls, xlsx, csv, txt, rtf, html, zip, mp3, wma, mpg, flv, avi, jpg, jpeg, png, gif" file-maxsize="1024" file-minsize="0" file-limit="0" /> -->
          <input class="form-upload-multiple" type="file" id="input_29" name="person_idPicture" multiple="multiple" file-accept="jpg, jpeg, png, gif" file-maxsize="1024" file-minsize="0" file-limit="0" />
        </div>
      </li>
      <li id="cid_69" class="form-input-wide" data-type="control_pagebreak">
        <div class="form-pagebreak">
          <div class="form-pagebreak-back-container">
            <button type="button" class="form-pagebreak-back " id="form-pagebreak-back_69">
              Back
            </button>
          </div>
          <div class="form-pagebreak-next-container">
            <button type="button" class="form-pagebreak-next " id="form-pagebreak-next_69">
              Next
            </button>
          </div>
        </div>
      </li>
    </ul>
    <ul class="form-section page-section" style="display:none;">
      <li class="form-line" data-type="control_text" id="id_78">
        <div id="cid_78" class="form-input-wide">
          <div id="text_78" class="form-html">
            <p style="text-align:center;"><strong>Donor Record - Medical Information</strong></p>
          </div>
        </div>
      </li>
      <li class="form-line" data-type="control_textbox" id="id_83">
        <label class="form-label form-label-right form-label-auto" id="label_83" for="input_83"> Medical Record ID </label>
        <div id="cid_83" class="form-input jf-required">
         <!--  <input type="text" class=" form-textbox" data-type="input-textbox" id="input_83" name="q83_medicalRecord83" size="20" value="" /> -->
         <input type="text" class=" form-textbox" data-type="input-textbox" id="input_83" name="idMedicalRecord" size="20" value="" />
        </div>
      </li>
      <li class="form-line jf-required" data-type="control_textbox" id="id_82">
        <label class="form-label form-label-right form-label-auto" id="label_82" for="input_82">
          Weight (lbs)
          <span class="form-required">
            *
          </span>
        </label>
        <div id="cid_82" class="form-input jf-required">
         <!--  <input type="text" class=" form-textbox validate[required]" data-type="input-textbox" id="input_82" name="q82_weightlbs82" size="20" value="" /> -->
         <input type="text" class=" form-textbox validate[required]" data-type="input-textbox" id="input_82" name="medicalRec_weight" size="20" value="" />
        </div>
      </li>
      <li class="form-line jf-required" data-type="control_textbox" id="id_18">
        <label class="form-label form-label-right form-label-auto" id="label_18" for="input_18">
          Height (ft.in)
          <span class="form-required">
            *
          </span>
        </label>
        <div id="cid_18" class="form-input jf-required">
          <!-- <input type="text" class=" form-textbox validate[required]" data-type="input-textbox" id="input_18" name="q18_heightftin" size="20" value="" /> -->
          <input type="text" class=" form-textbox validate[required]" data-type="input-textbox" id="input_18" name="medicalRec_height" size="20" value="" />
        </div>
      </li>
      <li class="form-line jf-required" data-type="control_textbox" id="id_24">
        <label class="form-label form-label-right form-label-auto" id="label_24" for="input_24">
          Blood Pressure (mmHg)
          <span class="form-required">
            *
          </span>
        </label>
        <div id="cid_24" class="form-input jf-required">
          <!-- <input type="text" class=" form-textbox validate[required]" data-type="input-textbox" id="input_24" name="q24_bloodPressure" size="20" value="" /> -->
          <input type="text" class=" form-textbox validate[required]" data-type="input-textbox" id="input_24" name="medicalRec_bloodPressure" size="20" value="" />
        </div>
      </li>
      <li class="form-line jf-required" data-type="control_textbox" id="id_61">
        <label class="form-label form-label-right form-label-auto" id="label_61" for="input_61">
          Temperature (FAH)
          <span class="form-required">
            *
          </span>
        </label>
        <div id="cid_61" class="form-input jf-required">
          <!-- <input type="text" class=" form-textbox validate[required]" data-type="input-textbox" id="input_61" name="q61_temperaturefah" size="20" value="" /> -->
          <input type="text" class=" form-textbox validate[required]" data-type="input-textbox" id="input_61" name="medicalRec_temperature" size="20" value="" />
        </div>
      </li>
      <li class="form-line jf-required" data-type="control_textbox" id="id_60">
        <label class="form-label form-label-right form-label-auto" id="label_60" for="input_60">
          Iron Level (mcg/dL)
          <span class="form-required">
            *
          </span>
        </label>
        <div id="cid_60" class="form-input jf-required">
          <!-- <input type="text" class=" form-textbox validate[required]" data-type="input-textbox" id="input_60" name="q60_ironLevel" size="20" value="" /> -->
          <input type="text" class=" form-textbox validate[required]" data-type="input-textbox" id="input_60" name="medicalRec_bloodIronLevel" size="20" value="" />
        </div>
      </li>
      <li class="form-line" data-type="control_textbox" id="id_86">
        <label class="form-label form-label-right form-label-auto" id="label_86" for="input_86"> Date Exam </label>
        <div id="cid_86" class="form-input jf-required">
          <!-- <input type="text" class=" form-textbox" data-type="input-textbox" id="input_86" name="q86_dateExam86" size="20" value="" /> -->
          <input type="text" class=" form-textbox" data-type="input-textbox" id="input_86" name="medicalRec_date" size="20" value="" />
        </div>
      </li>
      <li class="form-line jf-required" data-type="control_time" id="id_64">
        <label class="form-label form-label-right form-label-auto" id="label_64" for="input_64">
          Time
          <span class="form-required">
            *
          </span>
        </label>
        <div id="cid_64" class="form-input jf-required">
          <span class="form-sub-label-container" style="vertical-align: top">
            <!-- <select class="time-dropdown form-dropdown validate[required]" id="input_64_hourSelect" name="q64_time64[hourSelect]"> -->
            <select class="time-dropdown form-dropdown validate[required]" id="input_64_hourSelect" name="q64_time64[hourSelect]">
              <option>  </option>
              <option value="1"> 1 </option>
              <option value="2"> 2 </option>
              <option value="3"> 3 </option>
              <option value="4"> 4 </option>
              <option value="5"> 5 </option>
              <option value="6"> 6 </option>
              <option value="7"> 7 </option>
              <option value="8"> 8 </option>
              <option value="9"> 9 </option>
              <option value="10"> 10 </option>
              <option value="11"> 11 </option>
              <option value="12"> 12 </option>
            </select>
            <span class="date-separate">
              &nbsp;:
            </span>
            <label class="form-sub-label" for="input_64_hourSelect" id="sublabel_hour" style="min-height: 13px;"> Hour </label>
          </span>
          <span class="form-sub-label-container" style="vertical-align: top">
            <!-- <select class="time-dropdown form-dropdown validate[required]" id="input_64_minuteSelect" name="q64_time64[minuteSelect]"> -->
            <select class="time-dropdown form-dropdown validate[required]" id="input_64_minuteSelect" name="q64_time64[minuteSelect]">
              <option>  </option>
              <option value="00"> 00 </option>
              <option value="10"> 10 </option>
              <option value="20"> 20 </option>
              <option value="30"> 30 </option>
              <option value="40"> 40 </option>
              <option value="50"> 50 </option>
            </select>
            <label class="form-sub-label" for="input_64_minuteSelect" id="sublabel_minutes" style="min-height: 13px;"> Minutes </label>
          </span>
          <span class="form-sub-label-container" style="vertical-align: top">
            <!-- <select class="time-dropdown form-dropdown validate[required]" id="input_64_ampm" name="q64_time64[ampm]"> -->
            <select class="time-dropdown form-dropdown validate[required]" id="input_64_ampm" name="q64_time64[ampm]">
              <option value="AM"> AM </option>
              <option value="PM"> PM </option>
            </select>
            <label class="form-sub-label" for="input_64_ampm" style="min-height: 13px;">  </label>
          </span>
        </div>
      </li>
      <li class="form-line form-line-column form-col-1 jf-required" data-type="control_textarea" id="id_88">
        <label class="form-label form-label-left" id="label_88" for="input_88">
          Medical History
          <span class="form-required">
            *
          </span>
        </label>
        <div id="cid_88" class="form-input jf-required">
          <!-- <textarea id="input_88" class="form-textarea validate[required]" name="q88_medicalHistory" cols="40" rows="6"></textarea> -->
          <textarea id="input_88" class="form-textarea validate[required]" name="medicalRec_medicalHistory" cols="40" rows="6"></textarea>
        </div>
      <li class="form-line form-line-column form-col-1 jf-required" data-type="control_textarea" id="id_89">
        <label class="form-label form-label-left" id="label_89" for="input_89">
          Rejection Reason
          <span class="form-required">
            *
          </span>
        </label>
        <div id="cid_89" class="form-input jf-required">
          <!-- <textarea id="input_89" class="form-textarea validate[required]" name="q89_rejectionReason89" cols="40" rows="6"></textarea> -->
          <textarea id="input_89" class="form-textarea validate[required]" name="medicalRec_rejectionReason" cols="40" rows="6"></textarea>
        </div>
      </li>
      </li>
      <li id="cid_30" class="form-input-wide" data-type="control_pagebreak">
        <div class="form-pagebreak">
          <div class="form-pagebreak-back-container">
            <button type="button" class="form-pagebreak-back " id="form-pagebreak-back_30">
              Back
            </button>
          </div>
          <div class="form-pagebreak-next-container">
            <button type="button" class="form-pagebreak-next " id="form-pagebreak-next_30">
              Next
            </button>
          </div>
        </div>
      </li>
    </ul>
    <ul class="form-section page-section" style="display:none;">
      <li class="form-line" data-type="control_text" id="id_79">
        <div id="cid_79" class="form-input-wide">
          <div id="text_79" class="form-html">
            <p style="text-align:center;"><strong>Donor Record - Donation Information</strong></p>
          </div>
        </div>
      </li>
      <li class="form-line" data-type="control_textbox" id="id_84">
        <label class="form-label form-label-right form-label-auto" id="label_84" for="input_84"> Donation Record ID </label>
        <div id="cid_84" class="form-input jf-required">
          <!-- <input type="text" class=" form-textbox" data-type="input-textbox" id="input_84" name="q84_donationRecord84" size="20" value="" /> -->
          <input type="text" class=" form-textbox" data-type="input-textbox" id="input_84" name="idDonationRecord" size="20" value="" />
        </div>
      </li>
      <li class="form-line" data-type="control_textbox" id="id_87">
        <label class="form-label form-label-right form-label-auto" id="label_87" for="input_87"> Date Collected </label>
        <div id="cid_87" class="form-input jf-required">
          <!-- <input type="text" class=" form-textbox" data-type="input-textbox" id="input_87" name="q87_dateCollected87" size="20" value="" /> -->
          <input type="text" class=" form-textbox" data-type="input-textbox" id="input_87" name="donationRec_date" size="20" value="" />
        </div>
      </li>
      <li class="form-line jf-required" data-type="control_textbox" id="id_17">
        <label class="form-label form-label-right form-label-auto" id="label_17" for="input_17">
          Location Collected
          <span class="form-required">
            *
          </span>
        </label>
        <div id="cid_17" class="form-input jf-required">
         <!--  <input type="text" class=" form-textbox validate[required]" data-type="input-textbox" id="input_17" name="q17_locationCollected" size="20" value="" /> -->
         <input type="text" class=" form-textbox validate[required]" data-type="input-textbox" id="input_17" name="donationRec_location" size="20" value="" />
        </div>
      </li>
      <li class="form-line jf-required" data-type="control_dropdown" id="id_58">
        <label class="form-label form-label-right form-label-auto" id="label_58" for="input_58">
          Blood Type
          <span class="form-required">
            *
          </span>
        </label>
        <div id="cid_58" class="form-input jf-required">
          <!-- <select class="form-dropdown validate[required]" style="width:156px" id="input_58" name="q58_bloodType"> -->
          <select class="form-dropdown validate[required]" style="width:156px" id="input_58" name="donor_bloodType">
            <option value="">  </option>
            <option value="O"> O </option>
            <option value="A"> A </option>
            <option value="B"> B </option>
            <option value="AB"> AB </option>
          </select>
        </div>
      </li>
      <li class="form-line jf-required" data-type="control_radio" id="id_77">
        <label class="form-label form-label-right form-label-auto" id="label_77" for="input_77">
          Donor Type
          <span class="form-required">
            *
          </span>
        </label>
        <div id="cid_77" class="form-input jf-required">
          <div class="form-single-column">
            <span class="form-radio-item" style="clear:left;">
              <span class="dragger-item">
              </span>
             <!--  <input type="radio" class="form-radio validate[required]" id="input_77_0" name="q77_donorType77" value="Replacement" /> -->
             <input type="radio" class="form-radio validate[required]" id="input_77_0" name="donationRec_donorType" value="Replacement" />
              <label id="label_input_77_0" for="input_77_0"> Replacement </label>
            </span>
            <span class="form-radio-item" style="clear:left;">
              <span class="dragger-item">
              </span>
             <!--  <input type="radio" class="form-radio validate[required]" id="input_77_1" name="q77_donorType77" value="Voluntary" /> -->
             <input type="radio" class="form-radio validate[required]" id="input_77_1" name="donationRec_donorType" value="Voluntary" />
              <label id="label_input_77_1" for="input_77_1"> Voluntary </label>
            </span>
          </div>
        </div>
      </li>
      <li class="form-line jf-required" data-type="control_number" id="id_56">
        <label class="form-label form-label-right form-label-auto" id="label_56" for="input_56">
          Quantity Donated (mL)
          <span class="form-required">
            *
          </span>
        </label>
        <div id="cid_56" class="form-input jf-required">
          <!-- <input type="number" class="form-number-input  form-textbox validate[required]" id="input_56" name="q56_quantityDonated" style="width:76px" size="7" value="" data-type="input-number" /> -->
          <input type="number" class="form-number-input  form-textbox validate[required]" id="input_56" name="donationRec_quantityDonated" style="width:76px" size="7" value="" data-type="input-number" />
        </div>
      </li>
      <li class="form-line" data-type="control_textbox" id="id_41">
        <label class="form-label form-label-right form-label-auto" id="label_41" for="input_41"> Collected by </label>
        <div id="cid_41" class="form-input jf-required">
          <!-- <input type="text" class=" form-textbox" data-type="input-textbox" id="input_41" name="q41_collectedBy" size="20" value="" /> -->
          <input type="text" class=" form-textbox" data-type="input-textbox" id="input_41" name="donationRec_collectedBy" size="20" value="" />
        </div>
      </li>
      <li class="form-line" data-type="control_textbox" id="id_85">
        <label class="form-label form-label-right form-label-auto" id="label_85" for="input_85"> Blood Expiry Date </label>
        <div id="cid_85" class="form-input jf-required">
          <!-- <input type="text" class=" form-textbox" data-type="input-textbox" id="input_85" name="q85_bloodExpiry85" size="20" value="" /> -->
          <input type="text" class=" form-textbox" data-type="input-textbox" id="input_85" name="donationRec_expiryDate" size="20" value="" />
        </div>
      </li>
      <li class="form-line jf-required form-field-hidden" style="display:none;" data-type="control_textbox" id="id_81">
        <label class="form-label form-label-right form-label-auto" id="label_81" for="input_81">
          Recipient's TRN
          <span class="form-required">
            *
          </span>
        </label>
        <div id="cid_81" class="form-input jf-required">
          <!-- <input type="text" class=" form-textbox validate[required]" data-type="input-textbox" id="input_81" name="q81_recipientsTrn81" size="20" value="" /> -->
          <input type="text" class=" form-textbox validate[required]" data-type="input-textbox" id="input_81" name="donor_recipientTRN" size="20" value="" />
        </div>
      </li>
      <li class="form-line" data-type="control_button" id="id_45">
        <div id="cid_45" class="form-input-wide">
          <div style="text-align:center" class="form-buttons-wrapper">
            <button id="input_45" type="submit" class="form-submit-button">
              Save
            </button>
          </div>
        </div>
      </li>
      <li class="form-line" data-type="control_widget" id="id_47">
        <div id="cid_47" class=" jf-required">
          <div style="width:100%; text-align:Left;">
            <div class="direct-embed-widgets" data-type="direct-embed " style="width:1px;height: 1px;">
              <style type="text/css">
                @media only screen and (max-width:40em){.form-line,.form-line.form-line-column{padding:12px 2px;width:100%;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}.form-dropdown,.form-textarea,.form-textbox{width:100%!important;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}.form-label-left,.form-label-right{display: block;float: none;text-align:left;width:auto !important}.form-buttons-wrapper{margin-left:0!important}.form-all{width:95%}.form-sub-label-container{width:100%;display:block}span.form-sub-label-container+span.form-sub-label-container{margin-right:0}.form-address-table td,.form-address-table th{padding:0 1px 10px}.form-submit-button,.form-submit-print,.form-submit-reset{width:100%;margin-left:0!important}span.date-separate{display:none}div[id*=at_]{text-align:center}img.form-image{width:100%;height:auto}.form-matrix-row-headers{width:100%;word-break:break-all}.form-collapse-table,.form-header-group{margin:0}.form-address-city,.form-address-line,.form-address-postal,.form-address-state,.form-address-table,.form-address-table .form-sub-label-container,.form-address-table select,.form-input{width:100%}.form-sub-label{white-space:normal}}
              </style>
            </div>
          </div>
        </div>
      </li>
      <li class="form-line" data-type="control_widget" id="id_50">
        <div id="cid_50" class=" jf-required">
          <div style="width:100%; text-align:Left;">
            <div class="direct-embed-widgets" data-type="direct-embed " style="width:1px;height: 1px;">
              <style type="text/css">
                .active{display:block !important;} .remove{display:none;}
              </style>
              <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
              <script type="text/javascript">
              var $j = jQuery.noConflict();
$j(function()
{
  $j(".form-pagebreak-next").click(function()
  {
    if ($j(".form-all > ul.form-section:hidden:nth-child(4)"))
    {
      $j("#cid_3, #cid_4").css("display", "none");
      $j("#id_1").css("padding", "50px 36px 10px 36px")
    }
  });
  $j("#form-pagebreak-back_14").click(function()
  {
    $j("#cid_3, #cid_4").css("display", "block");
    $j("#id_1").css("padding", "140px 36px 100px 36px");
    $j("#id_1 ul").children("li").removeClass()
  });
  var e = $j(".form-all").find(".form-section:visible").index();
  $j(".form-pagebreak-next").click(function()
  {
    $j("#id_1 ul").children("li").addClass("remove");
    $j("#id_1 ul").children("li").eq(e++).addClass("active");
  });
  $j(".form-pagebreak-back").click(function()
  {
    $j("#id_1 ul").children("li").eq(e---1).removeClass("active");
  });
})
              </script>
            </div>
          </div>
        </div>
      </li>
      <li class="form-line" data-type="control_widget" id="id_42">
        <div id="cid_42" class=" jf-required">
          <div style="width:100%; text-align:Center;">
            <div class="direct-embed-widgets" data-type="direct-embed " style="width:1px;height: 1px;">
              <script type="text/javascript">
                  var visibleFields = "Yes",
      onlyCountReq = "No",
      fixedProgressBar = "Yes",
      theme = "{theme}";
              </script>
              <link href="//widgets.jotform.io/progressBar/progressbar.css" rel="stylesheet" media="screen">
              <link href="//widgets.jotform.io/progressBar/progressbar-custom.css" rel="stylesheet" media="screen">
              <script src="//widgets.jotform.io/progressBar/progressbar.min.js"></script>
              <script src="//widgets.jotform.io/progressBar/setupProgressBar.js"></script>
            </div>
          </div>
        </div>
      </li>
      <li class="form-line" data-type="control_widget" id="id_49">
        <div id="cid_49" class=" jf-required">
          <div style="width:100%; text-align:Left;">
            <div class="direct-embed-widgets" data-type="direct-embed " style="width:1px;height: 1px;">
              <script>
                  var buttonName = 'Preview Answers';
    var backButtonText = "Back"
    var showEmptyInputs = 'Yes';
    var showTitle = 'Yes';
    var showCollapsible = 'Yes';
    var deleteId = 'Label 1\nLabel 2';
              </script>
              <link href="//widgets.jotform.io/checkInput/min/styles.min.css" rel="stylesheet" media="screen">
              <script src="//widgets.jotform.io/checkInput/min/scripts.min.js"></script>
            </div>
          </div>
        </div>
      </li>
      <li style="display:none">
        Should be Empty:
        <input type="text" name="website" value="" />
      </li>
    </ul>
  </div>
  <input type="hidden" id="simple_spc" name="simple_spc" value="61097210605852" />
  <script type="text/javascript">
  document.getElementById("si" + "mple" + "_spc").value = "61097210605852-61097210605852";
  </script>
  <script src="https://cdn.jotfor.ms/js/widgetResizer.js?REV=3.3.12685" type="text/javascript"></script>
</form></body>
</html>
<script type="text/javascript">JotForm.ownerView=true;</script>
