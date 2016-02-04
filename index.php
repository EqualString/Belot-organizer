<?php	
	//Router
	require "AltoRouter.php";
	$router = new AltoRouter();
	
	$router->map( 'GET', '/', function() {
		echo "taj sam!";
		require __DIR__ . 'index.php';
	});
	$router->map( 'GET', '/home', function() {
		require __DIR__ . 'router.php';
	});
?>