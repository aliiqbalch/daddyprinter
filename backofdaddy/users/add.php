<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
?>

	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Add New User / Admin</h1>
	</section>
	<!-- Main content -->
	<section class="content" >
		<!-- start any work here. -->
		<form action="processAdmin.php?action=add" method="post" enctype="multipart/form-data" name="frmAddAdmin" id="frmAddAdmin" onsubmit="return validate(this)">
			<div class="container-fluid container_block">
				<div class="row inner_heading">
					<h1>User Details</h1><hr>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-4 mg_btm_30" >
						<label>Department</label></br>
						<select name="txtDepId" id="txtDepId" class="formField">
							<option value="0">--Select--</option>
							<?php departmentsName($dbConn); ?>
						</select>
					</div>
					<div class="col-md-4 col-sm-4 mg_btm_30" >
						<label>User Level</label></br>
						<select name="txtDesgId" id="txtDesgId" class="formField">
							<option value="0">--Select--</option>
							<?php designationName($dbConn); ?>
						</select>
					</div> 
					<div class="col-md-4 col-sm-4 mg_btm_30">
						<label>User Name:</label></br>
						<input type="text" name="txtUserName" id="txtUserName" class="formField" required="required" value="" />
					</div>
					<div class="col-md-4 col-sm-4 mg_btm_30">
						<label>User Password:</label></br>
						<input type="text" name="txtPassword" id="txtPassword" class="formField" required="required" value="daddyprinter" />
					</div>
					<div class="col-md-4 col-sm-4 mg_btm_30">
						<label>Mobile No:</label></br>
						<input type="text" name="txtMob" id="txtMob" class="formField" required="required" value="" />
					</div> 
					<div class="col-md-4 col-sm-4 mg_btm_30">
						<label>Family Mobile Number:</label></br>
						<input type="text" name="txtFamMob" id="txtFamMob" class="formField" required="required" value="" />
					</div> 
					<div class="col-md-4 col-sm-4 mg_btm_30">
						<label>City</label></br>
						<input type="text" name="txtCity" id="txtCity" class="formField" value="" />
					</div> 
					<div class="col-md-4 col-sm-4 mg_btm_30">
						<label>Email</label></br>
						<input type="email" name="txtEmail" id="txtEmail" class="formField" value="" />
					</div> 
					<div class="col-md-4 col-sm-4 mg_btm_30">
						<label>CNIC</label></br>
						<input type="text" name="txtCnic" id="txtCnic" class="formField" value="" />
					</div> 
					<div class="col-md-4 col-sm-4 mg_btm_30">
						<label>Image </label></br>
						<input type="file" name="txtImage" id="txtImage" />
					</div>	
					
					<div class="col-md-8 col-sm-8 mg_btm_30">
						<label>Address</label></br>
						<textarea name="txtAddress" class="formField" ></textarea>
					</div>
					<div class="col-md-4 col-sm-4 mg_btm_30">
						<label>Status :</label></br>
						<input type="radio" name="radStatus" id="radStatus" value="1" checked="checked" />
						<span class="txtDarkGray14">Active</span> &nbsp;
						<input type="radio" name="radStatus" id="radStatus" value="0" />
						<span class="txtDarkGray14">In Active</span>
					</div>			
				</div>
				
			</div>
			<div class="row">
				<div class="col-md-offset-5 col-xs-offset-3 col-sm-offset-5">
					<input type="submit" name="btnButton" value="Save" class="butn" /> &nbsp;
				</div>
			</div>
		</form>
	</section><!-- /.content -->
		