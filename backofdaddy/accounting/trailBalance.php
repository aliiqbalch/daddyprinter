<?php
if (!defined('WEB_ROOT')) {
    exit;
}
$rowsPerPage = 10;
$sql =  "SELECT * FROM account ORDER BY id DESC";
$result     = dbQuery($dbConn, getPagingQuery($sql, $rowsPerPage));
$pagingLink = getPagingLink($dbConn, $sql, $rowsPerPage);
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
<!--                <div class="col-md-12">-->
<!--                    <button type="button" name="btnButton" data-toggle="modal" data-target="#recordTrans"  class="btn btn-danger pull-left" style="margin-left: 5px;">Record Transaction</button>-->
<!--                    <form action="" method="post">-->
<!--                    <div class="input-group pull-right" style="width: 150px;">-->
<!--                            <input type="text" class="form-control" placeholder="25-03-2017" aria-describedby="basic-addon2">-->
<!--                            <span style="margin:0px;padding: 0px;" class="input-group-addon" id="basic-addon2"><button type="submit" style="border-radius:0px; border: none;" class="btn"><i class="fa fa-search"></i></button></span>-->
<!--                    </div>-->
<!--                    </form>-->
<!--                </div>-->
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
                        <th>Date</th>
                        <th>Account Title</th>
                        <th>Dr Amount</th>
                        <th>Cr Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>Date</td>
                        <td>Account Title</td>
                        <td>1000</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Date</td>
                        <td>Account Title</td>
                        <td></td>
                        <td>1000</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-center">Total</td>
                        <td>1000</td>
                        <td>1000</td>
                    </tr>
                    <tr height="20">
                        <td align="center" colspan="5" class="pagingStyle"><?php echo $pagingLink;?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--- End Table ---------------->
        <div style="margin-bottom:20px;" class="row">
            <div class="col-md-12">
                <button type="button" name="btnButton"  class="btn btn-danger pull-right" style="margin-left: 5px;">PDF</button>
            </div>
        </div>
    </div>

</section><!-- /.content -->
<!-- Modal -->
<div class="modal fade" id="recordTrans" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="padding:35px 50px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Record Transaction</h4>
            </div>
            <div class="modal-body" style="padding:40px 50px;">
                <form role="form" action="" method="post">
                    <h6>Dr</h6>
                    <div class="form-group">
                        <label for="usrname"> Account Title</label>
                        <select name="account_titleDr" class="form-control">
                            <option value="0">Select Title</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="psw"> Amount </label>
                        <input type="text" name="amount" class="form-control" id="code" placeholder="Amount">
                        <input type="hidden" name="natureDr" value="Dr">
                    </div>
                    <h6>Cr</h6>
                    <div class="form-group">
                        <label for="usrname"> Account Title</label>
                        <select name="account_titleCr" class="form-control">
                            <option value="0">Select Title</option>
                        </select>
                        <input type="hidden" name="natureCr" value="Cr">
                    </div>
                    <button type="submit" class="btn btn-danger btn-block"> Save </button>
                </form>
            </div>
        </div>
    </div>
</div>