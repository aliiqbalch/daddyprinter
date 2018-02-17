<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	
?>
	
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Add Variation Type</h1>
	</section>
	<!-- Main content -->
	<section class="content" >
		<!-- start any work here. -->
		<form name="frmAddMainNav" id="frmAddMainNav" method="post" action="processpro.php?action=vartype"  enctype="multipart/form-data" onsubmit="return validate(this)">
			<input type="hidden" value="<?php lastproductid($dbConn); ?>" name="txtProId" />
			<div class="container-fluid container_block">
				<div class="row inner_heading">
					<h1>Add Variation Type Details</h1><hr>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="allstep" >
							<h2>Step 1</h2>
							<p>Add Product</p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="allstep" id="allstepactive" >
							<h2>Step 2</h2>
							<p>Add Variation Type</p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="allstep">
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
						<div class="row">
							<?php 
							$sql = "SELECT * FROM tbl_variation_type ORDER BY var_type_id DESC";
							$result = dbQuery($dbConn, $sql);
							if(dbNumRows($result) > 0){
								while($row = dbFetchAssoc($result)){
									extract($row); ?>
									<div class="col-md-6">
										<div class="panel panel-danger">
											<div class="panel-heading">
												<div class="checkbox">
													<label><input type="checkbox" name="vtype_id[]" value="<?php echo $var_type_id; ?>"><?php echo $var_type_title;?></label>
												</div>
											</div>
										</div> 
									</div>
									<?php
								}
							}
							?>
						</div>
						
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
		