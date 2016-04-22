// Javascript functions

window.onload = function()
{
	/*// Load inbox of blood specimens
	loadBloodSpecimens();

	// Load system notifications
	loadSystemNotifcations();*/
}


function loadBloodSpecimens(id){

    // Load AJAX
	if (window.XMLHttpRequest) {
         // code for IE7+, Firefox, Chrome, Opera, Safari
         xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            	// inbox pane
                document.getElementById("sliders").innerHTML = xmlhttp.responseText;
            }
        };

        // Display list of recent specimens
        xmlhttp.open("GET","searhResult2.php?id="+id,true);
        xmlhttp.send();
   
}
}
|
function loadSystemNotifcations(){

    // Load AJAX
	if (window.XMLHttpRequest) {
         // code for IE7+, Firefox, Chrome, Opera, Safari
         xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            	// notification pane
                document.getElementById("main-left").innerHTML = xmlhttp.responseText;
            }
        };

        // Display list of recent specimens
        xmlhttp.open("GET","loadSystemNotifcations.php",true);
        xmlhttp.send();
   
}
}

/*FB.ui({
  method: 'share',
  href: 'http://localhost/BloodLine%20SourceCode/urgentRecipientCases.html#',
}, function(response){});*/


// Include right after the opening <body> tag
/* <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=684767574994409";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>*/

// Place wherever you want the button
/* <div class="fb-share-button" data-href="http://localhost/BloodLine%20SourceCode/urgentRecipientCases.html#" data-layout="button" data-mobile-iframe="false"></div>*/