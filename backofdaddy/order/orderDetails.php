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
    <h1><?=clientCampnyNameByID($dbConn, $client_id); ?> / Process Management</h1>
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
        <?php if($status_id == 101){?>
        <div class="row bord-right-space" >
            <div class="table-responsive tbl-respon">
                <table class="table table-bordered tbl-respon2">
                    <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Name</th>
						<th>Title</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
					/* Query to get total_amount by order_id */
					$sqlToGetTotal = "SELECT total_amount FROM `order` WHERE order_id= '".$order_id."'";
					$resultToGetTotal = dbQuery($dbConn,$sqlToGetTotal);
					$rowToGetTotal = dbFetchAssoc($resultToGetTotal);
					$totalAmount=$rowToGetTotal['total_amount'];
					
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
                                    <input type="hidden" name="orderDetailId" value="<?= $order_detail_id ?>">
                                    <td><?= $i++ ?></td>
                                    <td><?= productName($dbConn, $product_id) ?></td>
									<td><input type="text" name="title" value="<?= $title ?>"></td>
                                    <td><?php if(productCatId($dbConn, $product_id) == 3) {
                                            echo $width . " x " . $height;
                                        } else {
                                            echo "Std";
                                        } ?></td>
                                    <td><input type="text" name="qty" value="<?= $qty ?>" readonly></td>
                                    <td><input type="text" class="input-sm" name="unitPrice"
                                               value="<?= getunitPrice($qty, $retail_price) ?>"></td>
                                    <td><?= $retail_price ?></td>
                                    <td>
                                        <button type="submit" title="Update"><i class="fa fa-upload"></i></button>
                                        <a href="processOrder.php?action=deleteDetail&oDId=<?= $order_detail_id ?>"
                                           title="Remove"> <i class="fa fa-trash"></i></a></td>
                                </form>
                            </tr>
                            <?php
                            $total += $retail_price;
                            $discount += getDetDiscount($dbConn, $order_detail_id);
                            if (productCatId($dbConn, $product_id) !=3) {
                                $sql2 = "SELECT * FROM order_variation WHERE order_detail_id = $order_detail_id";
                                $result2 = dbQuery($dbConn, $sql2);
                                if (dbNumRows($result2) > 0) {
                                    ?>
                                    <tr>
                                        <td></td>
                                        <td colspan="6">
                                            <?php
                                            while ($row2 = dbFetchAssoc($result2)) {
                                                extract($row2);
                                                variationtitle($dbConn, $variation_id);
                                                echo ",";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                        ?>
                        <tr>
                            <td colspan="5"></td>
                            <td><?=$total?></td>
                            <td></td>
                        </tr>
                    <form action="processOrder.php?action=updateQuotation" method="post">
                        <input type="hidden" name="total" value="<?=$total?>">
                        <input type="hidden" name="client_id" value="<?=$client_id?>">
                        <tr>
                            <td colspan="4"></td>
                            <td>Tax</td>
                            <td><input type="text" name="tax" value="<?=getTax($dbConn,$orderId)?>"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td>Discount Voucher</td>
                            <td><input type="text" name="discountVoucher" value="" class="input-sm"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td>Discount</td>
                            <td><input type="text" name="discount" value="<?php echo isset($discount) ? $discount:"None";?>" class="input-sm"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td>Advance</td>
                            <td><input type="text" name="advance" value="<?=$advance?>" class="input-sm"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td>TOTAL</td>
                            <td><?php
                                $tax = 0;
                                if(getTax($dbConn,$orderId)){
                                    $tax = getTax($dbConn,$orderId);
                                    $tax = $total * $tax;
                                    $tax = $total / 100;
                                }
                                $total = $total - $discount;
                                $total = $total + $tax;
                                $total = $total - $advance;
                                echo $totalAmount;
                                ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="6"><?=$row['order_note']?></td>
                            <td class="text-right">
                                <select class="input-sm" name="depId">
                                    <option value="101">Quotation</option>
                                    <option value="102">Order</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                <a href="index.php">Back</a>
                                <input type="hidden" name="orderID" value="<?=$orderId?>">
                                <input type="submit" name="update" value="Save" class="butn pull-right">
                                <input type="submit" name="print" value="PDF" style="margin-right:5px;" class="butn pull-right">
                                <input type="submit" name="addMore" value="Add More" style="margin-right:5px;" class="butn pull-right">
                            </td>
                        </tr>
                    </form>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php }else{?>
        <div class="row bord-right-space" >
            <div class="table-responsive tbl-respon">
                <table class="table table-bordered tbl-respon2">
                    <thead>
                    <tr>
                        <th>Sr.No</th>
						<th>Title</th>
                        <th>Description</th>
                        <th>Size</th>
                        <th>Qty</th>
                        <?php if(modPerDelete($dbConn,"24")){?>
                        <th>unit Price</th>
                        <th>Amount</th>
                        <?php }?>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql1 = "SELECT * FROM order_detail WHERE order_id= $order_id";
                    $result1 = dbQuery($dbConn,$sql1);
                    if (dbNumRows($result1) > 0) {
                        $i = 1;
                        $total = 0;
                        $discount = getDiscount($dbConn, $orderId);
                        while ($row1 = dbFetchAssoc($result1)) {
                            extract($row1);
                            ?>
                            <tr>
                                <form action="processOrder.php?action=modify" method="post">
                                <td><?=$i++?></td>
								<td><?=$row1['title']?></td>
                                <td><?=productName($dbConn,$product_id)?></td>
                                <td><?php if(productCatId($dbConn,$product_id) == 3){echo "$width X $height"; }else{echo"Std";}?></td>
                                <td><?=$qty?></td>
                                    <?php if(modPerDelete($dbConn,"24")){?>
                                <td><?=getunitPrice($qty,$retail_price)?></td>
                                <td><?=$retail_price?></td>
                                <?php } ?>
                                <td>
                                        <?php
                                        if($_SESSION['userlevel'] == 7) {
                                            if ($order_detail_status == 207) {
                                                ?>
                                                <select name="dpID" class="input-sm">
                                                    <?php
                                                    $List = array('207' => "Fd", '202' => "Designing", '203' => "Production");
                                                    foreach ($List as $key => $value) {
                                                        ?>
                                                        <option
                                                            value="<?= $key ?>" <?php if ($key == $order_detail_status) {
                                                            echo "selected";
                                                        } ?> ><?= $value ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <?php
                                            } else {
                                                echo getDepartmentByID($dbConn, $order_detail_status);
                                            }
                                        }else if($_SESSION['userlevel'] == 4){
                                            if ($order_detail_status == 202) {
                                                ?>
                                                <select name="dpID" class="input-sm">
                                                    <?php
                                                    $List = array('202' => "Designing", '203' => "Production");
                                                    foreach ($List as $key => $value) {
                                                        ?>
                                                        <option
                                                            value="<?= $key ?>" <?php if ($key == $order_detail_status) {
                                                            echo "selected";
                                                        } ?> ><?= $value ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <?php
                                            } else {
                                                echo getDepartmentByID($dbConn, $order_detail_status);
                                            }
                                        }else if($_SESSION['userlevel'] == 9){
                                            if ($order_detail_status == 203 || $order_detail_status == 204 || $order_detail_status == 205|| $order_detail_status == 206) {
                                                ?>
                                                <select name="dpID" class="input-sm">
                                                    <?php
                                                    $List = array('203' => "Production",'204'=>"Quality Assurance",'205'=>"Delivery",'206'=>"Account");
                                                    foreach ($List as $key => $value) {
                                                        ?>
                                                        <option
                                                            value="<?= $key ?>" <?php if ($key == $order_detail_status) {
                                                            echo "selected";
                                                        } ?> ><?= $value ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <?php
                                            } else {
                                                echo getDepartmentByID($dbConn, $order_detail_status);
                                            }
                                        }elseif($_SESSION['userlevel'] == 8){

                                            if ($order_detail_status == 207) {
                                                ?>
                                                <select name="dpID" class="input-sm">
                                                    <?php
                                                    $fdList = array('207' => "Fd");
                                                    foreach ($fdList as $key => $value) {
                                                        ?>
                                                        <option
                                                            value="<?= $key ?>" <?php if ($key == $order_detail_status) {
                                                            echo "selected";
                                                        } ?> ><?= $value ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <?php
                                            } else {
                                                echo getDepartmentByID($dbConn, $order_detail_status);
                                            }
                                        }else{
                                            ?>
                                                <select name="dpID" class="input-sm">
                                                    <?php
                                                     $list = getDepartmentAr($dbConn);
                                                    foreach ($list as $key => $value) {
                                                        ?>
                                                        <option
                                                            value="<?= $key ?>" <?php if ($key == $order_detail_status) {
                                                            echo "selected";
                                                        } ?> ><?= $value ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <?php
                                        }
                                        ?>
                                </td>
                                <td>
                                    <textarea class="input-sm" name="proNote" rows="1" cols="50"><?=$order_note?></textarea>
                                </td>
                                <td>
                                    <input type="hidden" name="orDId" value="<?=$order_detail_id?>">
                                    <button type="submit" class="btn btn-default btn-sm" title="Update"><i class="fa fa-upload"></i></button>
                                    <a href="../job/index.php?view=add&detId=<?=$order_detail_id?>" class="btn btn-default btn-sm" title="Create JobOrder"> + </a>
                                    <button type="button" data-toggle="modal" data-target="#clientAdd" class="btn btn-default btn-sm"><i class="fa fa-tasks"></i></button>
                                </td>
                                </form>
                            </tr>
                            <?php
                            if(productCatId($dbConn,$product_id) != 3) {
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td colspan="8"><?php
                                $total += $retail_price;
                                $discount += getDetDiscount($dbConn, $order_detail_id);
                                $sql2 = "SELECT * FROM order_variation WHERE order_detail_id = $order_detail_id";
                                $result2 = dbQuery($dbConn, $sql2);
                                if (dbNumRows($result2) > 0) {
                                    while ($row2 = dbFetchAssoc($result2)) {
                                        extract($row2);
                                        ?>
                                        <?=variationtitle($dbConn, $variation_id);?>,
                                        <?php
                                    }
                                        ?></td>
                                        </tr>
                                        <?php
                                }
                            }
                        }
                    }else{
                    ?>
                        <tr>
                            <td height="20">No Quotation Added Yet</td>
                        </tr>
                    <?php }?>
                    <tr height="20">
                        <td align="center" colspan="9" class="pagingStyle"><?=$row['order_note']?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php } ?>
    </div>
</section>

<div class="modal fade" id="clientAdd" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="<?=WEB_ROOT_ADMIN?>users/processAdmin.php?action=addTask" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Create Task</h4>
                </div>
                <div class="modal-body">

                    <table>
                        <tbody>
                        <tr>
                            <th>Users</th>
                            <input type="hidden" name="oId" value="<?=$orderId?>">
                            <td>
                                <select name="userId" class="input-sm">
                                    <?php
                                    $users = getUsers($dbConn);
                                    foreach($users as $key=>$value){
                                        ?>
                                        <option value="<?=$key?>"><?=$value?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Task</th>
                            <td><textarea type="text" class="text input-lg" name="task" required></textarea></td>
                        </tr>
						<tr>
							<th>Due Date</th>
							<td> &nbsp;<input style="line-height:15px;" id="due_date" type="datetime-local" name="due_date" required></td>
						</tr>
                        <tr>
                            <td colspan="2"><input type="submit" class="btn btn-default" value="Add"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>

    </div>
</div>