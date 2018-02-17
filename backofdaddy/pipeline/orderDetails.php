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
    <h1>Pipeline / Pipeline Detail</h1>
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
                <div style="text-align: center;" class="col-sm-12">
                    <h1>Pipeline Detail</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div style="display: inline-block;vertical-align:middle;width:40%;">
                        <h4>Client ID</h4>
                    </div>
                    <div style="display: inline-block;vertical-align: middle;width: 50%;">
                        <?=clientCampnyNameByID($dbConn,$client_id)?>
                    </div>
                </div>
                <div class="col-sm-4 col-sm-offset-4">
                    <div style="display: inline-block;vertical-align:middle;width:40%;">
                        <h4> Pipeline No</h4>
                    </div>
                    <div style="display: inline-block;vertical-align: middle;width:50%;">
                        <?=$order_id?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div style="display: inline-block;vertical-align:middle;width: 40%;">
                        <h4>Contact Information</h4>
                    </div>
                    <div style="display: inline-block;vertical-align: middle;width:50%;">
                        <?=clientName($dbConn,$client_id)?> / <?=clienNumber($dbConn,$client_id)?>
                    </div>
                </div>
                <div class="col-sm-4 col-sm-offset-4">
                    <div style="display: inline-block;vertical-align:middle; width: 40%;">
                        <h4>Order Time</h4>
                    </div>
                    <div style="display: inline-block;vertical-align: middle;width: 50%;">
                        <?=$order_time?>
                    </div>
                    <div style="display: inline-block;vertical-align:middle; width: 40%;">
                        <h4>Delivery Time</h4>
                    </div>
                    <div style="display: inline-block;vertical-align: middle;width: 50%;">
                        <?=$order_delivery_time?>
                    </div>
                    <div style="display: inline-block;vertical-align:middle; width: 40%;">
                        <h4>Address</h4>
                    </div>
                    <div style="display: inline-block;vertical-align: middle; width: 50%;">
                        <?=clientCampnyAddress($dbConn,$client_id)?>
                    </div>
                    <div style="display: inline-block;vertical-align:middle; width: 40%;">
                        <h4>Status</h4>
                    </div>
                    <div style="display: inline-block;vertical-align: middle; width: 50%;">
                        <?php
                        if($status_id == 101){
                            echo "Quotation";
                        }else if($status_id == 102){
                            echo "Pipeline";
                        }elseif($status_id == 103){
                            echo "Delivered";
                        }
                        ?>
                    </div>
                </div>
            </div>
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
                            $total = 0;
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
                                $total += $retail_price;
                                $discount += getDetDiscount($dbConn,$order_detail_id);
                                $sql2 = "SELECT * FROM order_variation WHERE order_detail_id = $order_detail_id";
                                $result2 = dbQuery($dbConn,$sql2);
                                if(dbNumRows($result2) > 0 ){
                                    while($row2 = dbFetchAssoc($result2)){
                                        extract($row2);
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td><?=variationtitle($dbConn, $variation_id);?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                            ?>
                            <tr>
                                <td colspan="5"></td>
                                <td><?=$total?></td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td>Tax</td>
                                <td><?=getTax($dbConn,$orderId)?></td>
                            </tr>
                            <tr class="printHide">
                                <td colspan="4"></td>
                                <td>Discount Voucher</td>
                                <td></td>
                            </tr>
                            <tr class="printHide">
                                <td colspan="4"></td>
                                <td>Discount</td>
                                <td><?php echo isset($discount) ? $discount:"None";?></td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td>TOTAL</td>
                                <td><?php
                                    $total = $total - $discount;
                                    $total = $total + getTax($dbConn,$orderId);
                                    echo $total;
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