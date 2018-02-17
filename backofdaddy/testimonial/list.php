<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	
	$sql =  "SELECT * FROM tbl_testimonial ORDER BY test_id DESC";
	$result     = dbQuery($dbConn, $sql);
	
	
?>
	<?php include(THEME_PATH . '/tb_link.php');?>
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Testimonials Detail</h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid container_block">
			<?php if(modPerView($dbConn,"")){?>
			<div class="row">
				<div class="col-md-6">
					<div style="margin: 10px 0px 0px 5px;">
						<button type="submit" name="btnButton"  class="butn" onclick="addTestimonials()"  ><i class="fa fa-plus"></i> Add Testimonials</button>
					</div>
				</div>
			</div>
			<?php }?>
			<div>
				<?php 
				if(isset($_SESSION['errorMessage']) && isset($_SESSION['count'])){
					if($_SESSION['count'] <= 1){
						$_SESSION['count'] +=1; ?>
						<div style="min-height:10px;"></div>
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
								<th >Sr.No</th>
								<th >Name</th>
								<th >Designation</th>
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
										<td><?php echo $test_name;?></td>
										<td><?php echo $test_desig;?></td>
										<td>
											<?php  
												if ($test_img != '') { ?>
													<img src="<?php echo WEB_ROOT."upload/testimonial/". $row['test_img']; ?>"  width="70px" height="70px"/>
													<?php 
												}else{  ?>
													<img src="<?php echo WEB_ROOT."upload/blank.jpg" ?>"  width="70px" height="70px"/> <?php
												}
											?>
										</td>
										<td><?php echo $test_desc;?></td>
										
										
										<td>
											<?php if(modPerModify($dbConn,"16")){?>
											<a href="javascript:modifyTes(<?php echo $test_id;?>)">
												<i class="fa fa-edit"></i>&nbsp;
											</a>
										<?php } if(modPerDelete($dbConn,"16")){?>
											<a href="javascript:deleteTes(<?php echo $test_id;?>)">
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
		