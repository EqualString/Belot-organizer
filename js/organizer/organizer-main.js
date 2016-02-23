//Status stringovi
var error_empty = '<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status">Ispunite oba polja.</p>';
var error_empty2 = '<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status">Ispunite polje.</p>'; 
var error_orgmail = '<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status">Postojeća e-mail adresa u sustavu.</p>'
var error_validmail = '<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-top:7px;">Niste unijeli ispravnu e-mail adresu.</p>'
var error_orgusername = '<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-top:17px;">Postojeće korisničko ime u sustavu.</p>'
var succes = '<i class="icon icon-checkmark suc-icon input-icon"></i>';

//Error flag
var err2 = true;

//Testiranje prva tri input polja preko onblur poziva
function checkorgname() {
	var on1 = $('#org-name').val();
	var on2 = $('#org-second-name').val();
	if(  on1 === "" || on2 === "" ){
		$('#org-add-status1').html(error_empty);
		err2 = true;
	}
	else{
		$('#org-add-status1').html(succes);
		err2 = false;
	}
}

function checkorgmob() {
	var omb = $('#org-broj-mob').val();
	if(  omb === "" ){
		$('#org-add-status2').html(error_empty2);
		err2 = true;
	}
	else{
		$('#org-add-status2').html(succes);
		err2 = false;
	}
}

//Testiranje zapisa korisničkog imena (e-mail adrese)
function checkorgmail() {
	var oge = $('#org-email').val();
	var ogu = $('#org-username').val();
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/igm; //RegEx
	if( oge === "" || ogu === ""){
		$('#org-add-status3').html(error_empty);
		err2 = true;
	} else if ( !re.test(oge) ) {
		$('#org-add-status3').html(error_validmail);
		err2 = true;
	}
	else {
		var ajax = ajaxObj("POST", "php_includes/organizer-validation.php");
		//Primanje od strane php-a
		ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
				if(ajax.responseText == "1"){
					$('#org-add-status3').html(error_orgmail);
					err2 = true;
				}
				if(ajax.responseText == "2"){
					$('#org-add-status3').html(error_orgusername);
					err2 = true;
				}
				if(ajax.responseText == "0"){
					$('#org-add-status3').html(succes);
					err2 = false;
				}
	        }
        }
		ajax.send("oge="+oge+"&ogu="+ogu);
	}
}

//Testiranje lozinki
$("#org-passwd1").on("keypress keyup keydown", function() {
    var ts1 = $(this).val();
	if (ts1.length < 6) {
        $('#org-add-status4').html('<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-top:7px;">Loznika mora sardžavati min. 6 znakova.</p>');
		err2 = true;
    } else if (ts1.length > 50) {
        $('#org-add-status4').html('<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-top:7px;">Loznika može sardžavati max. 50 znakova.</p>');
		err2 = true;
    } else if (ts1.search(/\d/) == -1) {
        $('#org-add-status4').html('<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-top:7px;">Loznika mora sardžavati min. 1 broj.</p>');
		err2 = true;
    } else if (ts1.search(/[a-zA-Z]/) == -1) {
        $('#org-add-status4').html('<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-top:7px;">Loznika mora sardžavati min. 1 slovo.</p>');
		err2 = true;
    } else if (ts1.search(/[^a-zA-Z0-9\!\@\#\$\%\^\&\*\(\)\_\+]/) != -1) {
        $('#org-add-status4').html('<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-top:7px;">Nedopušteni znak u Vašoj lozinki.</p>');
		err2 = true;
    } else{
		//Test "jačine" lozinke
		var pass_score = checkPassStrength(ts1);
		var pass_string = '<i class="icon icon-checkmark suc-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-left:45px; font-size:21px; color:#7cc576;"> Jakost: '+pass_score+'.</p>'
		$('#org-add-status4').html(pass_string);
		err2 = false;
	}
});

$("#org-passwd2").on("keypress keyup keydown", function() {
	var ts1 = $('#org-passwd1').val();
	var ts2 = $(this).val();
	if (ts2 === ""){
		$('#org-add-status4').html('<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-top:16px;">Ponovite upis željene lozinke.</p>');
		err2 = true;
	} else if (ts1 != ts2) {
		$('#org-add-status4').html('<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-top:16px;">Unešene lozinke se ne podudaraju.</p>');
		err2 = true;
	} else {
		var pass_score = checkPassStrength(ts1);
		var pass_string = '<i class="icon icon-checkmark suc-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-left:45px; font-size:21px; color:#7cc576;"> Jakost: '+pass_score+'.</p>'
		$('#org-add-status4').html(pass_string);
		err2 = false;
	}
});		

function checkorgpass() {	
	var ts1 = $('#org-passwd1').val();
	var ts2 = $('#org-passwd2').val();
	if (ts2 === ""){
		$('#org-add-status4').html('<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-top:16px;">Ponovo upišite željenu lozinku.</p>');
		err2 = true;
	} else if (ts1 != ts2) {
		$('#org-add-status4').html('<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-top:16px;">Unešene lozinke se ne podudaraju.</p>');
		err2 = true;
	} else {
		err2 = false;
	}
}

//Registriracija ekipe
$("#reg-org").click( function(){ 
	var tn1 = $('#org-name').val();
	var tn2 = $('#org-second-name').val();
	var tbm = $('#org-broj-mob').val();
	var tme = $('#org-email').val();
	var tmu = $('#org-username').val();
	var ts1 = $('#org-passwd1').val();
	var ts2 = $('#org-passwd2').val();
	if ((err2 == false)&&(tn1 != "")&&(tn2 != "")&&(tbm != "")&&(tme != "")&&(tmu != "")&&(ts1 != "")&&(ts2 != "")){
		var ajax = ajaxObj("POST", "php_includes/organizer-registration.php");
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
							"html": "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Belot-organizer Message</title></head><body><center><table style='background:#dfdfdf;border-collapse:collapse;font-family:Georgia,Times,Times New Roman,serif;height:100%;margin:0;padding:0;width:100%' align='center' height='100%' border='0' cellpadding='0' cellspacing='0' width='600'><tbody><tr><td style='border-top:0;height:100%;margin:0;padding:0px;width:100%' align='center' valign='top'><table style='border:0;border-collapse:collapse' border='0' cellpadding='0' cellspacing='0' width='600'><tbody><tr><td align='center' valign='top'><table style='background-color:#ffffff;border-bottom:0;border-collapse:collapse;border-top:0' border='0' cellpadding='0' cellspacing='0' width='600'><tbody><tr><td valign='top'><table style='border-collapse:collapse' border='0' cellpadding='0' cellspacing='0' width='100%'><tbody><tr><td valign='top'><table style='border-collapse:collapse' align='left' border='0' cellpadding='0' cellspacing='0' width='100%'><tbody><tr><td valign='top'><img class='CToWUd' alt='' src='https://gallery.mailchimp.com/b46db128ddc3d1671fae678f5/images/3086b2ce-f9e0-4a96-8fa0-0dcbc0c6de67.gif' style='border:0;outline:none;text-decoration:none;vertical-align:bottom' align='left' width='600'></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td align='center' valign='top'><table style='background-color:#ffffff;border-bottom:0;border-collapse:collapse;border-top:0;overflow:hidden' border='0' cellpadding='0' cellspacing='0' width='600'><tbody><tr><td style='background:#ffffff' valign='top'><table style='border-collapse:collapse' border='0' cellpadding='0' cellspacing='0' width='600'><tbody><tr><td valign='top'><table style='border-collapse:collapse' align='left' border='0' cellpadding='0' cellspacing='0' width='600'><tbody><tr><td style='color:#606060;font-family:Helvetica;font-size:15px;line-height:150%;padding:60px 90px;padding-top:0px;text-align:left' valign='top'><hr style='background:#c0d1d9;border:none;min-height:1px;width:250px'><h1 style='border-bottom:none;color:#BD3C3C;display:block;font-family:Rockwell,Georgia,Times,Times New Roman,serif;font-size:15px;font-style:normal;font-weight:normal;letter-spacing:0.5px;margin:0;margin-bottom:18px;padding:0;padding-bottom:18px;text-align:center;text-transform:uppercase'>Belot - organizer</h1><p style='color:#939598;font-family:Georgia,Times,Times New Roman,serif;font-size:17px;line-height:28px;margin:1em 0;padding:0;text-align:left'>Jednostavno <a href='https://belot-organizer.herokuapp.com/organizer-activation.php?user="+tmu+"' style='color:#E06060;font-family:Georgia,Times,Times New Roman,serif;font-weight:normal;text-decoration:underline;word-wrap:break-word' target='_blank'>potvrdite Vaš e-mail</a> i slobodni Ste!</p><p style='color:#939598;font-family:Georgia,Times,Times New Roman,serif;font-size:17px;line-height:28px;margin:1em 0;padding:0;text-align:left'>Nakon toga ste u mogućnosti kreirati turnire.</p><p style='color:#939598;font-family:Georgia,Times,Times New Roman,serif;font-size:17px;line-height:28px;margin:1em 0;padding:0;text-align:left'>Vaši podaci za prijavu u sustav :<br />Korisničko ime : <span style='color:#E06060;font-family:Georgia,Times,Times New Roman,serif;font-weight:normal;word-wrap:break-word'>"+tmu+"</span><br />Lozinka : <span style='color:#E06060;font-family:Georgia,Times,Times New Roman,serif;font-weight:normal;word-wrap:break-word'>"+ts1+"</span></p><p style='color:#939598;font-family:Georgia,Times,Times New Roman,serif;font-size:17px;line-height:28px;margin:1em 0;padding:0;text-align:left'>Ukoliko imate bilo kakve upite kontaktirajte nas na <span style='color:#E06060;font-family:Georgia,Times,Times New Roman,serif;font-weight:normal;text-decoration:underline;word-wrap:break-word'>belot.organizer@gmail.com</span>.</p><p style='color:#939598;font-family:Georgia,Times,Times New Roman,serif;font-size:17px;line-height:28px;margin:1em 0;padding:0;text-align:left'>Vaš Belot-organizer Tim.</p></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td><table style='border-collapse:collapse;overflow:hidden' border='0' cellpadding='0' cellspacing='0' width='600'><tbody><tr><td valign='top'><table style='background:#f7f7f7;border-bottom:1px solid #b8d2dd;border-collapse:collapse' border='0' cellpadding='0' cellspacing='0' width='600'><tbody><tr><td valign='top'><table style='border-collapse:collapse' align='left' border='0' cellpadding='0' cellspacing='0' width='600'><tbody><tr><td style='font-family:Georgia,Times,Times New Roman,serif' valign='top'><a href='https://belot-organizer.herokuapp.com/' style='display:inline-block;padding:36px 0px 36px 32px;text-decoration:none;width:100%;word-wrap:break-word' target='_blank'><img class='CToWUd' alt='' src='https://gallery.mailchimp.com/b46db128ddc3d1671fae678f5/images/3469ee54-a118-4faf-b5b0-53c5cc2af7df.gif' style='border:0;min-height:auto;outline:none;text-decoration:none' align='left' height='94' width='95'><span style='display:inline-block;float:left;margin:21px;text-align:left'><h2 style='color:#BD3C3C;display:block;font-family:Rockwell,Georgia,Times,Times New Roman,serif;font-size:26px;font-style:normal;font-weight:normal;letter-spacing:-0.75px;line-height:125%;margin:0;padding:0;text-align:left'>Prijavite i ekipu!</h2><p style='color:#E06060;margin:0px;padding:0'><span style='display:inline-block;float:left;font-size:16px;margin:0px 5px 0px 0px;padding:0px;text-align:left'>Prijava</span><img class='CToWUd' alt='' src='https://gallery.mailchimp.com/b46db128ddc3d1671fae678f5/images/51c527d5-ec8d-4692-9bdf-bb5d863b1115.gif' style='border:0;display:inline-block;float:left;min-height:auto;margin-top:5px;outline:none;text-decoration:none' align='left' height='10' width='8'></p></span></a></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td align='center' valign='top'><table style='background:white;border-bottom:0;border-collapse:collapse;border-top:0;font-style:italic' border='0' cellpadding='0' cellspacing='0' width='600'><tbody><tr><td style='padding:12px 0px 24px 0px;padding-bottom:9px' valign='top'><table style='border-collapse:collapse' border='0' cellpadding='0' cellspacing='0' width='100%'><tbody><tr><td valign='top'><table style='border-collapse:collapse' align='left' border='0' cellpadding='0' cellspacing='0' width='600'><tbody><tr><td style='color:#bababa;font-family:Georgia,Times,Times New Roman,serif;font-size:15px;line-height:125%;padding-bottom:9px;padding-left:18px;padding-right:18px;padding-top:9px;text-align:center' valign='top'><div style='text-align:center'>Copyright © 2016 Belot-organizer • WebApp • 31 000 Osijek</div></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></center></body></html>"
						}
					});
					//Popup
					$('#org-add-succes-mail').html(tme);
					$('#global, #org-add-succes').fadeIn(550).css("display","block");
					$('body').addClass('stop-scrolling');
				}
				if(ajax.responseText == "2"){
					alert("Neuspješna registracija");
				}
	        }
        }
		ajax.send("orgregister="+tmu+"&tme="+tme+"&tn1="+tn1+"&tn2="+tn2+"&tbm="+tbm+"&ts1="+ts1);
	}
});	

//btn styling
 $("#reg-org").mouseenter(function() {  
	var tn1 = $('#org-name').val();
	var tn2 = $('#org-second-name').val();
	var tbm = $('#org-broj-mob').val();
	var tme = $('#org-email').val();
	var tmu = $('#org-username').val();
	var ts1 = $('#org-passwd1').val();
	var ts2 = $('#org-passwd2').val();
	if ((err2 == false)&&(tn1 != "")&&(tn2 != "")&&(tbm != "")&&(tme != "")&&(tmu != "")&&(ts1 != "")&&(ts2 != "")){
		$('#btn-reg-org').html("<i class='icon icon-checkmark' style='font-size:20px;'></i>");
		$("#reg-org").css("background","#7CC576").css("border-color","#4ECC7A");
	} else {
		$('#btn-reg-org').html("<i class='icon icon-cancel' style='font-size:20px;'></i>");
		$("#reg-org").css("background","#BD3C3C");
	}
	})
	.mouseleave(function() {  
    $('#btn-reg-org').text("Registriraj organizatora");
	$("#reg-org").css("background","#E06060").css("border-color","#BD3C3C");;
});

//Kreiranje novog turnira za organizatore

var err3 = true;

function checktournname() {	
	var tnname = $('#tourn-name').val();
	
	if (tnname === ""){
		$('#tourn-name-status').html(error_empty2);
		err3 = true;
	} else {
		
		var ajax = ajaxObj("POST", "php_includes/tournament-validation.php");
		//Primanje od strane php-a
		ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
				if(ajax.responseText == "0"){
					$('#tourn-name-status').html(succes);
					err3 = false;
				}
				if(ajax.responseText == "1"){
					$('#tourn-name-status').html('<i class="icon icon-cancel fal-icon input-icon"></i><label style="color:#fff">.</label><p class="validation-status" style="margin-top:17px;">Postojeći naziv turnira u sustavu.</p>');
					err3 = true;
				}
	        }
        }
		ajax.send("tnnamecheck="+tnname);

	}
}

$("#create-tn").click( function(){ 
	var maxteams = $("#team-num option:selected").text();
	var tnname = $('#tourn-name').val();
	
	if ((err3 == false)&&(tnname != "")){
		var ajax = ajaxObj("POST", "organizer");
			//Primanje od strane php-a
			ajax.onreadystatechange = function() {
				if(ajaxReturn(ajax) == true) {
					//Popup
					$('#global, #org-add-succes').fadeIn(550).css("display","block");
					$('body').addClass('stop-scrolling');
				}
			}
		ajax.send("tncreate="+tnname +"&tnmax="+maxteams);
	}	

});


