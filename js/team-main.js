//Status stringovi
var error_empty = '<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status">Popunite oba polja.</p>'; 
var error_teamname = '<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status">Postojeći naziv ekipe u sustavu.</p>'
var error_teammail = '<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status">Postojeća e-mail adresa u sustavu.</p>'
var error_validmail = '<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-top:7px;">Niste unijeli ispravnu e-mail adresu.</p>'
var error_teamusername = '<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-top:7px;">Postojeće korisničko ime u sustavu.</p>'
var succes = '<i class="icon icon-checkmark suc-icon input-icon"></i>';

//Error flag
var err = true;

//Testiranje prva dva input polja preko onblur poziva
function checkplayername() {
	var tn1 = $('#team-name1').val();
	var tn2 = $('#team-name2').val();
	if(  tn1 === "" || tn2 === "" ){
		$('#team-add-status1').html(error_empty);
		err = true;
	}
	else{
		$('#team-add-status1').html(succes);
		err = false;
	}
}

//Testiranje dostupnosti imena ekipe putem ajax poziva
function checkteamname() {
	var tmn = $('#team-name').val();
	var tbm = $('#team-broj-mob').val();
	if( tmn === "" || tbm === "" ){
		$('#team-add-status2').html(error_empty);
		err = true;
	}
	else if ( tmn != "") {
		var ajax = ajaxObj("POST", "php_includes/team-validation.php");
		//Primanje od strane php-a
		ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
				if(ajax.responseText == "1"){
					$('#team-add-status2').html(error_teamname);
					err = true;
				}
				if(ajax.responseText == "0"){
					$('#team-add-status2').html(succes);
					err = false;
				}
	        }
        }
		ajax.send("teamnamecheck="+tmn);
	}
}

//Testiranje zapisa korisničkog imena (e-mail adrese)
function checkteammail() {
	var tme = $('#team-email').val();
	var tmu = $('#team-username').val();
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/igm; //RegEx
	if( tme === "" || tmu === ""){
		$('#team-add-status3').html(error_empty);
		err = true;
	} else if ( !re.test(tme) ) {
		$('#team-add-status3').html(error_validmail);
		err = true;
	}
	else {
		var ajax = ajaxObj("POST", "php_includes/team-validation.php");
		//Primanje od strane php-a
		ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
				if(ajax.responseText == "1"){
					$('#team-add-status3').html(error_teammail);
					err = true;
				}
				if(ajax.responseText == "2"){
					$('#team-add-status3').html(error_teamusername);
					err = true;
				}
				if(ajax.responseText == "0"){
					$('#team-add-status3').html(succes);
					err = false;
				}
	        }
        }
		ajax.send("tme="+tme+"&tmu="+tmu);
	}
}

//Testiranje lozinki
$("#team-passwd1").on("keypress keyup keydown", function() {
    var ts1 = $(this).val();
	if (ts1.length < 6) {
        $('#team-add-status4').html('<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-top:7px;">Loznika mora sardžavati min. 6 znakova.</p>');
		err = true;
    } else if (ts1.length > 50) {
        $('#team-add-status4').html('<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-top:7px;">Loznika može sardžavati max. 50 znakova.</p>');
		err = true;
    } else if (ts1.search(/\d/) == -1) {
        $('#team-add-status4').html('<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-top:7px;">Loznika mora sardžavati min. 1 broj.</p>');
		err = true;
    } else if (ts1.search(/[a-zA-Z]/) == -1) {
        $('#team-add-status4').html('<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-top:7px;">Loznika mora sardžavati min. 1 slovo.</p>');
		err = true;
    } else if (ts1.search(/[^a-zA-Z0-9\!\@\#\$\%\^\&\*\(\)\_\+]/) != -1) {
        $('#team-add-status4').html('<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-top:7px;">Nedopušteni znak u Vašoj lozinki.</p>');
		err = true;
    } else{
		//Test "jačine" lozinke
		var pass_score = checkPassStrength(ts1);
		var pass_string = '<i class="icon icon-checkmark suc-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-left:45px; font-size:21px; color:#7cc576;"> Jakost: '+pass_score+'.</p>'
		$('#team-add-status4').html(pass_string);
		err = false;
	}
});

$("#team-passwd2").on("keypress keyup keydown", function() {
	var ts1 = $('#team-passwd1').val();
	var ts2 = $(this).val();
	if (ts2 === ""){
		$('#team-add-status4').html('<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-top:16px;">Ponovite upis željene lozinke.</p>');
		err = true;
	} else if (ts1 != ts2) {
		$('#team-add-status4').html('<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-top:16px;">Unešene lozinke se ne podudaraju.</p>');
		err = true;
	} else {
		var pass_score = checkPassStrength(ts1);
		var pass_string = '<i class="icon icon-checkmark suc-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-left:45px; font-size:21px; color:#7cc576;"> Jakost: '+pass_score+'.</p>'
		$('#team-add-status4').html(pass_string);
		err = false;
	}
});		

function checkteampass() {	
	var ts1 = $('#team-passwd1').val();
	var ts2 = $('#team-passwd2').val();
	if (ts2 === ""){
		$('#team-add-status4').html('<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-top:16px;">Ponovo upišite željenu lozinku.</p>');
		err = true;
	} else if (ts1 != ts2) {
		$('#team-add-status4').html('<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-top:16px;">Unešene lozinke se ne podudaraju.</p>');
		err = true;
	} else {
		err = false;
	}
}

//Registriracija ekipe
$("#reg-team").click( function(){ 
	var tn1 = $('#team-name1').val();
	var tn2 = $('#team-name2').val();
	var tmn = $('#team-name').val();
	var tbm = $('#team-broj-mob').val();
	var tme = $('#team-email').val();
	var tmu = $('#team-username').val();
	var ts1 = $('#team-passwd1').val();
	var ts2 = $('#team-passwd2').val();
	if ((err == false)&&(tn1 != "")&&(tn2 != "")&&(tmn != "")&&(tbm != "")&&(tme != "")&&(tmu != "")&&(ts1 != "")&&(ts2 != "")){
		var ajax = ajaxObj("POST", "php_includes/team-registration.php");
		//Primanje od strane php-a
		ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
				if(ajax.responseText == "1"){
					//Free hosting plan omogućuje slanje jednog maila dnevno pa se koristi Mandrill
					//https://mandrillapp.com
					var m = new mandrill.Mandrill('QrD7GlDdRKKIPlAOBlc4pg'); //Api key
					m.messages.send({
						"message": {
							"from_email": "belot.organizer@gmail.com",
							"from_name": "Belot-organizer WebApp",
							"to":[{"email": tme, "name": tmu}], // Array of recipients
							"subject": "Aktivacija računa",
							"html": "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Belot-organizer Message</title></head><body><center><table style='background:#dfdfdf;border-collapse:collapse;font-family:Georgia,Times,Times New Roman,serif;height:100%;margin:0;padding:0;width:100%' align='center' height='100%' border='0' cellpadding='0' cellspacing='0' width='600'><tbody><tr><td style='border-top:0;height:100%;margin:0;padding:0px;width:100%' align='center' valign='top'><table style='border:0;border-collapse:collapse' border='0' cellpadding='0' cellspacing='0' width='600'><tbody><tr><td align='center' valign='top'><table style='background-color:#ffffff;border-bottom:0;border-collapse:collapse;border-top:0' border='0' cellpadding='0' cellspacing='0' width='600'><tbody><tr><td valign='top'><table style='border-collapse:collapse' border='0' cellpadding='0' cellspacing='0' width='100%'><tbody><tr><td valign='top'><table style='border-collapse:collapse' align='left' border='0' cellpadding='0' cellspacing='0' width='100%'><tbody><tr><td valign='top'><img class='CToWUd' alt='' src='https://gallery.mailchimp.com/b46db128ddc3d1671fae678f5/images/3086b2ce-f9e0-4a96-8fa0-0dcbc0c6de67.gif' style='border:0;outline:none;text-decoration:none;vertical-align:bottom' align='left' width='600'></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td align='center' valign='top'><table style='background-color:#ffffff;border-bottom:0;border-collapse:collapse;border-top:0;overflow:hidden' border='0' cellpadding='0' cellspacing='0' width='600'><tbody><tr><td style='background:#ffffff' valign='top'><table style='border-collapse:collapse' border='0' cellpadding='0' cellspacing='0' width='600'><tbody><tr><td valign='top'><table style='border-collapse:collapse' align='left' border='0' cellpadding='0' cellspacing='0' width='600'><tbody><tr><td style='color:#606060;font-family:Helvetica;font-size:15px;line-height:150%;padding:60px 90px;padding-top:0px;text-align:left' valign='top'><hr style='background:#c0d1d9;border:none;min-height:1px;width:250px'><h1 style='border-bottom:none;color:#BD3C3C;display:block;font-family:Rockwell,Georgia,Times,Times New Roman,serif;font-size:15px;font-style:normal;font-weight:normal;letter-spacing:0.5px;margin:0;margin-bottom:18px;padding:0;padding-bottom:18px;text-align:center;text-transform:uppercase'>Belot - organizer</h1><p style='color:#939598;font-family:Georgia,Times,Times New Roman,serif;font-size:17px;line-height:28px;margin:1em 0;padding:0;text-align:left'>Jednostavno <a href='https://belot-organizer.herokuapp.com/team-activation.php?user="+tmu+"' style='color:#E06060;font-family:Georgia,Times,Times New Roman,serif;font-weight:normal;text-decoration:underline;word-wrap:break-word' target='_blank'>potvrdite Vaš e-mail</a> i slobodni Ste!</p><p style='color:#939598;font-family:Georgia,Times,Times New Roman,serif;font-size:17px;line-height:28px;margin:1em 0;padding:0;text-align:left'>Nakon toga ste u mogućnosti prijavljivati se na slobodne turnire.</p><p style='color:#939598;font-family:Georgia,Times,Times New Roman,serif;font-size:17px;line-height:28px;margin:1em 0;padding:0;text-align:left'>Vaši podaci za prijavu u sustav:</p><p style='color:#939598;font-family:Georgia,Times,Times New Roman,serif;font-size:17px;line-height:28px;margin:1em 0;padding:0;text-align:left'>Korisničko ime : <span style='color:#E06060;font-family:Georgia,Times,Times New Roman,serif;font-weight:normal;word-wrap:break-word'>"+tmu+"</span></p><p style='color:#939598;font-family:Georgia,Times,Times New Roman,serif;font-size:17px;line-height:28px;margin:1em 0;padding:0;text-align:left'>Lozinka : <span style='color:#E06060;font-family:Georgia,Times,Times New Roman,serif;font-weight:normal;word-wrap:break-word'>"+ts1+"</span></p><p style='color:#939598;font-family:Georgia,Times,Times New Roman,serif;font-size:17px;line-height:28px;margin:1em 0;padding:0;text-align:left'>Ukoliko imate bilo kakve upite kontaktirajte nas na <span style='color:#E06060;font-family:Georgia,Times,Times New Roman,serif;font-weight:normal;text-decoration:underline;word-wrap:break-word'>belot.organizer@gmail.com</span>.</p><p style='color:#939598;font-family:Georgia,Times,Times New Roman,serif;font-size:17px;line-height:28px;margin:1em 0;padding:0;text-align:left'>Vaš Belot-organizer Tim.</p></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td><table style='border-collapse:collapse;overflow:hidden' border='0' cellpadding='0' cellspacing='0' width='600'><tbody><tr><td valign='top'><table style='background:#f7f7f7;border-bottom:1px solid #b8d2dd;border-collapse:collapse' border='0' cellpadding='0' cellspacing='0' width='600'><tbody><tr><td valign='top'><table style='border-collapse:collapse' align='left' border='0' cellpadding='0' cellspacing='0' width='600'><tbody><tr><td style='font-family:Georgia,Times,Times New Roman,serif' valign='top'><a href='https://belot-organizer.herokuapp.com/' style='display:inline-block;padding:36px 0px 36px 32px;text-decoration:none;width:100%;word-wrap:break-word' target='_blank'><img class='CToWUd' alt='' src='https://gallery.mailchimp.com/b46db128ddc3d1671fae678f5/images/3469ee54-a118-4faf-b5b0-53c5cc2af7df.gif' style='border:0;min-height:auto;outline:none;text-decoration:none' align='left' height='94' width='95'><span style='display:inline-block;float:left;margin:21px;text-align:left'><h2 style='color:#BD3C3C;display:block;font-family:Rockwell,Georgia,Times,Times New Roman,serif;font-size:26px;font-style:normal;font-weight:normal;letter-spacing:-0.75px;line-height:125%;margin:0;padding:0;text-align:left'>Postanite i organizator!</h2><p style='color:#E06060;margin:0px;padding:0'><span style='display:inline-block;float:left;font-size:16px;margin:0px 5px 0px 0px;padding:0px;text-align:left'>Prijava</span><img class='CToWUd' alt='' src='https://gallery.mailchimp.com/b46db128ddc3d1671fae678f5/images/51c527d5-ec8d-4692-9bdf-bb5d863b1115.gif' style='border:0;display:inline-block;float:left;min-height:auto;margin-top:5px;outline:none;text-decoration:none' align='left' height='10' width='8'></p></span></a></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td align='center' valign='top'><table style='background:white;border-bottom:0;border-collapse:collapse;border-top:0;font-style:italic' border='0' cellpadding='0' cellspacing='0' width='600'><tbody><tr><td style='padding:12px 0px 24px 0px;padding-bottom:9px' valign='top'><table style='border-collapse:collapse' border='0' cellpadding='0' cellspacing='0' width='100%'><tbody><tr><td valign='top'><table style='border-collapse:collapse' align='left' border='0' cellpadding='0' cellspacing='0' width='600'><tbody><tr><td style='color:#bababa;font-family:Georgia,Times,Times New Roman,serif;font-size:15px;line-height:125%;padding-bottom:9px;padding-left:18px;padding-right:18px;padding-top:9px;text-align:center' valign='top'><div style='text-align:center'>Copyright © 2016 Belot-organizer • WebApp • 31 000 Osijek</div></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></center></body></html>"
						}
					});
					//Popup
					$('#team-add-succes-mail').html(tme);
					$('#global, #team-add-succes').fadeIn(550).css("display","block");
					$('body').addClass('stop-scrolling');
				}
				if(ajax.responseText == "2"){
					alert("Neuspješna registracija");
				}
	        }
        }
		ajax.send("teamregister="+tmu+"&tme="+tme+"&tn1="+tn1+"&tn2="+tn2+"&tmn="+tmn+"&tbm="+tbm+"&ts1="+ts1);
	}
});	
