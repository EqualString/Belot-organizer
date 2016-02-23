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

//Prijava na turnir		
$("#team-signin-tourn").click( function(){ 
	$("#t-status").html('<i class="fa fa-spinner fa-pulse timer2" style="margin-left:130px; margin-top:6px;"></i>');
	var id = getParameterByName('id');
	setTimeout(function(){
		var ajax = ajaxObj("POST", "tournament.php?id="+id);
				//Primanje od strane php-a
				ajax.onreadystatechange = function() {
					if(ajaxReturn(ajax) == true) {
						if (ajax.responseText == "1"){
							location.reload();
						}
				}
			}
			ajax.send("tournsignup");
	}, 750);
});	

//Odjava sa turnira	
$("#team-signout-tourn").click( function(){ 
	$("#t-status").html('<i class="fa fa-spinner fa-pulse timer2" style="margin-left:130px; margin-top:6px;"></i>');
	var id = getParameterByName('id');
	setTimeout(function(){
		var ajax = ajaxObj("POST", "tournament.php?id="+id);
				//Primanje od strane php-a
				ajax.onreadystatechange = function() {
					if(ajaxReturn(ajax) == true) {
						if (ajax.responseText == "1"){
							location.reload();
						}
				}
			}
			ajax.send("tournsignout");
	}, 750);
});	

//Započni turnir
$("#start-tournament").click( function(){ 
	$("#t-status").html('<i class="fa fa-spinner fa-pulse timer2" style="margin-left:130px; margin-top:6px;"></i>');
	var id = getParameterByName('id');
	setTimeout(function(){
		var ajax = ajaxObj("POST", "php_includes/start-tournament.php");
				//Primanje od strane php-a
				ajax.onreadystatechange = function() {
					if(ajaxReturn(ajax) == true) {
						if (ajax.responseText == "4"){
							window.location.href = "/results.php?tournament="+id;
						}
				}
			}
			ajax.send("StartTournament="+id);
	}, 750);
});	

//Link na rezultate
$("#tourn-results").click( function(){ 
	var id = getParameterByName('id');
	window.location.href = "/results.php?tournament="+id;
});	