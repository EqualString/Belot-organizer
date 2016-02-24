<?php
include_once ("php_includes/db-conx.php");
session_start();

if (isset($_GET['id'])) {
	
	$tn_id = $_GET['id']; //id turnira iz URL-a
	
	//Session varijable,izvode se ako postoji sessija
	if(isset($_SESSION['sudionik'])){
		
		//Dohvaćanje podataka o ekipi putem sessije
		$team = $_SESSION['sudionik'];
		$sql="SELECT * FROM `Teams` WHERE username='$team' LIMIT 1";
		$q = mysqli_query($db_conx, $sql);
		$team_string = mysqli_fetch_array($q);
		
	}
	if(isset($_SESSION['organizator'])){
		
		//Dohvaćanje podataka o organizatoru putem sessije
		$org = $_SESSION['organizator'];
		$sql="SELECT * FROM `Organizers` WHERE username='$org' LIMIT 1";
		$q = mysqli_query($db_conx, $sql);
		$org_string = mysqli_fetch_array($q);
		
	}
	
	$sql="SELECT * FROM `Tournaments` WHERE tournId='$tn_id' LIMIT 1";
	$q = mysqli_query($db_conx, $sql);
	$count = mysqli_num_rows($q);
	$tourn_string = mysqli_fetch_array($q);
		
	//Postoji zapis, Prikaži turnir
	if ($count == 1){ 

	//POST za prijavu ekipe
	if(isset($_POST["tournsignup"])){

		//Update turnira
		$curTeams = $tourn_string["curTeams"] + 1; //Broj ekipa
		
		//Prijavljene ekipe
		if( $tourn_string["teamsIn"] == '0') { 
			$teamsIn = $team_string["teamID"]; //Jedina ekipa
		} else {
			$teamsIn = $tourn_string["teamsIn"].",".$team_string["teamID"]; //Dodavanje ekipe
		}
		
		$full = '0';
		if ( $curTeams == $tourn_string["maxTeams"]) { $full = '1';} //Popunjen turnir
		
		$sql = "UPDATE `Tournaments` SET curTeams='$curTeams', teamsIn='$teamsIn', full='$full' WHERE tournId='$tn_id' LIMIT 1";
		$q = mysqli_query($db_conx, $sql);
		
		//Update ekipe
		if( $team_string["tournIn"] == '0') {
			$tournIn = $tn_id; //Jedini turnir
		} else {
			$tournIn = $team_string["tournIn"].",".$tn_id; //Dodavanje turnira
		}
		
		$sql = "UPDATE `Teams` SET tournIn='$tournIn' WHERE username='$team' LIMIT 1";
		$q = mysqli_query($db_conx, $sql);
		
		echo "1";
		exit();
		
	}
	
	//POST za odjavu ekipe
	if(isset($_POST["tournsignout"])){

		//Update turnira
		$curTeams = $tourn_string["curTeams"] - 1; //Broj ekipa
		
		//Prijavljene ekipe
		$members = explode(',', $tourn_string["teamsIn"]);
		$br = count($members);
		if ($br == 1) {
			$teamsIn = '0'; //Jedina ekipa
		}else {
			$teamsIn = "";
			foreach($members as $val) {
				if ($val != $team_string["teamID"]){
					$teamsIn = $teamsIn.$val."," ; //String od svih id-a osim onog iz sessiona
				}
			}
			$teamsIn = rtrim($teamsIn, ",") ; //Zadnji 'zarez'
		}
		
		$sql = "UPDATE `Tournaments` SET curTeams='$curTeams', teamsIn='$teamsIn', full='0' WHERE tournId='$tn_id' LIMIT 1";
		$q = mysqli_query($db_conx, $sql);
		
		//Update ekipe
		$members = explode(',', $team_string["tournIn"]);
		$br = count($members);
		if ($br == 1) {
			$tournIn = '0'; //Jedini turnir
		}else {
			$tournIn = "";
			foreach($members as $val) {
				if ($val != $tn_id){
					$tournIn = $tournIn.$val."," ; //String od svih id-a osim ovog turnira
				}
			}
			$tournIn = rtrim($tournIn, ",") ; //Zadnji 'zarez'
		}
		
		$sql = "UPDATE `Teams` SET tournIn='$tournIn' WHERE username='$team' LIMIT 1";
		$q = mysqli_query($db_conx, $sql);
		
		echo "1";
		exit();
		
	}

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
					<label>Prijavljene ekipe</label>
					<table class="table table-bordered table-striped table-booking-history">
                        <thead>
                            <tr>
                                <th style="text-align:center;">#</th>
                                <th style="text-align:center;">Naziv ekipe</th>
                            </tr>
                        </thead>
                        <tbody>
						<?php
							//Tablica prijavljenih ekipa
							
							$teams_in = $tourn_string["teamsIn"];
							
							if ($teams_in == '0') { echo '<td class="booking-history-type">Nema prijavljenih ekipa.</td>
														  <td class="booking-history-title" style="text-align:center;">Nema prijavljenih ekipa.</td>';}
							else {
							
								$sql = "SELECT * FROM `Teams` WHERE teamID IN ($teams_in) ORDER BY teamID"; 
								$q = mysqli_query($db_conx, $sql);
								
								$br = 1;
								while($row = mysqli_fetch_array($q))
									{
										echo '
											<tr>
												<td class="booking-history-type">'.$br.'</td>
												<td class="booking-history-title" style="text-align:center;">'.$row["teamName"].'</td>
											</tr>';
											
										$br++;
									}	
							}
						?>
						</tbody>
					</table>		
					<hr class="tab-gap"></hr>	
					<div class="row">	
						<div id="t-status" class="col-md-6">
						<?php
						
							//Turnir završen ili već pokrenut (Mogu vidjeti i ne registrirani korisnici)?
							if (($tourn_string["finished"] == '1')||($tourn_string["started"] == '1')) { echo '<input id="tourn-results" class="btn btn-primary" style="height:48px;" type="submit" value="Rezultati" />'; } //Rezultati
							else {//inače
							
								//Ekipa
								if(isset($_SESSION['sudionik'])){
									
									$is = false;
									$sql = "SELECT * FROM `Teams` WHERE teamID IN ($teams_in) ORDER BY teamID"; 
									$q = mysqli_query($db_conx, $sql);
									while($row = mysqli_fetch_array($q))
									{
										if ( $team == $row["username"] ){ $is = true; } //Već je prijavljena ekipa
									}
									if ($is == true){ 
									
										echo '<input id="team-signout-tourn" class="btn btn-primary" style="height:48px;" type="submit" value="Odjavi se" />'; //Odjava iz turnira
										
									} 
									else if( $tourn_string["full"] == '0' ){ //Ako nije popunjen
									
										echo '<input id="team-signin-tourn" class="btn btn-primary" style="height:48px;" type="submit" value="Prijavi se" />'; //Prijava na turnir
									
									}
								}
								
								//Organizator
								if(isset($_SESSION['organizator'])){
									
									if( $org != $tourn_string["orgName"] ){ //Vlasnik turnira?
									
										echo '<input id="tourn-results" class="btn btn-primary" style="height:48px;" type="submit" value="Rezultati" disabled/>';
										
									}else if( $tourn_string["full"] == '0' ){ //Ako nije popunjen
									
										echo '<h2> Nije popunjen.</h2>';
										
									}else {
									
										echo '<input id="start-tournament" class="btn btn-primary" style="height:48px;" type="submit" value="Započni turnir" />'; //Start turnira
									
									}
								}
							}
						?>	
						</div>
						<div class="col-md-6">
						<?php
							
							//Turnir završen/u tijeku ?
							if ($tourn_string["finished"] == '1') { echo '<h2 style="margin-right:-100px;"> Turnir je završen.</h2>'; }
							else if ( $tourn_string["started"] == '1' ){ echo '<h2 style="margin-right:-100px;"> Turnir je u tijeku.</h2>'; }
							else {
								echo '<h2 style="margin-right:-100px;">Broj ekipa: '.$tourn_string["curTeams"].'/'.$tourn_string["maxTeams"].'</h2>';
							}
							
						?>	
						</div>	
					</div>
				</div>	
			</form>
		</div>
	</div>	
	
	<div class="footer">
		<p>Copyright © 2016 <a href="index">Belot-organizer</a> • <span style="font-style:italic;">WebApp</span> • 31 000 Osijek</p>
	</div>
	
	<script src="js/vendor/jquery.js"></script>
	<script src="js/vendor/imagesloaded.pkgd.min.js"></script>
	<script src="js/ajax.js"></script>
	<script src="js/tournament.js"></script>

</body>
</html>	
<?php
	//Greške kod nedohvaćanja id-a ili nepostojećeg turnira
	}
	else {
		include_once ("php_includes/tournament-error.php");
	}
}
else {
	include_once ("php_includes/tournament-error.php");
}
?>