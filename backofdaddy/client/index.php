<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';
	$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
	checkUser();
	//checkUserPermission();

	$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

	switch ($view) {
		case 'list' :
			if(modPerView($dbConn,"14")){
				$content 	= 'list.php';
				$pageTitle 	= 'Clients';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
			break;
			
		case 'add' :
			if(modPerAdd($dbConn,"14")){
				$content 	= 'add.php';
				$pageTitle 	= 'Add New Client';
				$icon		=  '<img src="../images/add-file.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
			break;	
			
		case 'detail' :
			if(modPerView($dbConn,"14")){
				$content 	= 'detail.php';
				$pageTitle 	= 'Detail Client';
				$icon		=  '<img src="../images/add-file.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
			break;
			
		case 'modify' :
			if(modPerModify($dbConn,"14")){
				$content 	= 'modify.php';
				$pageTitle 	= 'Modify Client';
				$icon		=  '<img src="../images/add-file.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
			break;			

		default :
			if(modPerView($dbConn,"14")){
				$content 	= 'list.php';
				$pageTitle 	= 'Clients';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
	}

	$script    = array('client.js');

	require_once THEME_PATH . '/template.php';;
?>