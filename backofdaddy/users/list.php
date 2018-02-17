<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$rowsPerPage = 10;
  	$sql		=	"SELECT * FROM tbl_user";

	$result     = dbQuery($dbConn, getPagingQuery($sql, $rowsPerPage));
	$pagingLink = getPagingLink($dbConn, $sql, $rowsPerPage);
 	
?>
	<?php include(THEME_PATH . '/tb_link.php');?>
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>User / Admin List</h1>
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
								<th>Department</th>
								<th>User Level</th>
								<th>User Name</th>
								<th>Reg DATE</th>
								<th>Last Login</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (dbNumRows($result) > 0){
								$i = 1;
								while($row = dbFetchAssoc($result)) {
									extract($row);
							
									if ($user_status == 1) {
										$status = "<img src='" .  WEB_ROOT_TEMPLATE . "/images/icon/active.png' alt='Active' width='24' height='24' />";	
									} else {
										$status = "<img src='" .  WEB_ROOT_TEMPLATE . "/images/icon/inactive.png' alt='Inactive'  width='24' height='24' />";	
									} ?>
									<tr>
										<td><?php echo $i++;?></td>
										<td><?=departmentnaame($dbConn,$dep_id)?></td>
										<td><?php designaame($dbConn, $desig_id); ?></td>
										<td><?php echo $user_name; ?></td>
										<td><?php echo formatMySQLDate($user_regdate,'d-m-Y H:i:s') ; ?></td>
										<td><?php echo formatMySQLDate($user_last_login,'d-m-Y H:i:s'); ?></td>
										<td><?php echo $status; ?></td>
										<td>
											<?php if(modPerModify($dbConn,"10")){?>
											<a href="javascript:modifyUser(<?php echo $user_id; ?>)"><i class="fa fa-edit"></i></a>&nbsp;
											<?php } if(modPerDelete($dbConn,"10")){?>
											<a href="javascript:deleteUser(<?php echo $user_id; ?>)"><i class="fa fa-trash"></i></a>
											<?php }?>
										</td>
									</tr><?php
								}
							}else { ?>
								<tr>
									<td height="20">No User/ Admin Added Yet</td>
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
		
		<?php
		if(modPerAdd($dbConn, "10")){ ?>
			<div class="row">
				<div class="col-md-10 col-sm-11 col-xs-11">
					<input type="submit" name="btnButton" value="Add New User" class="butn pull-right" onclick="addUser()"  />
				</div>
			</div>
			<?php
		}?>
	</section><!-- /.content -->
			