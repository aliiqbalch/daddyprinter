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
		case 'deleteDetail' :
			deleteOrderD($dbConn);
			break;
		default :
			redirect('index.php');
	}
	//Modify User
	function modifyPendingOrder($dbConn) {
		$statusId		= mysqli_real_escape_string($dbConn, $_POST['statusId']);
		$orderId 	 	= mysqli_real_escape_string($dbConn, $_GET['oid']);
		$disId    = mysqli_real_escape_string($dbConn,$_REQUEST['disId']);
		$disAmount          = mysqli_real_escape_string($dbConn,$_POST['discount']);

		$sqlSelect = "SELECT * FROM discount WHERE discount_id = '$disId'";
		$result = dbQuery($dbConn,$sqlSelect);
//		var_dump($sqlSelect);
//		die("SSS");
		if(dbNumRows($result) > 0){
			$sqlUpdate = "UPDATE discount SET amount='$disAmount' WHERE discount_id = '$disId'";
			$result = dbQuery($dbConn,$sqlUpdate);
		}else{
//			die("SSSs");
			$sqlInsert = "INSERT INTO discount(discount_id, order_id, amount) VALUES (NULL ,'$orderId','$disAmount')";
			$result = dbQuery($dbConn,$sqlInsert);
		}
			$sql = "UPDATE `order` SET status_id='$statusId' WHERE order_id = '$orderId'";
			$result = dbQuery($dbConn, $sql);
			$_SESSION['count'] = 0;
			$_SESSION['errorMessage'] = "Order Updated Successfully.";
			redirect('index.php');
	}
	function modifyPendingOrderDetail($dbConn){
		$orderDetailId = mysqli_real_escape_string($dbConn, $_POST['orderDetailId']);
		$qty = mysqli_real_escape_string($dbConn, $_POST['qty']);
		$unitPrice = mysqli_real_escape_string($dbConn, $_POST['unitPrice']);
		$total = $qty * $unitPrice;
		if(!(empty($orderDetailId) || empty($qty) || empty($unitPrice))){
			$update = "UPDATE `order_detail` SET `qty`='$qty',`retail_price`='$total' WHERE `order_detail_id` = '$orderDetailId'";
			$result = dbQuery($dbConn, $update);
			$_SESSION['count'] = 0;
			$_SESSION['errorMessage'] = "Order Updated Successfully.";
			redirect('index.php');
		}else{
			redirect('index.php');
		}

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
	function deleteOrderD($dbConn){
		$oDId = $_GET['oDId'];
		if(!empty($oDId)){
			$sql1 = "SELECT * FROM order_detail WHERE order_detail_id = $oDId";
			$result1 = dbQuery($dbConn,$sql1);
			if($result1){
					$catId =  productCatId($dbConn,$row['product_id']);
					if($catId !=3){
						deleteOrderVariation($dbConn,$oDId);
					}
			}
			$DeleteSql = "DELETE FROM `order_detail` WHERE `order_detail_id` = $oDId";
			$result 	= 	dbQuery($dbConn, $DeleteSql);
			$_SESSION['count'] = 0;
			$_SESSION['errorMessage'] = "Member Deleted Successfully.";
			redirect('index.php');
		}else{
			redirect('index.php');
		}
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