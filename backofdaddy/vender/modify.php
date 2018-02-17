<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
	if (isset($_GET['VenId']) && $_GET['VenId'] > 0) {
		$VenId = $_GET['VenId'];
	}else {
		// redirect to index.php if user id is not present
		redirect('index.php');
	}
	$sql = "SELECT * FROM tbl_vender WHERE ven_id = $VenId";
	$result = dbQuery($dbConn, $sql) ;
	$row    = dbFetchAssoc($result);
	extract($row);
?>
	
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Modify Vender</h1>
	</section>
	<!-- Main content -->
	<section class="content" >
		<!-- start any work here. -->
		<form name="frmAddMainNav" id="frmAddMainNav" method="post" action="processven.php?action=modify"  enctype="multipart/form-data" onsubmit="return validate(this)">
			<input type="hidden" name="hidId" id="hidId"  value="<?php echo $ven_id;?>"/>
			
			<div class="container-fluid container_block">
				<div class="row inner_heading">
					<h1>Modify Vender Details</h1><hr>
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
					<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
						<label>Company Name</label></br>
						<input type="text" name="txtCompanyName" id="txtCompanyName" value="<?php echo $ven_cmp_name;?>" class="formField" required="required"/>
					</div>
					<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
						<label>Name</label></br>
						<input type="text" name="txtVenName" id="txtVenName" value="<?php echo $ven_name;?>" class="formField" required="required"/>
					</div>
					<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
						<label>Phone No</label></br>
						<input type="text" name="txtPhoneNo" id="txtPhoneNo"  value="<?php echo $phone;?>"class="formField" required="required"/>
					</div>
					<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
						<label>Email</label></br>
						<input type="email" name="txtEmail" id="txtEmail" value="<?php echo $email;?>" class="formField" />
					</div>
					<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
						<label>City</label></br>
						<input type="text" name="txtCity" id="txtCity" value="<?php echo $city;?>" class="formField" required="required"/>
					</div>
					<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
						<label>Image</label></br>
						<input type="file" name="venImg" id="venImg"/><?php echo $pic;?>
					</div>
					<div class="col-md-12 col-sm-12" style="margin-bottom: 25px;">
						<label>Address</label></br>
						<textarea name="txtAddress" class="formField" placeholder="Enter Address" required style="width: 95%;"><?php echo $address;?></textarea>
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
		