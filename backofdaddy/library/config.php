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
	
	define('THEME', "/xpert"); //For root use "/"
	// setting up the web root and server root for
	$thisFile = str_replace('\\', '/', __FILE__);
	$docRoot = $_SERVER['DOCUMENT_ROOT'];
	$webRoot  = str_replace(array($_SERVER['HTTP_HOST'], 'library/config.php'), '', $thisFile);
	$srvRoot  = str_replace('library/config.php', '', $thisFile);
	define('WEB_DIR', "/"); //For root use "/"
	define('WEB_DIR_ADMIN', "daddyprinter/backofdaddy/"); //For admin "/"

	// Web Path
	define('WEB_ROOT', "http://" . $_SERVER['HTTP_HOST'] . WEB_DIR);

	//Admin Path
	define('WEB_ROOT_ADMIN', "http://" . $_SERVER['HTTP_HOST'] . WEB_DIR . WEB_DIR_ADMIN);

	//Template Paths
	define('WEB_ROOT_TEMPLATE', "http://" . $_SERVER['HTTP_HOST'] . WEB_DIR . WEB_DIR_ADMIN . "template". THEME);

	//Absolute Path
	define('ABS_PATH', $docRoot . WEB_DIR);
	define('SRV_ROOT', $srvRoot);

	define('THEME_PATH', SRV_ROOT . "template" . THEME);
	
	// We need to limit the product image height?
	define('LIMIT_PRODUCT_WIDTH',   true);
	define('LIMIT_PRODUCT_HEIGHT',   true);
	
	define('THUMBNAIL_WIDTH', true);
	define('THUMBNAIL_HEIGHT', true);

	require_once 'database.php';
	require_once 'common.php';

?>