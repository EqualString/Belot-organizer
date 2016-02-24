<?php

include_once ("php_includes/db-conx.php");
session_start();

if ((isset($_GET['game']))&&(isset($_GET['table']))) {
	
	$game = $_GET['game']; 
	$table = $_GET['table'];
	
	//Session varijable,izvode se ako postoji sessija
	if(isset($_SESSION['sudionik'])){
		
		//Dohvaćanje podataka o ekipi putem sessije
		$team = $_SESSION['sudionik'];
		$sql="SELECT * FROM `Teams` WHERE username='$team' LIMIT 1";
		$q = mysqli_query($db_conx, $sql);
		$team_string = mysqli_fetch_array($q);
		$my_team = $team_string["teamName"];
		
	}else {
		header("location: /login");
		exit();
	}

	
	$table_name = "Results_".$table; //Ime tablice rezultata
	$sql = "SELECT * FROM `$table_name` WHERE game='$game' LIMIT 1"; 
	$q = mysqli_query($db_conx, $sql);
	$count = mysqli_num_rows($q);
	$game_string = mysqli_fetch_array($q);
		
	//Postoji zapis, Prikaži turnir
	if (($count == 1)&&($game_string["res1"] == "")&&($game_string["res2"] == "")){ 

?>
<!DOCTYPE HTML>
<html>

<head>

    <title>Belot-organizer | Utakmica</title>
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
	//Header za ekipe/organizatore
	if(isset($_SESSION['sudionik'])){
		echo '
			<div class="header" style="">
				<a href ="team" class="left"><i class="fa fa-group"></i> '.$team.'</a>
				<a href ="logout" class="right"><i class="fa fa-sign-out"></i> Odjava</a>
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
			<h3><i class="icon icon-clipboard"></i>Utakmica</h3>
			<form onsubmit="return false;">
				<div class="login-style">
					<div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-group-lg">
                                <label style="margin-left:120px;"><?php echo $game_string["team1"]; ?></label>
                                <input id="res1" class="form-control" placeholder="Rezultat prve ekipe" type="text" />
                             </div>
                        </div>
                        <div class="col-md-4" style="margin-left:130px;">
                            <div class="form-group form-group-lg">
                                <label style="margin-left:120px;"><?php echo $game_string["team2"]; ?></label>
                                <input id="res2" class="form-control" placeholder="Rezultat druge ekipe" type="text" />
                             </div>
                        </div> 
					</div>	
					<div class="row">
                        <div class="col-md-4">
							<label style="margin-left:135px;"><h2 id="res1-uk">0</h2></label>
						</div>
						<div class="col-md-4">
							<label style="margin-left:265px;"><h2 id="res2-uk">0</h2></label>
						</div>
					</div>	
					<div class="row">
						<button id="unos" class="btn btn-default btn-lg" style="width:100px; font-size:16px; margin-left:300px; margin-bottom:30px; margin-top:-10px;">U redu</button>
					</div>
					<div class="row">
						<div class="col-md-4" style="margin-left:232px;">
							<table class="table table-bordered table-striped table-booking-history">
							<thead>
								<tr>
									<th style="text-align:center; font-size:18px;">MI</th>
									<th style="text-align:center; font-size:18px;">VI</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td id="res1-part" style="text-align:center; font-size:15px; width:50%;">0</td>
									<td id="res2-part" style="text-align:center; font-size:15px; width:50%;">0</td>
								</tr>	
							</tbody>
						</table>	
						</div>
					</div>	
					<hr class="tab-gap"></hr>
					<div id = "status">		
						<button id="save-res" class="btn btn-primary btn-lg" style="width:200px; margin-left:235px; display:none;">Spremi rezultat</button>
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
	<script src="js/match.js"></script>

</body>
</html>	
<?php
	//Greške kod ne dohvaćanja id-a ili nepostojećeg turnira
	}
	else {
		include_once ("php_includes/tournament-error.php");
	}
}
else {
	include_once ("php_includes/tournament-error.php");
}
?>