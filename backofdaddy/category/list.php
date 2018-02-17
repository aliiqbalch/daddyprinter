<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	
	$sql =  "SELECT * FROM tbl_category ORDER BY cat_id DESC";
	$result     = dbQuery($dbConn, $sql);
	
	
?>
	<?php include(THEME_PATH . '/tb_link.php');?>
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Category Detail</h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid container_block">
			<?php
			if(modPerAdd($dbConn, "1")){ ?>
				<div class="row">
					<div class="col-md-6">
						<div style="margin: 10px 0px 0px 5px;">
							<button type="submit" name="btnButton"  class="butn" onclick="addCategory()"  ><i class="fa fa-plus"></i> Add Category</button>
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
								<th >Sr.No</th>
								<th >Title</th>
								<th >Image</th>
								<th >Description</th>
								<th >Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (dbNumRows($result) > 0) {
								$i = 1;
								while($row = dbFetchAssoc($result)){
									extract($row);
									 ?>
									<tr>
										<td><?php echo $i++;?></td>
										<td><?php echo $cat_title;?></td>
										<td>
											<?php  
												if ($cat_img != '') { ?>
													<img src="<?php echo WEB_ROOT."upload/category/". $row['cat_img']; ?>"  width="100px" height="70px"/>
													<?php 
												}else{ 
													echo "";
												}
											?>
										</td>
										<td><?php echo $cat_desc;?></td>
										<td>
											<?php if(modPerModify($dbConn,"1")){?>
											<a href="javascript:modifyCat(<?php echo $cat_id;?>)">
												<i class="fa fa-edit"></i>&nbsp;
											</a>
											<?php } if(modPerDelete($dbConn,"1")){?>
											<a href="javascript:deleteCat(<?php echo $cat_id;?>)">
												<i class="fa fa-trash"></i>
											</a>
									<?php }?>
										</td>
									</tr><?php
								}
							} ?>
							
						</tbody>
					</table>
				</div>
			</div>
				<!--- End Table ---------------->
		</div>
        
		
	</section><!-- /.content -->
		