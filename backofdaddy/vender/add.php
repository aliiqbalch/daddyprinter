<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
?>
	
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Add Vender</h1>
	</section>
	<!-- Main content -->
	<section class="content" >
		<!-- start any work here. -->
		<form name="frmAddMainNav" id="frmAddMainNav" method="post" action="processven.php?action=add"  enctype="multipart/form-data" onsubmit="return validate(this)">
			<div class="container-fluid container_block">
				<div class="row inner_heading">
					<h1>Add Vender Details</h1><hr>
				</div>
				<div class="row">
					<div>
						<?php 
						if(isset($_SESSION['errorMessage']) && isset($_SESSION['count'])){
							if($_SESSION['count'] <= 1){
								$_SESSION['count'] +=1; ?>
								<div style="min-height:10px;"></div>
								<p class="errorText"><?php echo $_SESSION['errorMessage'];  ?></p> <?php
								unset($_SESSION['errorMessage']);
							}
						} ?>
					</div>
					<div class="col-md-4 col-sm-4" style="margin-bottom: 25px;">
						<label>Company Name</label></br>
						<input type="text" name="txtCompanyName" id="txtCompanyName" class="formField" required="required"/>
					</div>
					<div class="col-md-4 col-sm-4" style="margin-bottom: 25px;">
						<label>Name</label></br>
						<input type="text" name="txtVenName" id="txtVenName" class="formField" required="required"/>
					</div>
					<div class="col-md-4 col-sm-4" style="margin-bottom: 25px;">
						<label>Phone No</label></br>
						<input type="text" name="txtPhoneNo" id="txtPhoneNo" class="formField" required="required"/>
					</div>
					<div class="col-md-4 col-sm-4" style="margin-bottom: 25px;">
						<label>Email</label></br>
						<input type="email" name="txtEmail" id="txtEmail" class="formField" />
					</div>
					<div class="col-md-4 col-sm-4" style="margin-bottom: 25px;">
						<label>City</label></br>
						<input type="text" name="txtCity" id="txtCity" class="formField" required="required"/>
					</div>
					
					<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
						<label>Vender Image</label></br>
						<input type="file" name="venImg" id="venImg"/>
					</div>
					<div class="col-md-12 col-sm-12" style="margin-bottom: 25px;">
						<label>Address</label></br>
						<textarea name="txtAddress" class="formField" placeholder="Enter Address" required style="width: 95%;"></textarea>
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
		