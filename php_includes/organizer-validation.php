<?php
	//Validacija novog organizatora
	include_once("db-conx.php");
	
	if(isset($_POST["oge"])){
		$orgmail = $_POST["oge"];
		$orgusername = $_POST["ogu"];
		
		$sql="SELECT * FROM `Organizers` WHERE email='$orgmail' LIMIT 1";
		$result = mysqli_query($db_conx, $sql);
		$count = mysqli_num_rows($result);
		
		$sql="SELECT * FROM `Organizers` WHERE username='$orgusername' LIMIT 1";
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