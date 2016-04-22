$("#login-button").click(function(event){
	event.preventDefault();
	$('form').fadeOut(500);
	$('.wrapper').addClass('form-success');
});

$("#label").click(function(){
	$('#nav-wrap').attr("overflow", "visible");
});

var drop;
window.onload = function() {
	var a = document.getElementById('label');
	a.onclick = function(){
		drop = document.getElementById('nav-wrap');
		if(drop.style.overflow === "hidden") {
			drop.style.overflow = 'visible';
			a.style.background = '#fff';
			a.style.color = '#333';
		}
		else {
			drop.style.overflow = 'hidden';
			a.style.background = 'transparent';
			a.style.color = '#fff';
		}
	}
}

