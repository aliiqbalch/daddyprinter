<?php
if (!defined('WEB_ROOT')) {
    exit;
}
$rowsPerPage = 10;
$sql		=	"SELECT * FROM `bill` WHERE status = 1";

$result     = dbQuery($dbConn, getPagingQuery($sql, $rowsPerPage));
$pagingLink = getPagingLink($dbConn, $sql, $rowsPerPage);
?>
<?php include(THEME_PATH . '/tb_link.php');?>
<!-- Content Header (Page header) -->
<section class="content-header top_heading">
    <h1>Bill</h1>
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid container_block">
        <div>
            <?php
            if(isset($_SESSION['errorMessage']) && isset($_SESSION['count'])){
                if($_SESSION['count'] <= 1){
                    $_SESSION['count'] +=1; ?>
                    <div class="space"></div>
                    <p class="alert alert-success"><?php echo $_SESSION['errorMessage'];  ?></p> <?php
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
                        <th>Bill No</th>
                        <th>Order No</th>
                        <th>Compnay Name </th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Action</th>
                        <!--								<th>Status</th>-->
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (dbNumRows($result) > 0){
                        $i = 1;
                        while($row = dbFetchAssoc($result)) {
                            extract($row);
//									var_dump($row);
//									die("SSs");
                            ?>
                            <tr>
                            <td><?php echo $i++;?></td>
                            <td><?=$bill_id?></td>
                            <td><?=$order_id?></td>
                            <td><?=clientCampnyNameByID($dbConn, clientIdFromOrder($dbConn,$order_id)); ?></td>
                            <td><?=$date?></td>
                            <td><?=$total?></td>
                            <td>
<!--                                <a href="processBill.php?action=incat&billId=--><?//=$bill_id?><!--" class="btn" title="Clear">--</a>-->
                                <a href="javascript:detail(<?php echo $order_id; ?>,<?=$bill_id?>)"><i class="fa fa-file-text" title="Bill Detail"></i></a>&nbsp;
                            </tr><?php
                        }
                    }else { ?>
                        <tr>
                            <td height="20">No Bill</td>
                        </tr>
                        <?php
                    } //end while ?>
                    <tr height="20">
                        <td align="center" colspan="9" class="pagingStyle"><?php echo $pagingLink;?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--- End Table ---------------->
    </div>
</section><!-- /.content -->
