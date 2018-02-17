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
    <h1>Quotation / Quotation Detail</h1>
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
                        <th>Q No</th>
                        <th>Compnay Name</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?=$order_id?></td>
                        <td><?=clientCampnyNameByID($dbConn,$client_id)?></td>
                        <td><?=clientName($dbConn,$client_id)?></td>
                        <td><?=clienNumber($dbConn,$client_id)?></td>
                        <td><?=clienEmail($dbConn,$client_id)?></td>
                        <td><?=clientCampnyAddress($dbConn,$client_id)?></td>
                        <td><?=$order_time?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row bord-right-space" >
            <div class="table-responsive tbl-respon">
                <table class="table table-bordered tbl-respon2">
                    <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Description</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                        <th>Action</th>
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
                                <form action="processOrder.php?action=modifyDetail" method="post">
                                    <input type="hidden" name="orderDetailId" value="<?=$order_detail_id?>">
                                    <td><?=$i++?></td>
                                    <td><?=productName($dbConn,$product_id)?></td>
                                    <td>size</td>
                                    <td><input type="text" name="qty" value="<?=$qty?>" readonly></td>
                                    <td><input type="text" class="input-sm" name="unitPrice" value="<?=getunitPrice($qty,$retail_price)?>"></td>
                                    <td><?=$retail_price?></td>
                                    <td><button type="submit" title="Update"><i class="fa fa-upload"></i></button><a href="processOrder.php?action=deleteDetail&oDId=<?=$order_detail_id?>" title="Remove"> <i class="fa fa-trash"></i></a> </td>
                                </form>
                            </tr>
                            <?php
                            $total += $retail_price;
                            $discount += getDetDiscount($dbConn,$order_detail_id);
                            $sql2 = "SELECT * FROM order_variation WHERE order_detail_id = $order_detail_id";
                            $result2 = dbQuery($dbConn,$sql2);
                            if(dbNumRows($result2) > 0 ){
                                ?>
                                <tr>
                                    <td></td>
                                    <td colspan="6">
                                        <?php
                                        while($row2 = dbFetchAssoc($result2)) {
                                            extract($row2);
                                            variationtitle($dbConn, $variation_id);echo",";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        <tr>
                            <td colspan="5"></td>
                            <td><?=$total?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td>Tax</td>
                            <td><?=getTax($dbConn,$orderId)?></td>
                            <td></td>
                        </tr>
                        <tr class="printHide">
                            <td colspan="4"></td>
                            <td>Discount Voucher</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="printHide">
                            <td colspan="4"></td>
                            <td>Discount</td>
                            <td><?php echo isset($discount) ? $discount:"None";?></td>
                            <td></td>
                        </tr>
                        <tr class="printHide">
                            <td colspan="4"></td>
                            <td>Advance</td>
                            <td><input type="text" name="advance" value="" class="input-sm"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td>TOTAL</td>
                            <td><?php
                                $total = $total - $discount;
                                $total = $total + getTax($dbConn,$orderId);
                                echo $total;
                                ?></td>
                            <td></td>
                        </tr>
                        <?php
                    }

                    ?>
                    <tr>
                        <td colspan="7">
                            <a href="index.php">Back</a>
                            <input type="submit" name="update" value="Save" class="butn pull-right">
                            <input type="submit" name="print" value="PDF" style="margin-right:5px;" class="butn pull-right">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>