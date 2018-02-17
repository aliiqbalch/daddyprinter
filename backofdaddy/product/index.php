<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';

	$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];

	checkUser();
	//checkUserPermission();

	$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
	
	switch ($view) {
		case 'list' :
			if(modPerView($dbConn,"7")){
				$content 	= 'list.php';
				$pageTitle 	= 'Product Detail';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}

			break;
		
		case 'add' :
			if(modPerAdd($dbConn,"7")){
				$content 	= 'add.php';
				$pageTitle 	= 'Add Product';
				$icon		=  '<img src="../images/add-file.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
			break;		
			
		case 'add-vari-type' :
			if(modPerAdd($dbConn,"7")){
				$content 	= 'add-vari-type.php';
				$pageTitle 	= 'Add Variation Type';
				$icon		=  '<img src="../images/add-file.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
			break;
		case 'add-vari' :
			if(modPerAdd($dbConn,"7")){
				$content 	= 'add-vari.php';
				$pageTitle 	= 'Add Variation';
				$icon		=  '<img src="../images/add-file.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
			break;
		case 'modify' :
			if(modPerModify($dbConn,"7")){
				$content 	= 'modify.php';
				$pageTitle 	= 'Modify Product';
				$icon		=  '<img src="../images/add-file.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
			break;
		case 'mod-var-type' :
			if(modPerModify($dbConn,"7")) {
				$content = 'mod-var-type.php';
				$pageTitle = 'Modify Variation Type';
				$icon = '<img src="../images/add-file.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
			break;
		case 'modif-vari' :
			if(modPerModify($dbConn,"7")) {
				$content = 'modif-vari.php';
				$pageTitle = 'Modify Variation';
				$icon = '<img src="../images/add-file.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
			break;
		case 'detail' :
			if(modPerView($dbConn,"7")) {
				$content = 'detail.php';
				$pageTitle = 'Product Detail';
				$icon = '<img src="../images/add-file.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
			break;

		default :
			if(modPerView($dbConn,"7")) {
				$content = 'list.php';
				$pageTitle = 'Product';
				$icon = '<img src="../images/icon-list.jpg">';
			}else{
				$content 	= '../dashboard.php';
				$pageTitle 	= 'Dashboard';
				$icon		=  '<img src="../images/icon-list.jpg">';
			}
	}

	$script    = array('product.js');

	require_once THEME_PATH . '/template.php';;
?>