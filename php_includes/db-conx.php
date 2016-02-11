<?php
	//Koristi se remote baza podataka
	//Database as a Service (DBaaS)
	$servername = "db4free.net:3306";
	$username = "belotorganizer";
	$password = "Luafr12";
	$database = "belot";
	
	$db_conx = mysqli_connect( $servername, $username, $password, $database);

	if (mysqli_connect_errno()){
		echo mysqli_connect_error();
		exit();
	}
?>