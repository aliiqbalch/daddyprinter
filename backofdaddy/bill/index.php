<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';
	$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
	checkUser();
	//checkUserPermission();

	$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

	switch ($view) {
		case 'list' :
			$content 	= 'list.php';		
			$pageTitle 	= 'Bill';
			$icon		=  '<img src="../images/icon-list.jpg">';
			break;
		case 'detail' :
			$content 	= 'billDetail.php';
			$pageTitle 	= 'Bill / Preview';
			$icon		=  '<img src="../images/icon-list.jpg">';
			break;
		case 'clearBill' :
			$content 	= 'clearBill.php';
			$pageTitle 	= 'Bill / Preview';
			$icon		=  '<img src="../images/icon-list.jpg">';
			break;
		default :
			$content 	= 'list.php';		
			$pageTitle 	= 'Bill';
			$icon		=  '<img src="../images/icon-list.jpg">';
	}

	$script    = array('bill.js');

	require_once THEME_PATH . '/template.php';;
?>