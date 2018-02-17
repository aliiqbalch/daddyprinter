<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
?>

	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Add New Client</h1>
	</section>
	<!-- Main content -->
	<section class="content" >
		<!-- start any work here. -->
		<form action="processClient.php?action=add" method="post" enctype="multipart/form-data" name="frmAddAdmin" id="frmAddAdmin" onsubmit="return validate(this)">
			<div class="container-fluid container_block">
				<div class="row inner_heading">
					<h1>Client Details</h1><hr>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-4 mg_btm_30" >
						<label>Company Name:</label></br>
						<input type="text" name="txtCmpName" id="txtCmpName" class="formField" required="required" value="" />
					</div> 
					<div class="col-md-4 col-sm-4 mg_btm_30">
						<label>Name:</label></br>
						<input type="text" name="txtName" id="txtName" class="formField" required="required" value="" />
					</div>
					<div class="col-md-4 col-sm-4 mg_btm_30">
						<label>Mobile Number:</label></br>
						<input type="text" name="txtPhone" id="txtPhone" class="formField" required="required" value="" />
					</div> 
					<div class="col-md-4 col-sm-4 mg_btm_30">
						<label>Email:</label></br>
						<input type="email" name="txtEmail" id="txtEmail" class="formField" value="" />
					</div> 
					
					<div class="col-md-4 col-sm-4 mg_btm_30">
						<label>City:</label></br>
						<input type="text" name="txtCity" id="txtCity" class="formField" value="" required />
					</div> 
					<div class="col-md-4 col-sm-4 mg_btm_30">
						<div class="form-group">
							<label for="dtp_input2" class="control-label">Next Follow Up Date:</label><br>
							<div class="input-group date form_datetime" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>                   
								<input class="form-control" size="16" type="text" value="" name="txtFolowDate" >
							</div>
							<input type="hidden" id="dtp_input2" value="" /><br/>
						</div>
					</div> 
					<div class="col-md-12 col-sm-12 mg_btm_30">
						<label>Address:</label></br>
						<textarea name="txtAddress" class="formField" ></textarea>
					</div>
					
					<div class="col-md-12 col-sm-12 mg_btm_30">
						<label>Notes:</label></br>
						<textarea name="txtNotes" class="formField" ></textarea>
					</div>
							
				</div>
				
			</div>
			<div class="row">
				<div class="col-md-offset-5 col-xs-offset-3 col-sm-offset-5">
					<input type="submit" name="btnButton" value="Save" class="butn" /> &nbsp;
					<input type="button" name="btnCanlce" value="Cancel" class="butn" onclick="window.location.href='index.php'"/>
				</div>
			</div>
		</form>
	</section><!-- /.content -->
		