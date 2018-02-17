<?php
	error_reporting(E_ALL);
	// start the session
	@session_start();
	// database connection config
	//For localhost
		$dbHost 	= 	'localhost';
	$dbUser 	=	'root';
	$dbPass		=	'';
	$dbName 	=	'daddyprinter';
	
	/* $dbHost 	= 	'daddyprinterscom.ipagemysql.com';
	$dbUser 	=	'dadyprinter';
	$dbPass		=	'7*-zTwTHaJ6^';
	$dbName 	=	'daddyprinter'; */
	$dbConn = mysqli_connect($dbHost,$dbUser,$dbPass,$dbName) or die(mysqli_error());

?>