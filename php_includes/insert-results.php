<?php
	//Unos rezultata u tablicu
	include_once("db-conx.php");
	
	if(isset($_POST["results"])){
		$game = $_POST["results"];
		$table_name = "Results_".$_POST["table"]; //Ime tablice rezultata
		$t1 = $_POST["t1"];
		$t2 = $_POST["t2"];
		
		$sql = "UPDATE `$table_name` SET res1='$t1', res2='$t2' WHERE game='$game' LIMIT 1";
		$q = mysqli_query($db_conx, $sql);
		
		echo "1";
		exit();
	}
	
?>	