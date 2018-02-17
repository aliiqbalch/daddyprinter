<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$rowsPerPage = 10;
	$sql =  "SELECT * FROM tbl_bank ORDER BY bank_id DESC";
	$result     = dbQuery($dbConn, getPagingQuery($sql, $rowsPerPage));
	$pagingLink = getPagingLink($dbConn, $sql, $rowsPerPage);
?>
	<?php include(THEME_PATH . '/tb_link.php');?>
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Bank Detail</h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid container_block">
			<div class="space"></div>
			<?php if(modPerAdd($dbConn,"23")){?>
			<div class="row">
				<div class="col-md-3">
					<button type="submit" name="btnButton"  class="butn" onclick="addbank()"  style="margin-left: 5px;"><i class="fa fa-plus"></i> Add Bank Detail</button>
				</div>
				
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
								<th >Sr.No</th>
								<th >Bank Name</th>
								<th >Branch Name</th>
								<th >Branch Code</th>
								<th >Person Name</th>
								<th >Account No</th>
								<th >Current Blance</th>
								<th >Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (dbNumRows($result) > 0) {
								$i = 1;
								while($row = dbFetchAssoc($result)){
									extract($row); ?>
									<tr>
										<td><?php echo $i++;?></td>
										<td><?php echo $bank_name;?></td>
										<td><?php echo $bank_branch_name;?></td>
										<td><?php echo $bank_branch_code;?></td>
										<td><?php echo $bank_acount_title;?></td>
										<td><?php echo $bank_acount_no;?></td>
										<td><?php echo $bank_current_blance;?></td>
										<td>
											<?php if(modPerAdd($dbConn,"23")){?>
											<a href="javascript:accountdetail(<?php echo $bank_id;?>)">
												<img src="<?php echo WEB_ROOT_TEMPLATE; ?>/images/icon/addmore.png" width="20" height="20" alt="Add" border="0" /></a>&nbsp;
											</a>
											<?php } if(modPerModify($dbConn,"23")){?>
											<a href="javascript:modifybank(<?php echo $bank_id;?>)">
												<img src="<?php echo WEB_ROOT_TEMPLATE; ?>/images/icon/edit.png" width="20" height="20" alt="edit" border="0" /></a>&nbsp;
											</a>
											<?php }?>
										</td>
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
		