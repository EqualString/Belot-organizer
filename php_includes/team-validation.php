<?php
	$mysql_hostname = getenv('OPENSHIFT_MYSQL_DB_HOST');
	$mysql_user = getenv('OPENSHIFT_MYSQL_DB_USERNAME');
	$mysql_password = getenv('OPENSHIFT_MYSQL_DB_PASSWORD');
	$mysql_database = "belot";
	$prefix = "";

	//Spajanje na bazu
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	
	if(isset($_POST["teamnamecheck"])){
		$teamname = $_POST["teamnamecheck"];
		$sql="SELECT * FROM `Teams` WHERE teamName='$teamname' LIMIT 1";
		$result = mysql_query($sql) or die(mysql_error());
		$count = mysql_num_rows($result);
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
		$result = mysql_query($sql) or die(mysql_error());
		$count = mysql_num_rows($result);
		
		$sql="SELECT * FROM `Teams` WHERE username='$teamusername' LIMIT 1";
		$result = mysql_query($sql) or die(mysql_error());
		$count2 = mysql_num_rows($result);
		
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