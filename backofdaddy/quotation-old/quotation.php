<?php
if (!defined('WEB_ROOT')) {
    exit;
}
require_once"cart.php";
require_once"../library/functions.php";
?>
<script>
    $(document).ready(function(){
        $("#printThis").click(function(){
            if($("#discount").val() == 0) {
                $(".printHide").css("display","none");
            }
            $("#printQuation").printThis({
                loadCSS: "http://localhost/daddyprinters/backofdaddy/template/xpert/dist/css/print.css",  // path to additional css file - use an array [] for multiple
            });

            $(".printHide").delay("slow").show(10000);
        });
    });

    $(document).ready(function() {
        $('#companyName').change(function () {
            var companyID = $(this).val();
            $.ajax({
                type:"POST",
                url:"customerDetail.php",
                data: 'companyID='+companyID ,
                success: function (html) {
                    $('#customerDetail').html(html);
                }
            });
            return false;
        });

        $("#orderStatus").change(function(){
            var txtDesign = document.getElementById('orderStatus').value;
            console.log(txtDesign);
            if(parseInt(txtDesign) == 101){
                $("#department").hide();
            }else{
                $("#department").show();
            }
        });


    });

</script>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Quotation</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Quotation</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid container_block">
        <?php
        if(isset($_SESSION['objItems'])) {
            $objItems = unserialize($_SESSION['objItems']);
        }else{
            $objItems = new Cart();
        }
        if($objItems->items) {
            if(isset($_SESSION['orderId'])){
                $orderId = $_SESSION['orderId'];
                $sqlSelect = "SELECT * FROM `order` WHERE `order_id` = '$orderId'";
                $result = dbQuery($dbConn,$sqlSelect);
                $row = dbFetchAssoc($result);
                extract($row);
        ?>
        <div id="printQuation">
            <form action="order.php" method="post">
                <div class="row">
                    <div class="col-sm-6 hidden-sm hidden-lg hidden-md col-xs-12">
                        <img class="responsive" style="width: 100%;height: 100%;" src="<?=WEB_ROOT?>assets/images/logo/logoPrint.png" alt="Daddy Printers" title="Daddy Printers">
                    </div>
                    <div class="col-sm-6">
                        <h1 class="colorF58634 text-bold" id="colorF58634">Quotation</h1>
                        <div class="clearfix">
                            <div class="pull-left col-sm-4 col-xs-12 text-bold">
                                Quotation Date
                            </div>
                            <div class="pull-right text-left col-sm-8 col-xs-12 text-bold">
                                <?=$order_time?>
                            </div>
                        </div>
                        <div class="clearfix">
                            <div class="pull-left col-sm-4 col-xs-12 text-bold">
                                Customer ID
                            </div>
                            <div class="pull-right text-left col-sm-8 col-xs-12 text-bold">
                                <?php clientCampnyNameByID($dbConn,$client_id)?>
                            </div>
                        </div>
                        <div class="clearfix">
                            <div class="pull-left col-sm-4 col-xs-12 text-bold">
                                Quotation Ref
                            </div>
                            <div class="pull-right text-left col-sm-8 col-xs-12 text-bold">
                                <?=$order_id?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 hidden-xs col-xs-12">
                        <img class="responsive" style="width: 100%;height: 100%;" src="<?=WEB_ROOT?>assets/images/logo/logoPrint.png" alt="Daddy Printers" title="Daddy Printers">
                    </div>
                </div>
                <div class="row">
                    <div class="space-lg"></div>
                    <div class="col-xs-12">
                        <div class="text-left bgF58634 ">
                            <h4 class="text-bold bgF58634">For the Attention of </h4>
                        </div>
                        <div id="customerDetail">
                            <div class="text-center text-bold">
                                <?=clientName($dbConn,$client_id)?>
                            </div>
                            <div class="text-center">
                                <?=clienNumber($dbConn,$client_id)?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="col-xs-12">
                            <div class="clearfix">
                                <div class="col-xs-12 text-bold">
                                    Sales Agent
                                </div>
                                <div class="col-xs-12 text-bold">
                                    <?=getUserNameById($dbConn,$user_id)?>
                                </div>
                            </div>
                            <div class="clearfix">
                                <div class="col-xs-12 text-bold">
                                    Quotation Validity
                                </div>
                                <div class="col-xs-12 text-bold">
                                    7 Days
                                </div>
                            </div>
                            <div class="clearfix">
                                <div class="col-xs-12 text-bold">
                                    Delivery Time
                                </div>
                                <div class="col-xs-12 text-bold">
                                    <?=$order_delivery_time?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="space-lg"></div>
                    <div class="col-sm-12 col-xs-12">
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

                            <?php
                            $i = 0;
                            foreach($objItems->items as $item){

                                ?>
                                <tr class="colorwhite">
                                    <td class="colorwhite text-bold"><?=++$i?></td>
                                    <td class="colorwhite text-bold"><?=productName($dbConn,$item->productID)?></td>
                                    <?php
                                    if($item->catID == 3){
                                        ?>
                                        <td class="colorwhite"> <?=$item->width?> x <?=$item->length?></td>
                                        <?php
                                    }else{
                                        ?>
                                        <td class="colorwhite">Std</td>
                                        <?php
                                    }
                                    ?>
                                    <td class="colorwhite"><?= $item->qty?></td>
                                    <td class="colorwhite"><?=$item->unitPrice?></td>
                                    <td class="colorwhite"><?=$item->total?></td>
                                </tr>
                                <?php
                                $j = 0;
                                foreach($item->itemsValue as $itemId){
                                    @extract($itemId);
                                    ?>
                                    <tr>
                                        <td class="colorwhite"></td>
                                        <td class="colorwhite"><?=variationtitle($dbConn, $variationid);?></td>
                                        <td class="colorwhite"></td>
                                        <td class="colorwhite"></td>
                                        <td class="colorwhite"></td>
                                        <td class="colorwhite"></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>

                            <tr>
                                <td class="colorgry" id="colorgry1" colspan="5"></td>
                                <td class="colorwhite"><?=$objItems->total?></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-center colorgry" id="colorgry2">TOTAL</td>
                                <td class="colorwhite" id="divSubTotal"><?=$objItems->total?></td>
                            </tr>
                            <tr class="printHide">
                                <td colspan="4" class="text-center"></td>
                                <td class="colorwhite" id="divSubTotal">
                                    <select name="orderStatus" id="orderStatus" style="width:100%" class="input-lg">
                                        <option value="101">Quotation</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" id="printHide" class="colorwhite">
                                    <input type="submit" name="orderUpdate" class="btn btn-danger pull-right" style="margin-right:5px " value="Save">
                                    <a href="processcart.php?action=empty_cart" class="btn btn-danger pull-right" style="margin-right:5px;color: #FFFFFF;">Cancel </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
                <div class="row">
            </form>
            <div class="col-sm-12">
                <div id="colorBlue" class="text-center text-bold colorBlue colorWht">Terms & Conditions</div>
                <div class="text-center">1. Customer will be billed after indicating acceptance of this quote</div>
                <div class="text-center">2. 75% Advance payment will be due at the time of placing order</div>
                <div colspan="6" class="text-center">3. Incase of Different tax method please revise the qoutation ( Rate ) from the base price</div>
                <div colspan="6" class="text-center">4. Cheque furnished , will be made in favour of " Daddy Printers "</div>
            </div>
            <div class="col-sm-12 text-center">
                <h3>Thank you for your business!</h3>
                <div>Should you have any queries regarding this quotation, please contact us at.</div>
                <div class="space-md"></div>
                <div class="text-bold borderBottom">G-2 , First Floor , Main Commerical Area , Phase 1 , Dha , Lahore</div>
                <div class="row text-bold text-center">
                    <div class="col-sm-4">0092-321-8460888 /0323-8412223</div>
                    <div class="col-sm-4">info@daddyprinters.com </div>
                    <div class="col-sm-4">www.daddyprinters.com</div>
                </div>
            </div>
        </div>
        <?php } else{
                ?>
        <div id="printQuation">
                    <form action="order.php" method="post">
                        <div class="row">
                            <div class="hidden-md hidden-lg hidden-sm col-xs-12">
                                <img class="responsive" style="width:100%;height:100%;" src="<?=WEB_ROOT?>assets/images/logo/logoPrint.png" alt="Daddy Printers" title="Daddy Printers">
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <h1 class="colorF58634 text-bold" id="colorF58634">Quotation</h1>
                                <div class="clearfix">
                                    <div class="pull-left col-sm-4 text-bold">
                                        Quotation Date
                                    </div>
                                    <div class="pull-right text-left col-sm-8 text-bold">
                                        <?=date("d-M-Y")?>
                                    </div>
                                </div>
                                <div class="clearfix">
                                    <div class="pull-left col-sm-4 text-bold">
                                        Customer ID
                                    </div>
                                    <div class="pull-right text-left col-sm-8 text-bold">
                                        <select id="companyName" class="input-sm" name="companyName" required >
                                            <option value="0">Select Customer</option>
                                            <?=clientCampnyName($dbConn)?>
                                        </select>
                                        <button type="button" data-toggle="modal" data-target="#clientAdd">+</button>
                                    </div>
                                </div>
                                <div class="clearfix">
                                    <div class="pull-left col-sm-4 text-bold">
                                        Quotation Ref
                                    </div>
                                    <div class="pull-right text-left col-sm-8 text-bold">
                                        <?php if(orderNo($dbConn)){ echo orderNo($dbConn); }else{ echo "1001";};?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 hidden-xs col-xs-12">
                                <img class="responsive" style="width:100%;height:100%;" src="<?=WEB_ROOT?>assets/images/logo/logoPrint.png" alt="Daddy Printers" title="Daddy Printers">
                            </div>
                        </div>
                        <div class="row">
                            <div class="space-lg"></div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="text-left bgF58634 ">
                                    <h4 class="text-bold bgF58634">For the Attention of </h4>
                                </div>
                                <div id="customerDetail">
                                    <div class="text-center text-bold">
                                        Customer Name
                                    </div>
                                    <div class="text-center">
                                        Customer Number
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-12 col-xs-12">
                                    <div class="clearfix">
                                        <div class="pull-left col-sm-6 col-xs-12 text-bold">
                                            Sales Agent
                                        </div>
                                        <div class="pull-right text-left col-sm-6 col-xs-12 text-bold">
                                            <select name="saleAgent" id="saleAgent" class="input-sm" required >
                                                <option value="<?=$_SESSION['userId']?>"><?=username($dbConn)?></option>
                                                <?=saleAgents($dbConn)?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <div class="pull-left col-sm-6 col-xs-12 text-bold">
                                            Quotation Validity
                                        </div>
                                        <div class="pull-right text-left col-sm-6 col-xs-12 text-bold">
                                            7 Days
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <div class="pull-left col-sm-6 col-xs-12 text-bold">
                                            Delivery Time
                                        </div>
                                        <div class="pull-right text-left col-sm-6 col-xs-12 text-bold">
                                            <input type="text" name="txtDelDay" id="txtDelDay" value="<?php echo date('d-m-Y');?>" class="input-sm" required />
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

                                    <?php
                                    $i = 0;
                                    foreach($objItems->items as $item){

                                        ?>
                                        <tr class="colorwhite">
                                            <td class="colorwhite text-bold"><?=++$i?></td>
                                            <td class="colorwhite text-bold"><?=productName($dbConn,$item->productID)?></td>
                                            <?php
                                            if($item->catID == 3){
                                                ?>
                                                <td class="colorwhite"> <?=$item->width?> X <?=$item->length?></td>
                                                <?php
                                            }else{
                                                ?>
                                                <td class="colorwhite">Std</td>
                                                <?php
                                            }
                                            ?>
                                            <td class="colorwhite"><?= $item->qty?></td>
                                            <td class="colorwhite"><?=$item->unitPrice?></td>
                                            <td class="colorwhite"><?=$item->total?></td>
                                        </tr>
                                        <?php
                                        $j = 0;
                                        foreach($item->itemsValue as $itemId){
                                            @extract($itemId);
                                            ?>
                                            <tr>
                                                <td class="colorwhite"></td>
                                                <td class="colorwhite"><?=variationtitle($dbConn, $variationid);?></td>
                                                <td class="colorwhite"></td>
                                                <td class="colorwhite"></td>
                                                <td class="colorwhite"></td>
                                                <td class="colorwhite"></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <tr>
                                        <td class="colorgry" id="colorgry1" colspan="5"></td>
                                        <td class="colorwhite"><?=$objItems->total?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right colorwhite">Income Tax & WHT Tax</td>
                                        <td class="colorwhite"><input type="text" id="incomeTax" class="input-sm" name="incomeTax" placeholder="Income $ Tax"></td>
                                    </tr>
                                    <tr class="printHide">
                                        <td colspan="5" class="text-right colorwhite">Discount</td>
                                        <td class="colorwhite"><input type="text" id="discount" name="discount" class="input-sm" placeholder="Discount"></td>
                                    </tr>
                                    <tr class="printHide">
                                        <td colspan="5" class="text-right colorwhite">Advance</td>
                                        <td class="colorwhite"><input type="text" id="advance" name="advance" class="input-sm" placeholder="Advance"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-center colorgry" id="colorgry2">TOTAL</td>
                                        <td class="colorwhite" id="divSubTotal"><?=$objItems->total?></td>
                                        <input type="hidden" name="subTotal" id="subTotal" value="<?=$objItems->total?>">
                                    </tr>
                                    <tr class="printHide">
                                        <td colspan="4" class="text-center"><textarea name="orderNote" id="orderNote" style="width:100%" class="input-lg" rows="1" placeholder="Order Note"></textarea></td>
                                        <td class="colorwhite" id="divSubTotal">
                                            <select name="orderStatus" id="orderStatus" style="width:100%" class="input-lg" required>
                                                <option value="101">Quotation</option>
                                                <option value="102">Order</option>
                                            </select>
                                        </td>
                                        <td class="colorwhite">
                                            <select name="department" id="department" style="display:none;" class="input-lg">
                                                <option value="0">Select Department</option>
                                                <option value="201">Designing</option>
                                                <option value="202">production</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" id="printHide" class="colorwhite">
                                            <input type="submit" name="print" class="btn btn-danger pull-right" style="margin-right:5px " value="PDF">
                                            <input type="submit" name="order" class="btn btn-danger pull-right" style="margin-right:5px " value="Save">
                                            <a href="processcart.php?action=empty_cart" class="btn btn-danger pull-right" style="margin-right:5px;color: #FFFFFF;">Cancel </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                    </form>
                    <div class="col-sm-12">
                        <div id="colorBlue" class="text-center text-bold colorBlue colorWht">Terms & Conditions</div>
                        <div class="text-center">1. Customer will be billed after indicating acceptance of this quote</div>
                        <div class="text-center">2. 75% Advance payment will be due at the time of placing order</div>
                        <div colspan="6" class="text-center">3. Incase of Different tax method please revise the qoutation ( Rate ) from the base price</div>
                        <div colspan="6" class="text-center">4. Cheque furnished , will be made in favour of " Daddy Printers "</div>
                    </div>
                    <div class="col-sm-12 text-center">
                        <h3>Thank you for your business!</h3>
                        <div>Should you have any queries regarding this quotation, please contact us at.</div>
                        <div class="space-md"></div>
                        <div class="text-bold borderBottom">G-2 , First Floor , Main Commerical Area , Phase 1 , Dha , Lahore</div>
                        <div class="row text-bold text-center">
                            <div class="col-sm-4">0092-321-8460888 /0323-8412223</div>
                            <div class="col-sm-4">info@daddyprinters.com </div>
                            <div class="col-sm-4">www.daddyprinters.com</div>
                        </div>
                    </div>
                </div>
        <?php
            }?>
    </div>

    <script>
        $(document).ready(function(){
            $("#incomeTax").change(function(){
                var per = parseFloat($(this).val());
                var subtotal = <?=$objItems->total?>;
                var perAmount = subtotal * per;
                per = perAmount / 100;
                subtotal = subtotal + per ;
                $("#subTotal").val(subtotal);
                $("#divSubTotal").html(subtotal);
            });

            $("#discount").change(function(){
                var dis = parseFloat($(this).val());
                var subtotal = $("#subTotal").val();
                subtotal = subtotal - dis ;
                $("#subTotal").val(subtotal);
                $("#divSubTotal").html(subtotal);
            });

            $("#advance").change(function (){
               var adv = parseFloat($(this).val());
                    var subtotal = $("#subTotal").val();
                    subtotal = subtotal - adv;
                    $("#divSubTotal").html(subtotal);
            });

        });
    </script>

    <?php
    }
    ?>
    <div class="space-lg"></div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="clientAdd" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="../client/processClient.php?action=add" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Client</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid container_block">
                        <div class="row inner_heading">
                            <h1>Client Details</h1><hr>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4 mg_btm_30" >
                                <label>Company Name:</label></br>
                                <input type="text" name="txtCmpName" id="txtCmpName" class="formField" required="required" value="" />
                            </div>
                            <div class="col-md-4 col-sm-4 mg_btm_30">
                                <label>Name:</label></br>
                                <input type="text" name="txtName" id="txtName" class="formField" required="required" value="" />
                            </div>
                            <div class="col-md-4 col-sm-4 mg_btm_30">
                                <label>Mobile Number:</label></br>
                                <input type="text" name="txtPhone" id="txtPhone" class="formField" required="required" value="" />
                            </div>
                            <div class="col-md-4 col-sm-4 mg_btm_30">
                                <label>Email:</label></br>
                                <input type="email" name="txtEmail" id="txtEmail" class="formField" value="" />
                            </div>

                            <div class="col-md-4 col-sm-4 mg_btm_30">
                                <label>City:</label></br>
                                <input type="text" name="txtCity" id="txtCity" class="formField" value="" required />
                            </div>
                            <div class="col-md-4 col-sm-4 mg_btm_30">
                                <div class="form-group">
                                    <label for="dtp_input2" class="control-label">Next Follow Up Date:</label><br>
                                    <div class="input-group date form_datetime" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                        <input class="form-control" size="16" type="text" value="" name="txtFolowDate" >
                                    </div>
                                    <input type="hidden" id="dtp_input2" value="" /><br/>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 mg_btm_30">
                                <label>Address:</label></br>
                                <textarea name="txtAddress" class="formField" ></textarea>
                            </div>

                            <div class="col-md-12 col-sm-12 mg_btm_30">
                                <label>Notes:</label></br>
                                <textarea name="txtNotes" class="formField" ></textarea>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="quotation" value="Add Client" class="butn">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>

    </div>
</div>
