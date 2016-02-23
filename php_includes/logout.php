<?php

	/*
	* Odjava iz sustava
	*/
	
	session_start();
	
	session_unset();   // destroy the session  
	session_destroy(); 
	ob_start();
	header("location: index");
	
?>