jQuery('.slider').lbSlider({
    leftBtn: '.sa-left',
    rightBtn: '.sa-right',
    visible: 3,
    autoPlay: true,
    autoPlayDelay: 3
});

window.onload = function(){
	// Load recipients list
	loadRecipients();

    /*loadBloodSpecimens();*/
};

function loadRecipients(){


	// Load AJAX
	if (window.XMLHttpRequest) {
         // code for IE7+, Firefox, Chrome, Opera, Safari
         // Create an XMLHttpRequest object
         xmlhttp = new XMLHttpRequest();

         // Create the function to be executed when the server response is ready
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            	// Users pane 
                document.getElementById("sliders").innerHTML = xmlhttp.responseText;
            }
        };

        // Display list of Cheapo users 
        xmlhttp.open("GET","displayUrgentRecipients.php",true);
        // Send the request off to a file on the server
        xmlhttp.send();
     }
}

/*function loadBloodSpecimens(){

 
    // Load AJAX
    if (window.XMLHttpRequest) {
         // code for IE7+, Firefox, Chrome, Opera, Safari
         // Create an XMLHttpRequest object
         xmlhttp = new XMLHttpRequest();

         // Create the function to be executed when the server response is ready
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                // Users pane 
                document.getElementById("sliders").innerHTML = xmlhttp.responseText;
            }
        };

        // Display list of Cheapo users 
        xmlhttp.open("GET","loadBloodSpecimens.php",true);
        // Send the request off to a file on the server
        xmlhttp.send();
     }
}*/
