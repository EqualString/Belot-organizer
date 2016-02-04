<?php
	session_start();
	
	//Dohvaća string username iz 'GET', ako postoji, aktivira account
	if (isset($_GET['user'])) {
		
		include_once("php_includes/db-conx.php");
		require "php_includes/recaptchalib.php";

		$u = $_GET['user'];
		
		$sql="SELECT * FROM `Teams` WHERE username='$u' and activated='0' LIMIT 1";
		$result = mysqli_query($db_conx, $sql);
		$count = mysqli_num_rows($result);
		
		//Postoji zapis, Prikaži Web sa reCaptch-om
		if ($count == 1){ 
			
			//ReCaptcha
			$secret = "6LetbBcTAAAAAErncFuDv2DGcFAcRTIorbdXgJoQ";
			$response = null;
			$reCaptcha = new ReCaptcha($secret);
			
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
    <script src="js/modernizr.js"></script>
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
		<hr class="tab-gap gap">		
		<div class="footer">
			<p>Copyright © 2016 Belot-organizer • <span style="font-style:italic;">WebApp</span> • 31 000 Osijek</p>
		</div>
	</div>	
	<script src="js/jquery.js"></script>
	<script src="js/ajax.js"></script>
	<script src="js/imagesloaded.pkgd.min.js"></script>
	<script>
		//Loader
		$(window).load(function() {
			$('.global-wrap').imagesLoaded( function() {
				setTimeout(function(){
					$("#loading").fadeOut(950);
				}, 1000);	
			});
		});
		var verifyCallback = function( response ) {
			setTimeout(function(){
				var ajax = ajaxObj("POST", "team-activation.php");
				ajax.send("activate");
			}, 2500);	
		};
	</script>
	<?php
		
		if(isset($_POST["activate"])){
			
			//Aktivacija računa
			$sql = "UPDATE `Teams` SET activated='1' WHERE username='$u' LIMIT 1";
			$query = mysqli_query($db_conx, $sql);
			
			//Stvaranje sessije
			$_SESSION['sudionik'] = $u; 
			header("location: index");
		}
	?>
</body>
</html><?php	
		}
		else{
			echo"došlo je do Greške";
		}
	}

?>