<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
	if (isset($_GET['BankId']) && $_GET['BankId'] > 0) {
		$BankId = $_GET['BankId'];
	}else {
		// redirect to index.php if user id is not present
		redirect('index.php');
	}
	$sql = "SELECT * FROM tbl_bank WHERE bank_id = $BankId";
	$result = dbQuery($dbConn, $sql) ;
	$row    = dbFetchAssoc($result);
	extract($row);
?>
	
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Modify Bank</h1>
	</section>
	<!-- Main content -->
	<section class="content" >
		<!-- start any work here. -->
		<form name="frmAddMainNav" id="frmAddMainNav" method="post" action="processbank.php?action=modify"  enctype="multipart/form-data" onsubmit="return validate(this)">
			<input type="hidden" name="hidId" id="hidId"  value="<?php echo $bank_id;?>"/>
			
			<div class="container-fluid container_block">
				<div class="row inner_heading">
					<h1>Modify Bank Details</h1><hr>
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
						<input type="text" name="txtBankName" value="<?php echo $bank_name;?>" class="formField" required />
					</div>
					
					<div class="col-md-4 col-sm-2" style="margin-bottom: 25px;">
						<label>Bank Branch Name</label></br>
						<input type="text" name="txtBranchName" value="<?php echo $bank_branch_name;?>" class="formField" required />
					</div>
					<div class="col-md-4 col-sm-2" style="margin-bottom: 25px;">
						<label>Branch Code</label></br>
						<input type="number" name="txtBranchCode" value="<?php echo $bank_branch_code;?>" class="formField" required />
					</div>
					<div class="col-md-4 col-sm-2" style="margin-bottom: 25px;">
						<label>Account Title</label></br>
						<input type="text" name="txtAccTitle" value="<?php echo $bank_acount_title;?>" class="formField" required />
					</div>
					<div class="col-md-4 col-sm-2" style="margin-bottom: 25px;">
						<label>Account No</label></br>
						<input type="text" name="txtAccNo" value="<?php echo $bank_acount_no;?>" class="formField" required />
					</div>
					<div class="col-md-4 col-sm-2" style="margin-bottom: 25px;">
						<label>Current Blance</label></br>
						<input type="number" name="txtCurrBlance" value="<?php echo $bank_current_blance;?>" readonly class="formField" required />
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
		