<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';
	require_once 'cart.php';

if(isset($_SESSION['objItems'])){
	$objItems = unserialize($_SESSION['objItems']);
}else{
	$objItems = new Cart();
}
if(isset($_POST['print'])){

	$client_id  = $_POST['companyName'];
	$user_id    = $_POST['saleAgent'];
	$order_note = $_POST['orderNote'];
	$order_delivery_time = $_POST['txtDelDay'];
	$status_id = $_POST['orderStatus'];
	$department_id = $_POST['department'];
	$clientName = $_POST['clientName'];
	$clientNumber = $_POST['clientNumber'];
	$userName = getUserNameBy($dbConn,$user_id);
	$order_id1 = 0;
	if(lastorderid($dbConn)){
		$order_id1 = 1+ lastorderid($dbConn);
	}else{
		$order_id1= 1001;
	}
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
                        <td width='50%'>".$order_id1."</td>
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
                        <td colspan='2' width='100%' style='text-align: center;'>".$clientName."</td>
                    </tr>
                    <tr>
                        <td colspan='2' width='100%' style='text-align: center;'>".$clientNumber."</td>
                    </tr>
                </tbody>
            </table>
        </td>
        <td width='50%'>
            <table width='100%'>
                <tbody>
                    <tr>
                        <td width='50%'>Sales Agent</td>
                        <td width='50%'>".$userName."</td>
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
                        <th style='background:#F58634;color:#FFFFFF;text-align:left; padding: 5px;border:#000 solid 1px;'>Description</th>
                        <th style='background:#F58634;color:#FFFFFF;text-align:left; padding: 5px;border:#000 solid 1px;'>Size</th>
                        <th style='background:#F58634;color:#FFFFFF;text-align:left; padding: 5px;border:#000 solid 1px;'>Quantity</th>
                        <th style='background:#F58634;color:#FFFFFF;text-align:left; padding: 5px;border:#000 solid 1px;'>Unit Price</th>
                        <th style='background:#F58634;color:#FFFFFF;text-align:left; padding: 5px;border:#000 solid 1px;'>Total</th>
                    </tr>
                </thead>
                <tbody>";
		$i = 0;
		foreach($objItems->items as $item) {
			$html .= "<tr>";
			$html .= "<td>".++$i."</td ><td >".productNamePr($dbConn, $item->productID)."</td ><td >";
			if ($item->catID == 3) {
				$html .= $item->width."X".$item->length;
			} else {
				$html .= "Std";
			}
			$html .= "</td>
                        <td>".$item->qty."</td >
                        <td>".$item->unitPrice."</td >
                        <td>".$item->total."</td >
                    </tr >";
			foreach ($item->itemsValue as $itemId) {
				@extract($itemId);
				$html .="<tr><td></td >
                        <td>".variationtitlePr($dbConn, $variationid)."</td >
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>";
			}
		}
		$html .="<tr>
                        <td colspan='5' style='background:#bbbbbb;'></td>
                        <td>".$objItems->total."</td>
                    </tr>";
    $total = $objItems->total;
		if(!empty($_POST['incomeTax']) || $_POST['incomeTax'] != 0) {
			$incomeTax = $_POST['incomeTax'];
			$incomeTax =  $objItems->total * $incomeTax;
			$incomeTax = $incomeTax / 100;
			$total = $total + $incomeTax;
			$html.="<tr>
                        <td colspan='5' style='text-align: right;'>Income Tax & WHT Tax</td>
                        <td>".$incomeTax."</td>
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
    if(!empty($order_note)){
        $html .= " <tr>
        <td colspan='2' style='text-align: center;background: blue;color:white;'>".$order_note."</td>
    </tr>";
    }
    $html .="
    <tr>
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
		$domPdf->stream(clientCampnyNameByIDPr($dbConn,$client_id)."_".$order_id1.".pdf");
}
if(isset($_POST['order'])){
	if($objItems->items) {
printR($_POST);
		$client_id  = $_POST['companyName'];
		$user_id    = $_POST['saleAgent'];
		$order_note = $_POST['orderNote'];
		$order_delivery_time = $_POST['txtDelDay'];
		$status_id = $_POST['orderStatus'];
		$department_id = $_POST['department'];
		$clientName = $_POST['clientName'];
		$clientNumber = $_POST['clientNumber'];
        $advance = $_POST['advance'];
		$order_id1 = 0;
        $total1 = 0;
		if(lastorderid($dbConn)){
			$order_id1 = 1+ lastorderid($dbConn);
		}else{
			$order_id1= 1001;
		}

		$sql = "INSERT INTO `order`(order_id, client_id, user_id, order_note, order_delivery_time, status_id, department_id,advance)
 			VALUES ('$order_id1' ,'$client_id','$user_id','$order_note','$order_delivery_time','$status_id','$department_id','$advance')";
		echo $sql;
		       die("SSS");

		$result = dbQuery($dbConn, $sql);
		$order_id = lastorderid($dbConn);
		if($order_id){
			foreach($objItems->items as $item){
                $total1 += $item->total;
				$insertOrderDetail = "INSERT INTO `order_detail`(`order_detail_id`, `product_id`, `base_price`, `qty`, `cost_price`, `whole_sale_price`, `retail_price`, `height`, `width`, `rate`, `order_detail_status`, `order_id`)
 							  VALUES (Null,'$item->productID','$item->basePrice','$item->qty','$item->costPrice','$item->wholesalePrice','$item->total','$item->length','$item->width','$item->rate','207','$order_id')";
				$result2 = dbQuery($dbConn,$insertOrderDetail);

                if($status_id == 102){
                    if($item->catID == 4){
                        $qty = pro_qty($dbConn,$item->productID);
                        $qty = $qty - $item->qty;
                        $sqlUpdate = "UPDATE `tbl_product` SET `pro_s_qty`=$qty WHERE `pro_id` = $item->productID";
                        $resultUp = dbQuery($dbConn,$sqlUpdate);
                    }
                }

				$order_detail_id = order_detail_id($dbConn);
				if($order_detail_id){
					if($item->catID != 3){
						foreach ($item->itemsValue as $key => $row) {
							//$productid = $row['productid'];
							$variationtypeid = $row['variationtypeid'];
							$variationid = $row['variationid'];
							$insertOrderVariation = "INSERT INTO `order_variation`(`order_variation_id`, `order_detail_id`, `variation_type_id`, `variation_id`)
												 VALUES (NULL ,'$order_detail_id','$variationtypeid','$variationid')";
							$result3 = dbQuery($dbConn, $insertOrderVariation);
//						var_dump($result3);
//						die($insertOrderVariation);
						}
					}
				}else{
					echo "<div class='alert alert-danger' style=''>Some Error Occured.Please Try Again</div>";
				}
			}
		}else{
			echo "<div class='alert alert-danger' style=''>Some Error Occured.Please Try Again</div>";
		}
		if(!(empty($_POST['incomeTax']) || $_POST['incomeTax'] == 0)) {
			$inTax = $_POST['incomeTax'];
			$incomeTax =  $objItems->total * $inTax;
			$incomeTax = $incomeTax / 100;
            $total1 += $incomeTax;
			$insertTax = "INSERT INTO `tax`(`tax_id`, `order_id`, `amount`) VALUES (NULL ,'$order_id','$inTax')";
			$result4 = dbQuery($dbConn,$insertTax);
		}

		if(!(empty($_POST['discount']) || $_POST['discount'] == 0)) {
			$discount = $_POST['discount'];
            $total1 -= $discount;
			$insertDiscount = "INSERT INTO `discount`(`discount_id`, `order_id`, `amount`) VALUES (NULL ,'$order_id','$discount')";
			$result5 = dbQuery($dbConn,$insertDiscount);
		}

        if($status_id == 102){
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
            $o_num = $order_id1;
            foreach($account_title as $nature => $title){
                $sql = "INSERT INTO `journal`(`id`,`day`,`month`,`year`, `account_title`, `amount`,`nature`,`nature_name`,`o_num`)
                VALUES (NULL ,'$day','$month','$year','$title','$amount','$nature','$nature_name[$i]',$o_num)";
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

	}else{
		echo "<div class='alert alert-danger' style=''>Some Error Occured.Please Try Again</div>";
	}
	unset($_SESSION['objItems']);
    redirect("index.php");
}
if(isset($_POST['orderUpdate'])){

    $order_id = $_SESSION['orderId'];
    if(isset($order_id)){
        foreach($objItems->items as $item){

            $insertOrderDetail = "INSERT INTO `order_detail`(`order_detail_id`, `product_id`, `base_price`, `qty`, `cost_price`, `whole_sale_price`, `retail_price`, `height`, `width`, `rate`, `order_detail_status`, `order_id`)
 							  VALUES (Null,'$item->productID','$item->basePrice','$item->qty','$item->costPrice','$item->wholesalePrice','$item->total','$item->length','$item->width','$item->rate','207','$order_id')";
            $result2 = dbQuery($dbConn,$insertOrderDetail);
            $order_detail_id = order_detail_id($dbConn);

            if($order_detail_id){

                if($item->catID != 3){
                    foreach ($item->itemsValue as $key => $row) {

                        //$productid = $row['productid'];
                        $variationtypeid = $row['variationtypeid'];
                        $variationid = $row['variationid'];
                        $insertOrderVariation = "INSERT INTO `order_variation`(`order_variation_id`, `order_detail_id`, `variation_type_id`, `variation_id`)
												 VALUES (NULL ,'$order_detail_id','$variationtypeid','$variationid')";
                        $result3 = dbQuery($dbConn, $insertOrderVariation);
//						var_dump($result3);
//						die($insertOrderVariation);
                    }
                }
            }else{
                echo "<div class='alert alert-danger' style=''>Some Error Occured.Please Try Again</div>";
            }
        }
    }else{
        echo "<div class='alert alert-danger' style=''>Some Error Occured.Please Try Again</div>";
    }
    unset($_SESSION['orderId']);
    unset($_SESSION['objItems']);
    redirect("../order/index.php?view=detail&orderId=$order_id");
}

	
	
		
		