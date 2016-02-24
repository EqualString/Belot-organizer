<?php

include_once ("php_includes/db-conx.php");
session_start();

//Session test
if(!isset($_SESSION['sudionik'])){
	header("location: /login");
	exit();
}

$team_name = $_SESSION['sudionik'];
$sql = "SELECT * FROM `Teams` WHERE username='$team_name' LIMIT 1";
$q = mysqli_query($db_conx, $sql);
$tourn_string = mysqli_fetch_array($q);

?>
<!DOCTYPE HTML>
<html>

<head>

    <title>Belot-organizer | Sudionici</title>
	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
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
	<link rel="stylesheet" href="css/team.css">
	<link rel="stylesheet" href="css/loader.css">
	
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
	<!-- GLOBAL -->
    <div class="global-wrap">
	<div id="global"></div>
	<!-- HEADER -->
        <header id="main-header">
            <div class="header-top">
                <div class="container">
                    <div>
                        <div class="top-logo">
                            <a class="logo" href="index">
								<i class="icon icon-srce"></i>
								<i class="icon icon-buc"></i>
								<i class="icon icon-zel"></i>
								<i class="icon icon-zir"></i>
								Belot - Organizer ®
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="nav">
                    <ul class="slimmenu" id="slimmenu">
                        <li class="active"><a><?php echo $_SESSION['sudionik']; ?></a></li>
						<li><a href="teams-list">Ekipe</a></li>
                        <li><a>Turniri</a>
                            <ul>
                                <li><a href="tournaments-started">U tijeku</a></li>
                                <li><a href="tournaments-underway">Nadolazeći</a></li>
								<li><a href="tournaments-finished">Završeni</a></li>
                            </ul>
                        </li>
                        <li style="float:right;"><a href="logout"><span class="fa fa-sign-out"></span> Odjava</a></li>        
                    </ul>
                </div>
            </div>
        </header>

        <!-- TOP -->
        <div class="small-top">
			<div class="bg-holder full text-center text-white">
				<div class="bg-mask"></div>
                <div class="bg-img" style="background-image:url(img/bg1.jpg); background-attachment: fixed;"></div> <!-- Paralax effect -->
                <div class="bg-front full-center">
                    <div class="owl-cap">
							<div class="owl-logo" style="margin-top:-90px;">
								<h5><i class="icon icon-Belot-organizer"></i></h5>
							</div>
							<div class="owl-cap-price" style = "margin-top: -60px;">
                                <h5><?php echo $tourn_string["teamName"]; ?></h5>
                            </div>
                    </div>
                </div>
            </div>
		</div>
		<!-- TABS -->
		<div class="container" style="margin-top:20px;">
            <div class="search-tabs search-tabs-bg search-tabs-to-top">
                <div class="tabbable">
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active"><a href="#tab-1" data-toggle="tab"><i class="icon icon-clipboard2"></i> <span >Vaši turniri</span></a>
                        </li>
                        <li><a href="#tab-2" data-toggle="tab"><i class="icon icon-clipboard"></i> <span >Prijave na turnir</span></a>
                        </li>
                    </ul>
                    <div class="tab-content">
						<!-- Prijavljeni turniri -->
                        <div class="tab-pane fade in active" id="tab-1">
                            <h2>Turniri na koje ste prijavljeni</h2>

								<?php
								
								if( $tourn_string["tournIn"] == '0' ) { echo '<h4>Nemate prijavljenih turnira.</h4>'; }
								else {
									
									/** Popunjeni prijavljeni turniri u tijeku **/
									
									$sql = "SELECT * FROM `Tournaments` WHERE tournId IN (".$tourn_string["tournIn"].") AND full='1' AND started='1' AND finished='0' ORDER BY date"; 
									$q = mysqli_query($db_conx, $sql);
									$row_cnt = mysqli_num_rows($q);
									
									$br = 1;
									$done = false;
							
									while($row = mysqli_fetch_array($q))
									{
										if ($done == false) { echo '<h4>Turniri u tijeku</h4>'; $done = true; }
											
											if ( $br == 1 ) { echo '<div class="row">'; } //Prvi zapis
											
												echo '
													 <div class="col-md-4">
														<div class="booking-item booking-item-small">
															<a href="tournament.php?id='.$row['tournId'].'">
																<div class="row">
																	<div class="col-xs-5">
																		<h5 class="booking-item-title"><i class="fa fa-trophy" style="font-size:20px; margin-top:5px;"></i></br>'.$row['tournName'].'</h5>
																	</div>
																	<div class="col-xs-3" style="margin-top:4px;">
																		<span class="booking-item-price-from">
																			<i class="fa fa-male"></i> 
																			<i class="fa fa-male"></i> 
																			<i class="fa fa-male"></i> 
																		</span>
																		<span class="booking-item-price">'.$row['curTeams'].'/'.$row['maxTeams'].'</span>
																	</div>
																	<div class="col-xs-3">
																		<h5 class="booking-item-title"><i class="icon icon-profile2" style="font-size:25px;"></i></br>'.$row['orgName'].'</h5>
																	</div>
																</div>
															</a>	
														</div>
													</div>';
											
											//Dobar ispis zbog bootstrap row-a :)
											if (( $br%3 == 0 )&&( $br == $row_cnt )){ echo '</div>'; } //Treći && zadnji
											else if ( $br%3 == 0 ){//Treći zapis
												echo '</div>';  echo '<div class="row">'; 
											} else if ( $br == $row_cnt ){ //Zadnji zapis
												echo '</div>'; 
											}
											
											$br++;
										
									}
									
									/** Popunjeni prijavljeni turniri **/
									
									$sql = "SELECT * FROM `Tournaments` WHERE tournId IN (".$tourn_string["tournIn"].") AND full='1' AND started='0' AND finished='0' ORDER BY date"; 
									$q = mysqli_query($db_conx, $sql);
									$row_cnt = mysqli_num_rows($q);
									
									$br = 1;
									$done = false;
							
									while($row = mysqli_fetch_array($q))
									{
										if ($done == false) { echo '<h4>Popunjeni turniri</h4>'; $done = true; }
											
											if ( $br == 1 ) { echo '<div class="row">'; } //Prvi zapis
											
												echo '
													 <div class="col-md-4">
														<div class="booking-item booking-item-small">
															<a href="tournament.php?id='.$row['tournId'].'">
																<div class="row">
																	<div class="col-xs-5">
																		<h5 class="booking-item-title"><i class="fa fa-trophy" style="font-size:20px; margin-top:5px;"></i></br>'.$row['tournName'].'</h5>
																	</div>
																	<div class="col-xs-3" style="margin-top:4px;">
																		<span class="booking-item-price-from">
																			<i class="fa fa-male"></i> 
																			<i class="fa fa-male"></i> 
																			<i class="fa fa-male"></i> 
																		</span>
																		<span class="booking-item-price">'.$row['curTeams'].'/'.$row['maxTeams'].'</span>
																	</div>
																	<div class="col-xs-3">
																		<h5 class="booking-item-title"><i class="icon icon-profile2" style="font-size:25px;"></i></br>'.$row['orgName'].'</h5>
																	</div>
																</div>
															</a>	
														</div>
													</div>';
											
											if (( $br%3 == 0 )&&( $br == $row_cnt )){ echo '</div>'; } //Treći && zadnji
											else if ( $br%3 == 0 ){//Treći zapis
												echo '</div>';  echo '<div class="row">'; 
											} else if ( $br == $row_cnt ){ //Zadnji zapis
												echo '</div>'; 
											}
											
											$br++;
										
									}
									
									/** Nepopunjeni prijavljeni turniri **/
									
									$sql = "SELECT * FROM `Tournaments` WHERE tournId IN (".$tourn_string["tournIn"].") AND full='0' AND started='0' AND finished='0' ORDER BY date"; 
									$q = mysqli_query($db_conx, $sql);
									$row_cnt = mysqli_num_rows($q);
									
									$br = 1;
									$done = false;
							
									while($row = mysqli_fetch_array($q))
									{
										if ($done == false) { echo '<h4>Nepopunjeni turniri</h4>'; $done = true; }
											
											if ( $br == 1 ) { echo '<div class="row">'; } //Prvi zapis
											
												echo '
													 <div class="col-md-4">
														<div class="booking-item booking-item-small">
															<a href="tournament.php?id='.$row['tournId'].'">
																<div class="row">
																	<div class="col-xs-5">
																		<h5 class="booking-item-title"><i class="fa fa-trophy" style="font-size:20px; margin-top:5px;"></i></br>'.$row['tournName'].'</h5>
																	</div>
																	<div class="col-xs-3" style="margin-top:4px;">
																		<span class="booking-item-price-from">
																			<i class="fa fa-male"></i> 
																			<i class="fa fa-male"></i> 
																			<i class="fa fa-male"></i> 
																		</span>
																		<span class="booking-item-price">'.$row['curTeams'].'/'.$row['maxTeams'].'</span>
																	</div>
																	<div class="col-xs-3">
																		<h5 class="booking-item-title"><i class="icon icon-profile2" style="font-size:25px;"></i></br>'.$row['orgName'].'</h5>
																	</div>
																</div>
															</a>	
														</div>
													</div>';
											
											if (( $br%3 == 0 )&&( $br == $row_cnt )){ echo '</div>'; } //Treći && zadnji
											else if ( $br%3 == 0 ){//Treći zapis
												echo '</div>';  echo '<div class="row">'; 
											} else if ( $br == $row_cnt ){ //Zadnji zapis
												echo '</div>'; 
											}
											
											$br++;
										
									}
									
									/** Završeni prijavljeni turniri **/
									
									$sql = "SELECT * FROM `Tournaments` WHERE tournId IN (".$tourn_string["tournIn"].") AND full='1' AND started='1' AND finished='1' ORDER BY date"; 
									$q = mysqli_query($db_conx, $sql);
									$row_cnt = mysqli_num_rows($q);
									
									$br = 1;
									$done = false;
							
									while($row = mysqli_fetch_array($q))
									{
										if ($done == false) { echo '<h4>Završeni turniri</h4>'; $done = true; }
											
											if ( $br == 1 ) { echo '<div class="row">'; } //Prvi zapis
											
												echo '
													 <div class="col-md-4">
														<div class="booking-item booking-item-small">
															<a href="tournament.php?id='.$row['tournId'].'">
																<div class="row">
																	<div class="col-xs-5">
																		<h5 class="booking-item-title"><i class="fa fa-trophy" style="font-size:20px; margin-top:5px;"></i></br>'.$row['tournName'].'</h5>
																	</div>
																	<div class="col-xs-3" style="margin-top:4px;">
																		<span class="booking-item-price-from">
																			<i class="fa fa-male"></i> 
																			<i class="fa fa-male"></i> 
																			<i class="fa fa-male"></i> 
																		</span>
																		<span class="booking-item-price">'.$row['curTeams'].'/'.$row['maxTeams'].'</span>
																	</div>
																	<div class="col-xs-3">
																		<h5 class="booking-item-title"><i class="icon icon-profile2" style="font-size:25px;"></i></br>'.$row['orgName'].'</h5>
																	</div>
																</div>
															</a>	
														</div>
													</div>';
											
											if (( $br%3 == 0 )&&( $br == $row_cnt )){ echo '</div>'; } //Treći && zadnji
											else if ( $br%3 == 0 ){//Treći zapis
												echo '</div>';  echo '<div class="row">'; 
											} else if ( $br == $row_cnt ){ //Zadnji zapis
												echo '</div>'; 
											}
											
											$br++;
										
									}
								}
								?>
                        </div>
						<!-- Slobodni turniri -->
                        <div class="tab-pane fade" id="tab-2">
                            <h2>Slobodni turniri</h2>
								<?php
										/** Slobodni turniri **/
										
										$sql = "SELECT * FROM `Tournaments` WHERE tournId NOT IN (".$tourn_string["tournIn"].") AND full='0' AND started='0' AND finished='0' ORDER BY date";
										$q = mysqli_query($db_conx, $sql);
										$row_cnt = mysqli_num_rows($q);
										
										if ($row_cnt == 0) { echo "<h4>Nažalost nema slobodnih turnira</h4>";}
										else {
										
											$br = 1;
										
											while($row = mysqli_fetch_array($q))
											{
										
													if ( $br == 1 ) { echo '<div class="row" style="margin-bottom:20px;">'; } //Prvi zapis
													
													echo '
													 <div class="col-md-4">
														<div class="booking-item booking-item-small">
															<a href="tournament.php?id='.$row['tournId'].'">
																<div class="row">
																	<div class="col-xs-5">
																		<h5 class="booking-item-title"><i class="fa fa-trophy" style="font-size:20px; margin-top:5px;"></i></br>'.$row['tournName'].'</h5>
																	</div>
																	<div class="col-xs-3" style="margin-top:4px;">
																		<span class="booking-item-price-from">
																			<i class="fa fa-male"></i> 
																			<i class="fa fa-male"></i> 
																			<i class="fa fa-male"></i> 
																		</span>
																		<span class="booking-item-price">'.$row['curTeams'].'/'.$row['maxTeams'].'</span>
																	</div>
																	<div class="col-xs-3">
																		<h5 class="booking-item-title"><i class="icon icon-profile2" style="font-size:25px;"></i></br>'.$row['orgName'].'</h5>
																	</div>
																</div>
															</a>	
														</div>
													</div>';
													
													if (( $br%3 == 0 )&&( $br == $row_cnt )){ echo '</div>'; } //Treći && zadnji
													else if ( $br%3 == 0 ){//Treći zapis
														echo '</div>';  echo '<div class="row" style="margin-bottom:20px;">'; 
													} else if ( $br == $row_cnt ){ //Zadnji zapis
														echo '</div>'; 
													}
													
													$br++;
												
											}
										}
								?>
								
                        </div>
                    </div>
                </div>
			</div>	
            <div class="gap"></div>
            <div class="gap gap-small"></div>
            <div class="gap gap-small"></div>
        </div>
		<?php
			include_once ("php_includes/footer.php");
		?>	
    </div>

	<script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/bootstrap.js"></script>
    <script src="js/vendor/slimmenu.js"></script>
    <script src="js/vendor/nicescroll.js"></script>
	<script src="js/vendor/owl-carousel.js"></script>
	<script src="js/vendor/imagesloaded.pkgd.min.js"></script>
	<script type="text/javascript" src="https://www.l2.io/ip.js?var=myip"></script>
    <script src="js/main.js"></script>
</body>
</html>


