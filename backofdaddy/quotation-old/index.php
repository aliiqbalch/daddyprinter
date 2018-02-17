<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';

	$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];

	checkUser();
	//checkUserPermission();

	$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
	
	switch ($view) {
		case 'list' :
			if(modPerView($dbConn,"8")) {
				$content = 'list.php';
				$pageTitle = 'Quotation';
				$icon = '<img src="../images/icon-list.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
			break;
		case 'quotation' :
			if(modPerView($dbConn,"8")){
				$content = 'quotation.php';
				$pageTitle = 'Quotation';
				$icon = '<img src="../images/icon-list.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
			break;
		default :
			if(modPerView($dbConn,"8")) {
				$content = 'list.php';
				$pageTitle = 'Quotation';
				$icon = '<img src="../images/icon-list.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
	}

	$script    = array('quotation.js');

	require_once THEME_PATH . '/template.php';;
?>