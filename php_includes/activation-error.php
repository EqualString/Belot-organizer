<!DOCTYPE HTML>
	<!-- Dio sa greškom u aktivaciji -->
<html>
<head>
    <title>Belot-organizer | Greška</title>
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
		<div class="header-text" style="margin-left:-93px;">
			<p>Nažalost došlo je do pogreške prilikom aktivacije.</p>
		</div>
		<hr class="tab-gap gap">		
		<div class="footer">
			<p>Copyright © 2016 Belot-organizer • <span style="font-style:italic;">WebApp</span> • 31 000 Osijek</p>
		</div>
	</div>	
	<script src="js/vendor/jquery.js"></script>
	<script src="js/vendor/imagesloaded.pkgd.min.js"></script>
	<script>
		//Loader
		$(window).load(function() {
			$('.global-wrap').imagesLoaded( function() {
				setTimeout(function(){
					$("#loading").fadeOut(950);
				}, 1000);	
			});
		});
	</script>
</body>
</html>