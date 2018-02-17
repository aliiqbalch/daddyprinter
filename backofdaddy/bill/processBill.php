<?php
require_once '../library/config.php';
require_once '../library/functions.php';

checkUser();
$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {
    case 'incat' :
        inActive($dbConn);
        break;
    case 'bill' :
        createBill($dbConn);
        break;
    default :
        // if action is not defined or unknown
        // move to main index page
        redirect('index.php');
}

function inActive($dbConn){
    $billId = $_GET['billId'];
    $sqlUpdate = "UPDATE `bill` SET `status`=1 WHERE `bill_id` = $billId";
    $result = dbQuery($dbConn,$sqlUpdate);
    redirect("index.php");

}
function createBill($dbConn){
    if(@$_POST['print']){
        $orderId = mysqli_real_escape_string($dbConn, $_POST['orderId']);
        $paymentMethod = mysqli_real_escape_string($dbConn, @$_POST['paymentMethod']);
        $total = mysqli_real_escape_string($dbConn, $_POST['total']);
        $date = date("d-m-Y");
        $status = "pending";
        $billId = updateBillID($dbConn);
        $sqlSelect = "SELECT * FROM `order` WHERE `order_id` = $orderId";
        $result = dbQuery($dbConn,$sqlSelect);
        $row = dbFetchAssoc($result);
        extract($row);
        if(empty($paymentMethod)){
            $sql3 = "SELECT * FROM `bill` WHERE `order_id` = $orderId";
            $result3 = dbQuery($dbConn,$sql3);
            $row3 = dbFetchAssoc($result3);
            extract($row3);
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
        <td width='50%'>
            <img style='width:300px;' src='../../assets/images/logo/logoPrint.png'>
        </td>
        <td width='50%'>
             <h1 style='color:#F58634;text-align: center;'>Invoice</h1>
        </td>
    </tr>
    <tr>
        <td width='50%'>
            <table width='100%'>
                <tbody>
                    <tr>
                        <td width='50%'>Customer ID</td>
                        <td width='50%'>".clientCampnyNameByIDPr($dbConn,$client_id)."</td>
                    </tr>
                    <tr>
                        <td width='50%'>Payment Method</td>
                        <td width='50%'>"; if(empty($paymentMethod)){ $html .= $payment_method; }else{ $html .= $paymentMethod; } $html.="</td>
                    </tr>
                    <tr>
                        <td width='50%'>Order Id</td>
                        <td width='50%'>".$order_id."</td>
                    </tr>
                </tbody>
            </table>
        </td>
        <td width='50%'>
            <table width='100%'>
                <tbody>
                    <tr>
                        <td width='50%'>Bill ID</td>
                        <td width='50%'>";
        if(empty($paymentMethod)) {
            $html.= $bill_id;
        }else{$html .= updateBillID($dbConn);}
        $html.="</td>
                    </tr>
                    <tr>
                        <td width='50%'>Invoice Date</td>
                        <td width='50%'>".date('d-M-Y')."</td>
                    </tr>
                    <tr>
                        <td width='50%'>Address</td>
                        <td width='50%'>".clientCampnyAddressPd($dbConn,$client_id)."</td>
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
        $sql1 = "SELECT * FROM `order_detail` WHERE `order_id` = $order_id";
        $result1 = dbQuery($dbConn,$sql1);
        //                var_dump($result1);
        //                die($sql1);
        if (dbNumRows($result1) > 0) {
            $i = 1;
            $total = 0;
            $discount = getDiscount($dbConn, $orderId);
            while ($row1 = dbFetchAssoc($result1)) {
                extract($row1);
                $html .= "<tr>";
                $html .= "<td>" . $i++ . "</td ><td >" . productNamePr($dbConn, $product_id) . "</td ><td >";
                if (productCatId($dbConn, $product_id) == 3) {
                    $html .= $width . " x " . $height;
                } else {
                    $html .= "Std";
                }
                $html .= "</td>
                        <td>" . $qty . "</td >
                        <td>" . getunitPricePdf($qty, $retail_price) . "</td >
                        <td>" . $retail_price . "</td >
                    </tr >";
                $total += $retail_price;
                $discount += getDetDiscount($dbConn, $order_detail_id);
                    if (productCatId($dbConn, $product_id) != 3) {
                        $sql2 = "SELECT * FROM order_variation WHERE order_detail_id = $order_detail_id";
                        $result2 = dbQuery($dbConn, $sql2);
                        if (dbNumRows($result2) > 0) {
                            while ($row2 = dbFetchAssoc($result2)) {
                                extract($row2);
                                $html .= "<tr><td></td >
                        <td>" . variationtitlePr($dbConn, $variation_id) . "</td >
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>";
                            }
                        }
                    }
            }
        }
        $html .="<tr>
                        <td colspan='5' style='background:#bbbbbb;'></td>
                        <td>".$total."</td>
                    </tr>
                    <tr>
                        <td colspan='5' style='text-align: right;'>Income Tax & WHT Tax</td>
                        <td>";
                    $tax = 0;
                    if(getTax($dbConn,$orderId)){
                        $tax = getTax($dbConn,$orderId);
                        $tax = $total * $tax;
                        $tax = $total / 100;
                        $html.= $tax;
                    }else{
                       $html .= "None";
                    }
        $html .="</td>
                    </tr><tr class='printHide'>
                                <td colspan='4'></td>
                                <td>Discount Voucher</td>
                                <td>None</td>
                            </tr>";
        if($discount) {
            $html .="<tr>
                        <td colspan='5' style='text-align: right;'>Discount</td>
                        <td>".$discount."</td>
                    </tr>";
        }
        if($advance) {
            $html .="<tr>
                            <td colspan='5' style='text-align: right;'>Advance</td>
                            <td>".$advance."</td>
                        </tr>";
        }
        $total = $total - $discount;
        $total = $total + $tax;
        $total = $total - $advance;
        $html .="<tr>
                        <td colspan='5' style='text-align: center;background:#bbbbbb;'>Total</td>
                        <td>".$total."</td>
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
        <td colspan='2' style='text-align: center;'>G-2 , First Floor , Main Commerical Area , Phase 1 , Dha , Lahore</td>
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
    if(@$_POST['save']) {
        $orderId = mysqli_real_escape_string($dbConn, $_POST['orderId']);
        $sqlSelect = "SELECT * FROM `bill` WHERE `order_id` = $orderId";
        $result1 = dbQuery($dbConn,$sqlSelect);
        if(!dbNumRows($result1)){
            $paymentMethod = mysqli_real_escape_string($dbConn, $_POST['paymentMethod']);
            $total = mysqli_real_escape_string($dbConn, $_POST['total']);
            $date = date("d-m-Y");
            $status = 0;
            $billId = updateBillID($dbConn);
            $insertQuery = "INSERT INTO `bill`(`bill_id`, `order_id`, `date`, `status`, `total`, `payment_method`)
 						VALUES ('$billId','$orderId','$date','$status','$total','$paymentMethod')";
            $result = dbQuery($dbConn, $insertQuery);
            redirect("index.php");
        }else{
            redirect("index.php");
        }
    }
}