<?php

include_once ("php_includes/db-conx.php");
session_start();

date_default_timezone_set('CET');

//Session test
if(!isset($_SESSION['organizator'])){
	header("location: /login");
	exit();
}

$orgname = $_SESSION['organizator'];

?>
<!DOCTYPE HTML>
<html>

<head>

    <title>Belot-organizer | Organizatori</title>
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
                        <li class="active"><a><?php echo $_SESSION['organizator']; ?></a></li>
                        <li style="float:right;"><a href="logout"><span class="fa fa-sign-out"></span> Odjava</a></li>        
                    </ul>
                </div>
            </div>
        </header>

        <!-- TOP -->
        <div class="small-top">
			<div class="bg-holder full text-center text-white">
				<div class="bg-mask"></div>
                <div class="bg-img" style="background-image:url(img/bg2.jpg); background-attachment: fixed;"></div> <!-- Paralax effect -->
                <div class="bg-front full-center">
                    <div class="owl-cap">
							<div class="owl-logo">
								<h5><i class="icon icon-Belot-organizer"></i></h5>
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
                        <li class="active"><a href="#tab-1" data-toggle="tab"><i class="icon icon-clipboard2"></i> <span >Kreiraj turnir</span></a>
                        </li>
                        <li><a href="#tab-2" data-toggle="tab"><i class="icon icon-clipboard"></i> <span >Vaši turniri</span></a>
                        </li>
                    </ul>
                    <div class="tab-content">
						<!-- Kreiranje turnira -->
                        <div class="tab-pane fade in active" id="tab-1">
                            <h2>Napravite novi turnir</h2>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group form-group-lg">
										<label>Broj ekipa</label>
										<select id="team-num" class="form-control">
											<option selected="selected">2</option>
											<option>3</option>
											<option>4</option>
											<option>5</option>
											<option>6</option>
											<option>7</option>
											<option>8</option>
											<option>9</option>
											<option>10</option>
											<option>11</option>
											<option>12</option>
											<option>13</option>
											<option>14</option>
											<option>15</option>
											<option>16</option>
											<option>17</option>
											<option>18</option>
										</select>
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group form-group-lg form-group-icon-left">
										<h4 style="margin-top:35px;">* Tip lige, svaka ekipa igra sa svakom.</h4>
                                    </div>
                                </div>	
							</div>	
							<div class="row">
								<div class="col-md-4">
									<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-trophy input-icon input-icon-hightlight"></i>
                                        <label>Naziv turnira</label>
                                        <input id="tourn-name" onblur="checktournname()" class="form-control" placeholder="Naziv Vašeg turnira" type="text" />
                                    </div>
                                </div>
								<div class="col-md-4">
									<div id="tourn-name-status" class="form-group form-group-lg form-group-icon-left">
                                    </div>
                                </div>
							</div>
							<button type="submit" id="create-tn" class="btn btn-primary btn-lg" style="width:200px; margin-top:20px;">Napravi turnir</button>
							<?php
							
							//Stvaranje novog turnira
							
							if(isset($_POST["tncreate"])){
								
								$tournname = $_POST["tncreate"];
								$maxteams = $_POST["tnmax"];
								
								$date = date("Y-m-d"); //Datum YY-MM-DD
								
								$sql="INSERT INTO `Tournaments` (orgName, tournName, maxTeams, date) VALUES ('$orgname', '$tournname', '$maxteams', '$date')";
								
								//Natrag na ajax
								if (mysqli_query($db_conx, $sql)){
									echo "0";	
									exit();
								} 
								
							}
							
							?>
                        </div>
						<!-- Organizatorovi turniri -->
                        <div class="tab-pane fade" id="tab-2">
                            <h2>Vaši turniri</h2>
										
								<?php
									
										/** Pokrenuti turniri **/
										
										$sql = "SELECT * FROM `Tournaments` WHERE orgName='$orgname' AND full='1' AND started='1' ORDER BY date"; 
										$q = mysqli_query($db_conx, $sql);
										$row_cnt = mysqli_num_rows($q);
										
										$br = 1;
										$done = false;
								
										while($row = mysqli_fetch_array($q))
										{
											if ($done == false) { echo '<h4>Pokrenuti turniri</h4>'; $done = true; }
												
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
												
												//Dobar ispis zbog bootstrap row-a :)
												if (( $br%3 == 0 )&&( $br == $row_cnt )){ echo '</div>'; } //Treći && zadnji
												else if ( $br%3 == 0 ){//Treći zapis
													echo '</div>';  echo '<div class="row" style="margin-bottom:20px;">'; 
												} else if ( $br == $row_cnt ){ //Zadnji zapis
													echo '</div>'; 
												}
												
												$br++;
											
										}
										
										/** Popunjeni turniri **/
										
										$sql = "SELECT * FROM `Tournaments` WHERE orgName='$orgname' AND full='1' AND started='0' ORDER BY date"; 
										$q = mysqli_query($db_conx, $sql);
										$row_cnt = mysqli_num_rows($q);
										
										$br = 1;
										$done = false;
								
										while($row = mysqli_fetch_array($q))
										{
											if ($done == false) { echo '<h4>Popunjeni turniri</h4>'; $done = true; }
												
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
												
												//Dobar ispis zbog bootstrap row-a :)
												if (( $br%3 == 0 )&&( $br == $row_cnt )){ echo '</div>'; } //Treći && zadnji
												else if ( $br%3 == 0 ){//Treći zapis
													echo '</div>';  echo '<div class="row" style="margin-bottom:20px;">'; 
												} else if ( $br == $row_cnt ){ //Zadnji zapis
													echo '</div>'; 
												}
												
												$br++;
											
										}
										
										/** Nepopunjeni turniri **/
										
										$sql = "SELECT * FROM `Tournaments` WHERE orgName='$orgname' AND full='0' AND started='0' ORDER BY date"; 
										$q = mysqli_query($db_conx, $sql);
										$row_cnt = mysqli_num_rows($q);
										
										$br = 1;
										$done = false;
								
										while($row = mysqli_fetch_array($q))
										{
											if ($done == false) { echo '<h4>Nepopunjeni turniri</h4>'; $done = true; }
										
												if ( $br == 1 ) { echo '<div class="row" style="margin-bottom:20px;">'; }
												
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
												
												if (( $br%3 == 0 )&&( $br == $row_cnt )){ echo '</div>'; }
												else if ( $br%3 == 0 ){
													echo '</div>';  echo '<div class="row" style="margin-bottom:20px;">'; 
												} else if ( $br == $row_cnt ){
													echo '</div>'; 
												}
												
												$br++;
											
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
	
	<!-- POPUP -->
	<div id="org-add-succes">
		<a class="icon icon-cancel" id ="cls-org-add-succes"></a>
		<h3>Uspješno ste kreirali turnir!</h3>
		<h4>Moći ćete ga pokrenuti nakon što ekipe popune svoja mjesta.</h4>
	</div>
	
	<script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/bootstrap.js"></script>
    <script src="js/vendor/slimmenu.js"></script>
    <script src="js/vendor/nicescroll.js"></script>
	<script src="js/vendor/owl-carousel.js"></script>
	<script src="js/vendor/imagesloaded.pkgd.min.js"></script>
	<script type="text/javascript" src="https://www.l2.io/ip.js?var=myip"></script>
	<script src="js/ajax.js"></script>
	<script src="js/organizer/organizer-main.js"></script>
    <script src="js/main.js"></script>
</body>
</html>


