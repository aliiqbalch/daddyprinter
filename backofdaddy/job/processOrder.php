<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';

	checkUser();
	$action = isset($_GET['action']) ? $_GET['action'] : '';
	switch ($action) {
		case 'process':
			process($dbConn);
			break;
        case 'delete':
            delete($dbConn);
            break;
        case 'comp':
            complete($dbConn);
            break;
        case 'inComp':
            inComplete($dbConn);
            break;
		default :
			// if action is not defined or unknown
			// move to main index page
			redirect('index.php');
	}
	function process($dbConn)
    {
        if (isset($_POST['print'])) {
            $vendorName = $_POST['vendorName'];
            $width = $_POST['width'];
            $height = $_POST['height'];
            $qty = $_POST['qty'];
            $unitPrice = $_POST['unitPrice'];
            $orderDetailId = $_POST['orderDetailId'];
            $price = $_POST['price'];
            $note = $_POST['note'];
            $date = date("d-M-Y");
            $job_name = $_POST['job_name'];
            $objVen = getVenderById($dbConn, $vendorName);
            $objOrder = orderDetail($dbConn, $orderDetailId);
            include_once "../dompdf/autoload.inc.php";
            $domPdf = new Dompdf\Dompdf();
            $html = "<!doctype html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>" . $objVen['ven_cmp_name'] . "</title>
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
         	<img style='width:300px;' src='../../assets/images/logo/logoPrint.png'>
        </td>
    </tr>
    <tr>
        <td width='50%'>
            <table width='100%'>
                <tbody>
                    <tr>
                        <td width='50%'>Job Order Date</td>
                        <td width='50%'>" . date('d-M-Y') . "</td>
                    </tr>
                    <tr>
                        <td width='50%'>Vendor Company</td>
                        <td width='50%'>" . $objVen['ven_cmp_name'] . "</td>
                    </tr>
                    <tr>
                        <td width='50%'>Vendor Name</td>
                        <td width='50%'>" . $objVen['ven_name'] . "</td>
                    </tr>
                </tbody>
            </table>
        </td>
        <td width='50%'>
        	<h1 style='text-align: center;'>Job ORder</h1>
        	<div style='text-align: center;'>" . categoryNamePr($dbConn, productCatId($dbConn, $objOrder['product_id'])) . "</div>
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
            $html .= "<tr><td>1</td><td>" . $job_name . "</td><td>" . $width . " x " . $height . "</td><td>" . $qty . "</td ><td>" . $unitPrice . "</td><td>" . $price . "</td></tr>
				<tr><td>&nbsp;</td><td>";
            if (productCatId($dbConn, $objOrder['product_id']) != 3) {
                $sql1 = "SELECT * FROM `order_variation` WHERE `order_detail_id` = $orderDetailId";
                $result1 = dbQuery($dbConn, $sql1);
                if (dbNumRows($result1) > 0) {
                    while ($row1 = dbFetchAssoc($result1)) {
                        extract($row1);
                        $html .= variationtitlePr($dbConn, $variation_id) . " , ";
                    }
                }
            }
            $html .= "
				</td><td></td><td></td><td></td><td></td></tr>
				<tr><td>&nbsp;</td><td>" . $note . "</td><td></td><td></td ><td></td><td></td></tr>
				<tr><td>&nbsp;</td><td></td><td></td><td></td ><td></td><td></td></tr>
				<tr><td>&nbsp;</td><td></td><td></td><td></td ><td></td><td></td></tr>";
            $html .= "<tr>
                        <td colspan='5' style='text-align: center;background:#bbbbbb;'>Total</td>
                        <td>" . $price . "</td>
                    </tr>
                </tbody>
            </table>
        </td>
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
            $domPdf->setPaper('A5');
            $domPdf->render();
            $domPdf->stream($job_name . ".pdf");
        }
        if (isset($_POST['order'])) {
            $job_name = $_POST['job_name'];
            $vendorName = $_POST['vendorName'];
            $width = $_POST['width'];
            $height = $_POST['height'];
            $qty = $_POST['qty'];
            $unitPrice = $_POST['unitPrice'];
            $orderDetailId = $_POST['orderDetailId'];
            $price = $_POST['price'];
            $note = $_POST['note'];
            $date = date("d-M-Y");

            $pId = orderDetailPID($dbConn, $orderDetailId);
            if (productCatId($dbConn, $pId) == 4) {
                $qty1 = productQty($dbConn, $pId);
                //$qty2 = productQtyRi($dbConn,$pId);
                die("SSSS");
                if ($qty1 > $qty) {
                    $qty1 = $qty1 - $qty;
                    $sqlUpdate = "UPDATE `tbl_product` SET `pro_s_qty`=$qty1 WHERE `pro_id` = $pId";
                    $resultUp = dbQuery($dbConn, $sqlUpdate);
                } else {
                    $_SESSION['error'] = "Your qty is low please fill the stock and creat job again";
                    redirect('index.php');
                    die();
                }

            }
                $sql = "INSERT INTO `job_order`(`Job_id`, `vendor_id`, `width`, `height`, `unit_price`, `qty`, `date`,`total`,`note`,job_name,`order_detail_id`)
									VALUES (NULL ,'$vendorName','$width','$height','$unitPrice','$qty','$date','$price','$note','$job_name','$orderDetailId')";
                $result = dbQuery($dbConn, $sql);
                if (@!getIdByName($dbConn, "Job Account")) {
                    $code = 0;
                    if (lastAccountid($dbConn)) {
                        $code = 1 + lastAccountid($dbConn);
                    } else {
                        $code = 700;
                    }
                    $name = "Job";
                    $name = $name . " Account";
                    $sql6 = "INSERT INTO `account`(`id`, `account_title`, `code`) VALUES (NULL ,'$name','$code')";
                    $result6 = dbQuery($dbConn, $sql6);
                }
                $venderList = getVenderById($dbConn, $vendorName);

                if (@!getIdByName($dbConn, $venderList['ven_cmp_name'] . " Account")) {
                    $code = 0;
                    if (lastAccountid($dbConn)) {
                        $code = 1 + lastAccountid($dbConn);
                    } else {
                        $code = 700;
                    }
                    $name = $venderList['ven_cmp_name'] . " Account";
                    $sql7 = "INSERT INTO `account`(`id`, `account_title`, `code`,`type`) VALUES (NULL ,'$name','$code','P')";
                    $result7 = dbQuery($dbConn, $sql7);
                }
                $account_title = array('Dr' => getIdByNamePr($dbConn, "Job Account"), 'Cr' => getIdByNamePr($dbConn, $venderList['ven_cmp_name'] . " Account"));
                $amount = $price;
                $day = date("d");
                $month = date("m");
                $year = date("Y");
                $nature_name = array($account_title['Cr'], $account_title['Dr']);
                $i = 0;
                $jobID = lastJobId($dbConn);
                $o_num = $jobID;
                foreach ($account_title as $nature => $title) {
                    $sql = "INSERT INTO `journal`(`id`,`day`,`month`,`year`, `account_title`, `amount`,`nature`,`nature_name`,`o_num`)
                VALUES (NULL ,'$day','$month','$year','$title','$amount','$nature','$nature_name[$i]','$o_num')";
                    $result = dbQuery($dbConn, $sql);
                    $i++;
                }
                redirect("index.php");
            }
    }
    function delete($dbConn){
        if(isset($_GET['jobId'])){
            $jobOrder = $_GET['jobId'];
        }
        $sql = "DELETE FROM `job_order` WHERE `Job_id` = $jobOrder";
        $result = dbQuery($dbConn,$sql);
        redirect("index.php");
    }
    function inComplete($dbConn){
        if(isset($_GET['jobId'])){
            $jobId = $_GET['jobId'];
        }
        $sql = "UPDATE `job_order` SET `status`= 0 WHERE `Job_id` = $jobId";
        $result = dbQuery($dbConn,$sql);
        redirect("index.php");

    }
    function complete($dbConn){
    if(isset($_GET['jobId'])){
        $jobId = $_GET['jobId'];
    }
    $sql = "UPDATE `job_order` SET `status`= 1 WHERE `Job_id` = $jobId";
    $result = dbQuery($dbConn,$sql);
    redirect("index.php");

}
?>