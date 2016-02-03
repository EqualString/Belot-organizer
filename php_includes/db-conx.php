<?php
	//Koristi se remote baza podataka
	//Database as a Service (DBaaS)
	$servername = "sql2.freemysqlhosting.net";
	$username = "sql2105451";
	$password = "rH8!sN2!";
	$db_conx = mysqli_connect( $servername, $username, $password, $username);

	if (mysqli_connect_errno()){
		echo mysqli_connect_error();
		exit();
	}
?>