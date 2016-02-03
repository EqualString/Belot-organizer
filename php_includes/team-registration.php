<?php
	include "php_includes/db-conx.php";
	
	if(isset($_POST["teamregister"])){
		$tmu = $_POST["teamregister"];
		$tme = $_POST["tme"];
		$tn1 = $_POST["tn1"];
		$tn2 = $_POST["tn2"];
	    $tmn = $_POST["tmn"];
	    $tbm = $_POST["tbm"];
	    $ts1 = $_POST["ts1"];
		$activated = 0;
		$sql="INSERT INTO `Teams` (username, teamName, email, igrac1, igrac2, brojMob, passwd, activated) VALUES ('$tmu', '$tmn', '$tme','$tn1', '$tn2', '$tbm', '$ts1', '$activated')";
		if (mysqli_query($sql)){
			echo "1";	
			exit();
		} else{
			echo "2";	
			exit();			
		}
	}
?>	