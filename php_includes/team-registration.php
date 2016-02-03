<?php
	include ("php_includes/db-conx.php");
	
	if(isset($_POST["teamregister"])){
		$tmu = $_POST["teamregister"];
		$tme = $_POST["tme"];
		$tn1 = $_POST["tn1"];
		$tn2 = $_POST["tn2"];
	    $tmn = $_POST["tmn"];
	    $tbm = $_POST["tbm"];
	    $ts1 = $_POST["ts1"];
		$activated = "0";
		$sql="INSERT INTO `Teams` (teamName, email, passwd, username, brojMob, igrac1, igrac2, activated) VALUES ('$tmn', '$tme', '$ts1','$tmu', '$tbm', '$tn1', '$tn2', '$activated')";
		if (mysqli_query($db_conx, $sql)){
			echo "1";	
			exit();
		} else{
			echo "2";	
			exit();			
		}
	}
?>	