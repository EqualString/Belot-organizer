
$("#team-login-btn").click( function(){ 
	var tn1 = $('#team-login-username').val();
	var tn2 = $('#team-login-password').val();
	if ((tn1 != "")&&(tn2 != "")){	
		$("#team-login-status").html('<i class="fa fa-spinner fa-pulse timer2"></i>');
		setTimeout(function(){
			var ajax = ajaxObj("POST", "php_includes/team-login.php");
			//Primanje od strane php-a
			ajax.onreadystatechange = function() {
				if(ajaxReturn(ajax) == true) {
					if(ajax.responseText == "3"){
						alert("logiran si");
					}
					if(ajax.responseText == "2"){
						$("#team-login-status").html('<p class="login-status"><i class="fa fa-exclamation-circle"></i>&nbsp; Korisnički račun nije aktiviran!</p>');
					}
					if(ajax.responseText == "1"){
						$("#team-login-status").html('<p class="login-status"><i class="fa fa-exclamation-circle"></i>&nbsp; Korisničko ime i lozinka se ne podudaraju</p>');
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