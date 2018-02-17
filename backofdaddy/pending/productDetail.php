<?php
if (!defined('WEB_ROOT')) {
    exit;
}
$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

if (isset($_GET['orderDetId']) && $_GET['orderDetId'] > 0) {
    $orderDetId = $_GET['orderDetId'];
    $pid = $_GET['pid'];
} else {
    redirect('index.php');
}

// get Page info
?>
<section class="content-header top_heading">
    <h1>Product Detail</h1>
</section>
<!-- Main content -->
<section class="content" >

    <div class="container-fluid container_block">
        <div class="row inner_heading">
            <h1>Product Details</h1><hr>
        </div>

        <div class="row">

            <div class="col-md-12">
                <div class="row">
                    <div class="table-responsive tbl-respon">
                        <table class="table table-bordered tbl-respon2">
                          <?php
                          $catId = productCatId($dbConn,$pid);
                          if($catId != 3){
                          ?>
                              <thead>
                              <tr>
                                  <th>Sr No</th>
                                  <th>Variation Type</th>
                                  <th>Variation</th>
                              </tr>
                              </thead>
                            <tbody>
                            <?php
                            $sql 	= 	"SELECT * FROM order_variation WHERE order_detail_id = $orderDetId";
                            $result = 	 dbQuery($dbConn, $sql) ;
                            if (dbNumRows($result) > 0){
                            $i = 1;
                            while($row = dbFetchAssoc($result)) {
                                extract($row);
                                ?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td><?=variationtypeName($dbConn,$variation_type_id)?></td>
                                    <td><?=variationtitle($dbConn,$variation_id)?></td>
                                </tr>
                            <?php
                                $i++;
                                }
                            }
                            ?>
                            </tbody>
                           <?php
                           }else{
                              ?>
                              <tbody>
                              <?php
                              $sql1		=	"SELECT * FROM `order_detail` WHERE order_detail_id = '$orderDetId'";
                              $result1     = dbQuery($dbConn, $sql1);
                              if (dbNumRows($result1) > 0){
                                  $row1 = dbFetchAssoc($result1);
                                      extract($row1);
                                      ?>
                                      <tr>
                                          <td>Height</td>
                                          <td><?=$height?></td>
                                      </tr>
                                      <tr>
                                          <td>Width</td>
                                          <td><?=$width?></td>
                                      </tr>
                                      <tr>
                                          <td>Rate</td>
                                          <td><?=$rate?></td>
                                      </tr>
                                      <?php
                              }
                              ?>
                              </tbody>
                            <?php
                          }
                           ?>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <div style="min-height: 20px;"></div>
    </div>
    <div class="row">
        <div class="col-md-offset-5 col-xs-offset-3 col-sm-offset-5">
            <input type="button" name="btnCanlce" value="Back" class="butn" onclick="window.location.href='index.php'"/>
        </div>
    </div>

</section><!-- /.content -->
















