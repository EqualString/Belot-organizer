<?php
	
	session_start();
	
	//Test sesije
	//Ako postoji makni ih headerom
	if(isset($_SESSION['organizator'])){
		/*header("location: /organizer");
		exit();*/
	}
	if(isset($_SESSION['sudionik'])){
		/*header("location: /participant");
		exit();*/
	}
	
?>
<!DOCTYPE HTML>
<html>

<head>

    <title>Belot-organizer | Login</title>
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
	<link rel="stylesheet" href="css/customfont.css">
	<link rel="stylesheet" href="css/loader.css">
	<link rel="stylesheet" href="css/login.css">
	
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
	<!-- Global -->
	<div class="logo">
		<i class="icon icon-Belot-organizer"></i>
	</div>
	<!-- From toggling -->
	<div class="module form-module">
		<div class="toggle"><i class="fa fa-chevron-up fa-chevron-down"></i>
			<div class="tooltip">Klikni me</div>
		</div>
		<div class="form-toggle">
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
		
		<div class="form-toggle">
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
	</div>	
	<div class="footer">
		<p>Copyright © 2016 Belot-organizer • <span style="font-style:italic;">WebApp</span> • 31 000 Osijek</p>
	</div>
	<script src="js/vendor/jquery.js"></script>
	<script src="js/vendor/imagesloaded.pkgd.min.js"></script>
	<script src="js/ajax.js"></script>
	<script src="js/login.js"></script>

</body>
</html>	