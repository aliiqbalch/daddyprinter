<?php
if (!defined('WEB_ROOT')) {
    exit;
}
$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
if (isset($_GET['orderDetId']) && $_GET['orderDetId'] > 0) {
    $orderDetId = $_GET['orderDetId'];
    $pid = ['pid'];
}else {
    // redirect to index.php if user id is not present
    redirect('index.php');
}

$sql		=	"SELECT * FROM order_detail WHERE order_detail_id = '$orderDetId'";
$result     = dbQuery($dbConn, $sql);
//var_dump($result);
//die("SSSs");
?>
<?php include(THEME_PATH . '/tb_link.php');?>
<!-- Content Header (Page header) -->
<section class="content-header top_heading">
    <h1>Modify / Order Details</h1>
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
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Base Price</th>
                        <th>Cost Price</th>
                        <th>Whole Sale</th>
                        <th>Retail Price</th>
                        <th>Discount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (dbNumRows($result) > 0){
                        $i = 1;
                        $row = dbFetchAssoc($result);
                            extract($row);
//									var_dump($row);
//									die("SSs");
                            ?>
                        <form action="processOrder.php?action=modifyDetail&odid=<?=$orderDetId?>" method="post">
                            <tr>
                            <td><?php echo $i++;?></td>
                            <td><?=productName($dbConn,$product_id)?></td>
                            <td><?=$qty ?></td>
                            <td><?=$base_price?></td>
                            <td><?=$cost_price?></td>
                            <td><?=$whole_sale_price?></td>
                            <td><?=$retail_price ?></td>
                            <td>
                               <input type="text" id="disId" name="disVal" class="input-sm" style="width: 50px" value="<?=getDetDiscount($dbConn,$orderDetId)?>">
                               <input type="hidden" name="disId" class="input-sm" style="width: 50px" placeholder="discount" value="<?=getDetDiscountId($dbConn,$orderDetId)?>">

                            </td>
                            <td>
                                <select name="statusId" id="txtDepId" class="formField">
                                    <option value="101">Pending</option>
                                    <option value="102">Process</option>
                                </select>
                            </td>
                            <td>
                                <input type="submit" class="butn" value="Save">
                            </td>
                            </tr>
                        </form>
                        <?php
                    }else { ?>
                        <tr>
                            <td height="20">No Quotation Added Yet</td>
                        </tr>
                        <?php
                    } //end while ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!--- End Table ---------------->
    </div>
    <div class="row">
        <div class="col-md-offset-5 col-xs-offset-3 col-sm-offset-5">
            <input type="button" name="btnCanlce" value="Back" class="butn" onclick="window.location.href='index.php'"/>
        </div>
    </div>
</section><!-- /.content -->
