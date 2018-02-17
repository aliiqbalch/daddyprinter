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

		case 'bill' :
			createBill($dbConn);
			break;
		case 'act' :
			active($dbConn);
			break;
			
		default :
			// if action is not defined or unknown
			// move to main index page
			redirect('index.php');
	}

	function createBill($dbConn){
		$orderId = mysqli_real_escape_string($dbConn,$_POST['orderId']);
		$paymentMethod = mysqli_real_escape_string($dbConn,$_POST['paymentMethod']);
		$total = mysqli_real_escape_string($dbConn,$_POST['total']);
		$date = date("d-m-Y");
		$status = "pending";
		$billId = updateBillID($dbConn);
		$insertQuery = "INSERT INTO `bill`(`bill_id`, `order_id`, `date`, `status`, `total`, `payment_method`)
 						VALUES ('$billId','$orderId','$date','$status','$total','$paymentMethod')";
		$result = dbQuery($dbConn,$insertQuery);
		redirect("index.php");
	}

function active($dbConn){
	if(isset($_GET['orderId'])){
		$orderID = $_GET['orderId'];
	}
	$sql = "UPDATE `order` SET `status`= 0 WHERE `order_id` = $orderID";
	$result = dbQuery($dbConn,$sql);
	redirect("index.php");
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

?>