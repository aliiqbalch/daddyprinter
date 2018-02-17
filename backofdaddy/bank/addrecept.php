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
?>
	
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Add Account Recept Detail</h1>
	</section>
	<!-- Main content -->
	<section class="content" >
		<!-- start any work here. -->
		<form name="frmAddMainNav" id="frmAddMainNav" method="post" action="processbank.php?action=addrecept"  enctype="multipart/form-data" onsubmit="return validate(this)">
			<input type="hidden" name="hidId" id="hidId"  value="<?php echo $BankId;?>"/>
			<div class="container-fluid container_block">
				<div class="row inner_heading">
					<h1>Add Account Recept Details</h1><hr>
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
						<input type="text" name="txtBankName" value="<?php BankName($dbConn, $BankId);?>" readonly class="formField" required />
					</div>
					
					<div class="col-md-4 col-sm-2" style="margin-bottom: 25px;">
						<label>Debit / Credit Date</label></br>
						<div class="controls input-append date form_date" data-date="" data-date-format="dd-mm-yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
							<input type="text" name="txtDcDate" id="txtJoinDate" class="formField"  readonly required="required"/>
							<span class="add-on"><i class="icon-remove"></i></span>
							<span class="add-on"><i class="icon-th"></i></span>
						</div>
						<input type="hidden" id="dtp_input2" value="" />
					</div>
					<div class="col-md-4 col-sm-2" style="margin-bottom: 25px;">
						<label>Time</label></br>
						<div class="input-group date form_time_3" data-date="" data-date-format="HH:ii P" data-link-format="HH:ii p" data-link-field="dtp_input1" >
							<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>                  
							<input class="formField" name="txtDcTime" type="text" value="">
						</div>
						<input type="hidden" id="dtp_input3" value="" />
					</div>
					<div class="col-md-4 col-sm-2" style="margin-bottom: 25px;">
						<label>Acount Type</label></br>
						<select name="txtAcoutnType" class="formField" style="width: 180px;">
							<option value="1">Debit</option>
							<option value="0">Credit</option>
						</select>
					</div>
					<div class="col-md-4 col-sm-2" style="margin-bottom: 25px;">
						<label>Amount Rs</label></br>
						<input type="number" name="txtAmount" class="formField" required />
					</div>
					<div class="col-md-4 col-sm-2" style="margin-bottom: 25px;">
						<label>Amount Description</label></br>
						<textarea name="txtdescrption" class="formField" required></textarea>
					</div>
				</div>
				<div style="min-height: 20px;"></div>
			</div>
			<div class="row">
				<div class="col-md-offset-5 col-xs-offset-3 col-sm-offset-5">
					<input type="submit" name="btnButton" value="Save" class="butn" /> &nbsp;
					<input type="button" name="btnCanlce" value="Back" class="butn" onclick="window.location.href='index.php?view=accdetail&BankId=<?php echo $BankId;?>'"/>
				</div>
			</div>
		</form>
	</section><!-- /.content -->
		