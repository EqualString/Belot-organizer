<?php
	//Validacija imena novog turnira
	include_once("db-conx.php");
	
	if(isset($_POST["tnnamecheck"])){
		$tournname = $_POST["tnnamecheck"];
		$sql="SELECT * FROM `Tournaments` WHERE tournName='$tournname' LIMIT 1";
		$result = mysqli_query($db_conx, $sql);
		$count = mysqli_num_rows($result);
		if ($count < 1){ 
			echo "0";
			exit();
		}
		else {
			echo "1";
			exit();
		}
	}
	
?>	