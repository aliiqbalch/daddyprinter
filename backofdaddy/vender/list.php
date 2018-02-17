<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$rowsPerPage = 20;
	$sql =  "SELECT * FROM tbl_vender ORDER BY ven_id DESC";
	$result     = dbQuery($dbConn, getPagingQuery($sql, $rowsPerPage));
	$pagingLink = getPagingLink($dbConn, $sql, $rowsPerPage);
?>
	<?php include(THEME_PATH . '/tb_link.php');?>
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Vender List</h1>
	</section>
	<!-- Main content -->
	<section class="content">
		
		<div class="container-fluid container_block">
			<div class="space"></div>
			<?php if(modPerAdd($dbConn,"22")){?>
			<div class="row">
				<div class="col-md-3">
					<button type="submit" name="btnButton" class="butn" onclick="addVender()" style="margin-left: 5px;"><i class="fa fa-plus"></i> Add Vender</button>
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
								<th >Company Name</th>
								<th >Name</th>
								<th >Phone No</th>
								<th >City</th>
								<th >Image</th>
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
										<td><a href="index.php?view=his&vId=<?=$ven_id?>"><?php echo $ven_cmp_name;?></a></td>
										<td><?php echo $ven_name;?></td>
										<td><?php echo $phone;?></td>
										<td><?php echo $city;?></td>
										<td><?php
											if ($pic != '') { ?>
												<img src="<?php echo WEB_ROOT."upload/vender/". $pic; ?>" width="70px" height="70px" />
												<?php 
											}else{ ?>
												<img src="<?php echo WEB_ROOT."upload/blank.png";?>" width="70px" height="70px" /> <?php
											} ?>
										</td>
										<td>
											<?php
											if(modPerView($dbConn,"22")){?>
											<a href="javascript:detailven(<?php echo $ven_id;?>)">
												<img src="<?php echo WEB_ROOT_TEMPLATE; ?>/images/icon/info.png" width="20" height="20" alt="Detail" border="0" /></a>&nbsp;
											</a>
											<?php }
											if(modPerModify($dbConn,"22")){?>
											<a href="javascript:modifyven(<?php echo $ven_id;?>)">
												<img src="<?php echo WEB_ROOT_TEMPLATE; ?>/images/icon/edit.png" width="20" height="20" alt="Modify" border="0" /></a>&nbsp;
											</a>
											<?php }
											if(modPerDelete($dbConn,"22")){?>
											<a href="javascript:deleteVen(<?php echo $ven_id;?>)">
												<img src="<?php echo WEB_ROOT_TEMPLATE; ?>/images/icon/delete.png" width="20" height="20" alt="Delete" border="0" /></a>&nbsp;
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
		