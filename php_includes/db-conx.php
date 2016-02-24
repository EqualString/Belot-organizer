<?php

	//Koristi se remote baza podataka
	//Database as a Service (DBaaS)
	//www.db4free.net
	
	$host = "85.10.205.173:3306";
	$username = "belotorganizer";
	$password = "Luafr12";
	$database = "belot";
	
	$db_conx = mysqli_connect($host, $username, $password, $database);

	if (mysqli_connect_errno()){
		echo mysqli_connect_error();
		exit();
	}
?>