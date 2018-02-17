<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';

	checkUser();
	$action = isset($_GET['action']) ? $_GET['action'] : '';
	switch ($action) {
		case 'modify' :
			modifyOrder($dbConn);
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
		case 'inact' :
			inActive($dbConn);
			break;
		case 'updateQuotation':
			updateQuotation($dbConn);
			break;
		default :
			// if action is not defined or unknown
			// move to main index page
			redirect('index.php');
	}
	//Modify User
	function inActive($dbConn){
		if(isset($_GET['orderId'])){
			$orderID = $_GET['orderId'];
		}
		$sql = "UPDATE `order` SET `status`= 1 WHERE `order_id` = $orderID";
		$result = dbQuery($dbConn,$sql);
		redirect("index.php");
	}
	function modifyOrder($dbConn) {
		$dpID = $_POST['dpID'];
		$proNote = $_POST['proNote'];
		$orDId = $_POST['orDId'];
		$sql = "UPDATE `order_detail` SET `order_detail_status`='$dpID',`order_note`='$proNote' WHERE `order_detail_id` = '$orDId'";
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
	function updateQuotation($dbConn){
	// echo '<pre>';
	// print_r($_POST);
	// die();
	if(isset($_POST['print'])){
		$orderId = $_POST['orderID'];
		$title = $_POST['title'];
		$discount = $_POST['discount'];
		$advance  = $_POST['advance'];
		$depId    = $_POST['depId'];
		$tax = $_POST['tax'];
		$discountVoucher = $_POST['discountVoucher'];
		$selectSql = "SELECT * FROM `order` WHERE `order_id` = $orderId";
		$result = dbQuery($dbConn,$selectSql);
		$row = dbFetchAssoc($result);
		extract($row);

		include_once "../dompdf/autoload.inc.php";
		$domPdf = new Dompdf\Dompdf();
		$html = "<!doctype html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>".clientCampnyNameByIDPr($dbConn,$client_id)."</title>
    <style>
        .wrapper{
            width: 100%;
        }
        .heading-q{
            color:#F58634;
        }
        .col-left{
            float: left;
            width: 50%;
        }
        .col-right{
        float: right;
        width: 50%;
        }
        .clear{
        clear: both;
        }
    </style>
</head>
<body>
<table width='100%'>
    <tbody>
    <tr>
        <td colspan='2'>
            <h1 style='color:#F58634;text-align: center;'>Quotation</h1>
        </td>
    </tr>
    <tr>
        <td width='50%'>
            <table width='100%'>
                <tbody>
                    <tr>
                        <td width='50%'>Quotation Date</td>
                        <td width='50%'>".date('d-M-Y')."</td>
                    </tr>
                    <tr>
                        <td width='50%'>Customer ID</td>
                        <td width='50%'>".clientCampnyNameByIDPr($dbConn,$client_id)."</td>
                    </tr>
                    <tr>
                        <td width='50%'>Quotation Ref</td>
                        <td width='50%'>".$order_id."</td>
                    </tr>
                </tbody>
            </table>
        </td>
        <td width='50%'>
            <img style='width:300px;' src='../../assets/images/logo/logoPrint.png'>
        </td>
    </tr>
    <tr>
        <td width='50%'>
            <table width='100%'>
                <tbody>
                    <tr>
                        <td colspan='2' width='100%'>
                            <div style='padding:5px;background:#F58634;color:#FFFFFF;'>For the Attention of</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2' width='100%' style='text-align: center;'>".clientNamePdf($dbConn,$client_id)."</td>
                    </tr>
                    <tr>
                        <td colspan='2' width='100%' style='text-align: center;'>".clienNumberPdf($dbConn,$client_id)."</td>
                    </tr>
                </tbody>
            </table>
        </td>
        <td width='50%'>
            <table width='100%'>
                <tbody>
                    <tr>
                        <td width='50%'>Sales Agent</td>
                        <td width='50%'>".getUserNameBy($dbConn,$user_id)."</td>
                    </tr>
                    <tr>
                        <td width='50%'>Quotation Validity</td>
                        <td width='50%'>7 Days</td>
                    </tr>
                    <tr>
                        <td width='50%'>Delivery Time</td>
                        <td width='50%'>".$order_delivery_time."</td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan='2'>
             <table width='100%' border='1' cellspacing='0'>
                <thead>
                    <tr>
                        <th style='background:#F58634;color:#FFFFFF;text-align:left; padding: 5px;border:#000 solid 1px;'>Item #</th>
						<th style='background:#F58634;color:#FFFFFF;text-align:left; padding: 5px;border:#000 solid 1px;'>Title</th>
                        <th style='background:#F58634;color:#FFFFFF;text-align:left; padding: 5px;border:#000 solid 1px;'>Description</th>
                        <th style='background:#F58634;color:#FFFFFF;text-align:left; padding: 5px;border:#000 solid 1px;'>Size</th>
                        <th style='background:#F58634;color:#FFFFFF;text-align:left; padding: 5px;border:#000 solid 1px;'>Quantity</th>
                        <th style='background:#F58634;color:#FFFFFF;text-align:left; padding: 5px;border:#000 solid 1px;'>Unit Price</th>
                        <th style='background:#F58634;color:#FFFFFF;text-align:left; padding: 5px;border:#000 solid 1px;'>Total</th>
                    </tr>
                </thead>
                <tbody>";
		$i = 0;
		$selectSql1 = "SELECT * FROM `order_detail` WHERE `order_id` = $orderId";
		$result1 = dbQuery($dbConn,$selectSql1);
		$total = 0;
		while($row1 = dbFetchAssoc($result1)) {
			extract($row1);
			$total += $retail_price;
			$title =$row1["title"];
			$html .= "<tr>";
			$html .= "<td>".++$i."</td ><td>".$title."</td ><td >".productNamePr($dbConn,$product_id)."</td ><td >";
			if (productCatId($dbConn,$product_id) == 3) {
				$html .= $width." x ".$height;
			} else {
				$html .= "Std";
			}
			$html .= "</td>
                        <td>".$qty."</td >
                        <td>".getunitPricePdf($qty,$retail_price)."</td >
                        <td>".$retail_price."</td >
                    </tr >";
			if(productCatId($dbConn,$product_id) != 3){
			$selectSql2 = "SELECT * FROM `order_variation` WHERE `order_detail_id` = $order_detail_id";
			$result2 = dbQuery($dbConn,$selectSql2);
				while($row2 =dbFetchAssoc($result2)){
						@extract($row2);
						$html .="<tr><td></td >
                        <td>".variationtitlePr($dbConn, $variation_id)."</td >
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>";
				}
			}
		}
		$html .="<tr>
                        <td colspan='5' style='background:#bbbbbb;'></td>
                        <td>".$total."</td>
                    </tr>";
		$total = $total;
		if(!empty($tax) || $tax != 0) {
			$tax =  $total * $tax;
			$tax = $tax / 100;
			$total = $total + $tax;
			$html.="<tr>
                        <td colspan='5' style='text-align: right;'>Income Tax & WHT Tax</td>
                        <td>".$tax."</td>
                    </tr>";
		}
		if(!empty($_POST['discount']) || $_POST['discount'] != 0) {
			$discount = $_POST['discount'];
			$total = $total - $discount;
			$html .="<tr>
                        <td colspan='5' style='text-align: right;'>Discount</td>
                        <td>".$discount."</td>
                    </tr>";
		}
		if(!empty($_POST['advance']) || $_POST['advance'] != 0) {
			$advance = $_POST['advance'];
			$total = $total - $advance;
			$html .="<tr>
                            <td colspan='5' style='text-align: right;'>Advance</td>
                            <td>".$advance."</td>
                        </tr>";
		}
		$html .="<tr>
                        <td colspan='5' style='text-align: center;background:#bbbbbb;'>Total</td>
                        <td>".$total."</td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>";
		if(!empty($row['order_note'])){
			$html .= " <tr>
        <td colspan='2' style='text-align: center;background: blue;color:white;'>".$row['order_note']."</td>
    </tr>";
		}
		$html .="<tr>
        <td colspan='2' style='text-align: center;background: blue;color:white;'>Terms & Conditions</td>
    </tr>
    <tr>
        <td colspan='2' style='text-align: center;'>1. Customer will be billed after indicating acceptance of this quote</td>
    </tr>
    <tr>
        <td colspan='2' style='text-align: center;'>2. 75% Advance payment will be due at the time of placing order</td>
    </tr>
    <tr>
        <td colspan='2' style='text-align: center;'>3. Incase of Different tax method please revise the qoutation ( Rate ) from the base price</td>
    </tr>
    <tr>
        <td colspan='2' style='text-align: center;'>4. Cheque furnished , will be made in favour of  Daddy Printers  </td>
    </tr>
    <tr>
        <td colspan='2' style='text-align: center;'><h4>Thank you for your business!</h4></td>
    </tr>
    <tr>
        <td colspan='2' style='text-align: center;'>Should you have any queries regarding this quotation, please contact us at.</td>
    </tr>
    <tr>
        <td colspan='2' style='text-align: center;'><h6>G-2 , First Floor , Main Commerical Area , Phase 1 , Dha , Lahore</h6></td>
    </tr>
    <tr>
        <td colspan='2'>
            <table width='100%'>
                <tr>
                    <th width='33%'>0092-321-8460888 /0323-8412223</th>
                    <th width='33%'>info@daddyprinters.com</th>
                    <th width='33%'>www.daddyprinters.com</th>
                </tr>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>";
		$domPdf->loadHtml($html);
		$domPdf->setPaper('A4');
		$domPdf->render();
		$domPdf->stream(clientCampnyNameByIDPr($dbConn,$client_id)."_".$order_id.".pdf");
	}
	if(isset($_POST['update'])){
		$orderId = $_POST['orderID'];
		$discount = $_POST['discount'];
		$advance  = $_POST['advance'];
		$depId    = $_POST['depId'];
		$tax = $_POST['tax'];
		$discountVoucher = $_POST['discountVoucher'];
		$sqlUpdate = "UPDATE `order` SET `status_id`='$depId',`advance` = '$advance' WHERE `order_id` = '$orderId'";
		$result = dbQuery($dbConn,$sqlUpdate);

		$sqlSelect = "SELECT * FROM discount WHERE order_id = '$orderId'";
		$result6 = dbQuery($dbConn,$sqlSelect);
		$total1 = $_POST['total'];
		if(dbNumRows($result6) > 0){
			$total1 -= $discount;
			$disUpdate = "UPDATE `discount` SET `amount`= '$discount' WHERE `order_id` = '$orderId'";
			$result5 = dbQuery($dbConn,$disUpdate);
		}else{
			$total1 -= $discount;
			$insertDiscount = "INSERT INTO `discount`(`discount_id`, `order_id`, `amount`) VALUES (NULL ,'$orderId','$discount')";
			$result5 = dbQuery($dbConn,$insertDiscount);
		}
		$sqlSelect2 = "SELECT * FROM tax WHERE order_id = '$orderId'";
		$result7 = dbQuery($dbConn,$sqlSelect2);
		if(dbNumRows($result7) > 0){
			$inTax = $tax;
			$incomeTax =  $_POST['total'] * $inTax;
			$incomeTax = $incomeTax / 100;
			$total1 += $incomeTax;
			$taxUpdate = "UPDATE `tax` SET `amount`='$tax' WHERE `order_id` = '$orderId'";
			$result4 = dbQuery($dbConn,$taxUpdate);
			
			$grandTotal=$_POST['total'] +$incomeTax - $_POST['discount']-$_POST['advance'] ;
			$updateTotal="UPDATE `order` set total_amount='".$grandTotal."' WHERE order_id='".$orderId."' ";
			dbQuery($dbConn,$updateTotal);
			// die()
			
		}else{
			$inTax = $tax;
			$incomeTax =  $_POST['total'] * $inTax;
			$incomeTax = $incomeTax / 100;
			$total1 += $incomeTax;
			$insertTax = "INSERT INTO `tax`(`tax_id`, `order_id`, `amount`) VALUES (NULL ,'$orderId','$tax')";
			$result4 = dbQuery($dbConn,$insertTax);
		}

		if($depId == 102){
			$client_id = $_POST['client_id'];
			if(@!getIdByName($dbConn,"Sales Account")){
				$code = 0;
				if(lastAccountid($dbConn)){
					$code = 1 + lastAccountid($dbConn);
				}else{
					$code= 700;
				}
				$name = "Sales";
				$name = $name." Account";
				$sql6 = "INSERT INTO `account`(`id`, `account_title`, `code`) VALUES (NULL ,'$name','$code')";
				$result6 = dbQuery($dbConn,$sql6);
			}
			if(@!getIdByName($dbConn,clientCampnyNameByIDPr($dbConn,$client_id)." Account")){
				$code = 0;
				if(lastAccountid($dbConn)){
					$code = 1 + lastAccountid($dbConn);
				}else{
					$code= 700;
				}
				$name = clientCampnyNameByIDPr($dbConn,$client_id);
				$name = $name." Account";
				$sql7 = "INSERT INTO `account`(`id`, `account_title`, `code`,`type`) VALUES (NULL ,'$name','$code','R')";
				$result7 = dbQuery($dbConn,$sql7);
			}
			if(@!getIdByName($dbConn,"Cash Account")){
				$code = 0;
				if(lastAccountid($dbConn)){
					$code = 1 + lastAccountid($dbConn);
				}else{
					$code= 700;
				}
				$name = "Cash";
				$name = $name." Account";
				$sql8 = "INSERT INTO `account`(`id`, `account_title`, `code`) VALUES (NULL ,'$name','$code')";
				$result8 = dbQuery($dbConn,$sql8);
			}

			$account_title = array('Dr'=>getIdByNamePr($dbConn,clientCampnyNameByIDPr($dbConn,$client_id)." Account"),'Cr'=>getIdByNamePr($dbConn,"Sales Account"));
			$amount = $total1;
			$day = date("d");
			$month = date("m");
			$year = date("Y");
			$nature_name = array($account_title['Cr'],$account_title['Dr']);
			$i = 0;
			$o_num = $orderId;
			foreach($account_title as $nature => $title){
				$sql = "INSERT INTO `journal`(`id`,`day`,`month`,`year`, `account_title`, `amount`,`nature`,`nature_name`,`o_num`)
                VALUES (NULL ,'$day','$month','$year','$title','$amount','$nature','$nature_name[$i]','$o_num')";
				$result = dbQuery($dbConn,$sql);
				$i++;
			}

			if(!(empty($advance) || $advance == 0)){
				$account_title = array('Dr'=>getIdByNamePr($dbConn,"Cash Account"),'Cr'=>getIdByNamePr($dbConn,clientCampnyNameByIDPr($dbConn,$client_id)." Account"));
				$amount = $advance;
				$day = date("d");
				$month = date("m");
				$year = date("Y");
				$nature_name = array($account_title['Cr'],$account_title['Dr']);
				$i = 0;
				foreach($account_title as $nature => $title){
					$sql = "INSERT INTO `journal`(`id`,`day`,`month`,`year`, `account_title`, `amount`,`nature`,`nature_name`)
                VALUES (NULL ,'$day','$month','$year','$title','$amount','$nature','$nature_name[$i]')";
					$result = dbQuery($dbConn,$sql);
					$i++;
				}
			}

		}
		redirect("index.php");
	}

	if(isset($_POST['addMore'])){
		$_SESSION['orderId'] = $_POST['orderID'];
		redirect("../quotation/index.php");
	}
}

?>