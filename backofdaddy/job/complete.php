<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$rowsPerPage = 10;
  	$sql		=	"SELECT * FROM `job_order` WHERE status = 1";
	$result     = dbQuery($dbConn, getPagingQuery($sql, $rowsPerPage));
	$pagingLink = getPagingLink($dbConn, $sql, $rowsPerPage ,'view=comp');
?>
	<?php include(THEME_PATH . '/tb_link.php');?>
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Job Orders</h1>
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
								<th>Vendor Name</th>
								<th>Client Name</th>
								<th>Order Num</th>
								<th>Product Name</th>
								<th>Size</th>
								<th>Qty</th>
								<th>Total</th>
<!--								<th>Action</th>-->
							</tr>
						</thead>
						<tbody>
							<?php
							if(dbNumRows($result) > 0){
								$i = 1;
								while($row = dbFetchAssoc($result)){
									extract($row);
									$objOrder = orderDetail($dbConn,$order_detail_id);
									?>
									<tr>
										<td><?=$i++;?></td>
										<td><?php $list = getVenderById($dbConn,$row['vendor_id']); echo $list['ven_cmp_name']; ?></td>
										<td><?php clientCampnyNameByID($dbConn,clientIdFromOrder($dbConn,$objOrder['order_id']))?></td>
										<td><?=$objOrder['order_id']?></td>
										<td><?=productNamePr($dbConn,$objOrder['product_id'])?></td>
										<td><?=$width?> x <?=$height?></td>
										<td><?=$qty?></td>
										<td><?=$total?></td>
<!--										<td>-->
											<?php if(modPerView($dbConn,"19")){?>
<!--													<a href="processOrder.php?action=inComp&jobId=--><?//=$Job_id?><!--" title="Complete"><i class="fa"></i> ++ </a>&nbsp;-->
											<?php } if(modPerDelete($dbConn,"19")){?>
<!--													<a href="processOrder.php?action=delete&jobId=--><?//=$Job_id?><!--" title="Delete" ><i class="fa fa-trash"></i></a>-->
											<?php  }?>
<!--										</td>-->
									</tr>
							<?php
								}
							}else { ?>
								<tr>
									<td height="20">No Job Order Added Yet</td>
								</tr>
								<?php
							} //end while ?>
							<tr height="20">
								<td align="center" colspan="9" class="pagingStyle"><?php  echo $pagingLink;?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
				<!--- End Table ---------------->
		</div>
	</section><!-- /.content -->
			