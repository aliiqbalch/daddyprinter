<?php
if (!defined('WEB_ROOT')) {
    exit;
}
$rowsPerPage = 20;
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
?>
<?php include(THEME_PATH . '/tb_link.php');?>
<!-- Content Header (Page header) -->
<section class="content-header top_heading">
    <h1>Bank Detail</h1>
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid container_block">
        <div class="space"></div>
        <?php if(modPerAdd($dbConn,"23")){?>
            <div class="row">
                <div class="col-md-12">
                    <button type="button" name="btnButton" data-toggle="modal" data-target="#recordTrans"  class="btn btn-danger pull-left" style="margin-left: 5px;">Record Transaction</button>
                    <form action="acountProcess.php?action=jouQser" method="post">
                    <div class="input-group pull-right" style="width: 150px;">
                            <input type="text" name="jurQ" class="form-control" placeholder="<?=date("d-m-Y")?>" aria-describedby="basic-addon2">
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
        <div class="row bord-right-space" >
            <div class="table-responsive tbl-respon">
                <table class="table table-bordered tbl-respon2">
                    <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Date</th>
                        <th>Account Title</th>
                        <th>Dr Amount</th>
                        <th>Cr Amount</th>
                    </tr>
                    </thead>
                    <a href=''></a>
                    <tbody>
<?php
if(dbNumRows($result) > 0){
    $j = 1;
    $total = 0;
    while($row = dbFetchAssoc($result)){
        extract($row);
        if($nature == "Dr"){
            ?>
            <tr>
                <td><?=$j++?></td>
                <td><?php echo $day."-".$month."-".$year;?></td>
                <td><?php if(getAccountName($dbConn,$account_title) == 'Job Account') {if($o_num != 0){ echo "<a href='../job/index.php?view=list&jId=$o_num'> #".jobName($dbConn,$o_num)."</a>"; }} ?> <?=getAccountName($dbConn,$account_title)?></td>
                <td><?=$amount?></td>
                <td></td>
            </tr>
            <?php
            $total += $amount;
        }if($nature == "Cr"){
            ?>
            <tr>
                <td></td>
                <td><?php echo $day."-".$month."-".$year;?></td>
                <td class="text-right"><?php if(getAccountName($dbConn,$account_title) == 'Sales Account') {if($o_num != 0){ echo "<a href='../bill/index.php?view=detail&orderId=$o_num&bid='".getBillId($dbConn,$o_num)."> #".$o_num." </a>"; }} ?><?=getAccountName($dbConn,$account_title)?></td>
                <td></td>
                <td><?=$amount?></td>
            </tr>
            <?php
        }
                ?>
                        <?php
                            }
                            ?>
                            <tr>
                                <td colspan="3" class="text-center">Total</td>
                                <td><?=$total?></td>
                                <td><?=$total?></td>
                            </tr>
                        <?php
                        }

                        ?>
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
                <?php if(@$_GET['d']){?>
                <a href="<?php echo "acountProcess.php?action=printPdfJ&d=$day&m=$month&Y=$year";?>" class="btn btn-danger pull-right" style="margin-left: 5px;">PDF</a>
                <?php } else {?>
                    <a href="acountProcess.php?action=printPdfJ" class="btn btn-danger pull-right" style="margin-left: 5px;">PDF</a>
                <?php } ?>
            </div>
        </div>
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
                <form role="form" action="acountProcess.php?action=addTran" method="post">
                    <h6>Dr</h6>
                    <div class="form-group">
                        <label for="usrname"> Account Title</label>
                        <select name="account_title[Dr]" class="form-control" required >
                            <?php $objAccount = account($dbConn);
                            foreach($objAccount as $obj){
                                ?>
                                <option value="<?=$obj['id']?>"><?=$obj['account_title']?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="psw"> Amount </label>
                        <input type="text" name="amount" class="form-control" id="code" placeholder="Amount" required >
                    </div>
                    <h6>Cr</h6>
                    <div class="form-group">
                        <label for="usrname"> Account Title</label>
                        <select name="account_title[Cr]" class="form-control" required >
                            <?php
                            foreach($objAccount as $obj){
                                ?>
                                <option value="<?=$obj['id']?>"><?=$obj['account_title']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-danger btn-block"> Save </button>
                </form>
            </div>
        </div>
    </div>
</div>