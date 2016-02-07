<?php
	//Registracija novog organizatora
	include_once("db-conx.php");
	
	if(isset($_POST["orgregister"])){
		$tmu = $_POST["orgregister"];
		$tme = $_POST["tme"];
		$tn1 = $_POST["tn1"];
		$tn2 = $_POST["tn2"];
	    $tbm = $_POST["tbm"];
	    $ts1 = $_POST["ts1"];
		$activated = "0";
		//Activated se aktivira s mail-a
		//orgID je auto increment u phpMyAdmin-u
		$sql="INSERT INTO `Organizers` (email, passwd, username, brojMob, ime, prezime, activated) VALUES ('$tme', '$ts1', '$tmu', '$tbm', '$tn1', '$tn2', '$activated')";
		if (mysqli_query($db_conx, $sql)){
			echo "1";	
			exit();
		} else{
			echo "2";	
			exit();			
		}
	}
?>	