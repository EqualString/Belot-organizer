
$("#organizer-login-btn").click( function(){ 
	var tn1 = $('#organizer-login-username').val();
	var tn2 = $('#organizer-login-password').val();
	if ((tn1 != "")&&(tn2 != "")){	
		$("#organizer-login-status").html('<i class="fa fa-spinner fa-pulse timer2"></i>');
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
						$("#organizer-login-status").html('<p class="login-status"><i class="fa fa-exclamation-circle"></i>&nbsp; Korisničko ime i lozinka se ne podudaraju</p>');
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