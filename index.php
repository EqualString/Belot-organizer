<?php	
	echo "taj sam!";
	//Router
	require "php_includes/AltoRouter.php";
	$router = new AltoRouter();
	
	$router->map( 'GET', '/', function() {
		require __DIR__ . 'index.php';
	});
	$router->map( 'GET', '/home', function() {
		require __DIR__ . 'router.php';
	});
?>