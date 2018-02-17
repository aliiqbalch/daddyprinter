<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	
?>
	
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Add Product Variation</h1>
	</section>
	<!-- Main content -->
	<section class="content" >
		<!-- start any work here. -->
		<form name="frmAddMainNav" id="frmAddMainNav" method="post" action="processpro.php?action=provar"  enctype="multipart/form-data" onsubmit="return validate(this)">
			<input type="hidden" value="<?php lastproductid($dbConn); ?>" name="txtProId" />
			<div class="container-fluid container_block">
				<div class="row inner_heading">
					<h1>Add Product Variation Details</h1><hr>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="allstep" >
							<h2>Step 1</h2>
							<p>Add Product</p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="allstep" >
							<h2>Step 2</h2>
							<p>Add Variation Type</p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="allstep" id="allstepactive" >
							<h2>Step 3</h2>
							<p>Add Variation</p>
						</div>
					</div>
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
					<div class="col-md-12">
						<?php 
						$vtype_id = $_SESSION['vtype_id'];
						foreach($vtype_id as $VarTypeId) { ?>
							<div class="panel newpanel panel-default">
								<div class="panel-heading">
									<label><?php variationtypeName($dbConn, $VarTypeId); ?></label>
								</div>
								<div class="panel-body" id="var_type" style="">
									<div class="table-responsive tbl-respon">
										<table class="table table-bordered table-striped tbl-respon2">
											<thead>
												<tr>
													<th >Add</th>
													<th >Title</th>
													<th >Cost Price</th>
													<th >Whole Sale Price (25%)</th>
													<th >Retail Price (75%)</th>
													<th >Image</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$sql = "SELECT * FROM tbl_variation WHERE var_type_id = '$VarTypeId' ORDER BY var_id ASC";
												$result = dbQuery($dbConn, $sql);
												if(dbNumRows($result) >0){
													while($row = dbFetchAssoc($result)){
														extract($row); ?>
														<script>
															function pricedouble<?php echo $var_id; ?>(){
																var txtCostP<?php echo $var_id; ?> = document.getElementById("cost_price<?php echo $var_id; ?>").value;
																//alert(txtCostP<?php echo $var_id; ?>);
																var twntyfive<?php echo $var_id; ?> = 25 / 100 * txtCostP<?php echo $var_id; ?>;
																var sevntyfive<?php echo $var_id; ?> = 75 / 100 * txtCostP<?php echo $var_id; ?>;
																var wholesale<?php echo $var_id; ?> = +txtCostP<?php echo $var_id; ?> + +twntyfive<?php echo $var_id; ?>.toFixed(4);
																var retailp<?php echo $var_id; ?> = +txtCostP<?php echo $var_id; ?> + +sevntyfive<?php echo $var_id; ?>.toFixed(4);
																
																document.frmAddMainNav.txtWholesaleP<?php echo $var_id; ?>.value = wholesale<?php echo $var_id; ?>;
																document.frmAddMainNav.txtRetailp<?php echo $var_id; ?>.value= retailp<?php echo $var_id; ?>;
															}
														</script>
														<tr>
															<td><input type="checkbox" id="var_id<?php echo $var_id; ?>" name="variation<?php echo $var_id; ?>"  value="1" /></td>		
															<td><?php echo $var_title;?></td>
															<td><input type="text" class="formField" id="cost_price<?php echo $var_id;?>" value="" name="cost_price<?php echo $var_id; ?>" onchange="pricedouble<?php echo $var_id; ?>()" /></td>		
															<td><input type="text" class="formField" id="txtWholesaleP<?php echo $var_id; ?>" value="" name="wholesale_price<?php echo $var_id; ?>" /></td>
															<td><input type="text" class="formField" id="txtRetailp<?php echo $var_id; ?>" value="" name="retail_price<?php echo $var_id; ?>" /></td>
															<td>
																<?php  
																	if ($var_img != '') { ?>
																		<img src="<?php echo WEB_ROOT."upload/variation/". $row['var_img']; ?>"  width="50px" height="50px"/>
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
							</div>  <?php
						} ?>
					
					
						
						
					</div>
				</div>
				<div style="min-height: 20px;"></div>
			</div>
			<div class="row">
				<div class="col-md-offset-5 col-xs-offset-3 col-sm-offset-5">
					<input type="submit" name="btnButton" value="Save" class="butn" /> &nbsp;
					<input type="button" name="btnCanlce" value="Back" class="butn" onclick="window.location.href='index.php'"/>
				</div>
			</div>
		</form>
	</section><!-- /.content -->
		