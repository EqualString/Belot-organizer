<?php

	include_once("db-conx.php");
	session_start();
		
	if(isset($_POST["organizer-login"])){
		$username = $_POST["organizer-login"];
		$pass = $_POST["pass"];
		
		//Pregled korisničkom imena
		$sql="SELECT * FROM `Organizers` WHERE username='$username' LIMIT 1";
		$result = mysqli_query($db_conx, $sql);
		$count = mysqli_num_rows($result);
		
		if ($count == 1){
			
			//Pregled postojećeg računa
			$sql="SELECT * FROM `Organizers` WHERE username='$username' and passwd='$pass' LIMIT 1";
			$result = mysqli_query($db_conx, $sql);
			$count2 = mysqli_num_rows($result);
		
			if ($count2 == 1){ 
			
				//Pregled postojećeg računa koji je aktiviran
				$sql="SELECT * FROM `Organizers` WHERE username='$username' and passwd='$pass' and activated='1' LIMIT 1";
				$result = mysqli_query($db_conx, $sql);
				$count3 = mysqli_num_rows($result);
					
				if($count3 == 1){	
					//Login
					$_SESSION['organizator'] = $username;
					echo "3";
					exit();
				}
				else{
					//Račun nije aktiviran putem mail-a
					echo "2";
					exit();
				}	
			}
			else {
				//Kriva lozinka
				echo "1";
				exit();
			}
		} else {
			//Nepostojeći korisnik
			echo "0";
			exit();
		}
		
	}
	
?>	