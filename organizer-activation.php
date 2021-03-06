<?php
	session_start();
	
	include_once("php_includes/db-conx.php");
	
	if(isset($_POST["activate"])){
				
		//Aktivacija računa
		$username = $_POST["activate"];
		$sql = "UPDATE `Organizers` SET activated='1' WHERE username='$username' LIMIT 1";
		
		if (mysqli_query($db_conx, $sql)){
			$_SESSION['organizator'] = $username; 
			echo "1";	
			exit();
		} else{
			echo "2";	
			exit();		
		}
		
	}
		
	//Dohvaća string username iz 'GET', ako postoji, aktivira account
	if (isset($_GET['user'])) {
		
		$u = $_GET['user'];
		
		$sql="SELECT * FROM `Organizers` WHERE username='$u' and activated='0' LIMIT 1";
		$result = mysqli_query($db_conx, $sql);
		$count = mysqli_num_rows($result);
		
		//Postoji zapis, Prikaži Web sa reCaptch-om
		if ($count == 1){ 
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Belot-organizer | Aktivacija</title>
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
	<link rel="stylesheet" href="css/team-register.css">
	<link rel="stylesheet" href="css/loader.css">
	
	<!-- MODERNIZR -->
    <script src="js/vendor/modernizr.js"></script>
	<script src='https://www.google.com/recaptcha/api.js?hl=hr'></script>
	
</head>

<body>
	<!-- LOADER  -->
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
	<div class="container">
		<div class="logo">
			<i class="icon icon-Belot-organizer"></i>
		</div>
		<div class="logo-text">
			<p>Belot-organizer</p>
		</div>
		<hr class="tab-gap gap">		
		<div class="header-text">
			<p>Na korak ste do potpune registracije. Dokažite da ste od krvi i mesa :</p>
		</div>
		<div class="g-recaptcha" style="margin-left:-10px;" data-sitekey="6LetbBcTAAAAAOZ7lysOR74EwCHB63s-W8k47gQW" data-callback="verifyCallback"></div>
		<div id="timer"></div>
		<hr class="tab-gap gap">		
		<div class="footer">
			<p>Copyright © 2016 Belot-organizer • <span style="font-style:italic;">WebApp</span> • 31 000 Osijek</p>
		</div>
	</div>	
	<script src="js/vendor/jquery.js"></script>
	<script src="js/vendor/imagesloaded.pkgd.min.js"></script>
	<script src="js/ajax.js"></script>
	<script src="js/organizer/organizer-activation.js"></script>
	
</body>
</html><?php	
		}
		else{
			include_once ("php_includes/activation-error.php");
		}
	} else {
		include_once ("php_includes/activation-error.php");
	}

?>