<?php
if (!defined('WEB_ROOT')) {
    exit;
}
$month = date("m");
$year = date("Y");
if($month == 01){
    $month = 12;
    $year = $year - 1;
}else{
    $month = $month - 1;
    if($month == 1 || $month == 2 || $month == 3 || $month == 4 || $month == 4 || $month == 5 || $month == 6 || $month == 7 || $month == 8 || $month == 9){
        $month = "0".$month;
    }
}
$sql =  "SELECT * FROM `ledger` WHERE `month` = '$month' AND `year` = '$year'";
$result     = dbQuery($dbConn, $sql);
?>
<?php include(THEME_PATH . '/tb_link.php');?>
<!-- Content Header (Page header) -->
<section class="content-header top_heading">
    <h1>Trail Balance</h1>
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid container_block">
        <div class="space"></div>
        <?php if(modPerAdd($dbConn,"23")){?>
            <div class="row">
                <div class="col-md-12">
<!--                    <button type="button" name="btnButton" data-toggle="modal" data-target="#recordTrans"  class="btn btn-danger pull-left" style="margin-left: 5px;">Record Transaction</button>-->
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
                        <th>Account Title</th>
                        <th>Dr Amount</th>
                        <th>Cr Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(dbNumRows($result) > 0) {
                        $list = accountRP($dbConn);
                        $i = 0;
                        $totalDr = 0;
                        $totalCr = 0;

                        while ($row = dbFetchAssoc($result)) {
                            if (!in_array($row['account_title'], $list)) {
                            extract($row);
                            ?>
                            <tr>
                                <td><?= ++$i; ?></td>
                                <td><?= getAccountName($dbConn, $account_title) ?></td>
                                <?php if ($nature == "Dr") {
                                    ?>
                                    <td><?= $amount ?></td>
                                    <td></td>
                                    <?php
                                    $totalDr += $amount;
                                } else {
                                    ?>
                                    <td></td>
                                    <td><?= $amount ?></td>
                                    <?php
                                    $totalCr += $amount;
                                }
                                ?>

                            </tr>
                            <?php
                        }
                    }
                        ?>
                        <tr>
                            <td colspan="2" class="text-center">Total</td>
                            <td><?=$totalDr?></td>
                            <td><?=$totalCr?></td>
                        </tr>
                    <?php
                    }else{
                        echo " No Record Found";
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
                <a href="acountProcess.php?action=printPdfT&m=<?=$month?>&Y=<?=$year?>" class="btn btn-danger pull-right" style="margin-left: 5px; color: #ffffff;">PDF</a>
            </div>
        </div>
    </div>

</section><!-- /.content -->