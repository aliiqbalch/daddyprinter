<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$rowsPerPage = 20;
if(isset($_GET['vId'])){
	$vid = $_GET['vId'];
}
	$sql =  "SELECT * FROM `job_order` WHERE `vendor_id` = $vid AND status = 1 ORDER BY Job_id DESC";
	$result     = dbQuery($dbConn, getPagingQuery($sql, $rowsPerPage));
	$pagingLink = getPagingLink($dbConn, $sql, $rowsPerPage);
?>
	<?php include(THEME_PATH . '/tb_link.php');?>
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Purchase Order</h1>
	</section>
	<!-- Main content -->
	<section class="content">
		
		<div class="container-fluid container_block">
			<div class="space"></div>
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
								<th >Sr.No</th>
								<th> Date</th>
								<th >Name</th>
								<th >Size</th>
								<th >Unit Price</th>
								<th >qty</th>
								<th >Amount</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (dbNumRows($result) > 0) {
								$i = 1;
								while($row = dbFetchAssoc($result)){
									extract($row); ?>
									<tr>
										<td><?=$i++;?></td>
										<td><?=$date;?></td>
										<td><?=$job_name;?></td>
										<td><?=$width;?> x <?=$height?></td>
										<td><?=$unit_price;?></td>
										<td><?=$qty;?></td>
										<td><?=$total?></td>
									</tr><?php
								}
							} ?>
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
		