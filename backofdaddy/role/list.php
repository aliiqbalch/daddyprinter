<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	
	$sql =  "SELECT DISTINCT desig_id FROM tbl_role ORDER BY role_id DESC";
	$result     = dbQuery($dbConn, $sql);
	
	
?>
	<?php include(THEME_PATH . '/tb_link.php');?>
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Role Detail</h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid container_block">
			<?php
			if(modPerAdd($dbConn, "12")){ ?>
				<div class="row">
					<div class="col-md-6">
						<div style="margin: 10px 0px 0px 5px;">
							<button type="submit" name="btnButton"  class="butn" onclick="addRole()"  ><i class="fa fa-plus"></i> Add Role</button>
						</div>
					</div>
				</div>
				<?php
			}?>
			<div class="row" id="alertmsg" style="margin: 10px 0px 0px 5px;" >
				<?php 
				if(isset($_SESSION['errorMessage']) && isset($_SESSION['count'])){
					if($_SESSION['count'] <= 1){
						$_SESSION['count'] +=1; ?>
						<div style="min-height:10px;"></div>
						<div class="alert alert-<?php echo $_SESSION['data'];?>">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<?php echo $_SESSION['errorMessage'];  ?>
						</div> <?php
						unset($_SESSION['errorMessage']);
					}
				} ?>
			</div>
			<div class="row bord-right-space" >
				<div class="table-responsive tbl-respon">
					<table class="table table-bordered table-striped tbl-respon2">
						<thead>
							<tr>
								<th>Sr.No</th>
								<th>Module</th>
								<th>View</th>
								<th>Add</th>
								<th>Edit</th>
								<th>Delete</th>
								<th>CostPrice</th>
								<th>WholeSalePrice</th>
								<th>Factor</th>
								<th>VariationDetail</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (dbNumRows($result) > 0) {
								$i = 1;
								while($row = dbFetchAssoc($result)){
									extract($row);
									 ?>
									<tr >
										<td rowspan="23" ><?php echo $i++;?></td>
										<td colspan="9" class="text-center" style="background-color: #CCCCCC;"><?php echo designaame($dbConn, $desig_id);?></td>
										<td rowspan="23">
											<?php if(modPerModify($dbConn,"12")){?>
											<a href="javascript:modifyRole(<?php echo $desig_id;?>)">
												<i class="fa fa-edit"></i>&nbsp;
											</a>
										<?php } if(modPerDelete($dbConn,"12")){?>
											<a href="javascript:deleteROle(<?php echo $desig_id;?>)">
												<i class="fa fa-trash"></i>
											</a>
										<?php }?>
										</td>
									</tr>
									<?php
									$sql2 = "SELECT * FROM tbl_role WHERE desig_id = '$desig_id'";
									$result2 = dbQuery($dbConn, $sql2);
									if(dbNumRows($result2) > 0){
										while($row2 = dbFetchAssoc($result2)){
											extract($row2); ?>
											<tr>
												<td><?php moduleName($dbConn, $mod_id);?></td>
												<td><?php
													if($role_view == 1){
														echo "&#10004;";
													}else{
														echo "&#10006;";
													}
												?></td>
												<td><?php
													if($role_add == 1){
														echo "&#10004;";
													}else{
														echo "&#10006;";
													}
												?></td>
												<td><?php
													if($role_edit == 1){
														echo "&#10004;";
													}else{
														echo "&#10006;";
													}
												?></td>
												<td><?php
													if($role_delete == 1){
														echo "&#10004;";
													}else{
														echo "&#10006;";
													}
												?></td>
												<td><?php
													if($cost_price == 1){
														echo "&#10004;";
													}else{
														echo "&#10006;";
													}
													?></td>
												<td><?php
													if($whole_sale == 1){
														echo "&#10004;";
													}else{
														echo "&#10006;";
													}
													?></td>
												<td><?php
													if($variation == 1){
														echo "&#10004;";
													}else{
														echo "&#10006;";
													}
													?></td>
												<td><?php
													if($factor == 1){
														echo "&#10004;";
													}else{
														echo "&#10006;";
													}
													?></td>
											</tr>
											<?php
										}
									}
								}
							} ?>
							
						</tbody>
					</table>
				</div>
			</div>
				<!--- End Table ---------------->
		</div>
        
		
	</section><!-- /.content -->
		