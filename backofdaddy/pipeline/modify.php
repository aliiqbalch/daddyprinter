<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
	if (isset($_GET['orderId']) && $_GET['orderId'] > 0) {
		$orderId = $_GET['orderId'];
	}else {
		// redirect to index.php if user id is not present
		redirect('index.php');
	}
	$sql = "SELECT * FROM `order` WHERE order_id = $orderId";
	$result = dbQuery($dbConn, $sql) ;
	$row    = dbFetchAssoc($result);
	extract($row);
?>

	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Modify Order </h1>
	</section>
	<!-- Main content -->
	<section class="content" >
		<!-- start any work here. -->
		<form action="processOrder.php?action=modify&oid=<?=$order_id?>" method="post" enctype="multipart/form-data">
			<div class="row bord-right-space" >
				<div class="table-responsive tbl-respon">
					<table class="table table-bordered tbl-respon2">
						<thead>
						<tr>
							<th>Quotation No</th>
							<th>Compnay Name</th>
							<th>Contact Information</th>
							<th>Sale Agents</th>
							<th>Quotation Time</th>
							<th>Status</th>
							<th>Discount</th>
							<th>Action</th>
						</tr>
						</thead>
						<tbody>
						<?php
						if (dbNumRows($result) > 0){
							$row = dbFetchAssoc($result);
								@extract($row);
//									var_dump($row);
//									die("SSs");
								?>
								<tr>
								<td><?=$order_id?></td>
								<td><?=clientCampnyNameByID($dbConn, $client_id); ?></td>
								<td><?=clientName($dbConn, $client_id) ?>/ <?=clienNumber($dbConn,$client_id)?></td>
								<td><?=getUserNameById($dbConn,$user_id) ?></td>
								<td><?=formatMySQLDate($order_time,'d-m-Y'); ?></td>
								<td>
									<select name="statusId" id="txtDepId" class="formField">
										<option value="101">Quotation</option>
										<option value="102">Order</option>
										<option value="103">Delivered</option>
									</select>
								</td>
								<td><?=getDiscount($dbConn,$orderId)?></td>
								<td>
									<input type="submit" class="butn" value="Save">
								</td>
								</tr>
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
		</form>
	</section><!-- /.content -->
		