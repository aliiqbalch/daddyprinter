<?php
if (!defined('WEB_ROOT')) {
    exit;
}

if (isset($_GET['orderId']) && $_GET['orderId'] > 0) {
    $orderId = $_GET['orderId'];
}else {
    // redirect to index.php if user id is not present
    redirect('index.php');
}
$sql		=	"SELECT * FROM `order` WHERE order_id = $orderId";
$result     = dbQuery($dbConn,$sql);
$row = dbFetchAssoc($result);
@extract($row);

?>
<?php include(THEME_PATH . '/tb_link.php');?>
<!-- Content Header (Page header) -->
<section class="content-header top_heading">
    <h1>Orders / Order Detail</h1>
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
        <form action="#" method="post">
            <div class="row">
                <div class="space-lg"></div>
                <div class="col-sm-12">
                    <table class="table table-bordered table-striped tbl-respon2s">
                        <thead>
                        <tr>
                            <th>Item #</th>
                            <th>Description</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th style="width: 100px;">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        $sql1 = "SELECT * FROM order_detail WHERE order_id= $order_id";
                        $result1 = dbQuery($dbConn,$sql1);
                        //                var_dump($result1);
                        //                die($sql1);
                        if (dbNumRows($result1) > 0){
                            $i = 1;
                            $total1 = 0;
                            $discount = getDiscount($dbConn,$orderId);
                            while($row1 = dbFetchAssoc($result1)) {
                                extract($row1);
                                ?>
                                <tr>
                                    <td><?=$i++?></td>
                                    <td><?=productName($dbConn,$product_id)?></td>
                                    <td>size</td>
                                    <td><?=$qty?></td>
                                    <td><?=getunitPrice($qty,$retail_price)?></td>
                                    <td><?=$retail_price?></td>
                                </tr>
                                <?php

                                $discount += getDetDiscount($dbConn,$order_detail_id);
                                $sql2 = "SELECT * FROM job_order WHERE order_detail_id = $order_detail_id";
                                $result2 = dbQuery($dbConn,$sql2);
                                $job_total = 0;
                                if(dbNumRows($result2) > 0 ){
                                    ?>
                                    <tr>
                                        <td colspan="6"> Job Orders</td>
                                    </tr>
                                    <?php
                                    $j = 0;
                                    while($row2 = dbFetchAssoc($result2)){
                                        $j++;
                                        extract($row2);
                                        $job_total+= $row2['total'];
                                        ?>
                                        <tr>
                                            <td><?=$j?></td>
                                            <td><?=$job_name?></td>
                                            <td><?=$width?> x <?=$height?></td>
                                            <td><?=$qty?></td>
                                            <td><?=$unit_price?></td>
                                            <td> (<?=$row2['total']?>)</td>
                                        </tr>
                                        <?php
                                    }
                                }
                                $job_total = $retail_price - $job_total;
                                $total1 += $job_total;
                                ?>
                                <tr>
                                    <td colspan="4"></td>
                                    <td>Gross Profit</td>
                                    <td><?=$job_total?></td>
                                </tr>
                                <?php

                            }
                            if(!empty(getTax($dbConn,$orderId)) || getTax($dbConn,$orderId) > 0){
                            ?>
                            <tr>
                                <td colspan="4"></td>
                                <td>Tax</td>
                                <td><?=getTax($dbConn,$orderId)?></td>
                            </tr>
                                <?php } if(!empty($discount) || $discount > 0){?>
                            <tr class="printHide">
                                <td colspan="4"></td>
                                <td>Discount</td>
                                <td><?php echo isset($discount) ? $discount:"None";?></td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="4"></td>
                                <td>Gross Profit</td>
                                <td><?php
                                    $total1 = $total1 - $discount;
                                    $total1 = $total1 + getTax($dbConn,$orderId);
                                    echo $total1;
                                    ?></td>
                            </tr>
                            <?php
                        }

                        ?>
                        <tr>
                            <td colspan="6">
                                <a href="index.php">Back</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</section>