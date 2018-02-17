<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
	if (isset($_GET['ConId']) && $_GET['ConId'] > 0) {
		$ConId = $_GET['ConId'];
	}else {
		// redirect to index.php if user id is not present
		redirect('index.php');
	}
	$sql = "SELECT * FROM tbl_contact WHERE con_id = '$ConId'";
	$result = dbQuery($dbConn, $sql);
	$row    = dbFetchAssoc($result);
	extract($row);
?>
	
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Email Reply</h1>
	</section>
	<!-- Main content -->
	<section class="content" >
		<!-- start any work here. -->
		<form name="frmAddMainNav" id="frmAddMainNav" method="post" action="processfeedback.php?action=replyemail"  enctype="multipart/form-data" onsubmit="return validate(this)">
			<div class="container-fluid container_block">
				<div class="row inner_heading">
					<h1>Email Details</h1><hr>
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
					<div class="col-md-6 col-sm-6">
						<label>To : Email</label></br>
						<input type="text" name="txtEmailid" id="txtEmailid" value="<?php echo $con_email;?>" class="formField" style="width:300px;" readonly />
					</div>
					
					<div class="col-md-6 col-sm-6">
						<label>Message :</label></br>
						<textarea class="form-control" name="txtmessage" placeholder="Write Text Here" required></textarea>
					</div>
				</div>
				<div style="min-height: 20px;"></div>
			</div>
			<div class="row">
				<div class="col-md-offset-5 col-xs-offset-3 col-sm-offset-5">
					<input type="submit" name="btnButton" value="Send Message" class="butn" /> &nbsp;
					<input type="button" name="btnCanlce" value="Back" class="butn" onclick="window.location.href='index.php'"/>
				</div>
			</div>
		</form>
	</section><!-- /.content -->
		