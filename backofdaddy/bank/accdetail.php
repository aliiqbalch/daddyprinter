<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$rowsPerPage = 10;
	if (isset($_GET['BankId']) && $_GET['BankId'] > 0) {
		$BankId = $_GET['BankId'];
	}else {
		// redirect to index.php if user id is not present
		redirect('index.php');
	}
	$sql =  "SELECT * FROM tbl_bank_recept WHERE bank_id = '$BankId' ORDER BY bank_id DESC";
	$result     = dbQuery($dbConn, getPagingQuery($sql, $rowsPerPage));
	$pagingLink = getPagingLink($dbConn, $sql, $rowsPerPage);
?>
	<?php include(THEME_PATH . '/tb_link.php');?>
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Account Detail</h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid container_block">
			<div class="space"></div>
			<div class="row">

				<div class="col-md-7">
					<?php if(modPerAdd($dbConn,"23")){?>
					<button type="submit" name="btnButton"  class="butn " onclick="addbankrecept(<?php echo $BankId;?>)"  style="margin-left: 5px;"><i class="fa fa-plus"></i> Add Account Detail</button>
					<?php }?>
				</div>
				<div class="col-md-5">
					<button type="submit" name="btnButton"  class="butn pull-right"  style="margin-right: 5px;">Current Balance : RS <?php accountamount($dbConn, $BankId);?></button>
				</div>
			</div>
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
								<th >Date / Time</th>
								<th >Debit</th>
								<th >Credit</th>
								<th >Description</th>
								<th >Ammount</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (dbNumRows($result) > 0) {
								$i = 1;
								$totalamount = totalamnt($dbConn, $BankId);
								while($row = dbFetchAssoc($result)){
									extract($row); ?>
									<tr>
										<td><?php echo $i++;?></td>
										<td><?php echo $bank_recept_date;?> : <?php echo $bank_recept_time;?></td>
										<td><?php  if($recept_debit == 0){ echo "-";}else{ echo $recept_debit;}?></td>
										<td><?php  if($recept_credit == 1){echo "-";}else{ echo $recept_credit;}?></td>
										<td><?php echo $recept_description;?></td>
										<td><?php echo $avalable_amount ;?></td>
										
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
		