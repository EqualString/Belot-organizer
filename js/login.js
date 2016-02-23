//Loader
$(window).load(function() {
	$('.global-wrap').imagesLoaded( function() {
		setTimeout(function(){
			$("#loading").fadeOut(950);
		}, 1000);	
	});
});
		
$('.toggle').click(function(){
	// Switches the Icon
	$(this).children('i').toggleClass('fa-chevron-down');
    // Switches the forms  
	$('.form-toggle').animate({
		height: "toggle",
		'padding-top': 'toggle',
		'padding-bottom': 'toggle',
		opacity: "toggle"
	}, "slow");
});

$("#organizer-login-btn").click( function(){ 
	var tn1 = $('#organizer-login-username').val();
	var tn2 = $('#organizer-login-password').val();
	if ((tn1 != "")&&(tn2 != "")){	
		$("#organizer-login-status").html('<i class="fa fa-spinner fa-pulse timer2" style="margin-left:130px;"></i>');
		setTimeout(function(){
			var ajax = ajaxObj("POST", "php_includes/organizer-login.php");
			//Primanje od strane php-a
			ajax.onreadystatechange = function() {
				if(ajaxReturn(ajax) == true) {
					if(ajax.responseText == "3"){
						window.location.href = "/organizer";
					}
					if(ajax.responseText == "2"){
						$("#organizer-login-status").html('<p class="login-status"><i class="fa fa-exclamation-circle"></i>&nbsp; Korisnički račun nije aktiviran!</p>');
					}
					if(ajax.responseText == "1"){
						$("#organizer-login-status").html('<p class="login-status" style="margin-left:-33px;"><i class="fa fa-exclamation-circle"></i>&nbsp; Korisničko ime i lozinka se ne podudaraju</p>');
					}
					if(ajax.responseText == "0"){
						$("#organizer-login-status").html('<p class="login-status"><i class="fa fa-exclamation-circle"></i>&nbsp; Nepostojeći korisnik</p>');
					}
				}
			}
			ajax.send("organizer-login="+tn1+"&pass="+tn2);
		}, 750);	
	}
	else{
		$("#organizer-login-status").html('<p class="login-status"><i class="fa fa-exclamation-circle"></i>&nbsp; Popunite sva polja</p>');
	}
});	

$("#team-login-btn").click( function(){ 
	var tn1 = $('#team-login-username').val();
	var tn2 = $('#team-login-password').val();
	if ((tn1 != "")&&(tn2 != "")){	
		$("#team-login-status").html('<i class="fa fa-spinner fa-pulse timer2" style="margin-left:130px;"></i>');
		setTimeout(function(){
			var ajax = ajaxObj("POST", "php_includes/team-login.php");
			//Primanje od strane php-a
			ajax.onreadystatechange = function() {
				if(ajaxReturn(ajax) == true) {
					if(ajax.responseText == "3"){
						window.location.href = "/team";
					}
					if(ajax.responseText == "2"){
						$("#team-login-status").html('<p class="login-status"><i class="fa fa-exclamation-circle"></i>&nbsp; Korisnički račun nije aktiviran!</p>');
					}
					if(ajax.responseText == "1"){
						$("#team-login-status").html('<p class="login-status" style="margin-left:-33px;"><i class="fa fa-exclamation-circle"></i>&nbsp; Korisničko ime i lozinka se ne podudaraju</p>');
					}
					if(ajax.responseText == "0"){
						$("#team-login-status").html('<p class="login-status"><i class="fa fa-exclamation-circle"></i>&nbsp; Nepostojeći korisnik</p>');
					}
				}
			}
			ajax.send("team-login="+tn1+"&pass="+tn2);
		}, 750);	
	}
	else{
		$("#team-login-status").html('<p class="login-status"><i class="fa fa-exclamation-circle"></i>&nbsp; Popunite sva polja</p>');
	}
});	