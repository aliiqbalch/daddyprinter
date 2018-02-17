<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';

	$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];

	checkUser();
	//checkUserPermission();

	$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

	switch ($view) {
		case 'list' :
			if(modPerView($dbConn,"23")){
				$content 	= 'list.php';
				$pageTitle 	= 'Bank';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
			break;
		case 'add' :
			if(modPerAdd($dbConn,"23")){
				$content 	= 'add.php';
				$pageTitle 	= 'Bank';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}

			break;
		case 'modify' :
			if(modAdd($dbConn,"23")){
				$content 	= 'modify.php';
				$pageTitle 	= 'Main Navigation List';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
			break;
		case 'accdetail' :
			if(modPerAdd($dbConn,"23")){
				$content 	= 'accdetail.php';
				$pageTitle 	= 'Main Navigation List';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
			break;
		case 'addrecept' :
			if(modPerAdd($dbConn,"23")){
				$content 	= 'addrecept.php';
				$pageTitle 	= 'Main Navigation List';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
			break;
			
		default :
			if(modPerView($dbConn,"23")){
				$content 	= 'list.php';
				$pageTitle 	= 'Main Nav List';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
	}

	$script    = array('bank.js');

	require_once THEME_PATH . '/template.php';;
?>