<?php
	include ("php_includes/db-conx.php");
	
	if(isset($_POST["teamnamecheck"])){
		$teamname = $_POST["teamnamecheck"];
		$sql="SELECT * FROM `Teams` WHERE teamName='$teamname' LIMIT 1";
		$result = mysqli_query($db_conx, $sql);
		$count = mysqli_num_rows($result);
		if ($count == 1){ 
			echo "1";
			exit();
		}
		else {
			echo "0";
			exit();
		}
	}
	
	if(isset($_POST["tme"])){
		$teammail = $_POST["tme"];
		$teamusername = $_POST["tmu"];
		
		$sql="SELECT * FROM `Teams` WHERE email='$teammail' LIMIT 1";
		$result = mysqli_query($db_conx, $sql);
		$count = mysqli_num_rows($result);
		
		$sql="SELECT * FROM `Teams` WHERE username='$teamusername' LIMIT 1";
		$result = mysqli_query($db_conx, $sql);
		$count2 = mysqli_num_rows($result);
		
		if ($count == 1){ 
			echo "1";
			exit();
		}
		else if ($count2 == 1){
			echo "2";
			exit();
		}
		else {
			echo "0";
			exit();
		}
	}
	
?>	