<?php

/* 
* Prima id turnira, uzima nazive ekipa te stvara tablicu rezultata pomoću roundrobin algoritma.
*/

include_once ("roundRobin.php");
include_once ("db-conx.php");

if(isset($_POST["StartTournament"])){

	$id= $_POST["StartTournament"];
	$members = array();
	$sql = "SELECT * FROM `Tournaments` WHERE tournId=".$id;
	$q = mysqli_query($db_conx, $sql);
	$tourn_string = mysqli_fetch_array($q);
	$teams_in = $tourn_string["teamsIn"];
	
	//Niz ekipa
	$sql = "SELECT * FROM `Teams` WHERE teamID IN ($teams_in) ORDER BY teamID"; 
    $q = mysqli_query($db_conx, $sql);
	$br = 0;
	while($row = mysqli_fetch_array($q))
	{	
		$members[$br] = $row["teamName"];	
		$br++;
	}
	
	if( count($members) == $tourn_string["maxTeams"] ){//Još jedna provjera
		
		//Napravi runde
		$rounds = roundRobin($members);

		//Kreiraj tablicu rezultata u bazi
		$table_name = "Results_".$id;
		$sql = "CREATE TABLE ".$table_name."
		(
		game int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		round int UNSIGNED,
		team1 varchar(255) COLLATE latin2_croatian_ci,
		team2 varchar(255) COLLATE latin2_croatian_ci,
		res1 varchar(255) COLLATE latin2_croatian_ci,
		res2 varchar(255) COLLATE latin2_croatian_ci
		) ENGINE = INNODB";
		
		if (!mysqli_query($db_conx, $sql)){
			echo "1";
			exit();	
		} else {
		
			//Dodaj ime tablice u zapis turnira
			$sql = "UPDATE `Tournaments` SET resultsTable='$table_name', started='1' WHERE tournId='$id' LIMIT 1";
			
			if (!mysqli_query($db_conx, $sql)){
				echo "2";
				exit();	
			} else {
			
				//Ispuni je poljima iz roundRobin-a
				foreach($rounds as $round => $games){
					foreach($games as $play){
						
						if(($play["Home"] != "_")&&($play["Away"] != "_")){ //Nema potrebe raditi zapis za ekipu koja ima pauzu u rundi
							
							//Query za unos
							$sql="INSERT INTO `".$table_name."` (round, team1, team2) VALUES ('".($round+1)."', '".$play["Home"]."', '".$play["Away"]."')";
							
							if (!mysqli_query($db_conx, $sql)){
								echo "3";
								exit();
							}
						}
					}
				}
				
				//Uspješno unesen raspored
				echo "4";
				exit();
			}
		}	
	}
}	
?>