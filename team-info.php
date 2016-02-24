<?php

include_once ("php_includes/db-conx.php");
session_start();

if (isset($_GET['id'])) {

	$team_id = $_GET['id'];
	
	//Session varijable,izvode se ako postoji sessija
	if(isset($_SESSION['sudionik'])){	

		$team = $_SESSION['sudionik'];
		
	}
	if(isset($_SESSION['organizator'])){

		$org = $_SESSION['organizator'];
		
	}
	
	$sql = "SELECT * FROM `Teams` WHERE teamID='$team_id' LIMIT 1"; 
	$q = mysqli_query($db_conx, $sql);
	$team_string = mysqli_fetch_array($q);
	
?>
<!DOCTYPE HTML>
<html>

<head>

    <title>Belot-organizer | <?php echo $team_string['teamName']; ?></title>
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
	<link rel="stylesheet" href="css/tournament.css">
	
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
	<?php
	//Header za ekipe/organizatore/posjetitelje
	if(isset($_SESSION['sudionik'])){
		echo '
			<div class="header" style="">
				<a href ="team" class="left"><i class="fa fa-group"></i> '.$team.'</a>
				<a href ="logout" class="right"><i class="fa fa-sign-out"></i> Odjava</a>
			</div>';
	}
	else if(isset($_SESSION['organizator'])){
		echo '
			<div class="header" style="">
				<a href ="team" class="left"><i class="icon icon-profile2"></i> '.$org.'</a>
				<a href ="logout" class="right"><i class="fa fa-sign-out"></i> Odjava</a>
			</div>';
	}else {
		echo '
			<div class="header" style="">
				<a href ="index" class="left"><i class="fa fa-home"></i> Početna</a>
				<a href ="login" class="right"><i class="fa fa-sign-in"></i> Prijava</a>
			</div>';
	
	}		
	?>
	<!-- Global -->
	<div class="logo">
		<i class="icon icon-Belot-organizer"></i>	
	</div>
	<!-- From toggling -->
	<div class="module form-module">
		<div class="form-toggle">
			<div class="row">
				<div class="col-md-5">
					<h2><i class="icon icon-team" style="font-size:50px;"></i><?php echo $team_string["teamName"]; ?></h2>
				</div>
			</div>	
			<form onsubmit="return false;">
				<div class="login-style">
					<h3>Informacije o ekipi</h3>
					<hr class="tab-gap"></hr>	
					<div class="row">
						<div class="col-md-5">
							<h4><i class="fa fa-user"></i> Ime prvog člana: <?php echo $team_string["igrac1"]; ?><h4>
						</div>	
						<div class="col-md-5">
							<h4><i class="fa fa-user"></i> Ime drugog člana: <?php echo $team_string["igrac2"]; ?><h4>
						</div>	
					</div>	
					<hr class="tab-gap"></hr>	
						<h4><i class="fa fa-phone-square"></i> Kontakt:
							<?php 
								if((isset($_SESSION['sudionik']))||(isset($_SESSION['sudionik']))){
									echo $team_string["brojMob"]; 
								}else{
									echo '<a href = "login"><span style="font-size:20px;"><i class="fa fa-exclamation-triangle"></i> Prijavite se</span></a>'; 
								}
							?>
						<h4>
						<h4><i class="fa fa-envelope"></i> E-mail:
							<?php 
								if((isset($_SESSION['sudionik']))||(isset($_SESSION['sudionik']))){
									echo $team_string["email"]; 
								}else{
									echo '<a href = "login"><span style="font-size:20px;"><i class="fa fa-exclamation-triangle"></i> Prijavite se</span></a>'; 
								}
							?>
						<h4>
					<hr class="tab-gap"></hr>	
					<h3>Rezultati</h3>
					<div class="row">
						<div class="col-md-4">
							<h2><i class="icon icon-medal"></i> <?php echo $team_string["os_turnira"]; ?><h2>
						</div>	
						<div class="col-md-4">
							<h2><i class="icon icon-victory"></i> <?php echo $team_string["pobjeda"]; ?><h2>
						</div>
						<div class="col-md-4">
							<h2><i class="icon icon-clipboard2"></i> <?php echo $team_string["od_susreta"]; ?><h2>
						</div>							
					</div>	
				</div>	
			</form>
		</div>
	</div>	
	
	<div class="footer" style="margin-bottom:30px;">
		<p>Copyright © 2016 <a href="index">Belot-organizer</a> • <span style="font-style:italic;">WebApp</span> • 31 000 Osijek</p>
	</div>
	
	<script src="js/vendor/jquery.js"></script>
	<script src="js/vendor/bootstrap.js"></script>
	<script src="js/vendor/nicescroll.js"></script>
	<script src="js/vendor/imagesloaded.pkgd.min.js"></script>
	<script src="js/ajax.js"></script>
	<script src="js/tournament.js"></script>

</body>
</html>	
<?php
} else {
	include ("php_includes/team-info-error.php");
}
?>