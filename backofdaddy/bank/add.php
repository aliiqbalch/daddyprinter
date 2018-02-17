<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
?>
	
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Add Bank Detail</h1>
	</section>
	<!-- Main content -->
	<section class="content" >
		<!-- start any work here. -->
		<form name="frmAddMainNav" id="frmAddMainNav" method="post" action="processbank.php?action=add"  enctype="multipart/form-data" onsubmit="return validate(this)">
			<div class="container-fluid container_block">
				<div class="row inner_heading">
					<h1>Add Bank Details</h1><hr>
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
					<div class="col-md-4 col-sm-2" style="margin-bottom: 25px;">
						<label>Bank Name</label></br>
						<input type="text" name="txtBankName" class="formField" required />
					</div>
					
					<div class="col-md-4 col-sm-2" style="margin-bottom: 25px;">
						<label>Bank Branch Name</label></br>
						<input type="text" name="txtBranchName" class="formField" required />
					</div>
					<div class="col-md-4 col-sm-2" style="margin-bottom: 25px;">
						<label>Branch Code</label></br>
						<input type="number" name="txtBranchCode" class="formField" required />
					</div>
					<div class="col-md-4 col-sm-2" style="margin-bottom: 25px;">
						<label>Account Title</label></br>
						<input type="text" name="txtAccTitle" class="formField" required />
					</div>
					<div class="col-md-4 col-sm-2" style="margin-bottom: 25px;">
						<label>Account No</label></br>
						<input type="text" name="txtAccNo" class="formField" required />
					</div>
					<div class="col-md-4 col-sm-2" style="margin-bottom: 25px;">
						<label>Current Blance</label></br>
						<input type="number" name="txtCurrBlance" class="formField" required />
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
		