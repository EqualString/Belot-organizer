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
					<h3><i class="icon icon-clipboard"></i><?php echo $tourn_string["tournName"]; ?></h3>
				</div>
				<div class="col-md-5">
					<h3 style="margin-left:250px;"><i class="icon icon-profile2" style="margin-right:6px;"></i><?php echo $tourn_string["orgName"]; ?></h3>
				</div>	
			</div>	
			<form onsubmit="return false;">
				<div class="login-style">
					<label>Poredak</label>
					<table class="table table-bordered table-striped table-booking-history">
                        <thead>
                            <tr>
                                <th style="text-align:center;">#</th>
                                <th style="text-align:center;">Naziv ekipe</th>
								<th style="text-align:center;">Odigranih susreta</th>
								<th style="text-align:center;">Pobjede</th>
								<th style="text-align:center;">Bodovi</th>
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
								
								//2-dim array sa rezultatima
								$br = 0;
								while($row = mysqli_fetch_array($q))
									{
										$teams_comp[$br] = array();
										$teams_comp[$br]['teamName'] = $row["teamName"]; //Naziv
										$teams_comp[$br]['os'] = 0; //Odigrani susreti
										$teams_comp[$br]['w'] = 0; //Pobjede
										$teams_comp[$br]['b'] = 0; //Bodovi
										$br++;
									}	
									
									
								$sql = "SELECT * FROM `$table_name` ORDER BY game"; 
								$q = mysqli_query($db_conx, $sql);
								
								while($row = mysqli_fetch_array($q))
									{
										if(($row["res1"] != "")&&($row["res2"]!="")){ //Ako su uneseni rezultati za taj row
											for ($i = 0; $i < $br; $i++) //Prođi po cijelom 2-dim polju
											{
												if (($teams_comp[$i]['teamName'] == $row["team1"])||($teams_comp[$i]['teamName'] == $row["team2"])){ //Ako postoji i-ta ekipa koja je u row-u
													$teams_comp[$i]['os'] ++; //Povećaj odigrane susrete
													if( $teams_comp[$i]['teamName'] == $row["team1"]) { //Ako je i-ta ekipa prva
														$teams_comp[$i]['b'] = $teams_comp[$i]['b'] + $row["res1"]; //Dodaj bodove prvog rezultata
														if($row['res1'] == '2'){//Ako su ti bodovi jednaki '2', povećaj pobjede
															$teams_comp[$i]['w'] ++; 
														}
															
													}
													else { //Ako je i-ta ekipa druga
														$teams_comp[$i]['b'] = $teams_comp[$i]['b'] + $row["res2"]; //Dodaj bodove drugog rezultata
														if($row['res2'] == '2'){//Ako su ti bodovi jednaki '2', povećaj pobjede
															$teams_comp[$i]['w'] ++; 
														}
													}
												} 
											
											}
										
										}
									}
								/*
								*      |index|teamName|os|w|b| -- izgled 2-dim polja koje sadržava sve rezultate za ekipe
								*/
								
								// Dohvaća listu 
								foreach ($teams_comp as $key => $row) {
									$wins[$key]  = $row['w'];
									$points[$key] = $row['b'];
								}

								// Sortira podatke u nizu, slično kao i order by u sql-u
								array_multisort($wins, SORT_DESC, $points, SORT_DESC, $teams_comp);	

								//Ako prva i druga ekipa imaju isti broj pobjeda i bodova, pogledaj u tablicu i vidi tko je pobjedio (međusobni omjer)
								if (($teams_comp[0]['w'] == $teams_comp[1]['w'])&&($teams_comp[0]['b'] == $teams_comp[1]['b']))
								{
									$t1 = $teams_comp[0]['teamName'];//1.ekipa
									$t2 = $teams_comp[1]['teamName'];//2.ekipa
									
									$sql = "SELECT * FROM `$table_name` WHERE (team1='$t1' AND team2='$t2') OR (team1='$t2' AND team2='$t1') LIMIT 1"; 
									$q = mysqli_query($db_conx, $sql);
									$count = mysqli_num_rows($q);
									$res = mysqli_fetch_array($q); //Tražena utakmica
									
									if ((( $t1 == $res["team1"] )&&($res['res1'] != '2'))||(( $t1 == $res["team2"] )&&( $res['res2'] != '2'))){ //Prvi je izgubio, zamjeni ih
										
										//Zamjena
										$temp = $teams_comp[0];
										$teams_comp[0] = $teams_comp[1];
										$teams_comp[1] = $temp;
										
									}
								}
								
								//Ispis tablice
								for ($i = 0; $i < $br; $i++) //Prođi po cijelom 2-dim polju
								{
									echo '<tr>';
									echo '<td style="width:10%; text-align:center;">'.($i+1).'</td>';
									echo '<td style="width:30%; text-align:center;">'.$teams_comp[$i]['teamName'].'</td>';
									echo '<td style="width:20%; text-align:center;">'.$teams_comp[$i]['os'].'</td>';
									echo '<td style="width:20%; text-align:center;">'.$teams_comp[$i]['w'].'</td>';
									echo '<td style="width:20%; text-align:center;">'.$teams_comp[$i]['b'].'</td>';
									echo '</tr>';
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
                                <th style="text-align:center;">Prva ekipa</th>
								<th style="text-align:center;">Druga ekipa</th>
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
												<td class="booking-history-title" style="width:25%; text-align:center;">'.$row["team1"].'</td>
												<td class="booking-history-title" style="width:25%; text-align:center;">'.$row["team2"].'</td>
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
										
										if(($row["res1"] =="")||($row["res2"] == "")){ $error = true;} //Ako nisu uneseni svi rezultati -> turnir u tijeku
				
									}	
							
						?>
						</tbody>
					</table>		
					<hr class="tab-gap"></hr>	
					<div class="row">	
						<div id="some-status" class="col-md-6">
						<?php
							
							if ($error == true){
								echo '<h2 style="margin-right:-100px;"> Turnir je u tijeku.</h2>'; //Nisu odigrani svi susreti
							}
							else{
								//Organizator zatvara turnir 
								if(isset($_SESSION['organizator'])){
									if(($org_string['username'] == $tournOrg)&&($tourn_string['finished'] == '0')){
										echo '<input id="org-finish-tourn" class="btn btn-primary" style="height:48px;" type="submit" value="Zatvori turnir" />';
									
									}else {
										echo '<h2 style="margin-right:-100px;"> Turnir je završen.</h2>';
								     	echo '<h2><i class="icon icon-medal"></i>'.$teams_comp[0]['teamName'].'</h2>'; //Pobjednička ekipa
									}
								
								} else if ($tourn_string['finished'] == '1'){ //Organizator je već zatvorio turnir
								
									echo '<h2 style="margin-right:-100px;"> Turnir je završen.</h2>';
									echo '<h2><i class="icon icon-medal"></i>'.$teams_comp[0]['teamName'].'</h2>'; //Pobjednička ekipa
								
								} else {
									echo '<h2 style="margin-right:-100px;"> Turnir je u tijeku.</h2>'; //Odigrani svi susreti ali nije zatvoren turnir
								}
								
							}
							
							//POST za zatvaranje turnira od strane organizatora
							if(isset($_POST["FinishTournament"])){
								
								//Završetak turnira
								$sql = "UPDATE `Tournaments` SET finished='1' WHERE tournId='$tn_id' LIMIT 1"; 
								$q = mysqli_query($db_conx, $sql);
								
								//Update statusa ekipa
								$winnerName = $teams_comp[0]['teamName'];
								
								$sql="SELECT * FROM `Teams` WHERE teamName='$winnerName' LIMIT 1";
								$q = mysqli_query($db_conx, $sql);
								$winnerOldStats = mysqli_fetch_array($q);
								
								$winnerNewStats = $winnerOldStats["os_turnira"] + 1; //Osvojeni turniri
								
								$sql = "UPDATE `Teams` SET os_turnira='$winnerNewStats' WHERE teamName='$winnerName' LIMIT 1"; 
								$q = mysqli_query($db_conx, $sql);
								
								for ($i = 0; $i < $br; $i++) //Prođi po cijelom 2-dim polju
								{
									$tempName = $teams_comp[$i]['teamName'];
									
									$sql="SELECT * FROM `Teams` WHERE teamName='$tempName' LIMIT 1";
									$q = mysqli_query($db_conx, $sql);
									$tempOldStats = mysqli_fetch_array($q);
									
									$tempNewOD = $tempOldStats['od_susreta'] + $teams_comp[$i]['os']; //Povećaj odigrane turnire
									$tempNewW = $tempOldStats['pobjeda'] + $teams_comp[$i]['w']; //Povećaj pobjede
									
									$sql = "UPDATE `Teams` SET od_susreta='$tempNewOD', pobjeda='$tempNewW' WHERE teamName='$tempName' LIMIT 1"; 
									$q = mysqli_query($db_conx, $sql);
									
								}
								
								echo "1";
								exit();
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