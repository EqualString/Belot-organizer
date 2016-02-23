//Loader
$(window).load(function() {
	$('.global-wrap').imagesLoaded( function() {
		setTimeout(function(){
			$("#loading").fadeOut(950);
		}, 1000);	
	});
});

var reg = /^\d+$/; //Regularni izraz za brojeve

//Ukupni rezultati
var t1 = 0;
var t2 = 0;

$("#unos").click( function(){ 
	//"Belot" Logika :)
	var res1 = parseInt($('#res1').val());
	var res2 = parseInt($('#res2').val());
	var res1part = parseInt($('#res1-part').text());
	var res2part = parseInt($('#res2-part').text());
	var sum1 = res1 + res1part;
	var sum2 = res2 + res2part;
	if (( reg.test(res1) )&&(reg.test(res2) )){ 
		$('#res1-part').text(sum1);
		$('#res2-part').text(sum2);
		if (( sum1 >= 1001 )||( sum2 >=1001 )){
			if( sum1 != sum2 ){
				if(sum1 > sum2){
					t1++;
					$('#res1-uk').text(t1);
					$('#res1-part').text(0);
					$('#res2-part').text(0);
				}else {
					t2++;
					$('#res2-uk').text(t2);
					$('#res1-part').text(0);
					$('#res2-part').text(0);
				}
			
			}
		}
	}
	if ((t1 == 2)||( t2 == 2)){
		$("#unos").attr("disabled", true);
		$("#save-res").css("display","block");
	}
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

//Spremi rezultat	
$("#save-res").click( function(){ 
	$("#status").html('<i class="fa fa-spinner fa-pulse timer2" style="margin-left:313px; margin-top:6px;"></i>');
	var game = getParameterByName('game');
	var table = getParameterByName('table');
	setTimeout(function(){
		var ajax = ajaxObj("POST", "php_includes/insert-results.php");
				//Primanje od strane php-a
				ajax.onreadystatechange = function() {
					if(ajaxReturn(ajax) == true) {
						if (ajax.responseText == "1"){
							window.location.href = "/results.php?tournament="+table;
						}
				}
			}
		ajax.send("results="+game+"&table="+table+"&t1="+t1+"&t2="+t2);
	}, 750);
});	


