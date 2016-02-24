<?php
include_once ("db-conx.php");
session_start();

//Session varijable,izvode se ako postoji sessija
if(isset($_SESSION['sudionik'])){	

	$team = $_SESSION['sudionik'];
	
}
if(isset($_SESSION['organizator'])){

	$org = $_SESSION['organizator'];
	
}
	
?>
<!DOCTYPE HTML>
<html>

<head>

    <title>Belot-organizer | Ekipe</title>
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
					<h3><i class="icon icon-clipboard"></i>Ukupni poredak</h3>
				</div>
			</div>	
			<form onsubmit="return false;">
				<div class="login-style">
					<label>Prijavljene ekipe</label>
					<table class="table table-bordered table-striped table-booking-history">
                        <thead>
                            <tr>
                                <th style="text-align:center;">#</th>
                                <th style="text-align:center;">Naziv ekipe</th>
								<th style="text-align:center;"><i class="fa fa-trophy" style="font-size:20px;"></i></th>
								<th style="text-align:center;"><i class="icon icon-clipboard2" style="font-size:20px;"></i></th>
								<th style="text-align:center;"><i class="icon icon-victory" style="font-size:20px;"></i></th>
                            </tr>
                        </thead>
                        <tbody>
						<?php
							//Tablica poretka
							
							$sql = "SELECT * FROM `Teams` ORDER BY os_turnira DESC, pobjeda DESC"; 
							$q = mysqli_query($db_conx, $sql);
							
							$br = 1;
							while($row = mysqli_fetch_array($q))
							{
								echo	'<tr>
											<td class="booking-history-type" style="width:10%;">'.$br.'</td>
											<td class="booking-history-title" style="width:25%; text-align:center;"><a href="team-info.php?id='.$row["teamID"].'">'.$row["teamName"].'</a></td>
											<td class="booking-history-title" style="width:25%; text-align:center;">'.$row["os_turnira"].'</td>
											<td class="booking-history-title" style="width:20%; text-align:center;">'.$row["od_susreta"].'</td>
											<td class="booking-history-title" style="width:20%; text-align:center;">'.$row["pobjeda"].'</td>
										</tr>';		
								$br++;		
							}	
									
						?>
						</tbody>
					</table>		
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