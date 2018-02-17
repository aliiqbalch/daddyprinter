<?php
if (!defined('WEB_ROOT')) {
    exit;
}

if(isset($_GET['detId'])){
    $id = $_GET['detId'];
}
if(isset($_GET['jobId'])){
    $jobid = $_GET['jobId'];
    $sql3 = "SELECT * FROM `job_order` WHERE `Job_id` = $jobid";
    $result3 = dbQuery($dbConn,$sql3);
    $row3 = dbFetchAssoc($result3);
    extract($row3);
}
$sql = "SELECT * FROM `order_detail` WHERE `order_detail_id` = $id";
$result = dbQuery($dbConn,$sql);
$row = dbFetchAssoc($result);
extract($row);
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Job Order</h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid container_block">
        <form action="processOrder.php?action=process" method="post">
        <div id="printQuation">
                <form action="index.php?view=list" method="post">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <img style="width: 100%;height: 100%;" src="<?=WEB_ROOT?>assets/images/logo/logoPrint.png" alt="Daddy Printers" title="Daddy Printers">
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div style="margin-top: 70px;"></div>
                            <h1 class="text-right text-bold" id="colorF58634">Job Order</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="space-lg"></div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="col-sm-12 col-xs-12">
                                <div class="clearfix">
                                    <div class="pull-left col-sm-6 col-xs-12 text-bold">
                                        Vendor Name
                                    </div>
                                    <div class="pull-right text-left col-sm-6 col-xs-12 text-bold">
                                        <?php if(@$_GET['jobId']){
                                           $objvendor = getVenderById($dbConn,$vendor_id);
                                            echo $objvendor['ven_cmp_name'];
                                        }else{ ?>
                                        <select name="vendorName" id="vendorName" class="input-sm" required >
                                            <option value="0">Select vendor</option>
                                            <?php
                                                foreach(getVender($dbConn) as $key => $value ){
                                                    ?>
                                                    <option value="<?=$key?>"><?=$value?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="clearfix">
                                    <div class="pull-left col-sm-6 col-xs-12 text-bold">
                                        Date
                                    </div>
                                    <div class="pull-right text-left col-sm-6 col-xs-12 text-bold">
                                        <?php if(@$_GET['jobId']){
                                            echo $date;
                                        }else{ ?>
                                       <?=date("d-M-Y")?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="col-sm-12 col-xs-12">
                                <div class="clearfix">
                                    <div class="pull-left col-sm-6 col-xs-12 text-bold">
                                        <?=categoryName($dbConn,productCatId($dbConn,$product_id));?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="space-lg"></div>
                        <div class="col-sm-12">
                            <div class="table-responsive tbl-respon">
                                <table class="table table-bordered table-striped tbl-respon2s">
                                <thead>
                                <tr class="bgF58634" >
                                    <th id="bgF586341">Item #</th>
                                    <th id="bgF586342">Description</th>
                                    <th id="bgF586343">Size</th>
                                    <th id="bgF586344">Quantity</th>
                                    <th id="bgF586345">Unit Price</th>
                                    <th id="bgF586346">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr class="colorwhite">
                                        <td class="colorwhite">1</td>
                                        <td class="colorwhite">
                                            <?php if(@$_GET['jobId']){
                                                echo productName($dbConn,$product_id);
                                            }else{ ?>
                                            <input type="text" name="job_name" class="input-sm" value="<?=productName($dbConn,$product_id)?>" required>
                                            <?php }?>
                                        </td>
                                        <td class="colorwhite">
                                            <?php
                                            if(@$_GET['jobId']){
                                                echo $row3['width'] ." x ". $row3['height'];
                                            }else {
                                                if (productCatId($dbConn, $product_id) == 3) {
                                                    ?>
                                                    <input type="text" class="input-sm" style="width:50px;" name="width" placeholder="width"
                                                           value="<?= $width ?>" required >
                                                    <input type="text" class="input-sm" style="width:50px;" name="height"
                                                           placeholder="height" value="<?= $height ?>" required>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <input type="text" class="input-sm" style="width:50px;" name="width" placeholder="width"
                                                           value="<?= $width ?>" required>
                                                    <input type="text" class="input-sm" style="width:50px;" name="height"
                                                           placeholder="height" value="<?= $height ?>" required>
                                                <?php }
                                            }

                                            ?>
                                        </td>
                                        <td class="colorwhite" id="qty">
                                            <?php  if(@$_GET['jobId']){
                                                echo $row3['qty'];
                                            }else{?>
                                            <input type="text" class="input-sm" id="Qty" name="qty" value="<?=$qty?>" required ></td>
                                        <?php }?>
                                        <td class="colorwhite"><?php
                                            if(@$_GET['jobId']){
                                                echo $row3['unit_price'];
                                            }else{
                                            if(productCatId($dbConn,$product_id) == 3){
                                            $sqf = $width * $height;
                                            $up = $cost_price / $sqf;
                                            echo "<input type='text' name='unitPrice' id='unitPrice' class='input-sm'  value='$up' required >";}
                                            else{
                                                ?>
                                                <input type='text' name='unitPrice' id='unitPrice' class="input-sm"  value='<?=getunitPrice($qty,$cost_price);?>' required>
                                                <?php
                                            }
                                            }
                                            ?></td>
                                        <td class="colorwhite">
                                            <?php if(@$_GET['jobId']){echo $total;}else{?>
                                            <input type="text" class="input-sm" id="price" name="price" value="<?=$cost_price?>" readonly></td>
                                        <?php }?>
                                    </tr>
                                    <?php
                                        if(productCatId($dbConn,$product_id) != 3){
                                            $sql1 = "SELECT * FROM `order_variation` WHERE `order_detail_id` = $order_detail_id";
                                            $result1 = dbQuery($dbConn,$sql1);
                                            if(dbNumRows($result1) > 0){
                                                ?>
                                                <tr>
                                                    <td></td>
                                                    <td colspan="5">
                                    <?php
                                                while($row1 = dbFetchAssoc($result1)){
                                                    extract($row1);
                                                    variationtitle($dbConn, $variation_id);
                                                    echo" , ";
                                                }
                                                ?>
                                                    </td>
                                                </tr>
                                    <?php
                                            }
                                        }
                                    ?>
                                    <tr>
                                        <td></td>
                                        <td colspan="5">
                                            <?php if(@$_GET['jobId']){echo $row3['note']; }else{?><textarea name="note" class="input-sm" rows="1" style="width:100%;" placeholder="Note"></textarea><?php }?></td>
                                    </tr>
                                <tr>
                                    <td colspan="5" class="text-center colorgry" id="colorgry2">TOTAL</td>
                                    <td class="colorwhite" id="divSubTotal"><?php if(@$_GET['jobId']){echo$total;}else{echo $cost_price; }?></td>
                                    <input type="hidden" name="subTotal" id="subTotal" value="">
                                </tr>
                                <tr>
                                    <?php if(@!$_GET['jobId']) {?>
                                    <td colspan="6" id="printHide" class="colorwhite">
                                        <input type="hidden" name="orderDetailId" value="<?=$order_detail_id?>">
                                        <input type="submit" name="print" class="btn btn-danger pull-right" style="margin-right:5px " value="PDF">
                                        <input type="submit" name="order" class="btn btn-danger pull-right" style="margin-right:5px " value="Save">
                                        <a href="#" class="btn btn-danger pull-right" style="margin-right:5px;color: #FFFFFF;">Cancel </a>
                                    </td>
                                    <?php }?>
                                </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </form>
        <div class="space-lg"></div>
    </div>
</section>
<script>
    $(document).ready(function(){
       $("#unitPrice").change(function(){
           <?php if(productCatId($dbConn,$product_id) != 3){?>
          var total =  $(this).val() * $("#Qty").val();
           $("#divSubTotal").html(total);
           $("#price").val(total);
           $("#subTotal").val(total);
           <?php }else{ ?>
           var width,height;
           width = <?=$width?>;
           height = <?=$height?>;
          var total = width * height;
           total =  $(this).val() * total;
           $("#divSubTotal").html(total);
           $("#price").val(total);
           $("#subTotal").val(total);
           <?php
            } ?>
       });


    });
</script>