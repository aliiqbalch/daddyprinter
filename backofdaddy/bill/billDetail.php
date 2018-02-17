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
    <h1>Bill / Detail</h1>
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
        <form action="processBill.php?action=bill" method="post">
            <div class="row">
                <div class="col-sm-4 col-xs-12">
                    <div style="display: inline-block;vertical-align:middle;width:40%;">
                        <h4>Client ID</h4>
                    </div>
                    <div style="display: inline-block;vertical-align: middle;width: 50%;">
                        <?=clientCampnyNameByID($dbConn,$client_id)?>
                    </div>
                </div>
                <div class="col-sm-4 col-xs-12 col-sm-offset-4">
                    <div style="display: inline-block;vertical-align:middle;width:40%;">
                        <h4>Bill No</h4>
                    </div>
                    <div style="display: inline-block;vertical-align: middle;width:50%;">
                        <?php
                        if(@$_GET['bid']){
                            echo $_GET['bid'];
                        }else{
                            if(lastBillId($dbConn)) {
                                $bill = 1 + lastBillId($dbConn);
                                echo $bill;
                            }else{
                                $bill = 1001;
                                echo $bill;
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-xs-12">
                    <div style="display: inline-block;vertical-align:middle;width: 40%;">
                        <h4> Payment Method</h4>
                    </div>
                    <div style="display: inline-block;vertical-align: middle;width:50%;">
                        <?php
                            if(@$_GET['bid']){
                               echo strtoupper(paymentMethod($dbConn,$_GET['bid']));
                            }else{
                        ?>
                        <select name="paymentMethod"class="input-sm">
                            <option value="cash">Cash</option>
                            <option value="cheque">Cheque</option>
                            <option value="cash on delivery">Cash on Delivery</option>
                            <option value="Online Payment Method">Online Payment Method</option>
                        </select>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-sm-4 col-xs-12 col-sm-offset-4">
                    <div style="display: inline-block;vertical-align:middle; width: 40%;">
                        <h4>Date</h4>
                    </div>
                    <div style="display: inline-block;vertical-align: middle;width: 50%;">
                        <?=date("d-M-Y")?>
                    </div>
                    <br>
                    <div style="display: inline-block;vertical-align:middle; width: 40%;">
                        <h4>Address</h4>
                    </div>
                    <div style="display: inline-block;vertical-align: middle; width: 50%;">
                        <?=clientCampnyAddress($dbConn,$client_id)?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="space-lg"></div>
                <div class="col-sm-12">
                    <div class="table-responsive tbl-respon">
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
                                    <td><?php
                                        if(productCatId($dbConn,$product_id) == 3){
                                            echo $width ." x ". $height;
                                        }else{
                                            echo "Std";
                                        }
                                        ?></td>
                                    <td><?=$qty?></td>
                                    <td><?=getunitPrice($qty,$retail_price)?></td>
                                    <td><?=$retail_price?></td>
                                </tr>
                                <?php
                                $total += $retail_price;
                                $discount += getDetDiscount($dbConn,$order_detail_id);
                                if(productCatId($dbConn,$product_id) != 3) {
                                    $sql2 = "SELECT * FROM order_variation WHERE order_detail_id = $order_detail_id";
                                    $result2 = dbQuery($dbConn, $sql2);
                                    if (dbNumRows($result2) > 0) {
                                        while ($row2 = dbFetchAssoc($result2)) {
                                            extract($row2);
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td><?= variationtitle($dbConn, $variation_id); ?></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <?php
                                        }
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
                                <td><?php
                                    $tax = 0;
                                    if(getTax($dbConn,$orderId)){
                                    $tax = getTax($dbConn,$orderId);
                                    $tax = $total * $tax;
                                    $tax = $tax / 100;
                                    echo $tax;
                                    }else{
                                        echo "None";
                                    }
                                    ?></td>
                            </tr>
                            <tr class="printHide">
                                <td colspan="4"></td>
                                <td>Discount Voucher</td>
                                <td>None</td>
                            </tr>
                            <?php  if($discount){ ?>
                            <tr class="printHide">
                                <td colspan="4"></td>
                                <td>Discount</td>
                                <td><?php echo $discount;?></td>
                            </tr>
                            <?php } if($advance){ ?>
                            <tr class="printHide">
                                <td colspan="4"></td>
                                <td>Advance</td>
                                <td><?php echo $advance; ?></td>
                            </tr>
                                <?php } ?>
                            <tr>
                                <td colspan="4"></td>
                                <td>TOTAL</td>
                                <td><?php
                                    $total = $total - $discount;
                                    $total = $total + $tax;
                                    $total = $total - $advance;
                                    echo $total;
                                    ?>
                                    <input type="hidden" name="orderId" value="<?=$orderId?>">
                                    <input type="hidden" name="total" value="<?=$total?>">
                                </td>
                            </tr>
                            <?php
                        }

                        ?>
                        <tr>
                            <td colspan="6">
                                <a href="index.php">Back</a>
                                <input type="submit" name="print" class="btn btn-danger pull-right" style="margin-right: 5px;" value="PDF">
                                <?php if(@!$_GET['bid']){?>
                                <input type="submit" name="save" class="btn btn-danger pull-right" style="margin-right: 5px;" value="Save">
                                <a href="index.php" class="btn btn-danger pull-right" style="margin-right: 5px; color: #ffffff;">Cancel</a>
                                <?php }?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>