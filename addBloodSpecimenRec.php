<?php
    /* === DATABASE CONNECTION === */
    include('dbaccess.php');
    /* === START SESSION === */
    session_start();

     include('BloodSpecimen.class.php');

       /* +++++++++++++++ UPDATE BLOOD SPECIMEN ++++++++++++ */
      if (isset( $_GET["id"]) && isset( $_GET["type"]) )
     { $id = $_GET["id"]; $type = $_GET["type"];} else { $id = "BS003"; $type = "B";}

      $msg = "";
       // Get current user signed in 
        if (isset($_SESSION["username"]))
        {
          $testedBy = $_SESSION["username"]; }

        else { $testedBy = "LindseyStirling";}
         // Get today's date
          $date = date("Y-m-d");

          
       if (isset($_POST["save"]))
       {
         
          // Get entered fields
          $components = $_POST['bloodSpec_componentsInfo'];
          $location = $_POST['bloodSpec_storageLocation'];
          $results = $_POST['bloodSpec_testResults'];
          $RH = $_POST['bloodSpec_RH'];
          $status = $_POST['bloodSpec_status'];

          // Create blood specimen object
        $bloodSpecimen = new BloodSpecimen();
        // Crete record
        $rec = array($id,$components,$location,$results,$type,$RH,$testedBy,$date,$status);
        // Update
        $bloodSpecimen->editRecord($rec);
        // Confirmation message
         $msg = "Blood Specimen. ".$id." successfully updated";
    

      }

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="alternate" type="application/json+oembed" href="https://www.jotform.com/oembed/?format=json&amp;url=http%3A%2F%2Fwww.jotform.com%2Fform%2F61098889980881" title="oEmbed Form"><link rel="alternate" type="text/xml+oembed" href="https://www.jotform.com/oembed/?format=xml&amp;url=http%3A%2F%2Fwww.jotform.com%2Fform%2F61098889980881" title="oEmbed Form">
<meta property="og:title" content="Clone of Student Information Form - White and Responsive" >
<meta property="og:url" content="http://www.jotform.co/form/61098889980881" >
<meta property="og:description" content="Please click the link to complete this form.">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="HandheldFriendly" content="true" />
<!--<title>Clone of Student Information Form - White and Responsive</title>-->
<title>Blood Specimen Record</title>
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
    }

    .form-all{
        margin:0px auto;
        padding-top:0px;
        width:800px;
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

<script src="https://cdn.jotfor.ms/static/prototype.forms.js" type="text/javascript"></script>
<script src="https://cdn.jotfor.ms/static/jotform.forms.js?3.3.12685" type="text/javascript"></script>
<script src="https://js.jotform.com/vendor/postMessage.js?3.3.12685" type="text/javascript"></script>
<script src="https://js.jotform.com/WidgetsServer.js" type="text/javascript"></script>
<script type="text/javascript">
   JotForm.init(function(){
      setTimeout(function() {
          $('input_41').hint(' NCH_R1C1');
       }, 20);
      setTimeout(function() {
          $('input_21').hint(' N|N|N|N|N');
       }, 20);
      setTimeout(function() {
          $('input_16').hint(' 55:1:45');
       }, 20);
	JotForm.clearFieldOnHide="disable";
	JotForm.onSubmissionError="jumpToFirstError";
   });
</script>

</head>
<body>
<!--<form class="jotform-form" action="https://submit.jotform.co/submit/61098889980881/" method="post" name="form_61098889980881" id="61098889980881" accept-charset="utf-8">-->
<form class="jotform-form" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" name="form_61098889980881" id="61098889980881" accept-charset="utf-8">
  <input type="hidden" name="formID" value="61098889980881" />
  <div class="form-all">
    <ul class="form-section page-section">
      <li id="cid_3" class="form-input-wide" data-type="control_head">
        <div class="form-header-group">
          <div class="header-text httac htvam">
            <h2 id="header_3" class="form-header">
              Blood Specimen Record
            </h2>
          </div>
        </div>
      </li>
      <li class="form-line" data-type="control_textbox" id="id_15">
        <label class="form-label form-label-right form-label-auto" id="label_15" for="input_15"> Blood Specimen ID </label>
        <div id="cid_15" class="form-input jf-required">
          <!-- <input type="text" class=" form-textbox" data-type="input-textbox" id="input_15" name="q15_bloodSpecimen" size="20" value="" /> -->
          <input type="text" class=" form-textbox" data-type="input-textbox" id="input_15" name="idBloodSpecimen" size="20" value="<?php echo $id; ?>" placeholder="<?php echo $id; ?>" readonly/> 
        </div>
      </li>
      <li class="form-line" data-type="control_textbox" id="id_19">
        <label class="form-label form-label-right form-label-auto" id="label_19" for="input_19"> Blood Tested By: </label>
        <div id="cid_19" class="form-input jf-required">
          <!-- <input type="text" class=" form-textbox" data-type="input-textbox" id="input_19" name="q19_bloodTested" size="20" value="" /> -->
          <input type="text" class=" form-textbox" data-type="input-textbox" id="input_19" name="bloodSpec_testedBy" size="20" value="<?php echo $testedBy; ?>" placeholder="<?php echo $testedBy; ?>" readonly />
        </div>
      </li>
      <li class="form-line" data-type="control_textbox" id="id_52">
        <label class="form-label form-label-right form-label-auto" id="label_52" for="input_52"> Process Date </label>
        <div id="cid_52" class="form-input jf-required">
          <!-- <input type="text" class=" form-textbox" data-type="input-textbox" id="input_52" name="q52_processDate52" size="20" value="" /> -->
          <input type="text" class=" form-textbox" data-type="input-textbox" id="input_52" name="bloodSpec_processDate" size="20" value="<?php echo $date; ?>" placeholder="<?php echo $date; ?>" readonly />
        </div>
      </li>
      <li class="form-line" data-type="control_textbox" id="id_56">
        <label class="form-label form-label-right form-label-auto" id="label_56" for="input_56"> Blood Type </label>
        <div id="cid_56" class="form-input jf-required">
          <!-- <input type="text" class=" form-textbox" data-type="input-textbox" id="input_56" name="q56_bloodType" size="20" value="" /> -->
          <input type="text" class=" form-textbox" data-type="input-textbox" id="input_56" name="bloodSpec_bloodType" size="20" value="<?php echo $type; ?>" placeholder="<?php echo $type; ?>" readonly />
        </div>
      </li>
      <li class="form-line jf-required" data-type="control_radio" id="id_55">
        <label class="form-label form-label-right form-label-auto" id="label_55" for="input_55">
          Blood RH
          <span class="form-required">
            *
          </span>
        </label>
        <div id="cid_55" class="form-input jf-required">
          <div class="form-single-column">
            <span class="form-radio-item" style="clear:left;">
              <span class="dragger-item">
              </span>
              <!-- <input type="radio" class="form-radio validate[required]" id="input_55_0" name="q55_bloodRh55" value="+" /> -->
              <input type="radio" class="form-radio validate[required]" id="input_55_0" name="bloodSpec_RH" value="+" />
              <label id="label_input_55_0" for="input_55_0"> + </label>
            </span>
            <span class="form-radio-item" style="clear:left;">
              <span class="dragger-item">
              </span>
              <!-- <input type="radio" class="form-radio validate[required]" id="input_55_1" name="q55_bloodRh55" value="-" /> -->
              <input type="radio" class="form-radio validate[required]" id="input_55_1" name="bloodSpec_RH" value="-" />
              <label id="label_input_55_1" for="input_55_1"> - </label>
            </span>
          </div>
        </div>
      </li>
      <li class="form-line" data-type="control_text" id="id_59">
        <div id="cid_59" class="form-input-wide">
          <div id="text_59" class="form-html">
            <p style="text-align:center;"><span style="font-size:8pt;">Format - Hospital Acronym_RowNumberColumnNumber</span></p>
            <p style="text-align:center;"> </p>
          </div>
        </div>
      </li>
      <li class="form-line jf-required" data-type="control_textbox" id="id_41">
        <label class="form-label form-label-right form-label-auto" id="label_41" for="input_41">
          Storage Location
          <span class="form-required">
            *
          </span>
        </label>
        <div id="cid_41" class="form-input jf-required">
          <!-- <input type="text" class=" form-textbox validate[required]" data-type="input-textbox" id="input_41" name="q41_storageLocation" size="20" value="" /> -->
          <input type="text" class=" form-textbox validate[required]" data-type="input-textbox" id="input_41" name="bloodSpec_storageLocation" size="20" value="" />
        </div>
      </li>
      <li class="form-line" data-type="control_text" id="id_58">
        <div id="cid_58" class="form-input-wide">
          <div id="text_58" class="form-html">
            <p style="text-align:center;"><span style="font-size:8pt;">Format - AntibodyScreen|HIV|HTLV|HBsAG|HCV</span></p>
            <p style="text-align:center;"><span style="font-size:8pt;">N - Negative / P - Positive</span></p>
          </div>
        </div>
      </li>
      <li class="form-line jf-required" data-type="control_textbox" id="id_21">
        <label class="form-label form-label-right form-label-auto" id="label_21" for="input_21">
          Blood Test Results
          <span class="form-required">
            *
          </span>
        </label>
        <div id="cid_21" class="form-input jf-required">
          <!-- <input type="text" class=" form-textbox validate[required]" data-type="input-textbox" id="input_21" name="q21_bloodTest21" size="20" value="" /> -->
          <input type="text" class=" form-textbox validate[required]" data-type="input-textbox" id="input_21" name="bloodSpec_testResults" size="20" value="" />
        </div>
      </li>
      <li class="form-line" data-type="control_text" id="id_60">
        <div id="cid_60" class="form-input-wide">
          <div id="text_60" class="form-html">
            <p style="text-align:center;"><span style="font-size:8pt;">Format - Plasma:Platelets:Red Blood Cells</span></p>
            <p style="text-align:center;"> </p>
          </div>
        </div>
      </li>
      <li class="form-line jf-required" data-type="control_textbox" id="id_16">
        <label class="form-label form-label-right form-label-auto" id="label_16" for="input_16">
          Blood Components
          <span class="form-required">
            *
          </span>
        </label>
        <div id="cid_16" class="form-input jf-required">
          <!-- <input type="text" class=" form-textbox validate[required]" data-type="input-textbox" id="input_16" name="q16_bloodComponents" size="20" value="" /> -->
          <input type="text" class=" form-textbox validate[required]" data-type="input-textbox" id="input_16" name="bloodSpec_componentsInfo" size="20" value="" />
        </div>
      </li>
      <li class="form-line" data-type="control_dropdown" id="id_57">
        <label class="form-label form-label-right form-label-auto" id="label_57" for="input_57"> Status </label>
        <div id="cid_57" class="form-input jf-required">
          <!-- <select class="form-dropdown" style="width:150px" id="input_57" name="q57_status"> -->
          <select class="form-dropdown" style="width:150px" id="input_57" name="bloodSpec_status">
            <option value="">  </option>
            <option value="To be Tested" selected="selected"> To be Tested </option>
            <option value="Delivered"> Delivered </option>
            <option value="Infected "> Infected </option>
            <option value="In Stock"> In Stock </option>
            <option value="Expired"> Expired </option>
          </select>
        </div>
      </li>
      <li class="form-line" data-type="control_button" id="id_45">
        <div id="cid_45" class="form-input-wide">
          <div style="text-align:center" class="form-buttons-wrapper">
            <button name="save" id="input_45" type="submit" class="form-submit-button">
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
  <input type="hidden" id="simple_spc" name="simple_spc" value="61098889980881" />
  <script type="text/javascript">
  document.getElementById("si" + "mple" + "_spc").value = "61098889980881-61098889980881";
  </script>
  <script src="https://cdn.jotfor.ms/js/widgetResizer.js?REV=3.3.12685" type="text/javascript"></script>
</form></body>
</html>
<script type="text/javascript">JotForm.ownerView=true;</script>
