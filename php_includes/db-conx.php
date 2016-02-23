<?php
	//Koristi se remote baza podataka
	//Database as a Service (DBaaS)
	$host = "johnny.heliohost.org";
	$username = "belot_user";
	$password = "Luafr12";
	$database = "belot_organizer";
	
	$db_conx = mysqli_connect($host, $username, $password, $database);

	if (mysqli_connect_errno()){
		echo mysqli_connect_error();
		exit();
	}
?>