<?php
if (!defined('WEB_ROOT')) {
    exit;
}
$rowsPerPage = 20;
if(isset($_GET['m']) || isset($_GET['Y'])){
    $month = $_GET['m'];
    $year = $_GET['Y'];
}else {
    $month = date("m");
    $year = date("Y");
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
?>
<?php include(THEME_PATH . '/tb_link.php');?>
<!-- Content Header (Page header) -->
<section class="content-header top_heading">
    <h1><?=strtoupper(getAccountName($dbConn,$id))?></h1>
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid container_block">
        <div class="space"></div>
        <?php if(modPerAdd($dbConn,"23")){?>
            <div class="row">
                <div class="col-md-12">
<!--                    <button type="button" name="btnButton" data-toggle="modal" data-target="#recordTrans"  class="btn btn-danger pull-left" style="margin-left: 5px;">Record Transaction</button>-->
                    <form action="acountProcess.php?action=ledS" method="post">
                    <div class="input-group pull-right" style="width: 150px;">
                            <input type="hidden" name="account_id" value="<?=$id?>">
                            <input type="text" name="ledQ" class="form-control" placeholder="mm-yyyy" aria-describedby="basic-addon2">
                            <span style="margin:0px;padding: 0px;" class="input-group-addon" id="basic-addon2"><button type="submit" style="border-radius:0px; border: none;" class="btn"><i class="fa fa-search"></i></button></span>
                    </div>
                    </form>
                </div>
            </div>
        <?php }?>
        <div style="margin-top: 10px;">
            <?php
            if(isset($_SESSION['errorMessage']) && isset($_SESSION['count'])){
                if($_SESSION['count'] <= 1){
                    $_SESSION['count'] +=1; ?>
                    <p class="alert alert-<?php echo $_SESSION['data'];?>"><?php echo $_SESSION['errorMessage'];  ?></p> <?php
                    unset($_SESSION['errorMessage']);
                }
            } ?>
        </div>
        <form action="acountProcess.php?action=ledgerEnd" method="post">
        <div class="row bord-right-space" >
            <div class="table-responsive tbl-respon">
                <table class="table table-bordered tbl-respon2">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Account Title</th>
                        <th>Dr Amount</th>
                        <th>Date</th>
                        <th>Account Title</th>
                        <th>Cr Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
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
                                if(@$row['nature'] == "Dr"){
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
                            if(@$row['nature'] == "Dr"){
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
                            $month = "0".$month;
                        }
                    }

                    if(!($_GET['title'] == 86 || $_GET['title'] == 87)) {
                        $sql1 = "SELECT * FROM `ledger` WHERE `account_title` = '$id' AND `month` = '$month' AND `year` = '$year' ORDER BY `id` DESC LIMIT 1 ";
                        $result1 = dbQuery($dbConn, $sql1);
                        if (@dbNumRows($result1) > 0) {
                            $row1 = dbFetchAssoc($result1);
                            extract($row1);
                            if ($nature == "Dr") {
                                ?>
                                <tr>
                                    <td>01-<?= date("m-Y") ?></td>
                                    <td>Balance B/d</td>
                                    <td><?= $amount ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php
                                $totalDr += $amount;
                            } else {
                                ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>01-<?= date("m-Y") ?></td>
                                    <td>Balance B/d</td>
                                    <td><?= $amount ?></td>
                                </tr>
                                <?php
                                $totalCr += $amount;
                            }
                        }
                    }
                    if($d > $c){
                        for($k=0; $k < $d; $k++){
                            $rowDr = @$dr[$k];
                            $rowCr = @$cr[$k];
                            ?>
                            <tr>
                                <td><?php if($rowDr['day']){
                                        echo $rowDr['day']."-".$rowDr['month']."-".$rowDr['year'];
                                    }?></td>
                                <td><?php if($rowDr['account_title']){
                                        if($_GET['title'] == 86 || $_GET['title'] == 87){
                                            echo getAccountName($dbConn,$rowDr['account_title']);
                                        }else {
                                            echo getAccountName($dbConn, $rowDr['nature_name']);
                                            if($rowDr['o_num'] != 0){
                                                if(jobName($dbConn,$rowDr['o_num']) == NULL){
                                                    echo "<a href='../bill/index.php?view=detail&orderId=".$rowDr['o_num']."&bid='".getBillId($dbConn,$rowDr['o_num'])."> #".$rowDr['o_num']." </a>";
                                                }else {
                                                    echo "<a href='../job/index.php?view=list&jId=" . $rowDr['o_num'] . "'> #" . jobName($dbConn, $rowDr['o_num']) . "</a>";
                                                }
                                            }
                                        }
                                    }?></td>
                                <td><?php if($rowDr['amount']){
                                        echo $rowDr['amount'];
                                    }?></td>
                                <td><?php if($rowCr['day']){
                                        echo $rowCr['day']."-".$rowCr['month']."-".$rowCr['year'];
                                    }
                                    ?></td>
                                <td><?php if($rowCr['account_title']){
                                        if($_GET['title'] == 86 || $_GET['title'] == 87){
                                            echo getAccountName($dbConn,$rowCr['account_title']);
                                        }else {
                                            echo getAccountName($dbConn, $rowCr['nature_name']);
                                            if($rowCr['o_num'] != 0){
                                                if(jobName($dbConn,$rowCr['o_num']) == NULL){
                                                    echo "<a href='../bill/index.php?view=detail&orderId=".$rowCr['o_num']."&bid='".getBillId($dbConn,$rowCr['o_num'])."> #".$rowCr['o_num']." </a>";
                                                }else {
                                                    echo "<a href='../job/index.php?view=list&jId=" . $rowCr['o_num'] . "'> #" . jobName($dbConn, $rowCr['o_num']) . "</a>";
                                                }
                                            }
                                        }
                                    }
                                    ?></td>
                                <td><?php if($rowCr['amount']){
                                        echo $rowCr['amount'];
                                    }
                                    ?></td>
                            </tr>
                            <?php
                        }
                    }else{
                        for($k=0; $k < $c; $k++){
                            $rowDr = @$dr[$k];
                            $rowCr = @$cr[$k];
                            ?>
                            <tr>
                                <td><?php if($rowDr['day']){
                                        echo $rowDr['day']."-".$rowDr['month']."-".$rowDr['year'];
                                    }?></td>
                                <td><?php if($rowDr['account_title']){
                                        if($_GET['title'] == 86 || $_GET['title'] == 87){
                                            echo getAccountName($dbConn,$rowDr['account_title']);
                                        }else {
                                            echo getAccountName($dbConn, $rowDr['nature_name']);
                                            if($rowDr['o_num'] != 0){
                                                if(jobName($dbConn,$rowDr['o_num']) == NULL){
                                                    echo "<a href='../bill/index.php?view=detail&orderId=".$rowDr['o_num']."&bid='".getBillId($dbConn,$rowDr['o_num'])."> #".$rowDr['o_num']." </a>";
                                                }else {
                                                    echo "<a href='../job/index.php?view=list&jId=" . $rowDr['o_num'] . "'> #" . jobName($dbConn, $rowDr['o_num']) . "</a>";
                                                }
                                            }
                                        }
                                    }?></td>
                                <td><?php if($rowDr['amount']){
                                        echo $rowDr['amount'];
                                    }?></td>
                                <td><?php if($rowCr['day']){
                                        echo $rowCr['day']."-".$rowCr['month']."-".$rowCr['year'];
                                    }
                                    ?></td>
                                <td><?php if($rowCr['account_title']){
                                        if($_GET['title'] == 86 || $_GET['title'] == 87){
                                            echo getAccountName($dbConn,$rowCr['account_title']);
                                        }else {
                                            echo getAccountName($dbConn, $rowCr['nature_name']);
                                            if($rowCr['o_num'] != 0){
                                                if(jobName($dbConn,$rowCr['o_num']) == NULL){
                                                    echo "<a href='../bill/index.php?view=detail&orderId=".$rowCr['o_num']."&bid='".getBillId($dbConn,$rowCr['o_num'])."> #".$rowCr['o_num']." </a>";
                                                }else {
                                                    echo "<a href='../job/index.php?view=list&jId=" . $rowCr['o_num'] . "'> #" . jobName($dbConn, $rowCr['o_num']) . "</a>";
                                                }
                                            }
                                        }
                                    }
                                    ?></td>
                                <td><?php if($rowCr['amount']){
                                        echo $rowCr['amount'];
                                    }
                                    ?></td>
                            </tr>
                            <?php
                        }
                    }
                    if($totalDr <= $totalCr){
                       $bf = $totalCr - $totalDr;
                        ?>
                        <tr>
                            <td><?=date("d-m-Y")?></td>
                            <td class="text-center">Balance B/f</td>
                            <td><?=$bf?> <input type="hidden" name="amount" value="<?=$bf?>"> <input type="hidden" name="nature" value="Cr"></td>
                            <td></td>
                            <td class="text-center"></td>
                            <td></td>
                        </tr>
                    <?php
                    }else {
                        $bf = $totalDr - $totalCr;
                        ?>
                        <tr>
                            <td></td>
                            <td class="text-center"></td>
                            <td></td>
                            <td><?=date("d-m-Y")?></td>
                            <td class="text-center">Balance B/f</td>
                            <td><?=$bf?><input type="hidden" name="amount" value="<?=$bf?>"> <input type="hidden" name="nature" value="Dr"></td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td colspan="2" class="text-center">Total</td>
                        <td><?php if($totalDr > $totalCr){
                                echo $totalDr;
                            }else{
                               echo $totalCr;
                            } ?></td>
                        <td colspan="2" class="text-center">Total</td>
                        <td><?php if($totalDr > $totalCr){
                                echo $totalDr;
                            }else{
                                echo $totalCr;
                            } ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--- End Table ---------------->
        <div style="margin-bottom:20px;" class="row">
            <div class="col-md-6">
                <a href="index.php" class="btn btn-danger pull-left" style="margin-left: 5px;">Back</a>
            </div>
            <div class="col-md-6">
                <?php
                    $id = $_GET['title'];
                ?>
                <input type="hidden" name="account_id" value="<?=$id?>">
                <?php if(date("d") == 30 || date("d") == 31){?>
                <button type="submit" name="btnButton"  class="btn btn-danger pull-right" style="margin-left: 5px;">Save</button>
                <?php }
                if(isset($_GET['m']) || isset($_GET['Y'])){
                    $month = $_GET['m'];
                    $year = $_GET['Y'];
                }else {
                    $month = date("m");
                    $year = date("Y");
                }
                ?>
                <a href="acountProcess.php?action=printPdfL&m=<?=$month?>&Y=<?=$year?>&title=<?=$id?>" class="btn btn-danger pull-right" style="margin-left: 5px;">PDF</a>
            </div>
        </div>
        </form>
    </div>

</section><!-- /.content -->
<!-- Modal -->
<div class="modal fade" id="recordTrans" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="padding:35px 50px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Record Transaction</h4>
            </div>
            <div class="modal-body" style="padding:40px 50px;">
                <form role="form" action="" method="post">
                    <h6>Dr</h6>
                    <div class="form-group">
                        <label for="usrname"> Account Title</label>
                        <select name="account_titleDr" class="form-control">
                            <option value="0">Select Title</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="psw"> Amount </label>
                        <input type="text" name="amount" class="form-control" id="code" placeholder="Amount">
                        <input type="hidden" name="natureDr" value="Dr">
                    </div>
                    <h6>Cr</h6>
                    <div class="form-group">
                        <label for="usrname"> Account Title</label>
                        <select name="account_titleCr" class="form-control">
                            <option value="0">Select Title</option>
                        </select>
                        <input type="hidden" name="natureCr" value="Cr">
                    </div>
                    <button type="submit" class="btn btn-danger btn-block"> Save </button>
                </form>
            </div>
        </div>
    </div>
</div>