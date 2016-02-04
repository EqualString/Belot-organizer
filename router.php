<?php	
	include ("php_includes/AltoRouter.php");
	$router = new AltoRouter();
	$router->setBasePath('');

	$router->map('GET','/', 'index.php', 'home');
	$router->map('GET','/home/', 'index.php', 'home-home');
	
?>