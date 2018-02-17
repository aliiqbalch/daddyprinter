<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';
	$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
	checkUser();
	//checkUserPermission();

	$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

	switch ($view) {
		case 'list' :
			if(modPerView($dbConn,"21")){
				$content 	= 'list.php';
				$pageTitle 	= 'Orders / Delivered';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
			break;
		case 'detail' :
			if(modPerView($dbConn,"21")){
				$content 	= 'orderDetails.php';
				$pageTitle 	= 'Orders / Delivered';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
			break;
		case 'modify' :
			if(modPerModify($dbConn,"21")){
				$content 	= 'modify.php';
				$pageTitle 	= 'Orders / Delivered';
				$icon		=  '<img src="../images/add-file.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
			break;
		case 'createBill' :
			$content 	= 'bill.php';
			$pageTitle 	= 'Orders / Bill';
			$icon		=  '<img src="../images/add-file.jpg">';
			break;
		default :
			if(modPerView($dbConn,"21")){
				$content 	= 'list.php';
				$pageTitle 	= 'Orders / Delivered';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
	}

	$script    = array('order.js');

	require_once THEME_PATH . '/template.php';;
?>