<?php
require_once '../library/config.php';
require_once '../library/functions.php';

checkUser();
$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {
    case 'addTran' :
        addTran($dbConn);
        break;
    case 'addAcc' :
        addAcc($dbConn);
        break;
    case 'jouQser' :
        journalQS($dbConn);
        break;
    case 'ledS' :
        ledgerQS($dbConn);
        break;
    case 'ledgerEnd' :
        ledgerEnd($dbConn);
        break;
    case 'codS' :
        codS($dbConn);
        break;
    case 'printPdfJ':
        printPdfJ($dbConn);
        break;
    case 'printPdfT':
        printPdfT($dbConn);
        break;
    case 'printPdfL':
        printPdfL($dbConn);
        break;
    default :
        // if action is not defined or unknown
        // move to main index page
        redirect('index.php');
}

function ledgerEnd($dbConn){
    $amount = $_POST['amount'];
    $nature = $_POST['nature'];
    $account_id = $_POST['account_id'];
    $day = date("d");
    $month = date("m");
    $year = date("Y");
    $sql = "INSERT INTO `ledger`(`id`, `account_title`, `day`, `month`, `year`, `amount`, `nature`)
            VALUES (NULL ,'$account_id','$day','$month','$year',$amount,'$nature')";
    $result = dbQuery($dbConn,$sql);
    redirect("index.php");
}
function ledgerQS($dbConn){
    if(!empty($_POST['ledQ'])){
    $date = explode("-",$_POST['ledQ']);
    redirect("index.php?view=led&title=".$_POST['account_id']."&m=".$date[0]."&Y=".$date['1']);
    }else{
        redirect("index.php?view=led&title=".$_POST['account_id']);
    }
}
function codS($dbConn){
    if(!empty($_POST['code'])){
        $code = $_POST['code'];
        redirect("index.php?code=$code");
    }else{
        redirect("index.php");
    }
}
function journalQS($dbConn){
    $date = explode("-",$_POST['jurQ']);
    redirect("index.php?view=jou&d=".$date[0]."&m=".$date[1]."&Y=".$date[2]);
}
function addTran($dbConn){
    $account_title = $_POST['account_title'];
    $amount = $_POST['amount'];
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
    redirect("index.php?view=jou");
}
function addAcc($dbConn){
    $code = 0;
    if(lastAccountid($dbConn)){
        $code = 1 + lastAccountid($dbConn);
    }else{
        $code= 700;
    }
    $name = $_POST['account_title'];
    $name = $name." Account";
    $sql = "INSERT INTO `account`(`id`, `account_title`, `code`) VALUES (NULL ,'$name','$code')";
    $result = dbQuery($dbConn,$sql);
    redirect("index.php");
}
function printPdfJ($dbConn){
    if(isset($_GET['d']) || isset($_GET['m']) || isset($_GET['Y'])){
        $day = $_GET['d'];
        $month = $_GET['m'];
        $year = $_GET['Y'];
    }else {
        $day = date("d");
        $month = date("m");
        $year = date("Y");
    }
    $sql =  "SELECT * FROM journal WHERE `day` = '$day' AND `month` = '$month' AND `year` = '$year'";
    $result     = dbQuery($dbConn, $sql);
    if(dbNumRows($result) > 0) {
        include_once "../dompdf/autoload.inc.php";
        $domPdf = new Dompdf\Dompdf();
        $html = "<!doctype html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>Journal</title>
    <style rel='stylesheet'>
    .he{
    text-align: center;
    font-weight: 700;
    }
    .table{
    width: 100%;
    border-spacing: 0;
    border-collapse: collapse;
    font-size: 11px;
    }
    .table tr{
    background: #CCCCCC;
    }
    .table th,.table td{
    border: solid 1px #000;
    padding: 5px;
    margin: 0px;
    }
    .text-right{
    text-align: right;
    }
    .text-center{
    text-align: center;
    }
</style>
</head>
<body>
<div class='he'>" .$day."_".$month."_".$year."</div>
<table class='table' >
                    <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Date</th>
                        <th>Account Title</th>
                        <th>Dr Amount</th>
                        <th>Cr Amount</th>
                    </tr>
                    </thead>
                    <tbody>";
        $j = 1;
        $total = 0;
        while($row = dbFetchAssoc($result)){
            extract($row);
            if($nature == "Dr"){
                $html .= "<tr>
                <td>".$j++."</td>
                <td>".$day."-".$month."-".$year."</td>
                <td>".getAccountName($dbConn,$account_title)."</td>
                <td>".$amount."</td>
                <td></td>
            </tr>";
                $total += $amount;
            }
            if($nature == "Cr"){
                $html .= "<tr>
                <td>".$j++."</td>
                <td>".$day."-".$month."-".$year."</td>
                <td class='text-right'>".getAccountName($dbConn,$account_title)."</td>
                <td></td>
                <td>".$amount."</td>";
            }
        }
        $html .= "<tr>
        <td colspan='3' class='text-center'>Total</td>
        <td>".$total."</td>
        <td>".$total."</td>
    </tr>
           </tbody>
                </table>
</body>
</html>";
        $domPdf->loadHtml($html);
        $domPdf->setPaper('A4');
        $domPdf->render();
        $domPdf->stream("journal -".$day."-".$month."-".$year.".pdf");
    }

}
function printPdfL($dbConn){
    if(isset($_GET['m']) || isset($_GET['Y'])){
        $month = $_GET['m'];
        $year = $_GET['Y'];
    }
    if($_GET['title'] == 87 || $_GET['title'] ==86 ){
        $id = $_GET['title'];
        $sql =  "SELECT * FROM `ledger` WHERE `month` = '$month' AND `year` = '$year'";
        $result = dbQuery($dbConn, $sql);
    }else {
        $id = $_GET['title'];
        $sql = "SELECT * FROM journal WHERE `account_title` = '$id' AND `month` = '$month' AND `year`='$year'";
        $result = dbQuery($dbConn, $sql);
    }

    if(dbNumRows($result) > 0) {

        include_once "../dompdf/autoload.inc.php";
        $domPdf = new Dompdf\Dompdf();
        $html = "<!doctype html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>Ledger</title>
    <style rel='stylesheet'>
    .he{
    text-align: center;
    font-weight: 700;
    }
    .table{
    width: 100%;
    border-spacing: 0;
    border-collapse: collapse;
    font-size: 11px;
    }
    .table th,.table td{
    border: solid 1px #000;
    padding: 5px;
    margin: 0px;
    }
    .text-right{
    text-align: right;
    }
    .text-center{
    text-align: center;
    }
</style>
</head>
<body>
<table class='table'>
<tr>
<td colspan='6' style='background:#F58634;color:#FFFFFF;text-align:center; padding: 5px;border:none;font-size: 42px;font-weight: 700;' >Ledger</td>
</tr>
<tr>
<td colspan='3' style='border:none;'><h3>Account Name: ".getAccountName($dbConn,$id)."</h3><h3>Date: ".date('d')."-".$month."-".$year."</h3></td>
<td colspan='3' width='25%' style='border:none;'><img style='width:300px;' src='../../assets/images/logo/logoPrint.png'></td>
</tr><thead>
                    <tr>
                        <th style='background:#F58634;color:#FFFFFF;text-align:left; padding: 5px;border:#000 solid 1px;' >Date</th>
                        <th style='background:#F58634;color:#FFFFFF;text-align:left; padding: 5px;border:#000 solid 1px;' >Account Title</th>
                        <th style='background:#F58634;color:#FFFFFF;text-align:left; padding: 5px;border:#000 solid 1px;' >Dr Amount</th>
                        <th style='background:#F58634;color:#FFFFFF;text-align:left; padding: 5px;border:#000 solid 1px;' >Date</th>
                        <th style='background:#F58634;color:#FFFFFF;text-align:left; padding: 5px;border:#000 solid 1px;' >Account Title</th>
                        <th style='background:#F58634;color:#FFFFFF;text-align:left; padding: 5px;border:#000 solid 1px;' >Cr Amount</th>
                    </tr>
                    </thead>
                    <tbody>";
$totalDr = 0;
$totalCr = 0;
$dr = array();
$cr = array();
$d = 0;
$c = 0;
if($_GET['title'] == 86){
    $list = accountP($dbConn);
}
if($_GET['title'] == 87){
    $list = accountR($dbConn);
}

while($row = dbFetchAssoc($result)){
    if($_GET['title'] == 86 || $_GET['title'] == 87){
        if(in_array($row['account_title'],$list)){
            if(@$row['nature'] == 'Dr'){
                $dr[] = $row;
                $totalDr += $row['amount'];
                $d++;
            }else{
                $cr[] = $row;
                $totalCr += $row['amount'];
                $c++;
            }
        }
    }
    else{
        if(@$row['nature'] == 'Dr'){
            $dr[] = $row;
            $totalDr += $row['amount'];
            $d++;
        }else{
            $cr[] = $row;
            $totalCr += $row['amount'];
            $c++;
        }
    }

}

if($month == 12){
    $month = 01;
    $year = $year - 1;
}else{
    $month = $month -1;
    if($month == 1 || $month == 2 || $month == 3 || $month == 4 || $month == 4 || $month == 5 || $month == 6 || $month == 7 || $month == 8 || $month == 9){
        $month = '0'.$month;
    }
}

if(!($_GET['title'] == 86 || $_GET['title'] == 87)) {
    $sql1 = "SELECT * FROM `ledger` WHERE `account_title` = '$id' AND `month` = '$month' AND `year` = '$year' ORDER BY `id` DESC LIMIT 1 ";
    $result1 = dbQuery($dbConn, $sql1);
    if (@dbNumRows($result1) > 0) {
        $row1 = dbFetchAssoc($result1);
        extract($row1);
        if ($nature == 'Dr') {
           $html .=" <tr>
                <td>01-".date('m-Y')."</td>
                <td>Balance B/d</td>
                <td>".$amount."</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>";
            $totalDr += $amount;
        } else {

            $html .= "<tr>
                <td></td>
                <td></td>
                <td></td>
                <td>01-".date('m-Y')."</td>
                <td>Balance B/d</td>
                <td>".$amount."</td>
            </tr>";
            $totalCr += $amount;
        }
    }
}
if($d > $c){
    for($k=0; $k < $d; $k++){
        $rowDr = @$dr[$k];
        $rowCr = @$cr[$k];
        $html .= "<tr>
            <td>"; if($rowDr['day']){
                    $html .= $rowDr['day']."-".$rowDr['month']."-".$rowDr['year'];
                } $html .= "</td>
            <td>"; if($rowDr['account_title']){
                    if($_GET['title'] == 86 || $_GET['title'] == 87){
                        $html .= getAccountName($dbConn,$rowDr['account_title']);
                    }else {
                        $html .= getAccountName($dbConn, $rowDr['nature_name']);
                        if($rowDr['o_num'] != 0){
                            if(jobName($dbConn,$rowDr['o_num']) == NULL){
                                $html .= " #".$rowDr['o_num'];
                            }else {
                                $html.= " #".jobName($dbConn, $rowDr['o_num']);
                            }
                        }
                    }
                } $html .= "</td>
            <td>"; if($rowDr['amount']){
                    $html .= $rowDr['amount'];
                } $html .= "</td>
            <td>"; if($rowCr['day']){
                    $html .= $rowCr['day']."-".$rowCr['month']."-".$rowCr['year'];
                } $html .="</td>
            <td>"; if($rowCr['account_title']){
                    if($_GET['title'] == 86 || $_GET['title'] == 87){
                        $html.= getAccountName($dbConn,$rowCr['account_title']);
                    }else {
                        $html .= getAccountName($dbConn, $rowCr['nature_name']);
                        if($rowCr['o_num'] != 0){
                            if(jobName($dbConn,$rowCr['o_num']) == NULL){
                                $html .= " #".$rowCr['o_num'];
                            }else {
                                $html .=  " #".jobName($dbConn, $rowCr['o_num']);
                            }
                        }
                    }
                }$html .="</td>
            <td>";if($rowCr['amount']){
                    $html .= $rowCr['amount'];
                }
                $html .="</td>
        </tr>";
    }
}else{
    for($k=0; $k < $c; $k++){
        $rowDr = @$dr[$k];
        $rowCr = @$cr[$k];
$html .="<tr>
            <td>"; if($rowDr['day']){
                    $html .= $rowDr['day']."-".$rowDr['month']."-".$rowDr['year'];
                } $html .= "</td>
            <td>";  if($rowDr['account_title']){
                    if($_GET['title'] == 86 || $_GET['title'] == 87){
                        $html .= getAccountName($dbConn,$rowDr['account_title']);
                    }else {
                        $html .= getAccountName($dbConn, $rowDr['nature_name']);
                        if($rowDr['o_num'] != 0){
                            if(jobName($dbConn,$rowDr['o_num']) == NULL){
                                $html.= " #".$rowDr['o_num'];
                            }else {
                                $html .= " #".jobName($dbConn, $rowDr['o_num']);
                            }
                        }
                    }
                } $html.= "</td>
            <td>"; if($rowDr['amount']){
                    $html .= $rowDr['amount'];
                } $html .="</td>
            <td>"; if($rowCr['day']){
                    $html.= $rowCr['day']."-".$rowCr['month']."-".$rowCr['year'];
                } $html .= "</td>
            <td>"; if($rowCr['account_title']){
                    if($_GET['title'] == 86 || $_GET['title'] == 87){
                        $html.= getAccountName($dbConn,$rowCr['account_title']);
                    }else {
                        $html.= getAccountName($dbConn, $rowCr['nature_name']);
                        if($rowCr['o_num'] != 0){
                            if(jobName($dbConn,$rowCr['o_num']) == NULL){
                                $html.= " #".$rowCr['o_num'];
                            }else {
                                $html.= " #".jobName($dbConn, $rowCr['o_num']);
                            }
                        }
                    }
                }
$html.= "</td>
            <td>"; if($rowCr['amount']){
    $html.= $rowCr['amount'];
                } $html.= "</td>
        </tr>";
    }
}
if($totalDr <= $totalCr){
    $bf = $totalCr - $totalDr;
    $html.= "
    <tr>
        <td>".date('d-m-Y')."</td>
        <td class='text-center'>Balance B/f</td>
        <td>".$bf."</td>
        <td></td>
        <td class='text-center'></td>
        <td></td>
    </tr>";
}else {
    $bf = $totalDr - $totalCr;
$html.= "
    <tr>
        <td></td>
        <td class='text-center'></td>
        <td></td>
        <td>".date('d-m-Y')."</td>
        <td class='text-center'>Balance B/f</td>
        <td>".$bf."</td>
    </tr>";
}
$html.="
<tr>
    <td colspan='2' class='text-center' style='background:#F58634;color:#FFFFFF;text-align:center; padding: 5px;border:#000 solid 1px;' >Total</td>
    <td>"; if($totalDr > $totalCr){
            $html .= $totalDr;
        }else{
            $html .= $totalCr;
        } $html.= "</td>
    <td colspan='2' class='text-center' style='background:#F58634;color:#FFFFFF;text-align:center; padding: 5px;border:#000 solid 1px;' >Total</td>
    <td>"; if($totalDr > $totalCr){
    $html.= $totalDr;
        }else{
    $html.= $totalCr;
        } $html.= "</td>
</tr>
           </tbody>
                </table>
</body>
</html>";
        $month = $_GET['m'];
        $year = $_GET['Y'];
        $id = $_GET['title'];
        $domPdf->loadHtml($html);
        $domPdf->setPaper('A4');
        $domPdf->render();
        $domPdf->stream("Leger -".strtoupper(getAccountName($dbConn,$id))."_". $month."-".$year.".pdf");
    }
    redirect('index.php');

}
function printPdfT($dbConn){
    if(isset($_GET['m']) || isset($_GET['Y'])){
        $month = $_GET['m'];
        $year = $_GET['Y'];
    }
    $sql =  "SELECT * FROM `ledger` WHERE `month` = '$month' AND `year` = '$year'";
    $result     = dbQuery($dbConn, $sql);
    if(dbNumRows($result) > 0) {

        include_once "../dompdf/autoload.inc.php";
        $domPdf = new Dompdf\Dompdf();
        $html = "<!doctype html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>Trail Balance</title>
    <style rel='stylesheet'>
    .he{
    text-align: center;
    font-weight: 700;
    }
    .table{
    width: 100%;
    border-spacing: 0;
    border-collapse: collapse;
    font-size: 11px;
    }
    .table tr{
    background: #CCCCCC;
    }
    .table th,.table td{
    border: solid 1px #000;
    padding: 5px;
    margin: 0px;
    }
    .text-right{
    text-align: right;
    }
    .text-center{
    text-align: center;
    }
</style>
</head>
<body>
<div class='he'>".$month."_".$year."</div>
<table class='table' >
                    <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Account Title</th>
                        <th>Dr Amount</th>
                        <th>Cr Amount</th>
                    </tr>
                    </thead>
                    <tbody>";
        $list = accountRP($dbConn);
        $i = 0;
        $totalDr = 0;
        $totalCr = 0;

        while ($row = dbFetchAssoc($result)) {
            if (!in_array($row['account_title'], $list)) {
                extract($row);
                $html .= "<tr>
                                <td>".++$i."</td>
                                <td>".getAccountName($dbConn, $account_title)."</td>";
                                if ($nature == 'Dr') {
                                   $html.="<td>". $amount."</td>
                                    <td></td>";
                                    $totalDr += $amount;
                                } else {
                                    $html .= "<td></td>
                                    <td>".$amount ."</td>";
                                    $totalCr += $amount;
                                }

                            $html.="</tr>";
            }
        }
        $html .= "<tr>
                            <td colspan='2' class='text-center'>Total</td>
                            <td>".$totalDr."</td>
                            <td>".$totalCr."</td>
                        </tr>
           </tbody>
                </table>
</body>
</html>";

        $domPdf->loadHtml($html);
        $domPdf->setPaper('A4');
        $domPdf->render();
        $domPdf->stream("TrailBalance -".$month."-".$year.".pdf");
    }
    redirect('index.php');

}
?>