//Loader
$(window).load(function() {
	$('.global-wrap').imagesLoaded( function() {
		setTimeout(function(){
			$("#loading").fadeOut(950);
		}, 1000);	
	});
});
		
//Dohvaćanje stringa iz url-a
//http://stackoverflow.com/questions/901115/how-can-i-get-query-string-values-in-javascript?page=1&tab=votes#tab-top
function getParameterByName(name, url) {
	if (!url) url = window.location.href;
	name = name.replace(/[\[\]]/g, "\\$&");
	var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
		results = regex.exec(url);
	if (!results) return null;
	if (!results[2]) return '';
	return decodeURIComponent(results[2].replace(/\+/g, " "));
}
		
//Callback od reCaptche
var verifyCallback = function( response ) {
	//Dohvaćanje stringa iz url-a
	var acc = getParameterByName('user');
	setTimeout(function(){
		var ajax = ajaxObj("POST", "organizer-activation.php");
		ajax.onreadystatechange = function() {
			if(ajaxReturn(ajax) == true) {
				if(ajax.responseText == "1"){
					window.location.replace("/organizer");
				}
		}}
		ajax.send("activate="+acc);
	}, 2500);	
};