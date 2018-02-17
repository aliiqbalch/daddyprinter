<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$rowsPerPage = 10;
  	$sql		=	"SELECT * FROM `order`";

	$result     = dbQuery($dbConn, getPagingQuery($sql, $rowsPerPage));
	$pagingLink = getPagingLink($dbConn, $sql, $rowsPerPage);
?>
	<?php include(THEME_PATH . '/tb_link.php');?>
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Order Que Management</h1>
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
								<th>Compnay Name</th>
								<th>Name</th>
								<th>Phone Number</th>
								<th>Email</th>
								<th>Quotation No</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (dbNumRows($result) > 0){
								$i = 1;
								while($row = dbFetchAssoc($result)) {
									extract($row);
//									var_dump($row);
//									die("SSs");
									?>
									<tr>
										<td><?php echo $i++;?></td>
										<td><a href="javascript:viewPendingOrderDetail(<?php echo $order_id; ?>)"><?=clientCampnyNameByID($dbConn, $client_id); ?></a></td>
										<td><?=clientName($dbConn, $client_id) ?></td>
										<td><?=clienNumber($dbConn,$client_id)?></td>
										<td><?=clienEmail($dbConn,$client_id) ?></td>
										<td><?=$order_id?></td>
										<td>
											<?php if(modPerView($dbConn,"19")){?>
											<a href="javascript:viewPendingOrderDetail(<?php echo $order_id; ?>)"><i class="fa fa-file-text"></i></a>&nbsp;
										<?php } if(modPerModify($dbConn,"19")){?>
<!--											<a href="javascript:modifyPendingOrder(--><?php //echo $order_id; ?><!--)"><i class="fa fa-edit"></i></a>&nbsp;-->
										<?php } if(modPerDelete($dbConn,"19")){?>
											<a href="javascript:deletePendingOrder(<?php echo $order_id; ?>)"><i class="fa fa-trash"></i></a>
										<?php }?>
										</td>
									</tr><?php
								}
							}else { ?>
								<tr>
									<td height="20">No Quotation Added Yet</td>
								</tr>
								<?php 
							} //end while ?>
							<tr height="20">
								<td align="center" colspan="9" class="pagingStyle"><?php echo $pagingLink;?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
				<!--- End Table ---------------->
		</div>
	</section><!-- /.content -->
			