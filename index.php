<?php
	include_once("php_includes/db-conx.php");
	
	session_start();
	
	//Test sesije
	//Ako postoji makni ih headerom
	if(isset($_SESSION['organizator'])){
		header("location: /organizer");
		exit();
	}
	if(isset($_SESSION['sudionik'])){
		header("location: /team");
		exit();
	}
	
?>
<!DOCTYPE HTML>
<html>

<head>

    <title>Belot-organizer | Početna</title>
	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
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
    <script src="js/vendor/modernizr.js"></script>
	
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
                            <a class="logo" href="index">
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
                        <li class="active"><a href="index">Početna</a></li>
                        <li><a>Turniri</a>
                            <ul>
                                <li><a href="success-payment.html">U tijeku</a></li>
                                <li><a href="user-profile.html">Nadolazeći</a></li>
                            </ul>
                        </li>
                        <li style="float:right;"><a><span class="fa fa-sign-in"></span> Prijava</a>
                            <ul>                            
                                <li><a id="show-login-org">Organizatori</a></li>
                                <li><a id="show-login-comp">Sudionici</a></li>
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
                        <li><a href="#tab-2" data-toggle="tab"><i class="icon icon-profile2"></i> <span >Registracija organizatora</span></a>
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
                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-user input-icon input-icon-hightlight"></i>
                                            <label>Ime 1. člana</label>
                                            <input id="team-name1" onblur="checkplayername()" class="form-control" placeholder="Ime prvog člana ekipe" type="text" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-user input-icon input-icon-hightlight"></i>
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
										<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-file-text input-icon input-icon-hightlight"></i>
                                            <label>Naziv ekipe</label>
                                            <input id="team-name" onblur="checkteamname()" class="form-control" placeholder="Naziv Vaše ekipe" type="text" />
                                        </div>
                                    </div>
									<div class="col-md-4">
										<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-phone-square input-icon input-icon-hightlight"></i>
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
										<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-envelope input-icon input-icon-hightlight"></i>
                                            <label>E-mail adresa</label>
                                            <input id="team-email" onblur="checkteammail()" class="form-control" placeholder="Kontakt mail" type="text" />
                                        </div>
                                    </div>
									<div class="col-md-4">
										<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-group input-icon input-icon-hightlight"></i>
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
										<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-key input-icon input-icon-hightlight"></i>
                                            <label>Lozinka</label>
                                            <input id="team-passwd1" onblur="checkteampass()" class="form-control" placeholder="Vaša lozinka" type="password" />
                                        </div>
                                    </div>
									<div class="col-md-4">
										<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-key input-icon input-icon-hightlight"></i>
                                            <label>Ponovljena lozinka</label>
                                            <input id="team-passwd2" onblur="checkteampass()" class="form-control" placeholder="Vaša lozinka" type="password" />
                                        </div>
                                    </div>
									<div class="col-md-4">
										<div id="team-add-status4" class="form-group form-group-lg form-group-icon-left">
                                        </div>
                                    </div>	
								</div>
                                <button type="submit" id="reg-team" class="btn btn-primary btn-lg" style="width:200px;"><span id="btn-reg-tm">Registriraj ekipu</span></button>
                            </form>
                        </div>
						<!-- Dodavanje organizatora -->
                        <div class="tab-pane fade" id="tab-2">
                            <h2>Registriraj se kao organizator <i class="icon icon-add-organizer"></i></h2>
                            <form onsubmit="return false;">
								<h4>Vaši podaci</h4>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-user input-icon input-icon-hightlight"></i>
                                            <label>Ime</label>
                                            <input id="org-name" onblur="checkorgname()" class="form-control" placeholder="Vaše ime" type="text" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-user input-icon input-icon-hightlight"></i>
                                            <label>Prezime</label>
                                            <input id="org-second-name" onblur="checkorgname()" class="form-control" placeholder="Vaše prezime" type="text" />
                                        </div>
                                    </div> 
									<div class="col-md-4">
										<div id="org-add-status1" class="form-group form-group-lg form-group-icon-left">
                                        </div>
                                    </div>									
                                </div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-phone-square input-icon input-icon-hightlight"></i>
                                            <label>Broj telefona</label>
                                            <input id="org-broj-mob" onblur="checkorgmob()" class="form-control" placeholder="Broj kontakt telefona" type="text" />
                                        </div>
                                    </div>
									<div class="col-md-4">
										<div id="org-add-status2" class="form-group form-group-lg form-group-icon-left">
                                        </div>
                                    </div>
								</div>
								<hr class="tab-gap">
								<h4>Podaci za prijavu u sustav</h4>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-envelope input-icon input-icon-hightlight"></i>
                                            <label>E-mail adresa</label>
                                            <input id="org-email" onblur="checkorgmail()" class="form-control" placeholder="Kontakt mail" type="text" />
                                        </div>
                                    </div>
									<div class="col-md-4">
										<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-group input-icon input-icon-hightlight"></i>
                                            <label>Korisničko ime</label>
                                            <input id="org-username" onblur="checkorgmail()" class="form-control" placeholder="Korisničko ime" type="text" />
                                        </div>
                                    </div>
									<div class="col-md-4">
										<div id="org-add-status3" class="form-group form-group-lg form-group-icon-left">
                                        </div>
                                    </div>	
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-key input-icon input-icon-hightlight"></i>
                                            <label>Lozinka</label>
                                            <input id="org-passwd1" onblur="checkorgpass()" class="form-control" placeholder="Vaša lozinka" type="password" />
                                        </div>
                                    </div>
									<div class="col-md-4">
										<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-key input-icon input-icon-hightlight"></i>
                                            <label>Ponovljena lozinka</label>
                                            <input id="org-passwd2" onblur="checkorgpass()" class="form-control" placeholder="Vaša lozinka" type="password" />
                                        </div>
                                    </div>
									<div class="col-md-4">
										<div id="org-add-status4" class="form-group form-group-lg form-group-icon-left">
                                        </div>
                                    </div>	
								</div>
                                <button type="submit" id="reg-org" class="btn btn-primary btn-lg" style="width:250px;"><span id="btn-reg-org">Registriraj organizatora</span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gap"></div>
            <div class="gap gap-small"></div>
            <div class="gap gap-small"></div>
        </div>
		
		<?php
			include_once ("php_includes/footer.php")
		?>
		
    </div>
	<!-- POPUPS -->
	<!-- Login -->
	<div id="login-organizer">
		<a class="icon icon-cancel" id ="cls-loging-org"></a>
		<h3>Prijava kao organizator</h3>
		<form onsubmit="return false;">
			<div class="login-style">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-user input-icon input-icon-hightlight"></i>
							<label>Korisničko ime</label>
							<input id="organizer-login-username" class="form-control" placeholder="Korisničko ime" type="text" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-key input-icon input-icon-hightlight"></i>
							<label>Lozinka</label>
							<input id="organizer-login-password" class="form-control" placeholder="Lozinka" type="password" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div id="organizer-login-status" class="form-group">
						</div>
					</div>
				</div>					
				<hr class="tab-gap"></hr>					
				<input id="organizer-login-btn" class="btn btn-primary" style="height:48px;" type="submit" value="Prijava" />
			</div>	
        </form>
	</div>
	
	<div id="login-comp">
		<a class="icon icon-cancel" id ="cls-loging-comp"></a>
		<h3>Prijava kao sudionik</h3>
		<form onsubmit="return false;">
			<div class="login-style">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-envelope input-icon input-icon-hightlight"></i>
							<label>Korisničko ime</label>
							<input id="team-login-username" class="form-control" placeholder="Korisničko ime" type="text" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-key input-icon input-icon-hightlight"></i>
							<label>Lozinka</label>
							<input id="team-login-password" class="form-control" placeholder="Lozinka" type="password" />
						</div>
					</div>
				</div>	
				<div class="row">
					<div class="col-md-4">
						<div id="team-login-status" class="form-group">
						</div>
					</div>
				</div>	
				<hr class="tab-gap"></hr>					
				<input id="team-login-btn" class="btn btn-primary" style="height:48px;" type="submit" value="Prijava" />
			</div>	
        </form>
	</div>
	<!-- Registracija -->
	<div id="team-add-succes">
		<a class="icon icon-cancel" id ="cls-team-add-succes"></a>
		<h3>Uspješno ste registrirali ekipu!</h3>
		<h4>Na korak ste do potpune registracije. Molimo provjerite uneseni e-mail: <span id="team-add-succes-mail"></span>, zbog aktivacije računa.</h4>
	</div>
	<div id="org-add-succes">
		<a class="icon icon-cancel" id ="cls-org-add-succes"></a>
		<h3>Uspješno ste se registrirali kao organizator!</h3>
		<h4>Na korak ste do potpune registracije. Molimo provjerite uneseni e-mail: <span id="org-add-succes-mail"></span>, zbog aktivacije računa.</h4>
	</div>
	
	<script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/bootstrap.js"></script>
    <script src="js/vendor/slimmenu.js"></script>
    <script src="js/vendor/nicescroll.js"></script>
    <script src="js/vendor/owl-carousel.js"></script>
	<script src="js/vendor/imagesloaded.pkgd.min.js"></script>
	<script src="js/vendor/mandrill.js"></script>
	<script type="text/javascript" src="https://www.l2.io/ip.js?var=myip"></script>
	<script src="js/ajax.js"></script>
	<script src="js/passwd-strenght.js"></script>
	<script src="js/team/team-main.js"></script>
	<script src="js/team/team-login.js"></script>
	<script src="js/organizer/organizer-main.js"></script>
	<script src="js/organizer/organizer-login.js"></script>
    <script src="js/main.js"></script>
</body>
</html>


