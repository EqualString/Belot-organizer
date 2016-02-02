"use strict";

$('ul.slimmenu').slimmenu({
    resizeWidth: '992',
    collapserTitle: 'Glavni meni',
    animSpeed: 250,
    indentChildren: true,
    childrenIndenter: ''
});

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
							"html": "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Belot-organizer Message</title></head><body style='margin:0px; font-family:Tahoma, Geneva, sans-serif;'><div style='padding:10px; background:#333; font-size:24px; color:#CCC;'>Belot-organizer Account Activation</div><div style='padding:24px; font-size:17px;'>Srdačan Pozdrav! <br /><br />Kliknite na link ispod za aktivaciju računa:<br /><br /><a href='http://www.kk-slavonija.host-ed.me/activation.php?u="+tmu+"&e="+tme+"&p="+ts1+"'>Klikni ovdje</a><br /><br />Nakon aktivacije se možete prijaviti sa:<br />* E-mail adresom: <b>"+tme+"</b>, ili,<br/>* Korisničkim imenom: <b>"+tmu+"</b></div></body></html>" 
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
	
//Loader
$(window).load(function() {
	$('.global-wrap').imagesLoaded( function() {
		setTimeout(function(){
			$("#loading").fadeOut(950);
		}, 1000);	
	});

});

//IP Footer
$('#user-ip').text(myip);

//Popups
$("#show-login-org").click( function(){ 
	$('#global, #login-organizer').fadeIn(550).css("display","block");
	$('body').addClass('stop-scrolling');
});

$("#cls-loging-org").click( function(){ 
	$('#global, #login-organizer').fadeOut(550);
	$('body').removeClass('stop-scrolling');
});

$("#show-login-comp").click( function(){ 
	$('#global, #login-comp').fadeIn(550).css("display","block");
	$('body').addClass('stop-scrolling');
});
$("#cls-loging-comp").click( function(){ 
	$('#global, #login-comp').fadeOut(550);
	$('body').removeClass('stop-scrolling');
});


$("#cls-team-add-succes").click( function(){ 
	$('#global, #team-add-succes').fadeOut(550);
	$('body').removeClass('stop-scrolling');
});

$("#show-org-succes").click( function(){ 
	$('#global, #org-add-succes').fadeIn(550).css("display","block");
	$('body').addClass('stop-scrolling');
});
$("#cls-org-add-succes").click( function(){ 
	$('#global, #org-add-succes').fadeOut(550);
	$('body').removeClass('stop-scrolling');
});

$('.btn').button();

$("[rel='tooltip']").tooltip();

$('.form-group').each(function() {
    var self = $(this),
        input = self.find('input');

    input.focus(function() {
        self.addClass('form-group-focus');
    })

    input.blur(function() {
        if (input.val()) {
            self.addClass('form-group-filled');
        } else {
            self.removeClass('form-group-filled');
        }
        self.removeClass('form-group-focus');
    });
});


$('.booking-item-price-calc .checkbox label').click(function() {
    var checkbox = $(this).find('input'),
        // checked = $(checkboxDiv).hasClass('checked'),
        checked = $(checkbox).prop('checked'),
        price = parseInt($(this).find('span.pull-right').html().replace('$', '')),
        eqPrice = $('#car-equipment-total'),
        tPrice = $('#car-total'),
        eqPriceInt = parseInt(eqPrice.attr('data-value')),
        tPriceInt = parseInt(tPrice.attr('data-value')),
        value,
        animateInt = function(val, el, plus) {
            value = function() {
                if (plus) {
                    return el.attr('data-value', val + price);
                } else {
                    return el.attr('data-value', val - price);
                }
            };
            return $({
                val: val
            }).animate({
                val: parseInt(value().attr('data-value'))
            }, {
                duration: 500,
                easing: 'swing',
                step: function() {
                    if (plus) {
                        el.text(Math.ceil(this.val));
                    } else {
                        el.text(Math.floor(this.val));
                    }
                }
            });
        };
    if (!checked) {
        animateInt(eqPriceInt, eqPrice, true);
        animateInt(tPriceInt, tPrice, true);
    } else {
        animateInt(eqPriceInt, eqPrice, false);
        animateInt(tPriceInt, tPrice, false);
    }
});


$('div.bg-parallax').each(function() {
    var $obj = $(this);
    if($(window).width() > 992 ){
        $(window).scroll(function() {
            var animSpeed;
            if ($obj.hasClass('bg-blur')) {
                animSpeed = 10;
            } else {
                animSpeed = 15;
            }
            var yPos = -($(window).scrollTop() / animSpeed);
            var bgpos = '50% ' + yPos + 'px';
            $obj.css('background-position', bgpos);

        });
    }
});



$(document).ready(
    function() {

    $('html').niceScroll({
        cursorcolor: "#000",
        cursorborder: "0px solid #fff",
        railpadding: {
            top: 0,
            right: 0,
            left: 0,
            bottom: 0
        },
        cursorwidth: "10px",
        cursorborderradius: "0px",
        cursoropacitymin: 0.2,
        cursoropacitymax: 0.8,
        boxzoom: true,
        horizrailenabled: false,
        zindex: 9999
    });


        // Owl Carousel
        var owlCarousel = $('#owl-carousel'),
            owlItems = owlCarousel.attr('data-items'),
            owlCarouselSlider = $('#owl-carousel-slider'),
            owlNav = owlCarouselSlider.attr('data-nav');
        // owlSliderPagination = owlCarouselSlider.attr('data-pagination');

        owlCarousel.owlCarousel({
            items: owlItems,
            navigation: true,
            navigationText: ['', '']
        });

        owlCarouselSlider.owlCarousel({
            slideSpeed: 300,
            paginationSpeed: 400,
            // pagination: owlSliderPagination,
            singleItem: true,
            navigation: true,
            navigationText: ['', ''],
            transitionStyle: 'fade',
            autoPlay: 4500
        });


    // footer always on bottom
    var docHeight = $(window).height();
   var footerHeight = $('#main-footer').height();
   var footerTop = $('#main-footer').position().top + footerHeight;
   
   if (footerTop < docHeight) {
    $('#main-footer').css('margin-top', (docHeight - footerTop) + 'px');
   }
    }

);



$('.booking-item-review-expand').click(function(event) {
    console.log('baz');
    var parent = $(this).parent('.booking-item-review-content');
    if (parent.hasClass('expanded')) {
        parent.removeClass('expanded');
    } else {
        parent.addClass('expanded');
    }
});


$('.stats-list-select > li > .booking-item-rating-stars > li').each(function() {
    var list = $(this).parent(),
        listItems = list.children(),
        itemIndex = $(this).index();

    $(this).hover(function() {
        for (var i = 0; i < listItems.length; i++) {
            if (i <= itemIndex) {
                $(listItems[i]).addClass('hovered');
            } else {
                break;
            }
        };
        $(this).click(function() {
            for (var i = 0; i < listItems.length; i++) {
                if (i <= itemIndex) {
                    $(listItems[i]).addClass('selected');
                } else {
                    $(listItems[i]).removeClass('selected');
                }
            };
        });
    }, function() {
        listItems.removeClass('hovered');
    });
});



$('.booking-item-container').children('.booking-item').click(function(event) {
    if ($(this).hasClass('active')) {
        $(this).removeClass('active');
        $(this).parent().removeClass('active');
    } else {
        $(this).addClass('active');
        $(this).parent().addClass('active');
        $(this).delay(1500).queue(function() {
            $(this).addClass('viewed')
        });
    }
});

$('.form-group-select-plus').each(function() {
    var self = $(this),
        btnGroup = self.find('.btn-group').first(),
        select = self.find('select');
    btnGroup.children('label').last().click(function() {
        btnGroup.addClass('hidden');
        select.removeClass('hidden');
    });
});


$(document).ready(function() {
    var ul = $('#twitter-ticker').find(".tweet-list");
    var ticker = function() {
        setTimeout(function() {
            ul.find('li:first').animate({
                marginTop: '-4.7em'
            }, 850, function() {
                $(this).detach().appendTo(ul).removeAttr('style');
            });
            ticker();
        }, 5000);
    };
    ticker();
});


var tid = setInterval(tagline_vertical_slide, 2500);

// vertical slide
function tagline_vertical_slide() {
    var curr = $("#tagline ul li.active");
    curr.removeClass("active").addClass("vs-out");
    setTimeout(function() {
        curr.removeClass("vs-out");
    }, 500);

    var nextTag = curr.next('li');
    if (!nextTag.length) {
        nextTag = $("#tagline ul li").first();
    }
    nextTag.addClass("active");
}

function abortTimer() { // to be called when you want to stop the timer
    clearInterval(tid);
}