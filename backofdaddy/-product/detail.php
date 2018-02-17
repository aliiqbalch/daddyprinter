<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

	if (isset($_GET['PI']) && $_GET['PI'] > 0) {
		$PI = $_GET['PI'];
	} else {
		// redirect to index.php if page id is not present
		redirect('index.php');
	}

	// get Page info
	$sql 	= 	"SELECT * FROM tbl_product WHERE pro_id = $PI";
	$result = 	 dbQuery($dbConn, $sql) ;
	$row    = 	 dbFetchAssoc($result);
	extract($row);
?> 
	<section class="content-header top_heading">
		<h1>Detail Product</h1>
	</section>
	<!-- Main content -->
	<section class="content" >
		
			<div class="container-fluid container_block">
				<div class="row inner_heading">
					<h1>Product Details</h1><hr>
				</div>
				<div class="space"></div>
				<div class="row" id="alertmsg" style="margin: 10px 0px 0px 5px;">
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
				<div class="row">
					
					<div class="col-md-8">
						<div class="row">
							<input type="hidden" name="txtfeature" class="formField" value="1" required="required"/>
							<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
								<label>Category:</label></br>
								<input type="text" class="formField" value="<?php categoryName($dbConn, $cat_id);?>" readonly />
							</div>
							<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
								<label>Sub-Category:</label></br>
								<input type="text" class="formField" value="<?php subcategoryName($dbConn, $sub_cat_id);?>" readonly />
								
							</div>
							<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
								<label>Title:</label></br>
								<input type="text" class="formField" value="<?php echo $pro_title;?>" readonly />
								
							</div>
							<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
								<label>Price:</label></br>
								<input type="text" class="formField" value="<?php echo $pro_price;?>" readonly />
								
							</div>
							<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
								<label>Minimum Quantity:</label></br>
								<input type="text" class="formField" value="<?php echo $pro_min_qty;?>" readonly />
								
							</div>
							<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
								<label>Multiple of:</label></br>
								<input type="text" class="formField" value="<?php echo $pro_multi_qty;?>" readonly />
								
							</div>
							<div id="offset" style="display:none;" >
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Printing Sheets per 1000 *:</label></br>
									<input type="text" class="formField" value="<?php echo $pro_print_sheet;?>" readonly />
								
								</div>
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Item/printed sheet *:</label></br>
									<input type="text" class="formField" value="<?php echo $pro_item_per_sheet;?>" readonly />
								
								</div>
							</div>
							<div id="outdoor" style="display:none;" >
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Length:</label></br>
									<input type="text" class="formField" value="<?php echo $pro_length;?>" readonly />
								
								</div>
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Width:</label></br>
									<input type="text" class="formField" value="<?php echo $pro_width;?>" readonly />
								
								</div>
							</div>
							
							
							<div class="col-md-12 col-sm-12" style="margin-bottom:20px;">
								<label>Description:</label></br>
								<textarea class="formField" readonly ><?php echo $pro_desc;?></textarea>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="row">
							<div class="col-md-12 col-sm-12" style="margin-bottom:30px;">
								<label>Main Image</label></br>
								<?php  
									if ($pro_main_img != '') { ?>
										<img src="<?php echo WEB_ROOT."upload/product/". $pro_main_img; ?>"  width="70px" height="70px"/>
										<?php 
									}else{ 
										echo "";
									}
								?>
							</div>
							<div class="col-md-12 col-sm-12" style="margin-bottom:30px;">
								<label>Image-1</label></br>
								<?php  
									if ($pro_img_1 != '') { ?>
										<img src="<?php echo WEB_ROOT."upload/product/". $pro_img_1; ?>"  width="70px" height="70px"/>
										<?php 
									}else{ 
										echo "";
									}
								?>
							</div>
							<div class="col-md-12 col-sm-12" style="margin-bottom:30px;">
								<label>Image-2</label></br>
								<?php  
									if ($pro_img_2 != '') { ?>
										<img src="<?php echo WEB_ROOT."upload/product/". $pro_img_2; ?>"  width="70px" height="70px"/>
										<?php 
									}else{ 
										echo "";
									}
								?>
							</div>
							<div class="col-md-12 col-sm-12" style="margin-bottom:30px;">
								<label>Image-3</label></br>
								<?php  
									if ($pro_img_3 != '') { ?>
										<img src="<?php echo WEB_ROOT."upload/product/". $pro_img_3; ?>"  width="70px" height="70px"/>
										<?php 
									}else{ 
										echo "";
									}
								?>
							</div>
							<div class="col-md-12 col-sm-12" style="margin-bottom:30px;">
								<label>Image-4</label></br>
								<?php  
									if ($pro_img_4 != '') { ?>
										<img src="<?php echo WEB_ROOT."upload/product/". $pro_img_4; ?>"  width="70px" height="70px"/>
										<?php 
									}else{ 
										echo "";
									}
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="row inner_heading">
					<h1>Variation Details</h1><hr>
					<div class="col-md-12">
						<?php
						$sql2 = "SELECT DISTINCT var_type_id FROM tbl_pro_var WHERE pro_id = '$PI'";
						$result2 = dbQuery($dbConn, $sql2);
						if(dbNumRows($result2) > 0){
							while($row2 = dbFetchAssoc($result2)){
								extract($row2); ?>
								<div class="panel newpanel panel-default">
									<div class="panel-heading">
										<label><?php variationtypeName($dbConn, $var_type_id); ?> - (<?php echo $var_type_id; ?>)</label>
									</div>
									<div class="panel-body" id="var_type" style="">
										<div class="table-responsive tbl-respon">
											<table class="table table-bordered table-striped tbl-respon2">
												<thead>
													<tr>
														<th >Variation Id</th>
														<th >Title</th>
														<th >Cost Price</th>
														<th >Whole Sale Price (25%)</th>
														<th >Retail Price (75%)</th>
														<th >Image</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$sql3 = "SELECT * FROM tbl_pro_var WHERE pro_id = '$PI' AND  var_type_id = '$var_type_id' ORDER BY var_type_id ASC";
													$result3 = dbQuery($dbConn, $sql3);
													if(dbNumRows($result3) > 0){
														while($row3 = dbFetchAssoc($result3)){
															extract($row3); ?>
															
															<tr>
																<td><?php echo  $var_id; ?></td>		
																<td><?php echo variationtitle($dbConn, $var_id);?></td>
																<td><input type="text" class="formField" value="<?php echo $pv_cost;?>" readonly /></td>		
																<td><input type="text" class="formField" value="<?php echo $pv_wholesale; ?>" readonly /></td>
																<td><input type="text" class="formField" value="<?php echo $pv_retail; ?>" readonly /></td>
																<td>
																	<?php  
																		$varimg = variationImg($dbConn, $var_id);
																		if (!empty($varimg)) { ?>
																			<img src="<?php echo WEB_ROOT."upload/variation/". $varimg; ?>"  width="50px" height="50px"/>
																			<?php 
																		}else{ 
																			echo "";
																		}
																	?>
																</td>
															</tr>
															<?php
														}
													} ?>
												</tbody>
											</table>
										</div>
									</div> 
									
									
									
								</div> <?php
							}
						}
						?>
					</div>
					
					
			
					
					
					
					
					
					
				</div>
				<div style="min-height: 20px;"></div>
			</div>
			<div class="row">
				<div class="col-md-offset-5 col-xs-offset-3 col-sm-offset-5">
					<input type="button" name="btnCanlce" value="Back" class="butn" onclick="window.location.href='index.php'"/>
				</div>
			</div>
		
	</section><!-- /.content -->
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	