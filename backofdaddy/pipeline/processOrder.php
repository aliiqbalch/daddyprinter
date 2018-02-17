<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';

	checkUser();
	$action = isset($_GET['action']) ? $_GET['action'] : '';
	switch ($action) {
		case 'modify' :
			modifyPendingOrder($dbConn);
			break;
		case 'modifyDetail' :
			modifyPendingOrderDetail($dbConn);
			break;

		case 'delete' :
			deleteOrder($dbConn);
			break;
			
		default :
			// if action is not defined or unknown
			// move to main index page
			redirect('index.php');
	}
	//Modify User
	function modifyPendingOrder($dbConn) {
		$statusId		= mysqli_real_escape_string($dbConn, $_POST['statusId']);
		$orderId 	 	= mysqli_real_escape_string($dbConn, $_GET['oid']);
		$disAmount          = mysqli_real_escape_string($dbConn,$_POST['discount']);

		if(!(empty($disAmount) || $disAmount ==0)){
			$sql1 = "UPDATE discount SET amount='$disAmount' WHERE order_id = '$orderId'";
			$result1 = dbQuery($dbConn,$sql1);
		}
			$sql = "UPDATE `order` SET status_id='$statusId' WHERE order_id = '$orderId'";
			$result = dbQuery($dbConn, $sql);
			$_SESSION['count'] = 0;
			$_SESSION['errorMessage'] = "Member Updated Successfully.";
			redirect('index.php');
	}
	function modifyPendingOrderDetail($dbConn){
		$odid     = mysqli_real_escape_string($dbConn,$_REQUEST['odid']);
		$disVal   = mysqli_real_escape_string($dbConn,$_REQUEST['disVal']);
		$disId    = mysqli_real_escape_string($dbConn,$_REQUEST['disId']);
		$statusId = mysqli_real_escape_string($dbConn,$_REQUEST['statusId']);

		$sqlSelect = "SELECT * FROM disdetails WHERE dis_det_Id = '$disId'";
		$result = dbQuery($dbConn,$sqlSelect);
//		var_dump($sqlSelect);
//		die("SSS");
		if(dbNumRows($result) > 0){
			$sqlUpdate = "UPDATE disdetails SET amount='$disVal' WHERE dis_det_Id = '$disId'";
			$result = dbQuery($dbConn,$sqlUpdate);
		}else{
//			die("SSSs");
			$sqlInsert = "INSERT INTO disdetails(dis_det_Id, order_detail_Id, amount) VALUES (NULL ,'$odid','$disVal')";
			$result = dbQuery($dbConn,$sqlInsert);
		}
		redirect('index.php');

	}
	function deleteOrder($dbConn){
		if (isset($_GET['orderId']) && (int)$_GET['orderId']>0){
			$orderId	=    $_GET['orderId'];
		}
		deleteOrderDetail($dbConn,$orderId);
		deleteDiscount($dbConn,$orderId);
		delelteTax($dbConn,$orderId);
		$sql		=	"DELETE FROM `order` WHERE order_id=$orderId";
		$result 	= 	dbQuery($dbConn, $sql);
		$_SESSION['count'] = 0;
		$_SESSION['errorMessage'] = "Member Deleted Successfully.";
		redirect('index.php');			
	}
	function deleteOrderDetail($dbConn,$orderID){
		$id = array();
		$sql1 = "SELECT * FROM order_detail WHERE order_id = $orderID";
		$result1 = dbQuery($dbConn,$sql1);
		if($result1){
			while($row = dbFetchAssoc($result1)){

				$catId =  productCatId($dbConn,$row['product_id']);
				if($catId !=3){
					$id[] = $row['order_detail_id'];
				}
			}
		}
		deleteOrderVariation($dbConn,$id);
		//var_dump(deleteOrderVariation($id));
		$sql		=	"DELETE FROM `order_detail` WHERE order_id = $orderID";
		$result 	= 	dbQuery($dbConn, $sql);
	}
	function deleteOrderVariation($dbConn,$id){
		foreach($id as $vid){
			$sql		=	"DELETE FROM `order_variation` WHERE order_detail_id = $vid";
			//die($sql);
			$result 	= 	dbQuery($dbConn, $sql);
		}
	}
	function deleteDiscount($dbConn,$orderId){
		$sql		=	"DELETE FROM `discount` WHERE order_id = $orderId";
		$result 	= 	dbQuery($dbConn, $sql);
	}
	function delelteTax($dbConn,$orderId){
		$sql		=	"DELETE FROM `tax` WHERE order_id = $orderId";
		$result 	= 	dbQuery($dbConn, $sql);
	}

?>