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
			$pageTitle 	= 'Product Detail';
			$icon		=  '<img src="../images/icon-list.jpg">';
			break;
		
		case 'add' :
			$content 	= 'add.php';		
			$pageTitle 	= 'Add Product';
			$icon		=  '<img src="../images/add-file.jpg">';
			break;		
			
		case 'add-vari-type' :
			$content 	= 'add-vari-type.php';		
			$pageTitle 	= 'Add Variation Type';
			$icon		=  '<img src="../images/add-file.jpg">';
			break;
		case 'add-vari' :
			$content 	= 'add-vari.php';		
			$pageTitle 	= 'Add Variation';
			$icon		=  '<img src="../images/add-file.jpg">';
			break;
		case 'modify' :
			$content 	= 'modify.php';		
			$pageTitle 	= 'Modify Product';
			$icon		=  '<img src="../images/add-file.jpg">';
			break;
		case 'mod-var-type' :
			$content 	= 'mod-var-type.php';		
			$pageTitle 	= 'Modify Variation Type';
			$icon		=  '<img src="../images/add-file.jpg">';
			break;
		case 'modif-vari' :
			$content 	= 'modif-vari.php';		
			$pageTitle 	= 'Modify Variation';
			$icon		=  '<img src="../images/add-file.jpg">';
			break;
		case 'detail' :
			$content 	= 'detail.php';		
			$pageTitle 	= 'Product Detail';
			$icon		=  '<img src="../images/add-file.jpg">';
			break;
			
		default :
			$content 	= 'list.php';		
			$pageTitle 	= 'Product';
			$icon		=  '<img src="../images/icon-list.jpg">';
	}

	$script    = array('product.js');

	require_once THEME_PATH . '/template.php';;
?>