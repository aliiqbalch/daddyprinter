<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';

	$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];

	checkUser();
	//checkUserPermission();

	$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
	
	switch ($view) {
		case 'list' :
			if(modPerView($dbConn,"2")) {
				$content = 'list.php';
				$pageTitle = 'Sub Category';
				$icon = '<img src="../images/icon-list.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
			break;
		
		case 'add' :
			if(modPerAdd($dbConn,"2")) {
				$content = 'add.php';
				$pageTitle = 'Add Sub Category';
				$icon = '<img src="../images/add-file.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
			break;		
			
		case 'modify' :
			if(modPerModify($dbConn,"2")) {
				$content = 'modify.php';
				$pageTitle = 'Modify Sub Category';
				$icon = '<img src="../images/add-file.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
			break;
			
		default :
			if(modPerView($dbConn,"2")) {
				$content = 'list.php';
				$pageTitle = 'Sub Category';
				$icon = '<img src="../images/icon-list.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
	}

	$script    = array('subcategory.js');

	require_once THEME_PATH . '/template.php';;
?>