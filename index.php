<?php
	include "php_includes/db-conx.php";
	session_start();
	
	//Test sesije
	if(isset($_SESSION['organizator'])){
		header("location: organizer.php");
	}
	if(isset($_SESSION['sudionik'])){
		header("location: participant.php");
	}
	
?>
<!DOCTYPE HTML>
<html>

<head>

    <title>Belot-organizer | Početna</title>
	<link rel="shortcut icon" href="img/favicon.png">
	<!-- METAS -->
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords" content="Tournament organizer,Belot" />
    <meta name="description" content="Web app for Belot tournament organization">
    <meta name="author" content="Matej Prpic">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- STYLES -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/mystyles.css">
	<link rel="stylesheet" href="css/customfont.css">
	<link rel="stylesheet" href="css/loader.css">
	
	<!-- MODERNIZR -->
    <script src="js/modernizr.js"></script>
	
</head>

<body>
	<!-- LOADER -->
	<div id="loading">
		<div id="loading-center">
			<div id="loading-center-absolute">
				<div class="loading-logo">
					<i class="icon icon-Belot-organizer"></i>
				</div>
				<div class="animated_lines" id="line_one"></div>
				<div class="animated_lines" id="line_two"></div>
				<div class="loading-text">
					<p>Belot-organizer</p>
				</div>
			</div>
		</div>
	</div>
	<!-- GLOBAL -->
    <div class="global-wrap">
	<div id="global"></div>
	<!-- HEADER -->
        <header id="main-header">
            <div class="header-top">
                <div class="container">
                    <div>
                        <div class="top-logo">
                            <a class="logo" href="index.html">
								<i class="icon icon-srce"></i>
								<i class="icon icon-buc"></i>
								<i class="icon icon-zel"></i>
								<i class="icon icon-zir"></i>
								Belot - Organizer ®
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="nav">
                    <ul class="slimmenu" id="slimmenu">
                        <li class="active"><a href="index.html">Početna</a></li>
                        <li><a href="success-payment.html">Turniri</a>
                            <ul>
                                <li><a href="success-payment.html">U tijeku</a></li>
                                <li><a href="user-profile.html">Nadolazeći</a></li>
								<li><a href="user-profile.html">Rezultati</a></li>
                            </ul>
                        </li>
                        <li style="float:right;"><a href="#"><span class="fa fa-lock"></span> Prijava</a>
                            <ul>                            
                                <li><a id="show-login-org" href="#">Organizatori</a></li>
                                <li><a id="show-login-comp" href="#">Sudionici</a></li>
                            </ul>
                        </li>        
                    </ul>
                </div>
            </div>
        </header>

        <!-- TOP -->
        <div class="top-area show-onload">
            <div class="owl-carousel owl-slider owl-carousel-area" id="owl-carousel-slider">
                <div class="bg-holder full text-center text-white">
                    <div class="bg-mask"></div>
                    <div class="bg-img" style="background-image:url(img/bg1.jpg);"></div>
                    <div class="bg-front full-center">
                        <div class="owl-cap">
							<div class="owl-logo">
								<h5><i class="icon icon-Belot-organizer"></i></h5>
							</div>
                            <h1 class="owl-cap-title fittext">Turnir u belotu</h1>
                            <div class="owl-cap-price"><small>Želite prijaviti</small>
                                <h5>Vlastitu ekipu?</h5>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="bg-holder full text-center text-white">
                    <div class="bg-mask"></div>
                    <div class="bg-img" style="background-image:url(img/bg2.jpg);"></div>
                    <div class="bg-front full-center">
                        <div class="owl-cap">
							<div class="owl-logo">
								<h5><i class="icon icon-Belot-organizer"></i></h5>
							</div>
                            <h1 class="owl-cap-title fittext">Turnir u belotu</h1>
                            <div class="owl-cap-price"><small>Zainteresirani ste za mjesto</small>
                                <h5>Organizatora?</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
		<!-- TABS -->
		<div class="container">
            <div class="search-tabs search-tabs-bg search-tabs-to-top">
                <div class="tabbable">
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active"><a href="#tab-1" data-toggle="tab"><i class="icon icon-user-profile-plus"></i> <span >Registracija ekipe</span></a>
                        </li>
                        <li><a href="#tab-2" data-toggle="tab"><i class="icon icon-organizer-profile"></i> <span >Registracija organizatora</span></a>
                        </li>
                    </ul>
                    <div class="tab-content">
						<!-- Dodavanje ekipe -->
                        <div class="tab-pane fade in active" id="tab-1">
                            <h2>Registriraj vlastitu ekipu <i class="icon icon-addteam"></i></h2>
                            <form onsubmit="return false;">
								<h4>Podaci o ekipi</h4>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-user input-icon"></i>
                                            <label>Ime 1. člana</label>
                                            <input id="team-name1" onblur="checkplayername()" class="form-control" placeholder="Ime prvog člana ekipe" type="text" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-user input-icon"></i>
                                            <label>Ime 2. člana</label>
                                            <input id="team-name2" onblur="checkplayername()" class="form-control" placeholder="Ime drugog člana ekipe" type="text" />
                                        </div>
                                    </div> 
									<div class="col-md-4">
										<div id="team-add-status1" class="form-group form-group-lg form-group-icon-left">
                                        </div>
                                    </div>									
                                </div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-file-text input-icon"></i>
                                            <label>Naziv ekipe</label>
                                            <input id="team-name" onblur="checkteamname()" class="form-control" placeholder="Naziv Vaše ekipe" type="text" />
                                        </div>
                                    </div>
									<div class="col-md-4">
										<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-phone input-icon"></i>
                                            <label>Broj telefona</label>
                                            <input id="team-broj-mob" onblur="checkteamname()" class="form-control" placeholder="Broj kontakt telefona" type="text" />
                                        </div>
                                    </div>
									<div class="col-md-4">
										<div id="team-add-status2" class="form-group form-group-lg form-group-icon-left">
                                        </div>
                                    </div>
								</div>
								<hr class="tab-gap">
								<h4>Podaci za prijavu u sustav</h4>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-envelope input-icon"></i>
                                            <label>E-mail adresa</label>
                                            <input id="team-email" onblur="checkteammail()" class="form-control" placeholder="Kontakt mail" type="text" />
                                        </div>
                                    </div>
									<div class="col-md-4">
										<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-group input-icon"></i>
                                            <label>Korisničko ime</label>
                                            <input id="team-username" onblur="checkteammail()" class="form-control" placeholder="Korisničko ime" type="text" />
                                        </div>
                                    </div>
									<div class="col-md-4">
										<div id="team-add-status3" class="form-group form-group-lg form-group-icon-left">
                                        </div>
                                    </div>	
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-key input-icon"></i>
                                            <label>Lozinka</label>
                                            <input id="team-passwd1" onblur="checkteampass()" class="form-control" placeholder="Vaša lozinka" type="password" />
                                        </div>
                                    </div>
									<div class="col-md-4">
										<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-key input-icon"></i>
                                            <label>Ponovljena lozinka</label>
                                            <input id="team-passwd2" onblur="checkteampass()" class="form-control" placeholder="Vaša lozinka" type="password" />
                                        </div>
                                    </div>
									<div class="col-md-4">
										<div id="team-add-status4" class="form-group form-group-lg form-group-icon-left">
                                        </div>
                                    </div>	
								</div>
                                <button type="submit" id="reg-team" class="btn btn-primary btn-lg">Registriraj ekipu</button>
                            </form>
					
                        </div>
						<!-- Dodavanje organizatora -->
                        <div class="tab-pane fade" id="tab-2">
                            <h2>Registriraj se kao organizator <i class="icon icon-add-organizer"></i></h2>
                            <form>
								<h4>Osobni podaci</h4>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-user input-icon"></i>
                                            <label>Ime </label>
                                            <input class="form-control" placeholder="Vaše ime" type="text" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-user input-icon"></i>
                                            <label>Prezime</label>
                                            <input class="form-control" placeholder="Vaše prezime" type="text" />
                                        </div>
                                    </div>   
                                </div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-phone input-icon"></i>
                                            <label>Broj telefona</label>
                                            <input class="form-control" placeholder="Broj kontakt telefona" type="text" />
                                        </div>
                                    </div>
								</div>
								<hr class="tab-gap">
								<h4>Podaci za prijavu u sustav</h4>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-envelope input-icon"></i>
                                            <label>E-mail adresa</label>
                                            <input class="form-control" placeholder="Kontakt mail" type="text" />
                                        </div>
                                    </div>
									<div class="col-md-4">
										<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-key input-icon"></i>
                                            <label>Lozinka</label>
                                            <input class="form-control" placeholder="Vaša lozinka" type="password" />
                                        </div>
                                    </div>
								</div>
                                <button id="show-org-succes" class="btn btn-primary btn-lg">Registriraj organizatora</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gap"></div>
            <div class="gap gap-small"></div>
            <div class="gap gap-small"></div>
        </div>
		
		<!-- FOOTER -->
        <footer id="main-footer">
            <div class="container">
                <div class="row row-wrap">
                    <div class="col-md-3">
                        <div class="top-logo">
							<a class="logo" href="index.html">
								<i class="icon icon-Belot-organizer" style="font-size:50px; margin-top:-20px;"></i>
								<span style="font-size:23px;">Belot - Organizer ®</span>
							</a>
						</div>
                        <p class="mb20">Pomoć u organiziranju i izvođenju turnira u belotu. Pratite nas na:</p>
                        <ul class="list list-horizontal list-space">
                            <li>
                                <a class="fa fa-facebook box-icon-normal round animate-icon-bottom-to-top" href="#"></a>
                            </li>
                            <li>
                                <a class="fa fa-twitter box-icon-normal round animate-icon-bottom-to-top" href="#"></a>
                            </li>
                            <li>
                                <a class="fa fa-google-plus box-icon-normal round animate-icon-bottom-to-top" href="#"></a>
                            </li>
                            <li>
                                <a class="fa fa-linkedin box-icon-normal round animate-icon-bottom-to-top" href="#"></a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h4>Imate pitanja?</h4>
                        <h4 class="text-color">+385 098 948 7820</h4>
                        <h4><a href="#" class="text-color">belot.organizer@gmail.com</a></h4>
                        <p>Vaša IP adresa: <span id="user-ip" style="font-size:14px;"></span>.</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
	<!-- POPUPS -->
	<div id="login-organizer">
		<a class="icon icon-cancel" id ="cls-loging-org"></a>
		<h3>Prijava kao organizator</h3>
		<form>
			<div class="login-style">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-envelope input-icon"></i>
							<label>E-mail adresa</label>
							<input class="typeahead form-control" placeholder="E-mail adresa" type="text" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-key input-icon"></i>
							<label>Lozinka</label>
							<input class="typeahead form-control" placeholder="Lozinka" type="password" />
						</div>
					</div>
				</div>	
				<hr class="tab-gap">					
				<input class="btn btn-primary" style="height:48px;" type="submit" value="Prijava" />
			</div>	
        </form>
	</div>
	<div id="login-comp">
		<a class="icon icon-cancel" id ="cls-loging-comp"></a>
		<h3>Prijava kao sudionik</h3>
		<form>
			<div class="login-style">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-envelope input-icon"></i>
							<label>E-mail adresa</label>
							<input class="typeahead form-control" placeholder="E-mail adresa" type="text" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-key input-icon"></i>
							<label>Lozinka</label>
							<input class="typeahead form-control" placeholder="Lozinka" type="password" />
						</div>
					</div>
				</div>	
				<hr class="tab-gap">					
				<input class="btn btn-primary" style="height:48px;" type="submit" value="Prijava" />
			</div>	
        </form>
	</div>
	<div id="team-add-succes">
		<a class="icon icon-cancel" id ="cls-team-add-succes"></a>
		<h3>Uspješno ste registrirali ekipu!</h3>
		<h4>Na korak ste do potpune registracije. Molimo provjerite uneseni e-mail: <span id="team-add-succes-mail"></span>, zbog aktivacije računa.</h4>
	</div>
	<div id="org-add-succes">
		<a class="icon icon-cancel" id ="cls-org-add-succes"></a>
		<h3>Uspješno ste se registrirali kao organizator!</h3>
		<h4>Na korak ste do potpune registracije. Molimo provjerite uneseni e-mail: <span id="org-add-succes-mail"></span> zbog aktivacije računa.</h4>
	</div>
	
	<script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/slimmenu.js"></script>
    <script src="js/nicescroll.js"></script>
    <script src="js/owl-carousel.js"></script>
	<script src="js/ajax.js"></script>
	<script src="js/mandrill.js"></script>
	<script type="text/javascript" src="https://www.l2.io/ip.js?var=myip"></script>
	<script src="js/imagesloaded.pkgd.min.js"></script>
	<script src="js/passwd-strenght.js"></script>
    <script src="js/main.js"></script>
</body>
</html>


