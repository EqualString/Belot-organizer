<?php
include_once ("php_includes/db-conx.php");
session_start();

if (isset($_GET['tournament'])) {
	
	$tn_id = $_GET['tournament']; //id turnira iz URL-a
	
	//Session varijable,izvode se ako postoji sessija
	if(isset($_SESSION['sudionik'])){
		
		//Dohvaćanje podataka o ekipi putem sessije
		$team = $_SESSION['sudionik'];
		$sql="SELECT * FROM `Teams` WHERE username='$team' LIMIT 1";
		$q = mysqli_query($db_conx, $sql);
		$team_string = mysqli_fetch_array($q);
		$my_team = $team_string["teamName"];
		
	}
	if(isset($_SESSION['organizator'])){
		
		//Dohvaćanje podataka o organizatoru putem sessije
		$org = $_SESSION['organizator'];
		$sql="SELECT * FROM `Organizers` WHERE username='$org' LIMIT 1";
		$q = mysqli_query($db_conx, $sql);
		$org_string = mysqli_fetch_array($q);
		
	}
	
	$table_name = "Results_".$tn_id; //Ime tablice rezultata
	
	$sql="SELECT * FROM `Tournaments` WHERE tournId='$tn_id' AND resultsTable='$table_name' LIMIT 1";
	$q = mysqli_query($db_conx, $sql);
	$count = mysqli_num_rows($q);
	$tourn_string = mysqli_fetch_array($q);
	$tournOrg = $tourn_string["orgName"];
		
	//Postoji zapis, Prikaži turnir
	if ($count == 1){ 

?>
<!DOCTYPE HTML>
<html>

<head>

    <title>Belot-organizer | Turnir</title>
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
	if(isset($_SESSION['organizator'])){
		echo '
			<div class="header" style="">
				<a href ="team" class="left"><i class="icon icon-clipboard"></i> '.$org.'</a>
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
			<h3><i class="icon icon-clipboard"></i><?php echo $tourn_string["tournName"]; ?></h3>
			<form onsubmit="return false;">
				<div class="login-style">
					<label>Poredak</label>
					<table class="table table-bordered table-striped table-booking-history">
                        <thead>
                            <tr>
                                <th style="text-align:center;">#</th>
                                <th>Naziv ekipe</th>
                            </tr>
                        </thead>
                        <tbody>
						<?php
							//Tablica poretka
							
							$teams_in = $tourn_string["teamsIn"];
							
							if ($teams_in == '0') { echo '<td class="booking-history-type">Nema prijavljenih ekipa.</td>
														  <td class="booking-history-title">Nema prijavljenih ekipa.</td>';}
							else {
							
								$sql = "SELECT * FROM `Teams` WHERE teamID IN ($teams_in) ORDER BY teamID"; 
								$q = mysqli_query($db_conx, $sql);
								
								$br = 1;
								while($row = mysqli_fetch_array($q))
									{
										echo '
											<tr>
												<td class="booking-history-type">'.$br.'</td>
												<td class="booking-history-title">'.$row["teamName"].'</td>
											</tr>';
											
										$br++;
									}	
							}
						?>
						</tbody>
					</table>		
					<label>Raspored utakmica</label>
					<table class="table table-bordered table-striped table-booking-history">
                        <thead>
                            <tr>
                                <th style="text-align:center;">#</th>
                                <th>Prva ekipa</th>
								<th>Druga ekipa</th>
								<th>Prvi rezultat</th>
								<th>Drugi rezultat</th>
								<th style="text-align:center;"><i class="icon icon-clipboard2" style="font-size:30px;"></i></th>
                            </tr>
                        </thead>
                        <tbody>
						<?php
								//Tablica utakmica
								
								$sql = "SELECT * FROM `$table_name` ORDER BY game"; 
								$q = mysqli_query($db_conx, $sql);
								
								$done = false;
								$error = false;
								
								while($row = mysqli_fetch_array($q))
									{
										echo '
											<tr>
												<td class="booking-history-type" style="width:10%;">'.$row["game"].'</td>
												<td class="booking-history-title" style="width:25%;">'.$row["team1"].'</td>
												<td class="booking-history-title" style="width:25%;">'.$row["team2"].'</td>
												<td class="booking-history-title" style="width:10%; text-align:center;">'.$row["res1"].'</td>
												<td class="booking-history-title" style="width:10%; text-align:center;">'.$row["res2"].'</td>';
												
										if(($row["res1"] != "")&&($row["res2"]!="")){ //Već odigrani susreti
											echo '<td class="booking-history-title" style="width:20%; text-align:center;"><i class="icon icon-checkmark"></i></td>';
										}		
										else if(isset($_SESSION['sudionik'])){ //Može samo logirana ekipa
											if (($row["res1"] == "")&&($row["res2"]=="")&&(($my_team == $row["team1"])||($my_team == $row["team2"]))&&($done == false))	{ //Logirana ekipa prijavljena na turnir
											
												echo '<td class="booking-history-title" style="width:20%; text-align:center;">
													  <a class="btn btn-default btn-sm" href="match.php?game='.$row["game"].'&table='.$tn_id.'">Igraj</a></td>';
													  
												$done = true; //Samo se prva utakmica može igrati
												
											}	
										}
										else{
											echo '<td class="booking-history-title" style="width:20%; text-align:center;">-</td>';
										}										
										
										echo '</tr>';
										
										if(($row["res1"] =="")||($row["res2"] == "")){ $error = true;}
				
									}	
							
						?>
						</tbody>
					</table>		
					<hr class="tab-gap"></hr>	
					<div class="row">	
						<div class="col-md-6">
						<?php
							
							if ($error == true){
								echo '<h2 style="margin-right:-100px;"> Turnir je u tijeku.</h2>';
							}
							else{
								echo '<h2 style="margin-right:-100px;"> Turnir je završio.</h2>';
								
								$sql = "UPDATE `Tournaments` SET finished='1' WHERE tournId='$tn_id' LIMIT 1";
								$q = mysqli_query($db_conx, $sql);
							}
						
						?>	
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