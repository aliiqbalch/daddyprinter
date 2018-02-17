<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
	if(isset($_GET['TestId']) && ($_GET['TestId']) > 0){
		$TestId  = $_GET['TestId'];
	}else {
		redirect('index.php');
	}
	$sql = "SELECT * FROM tbl_testimonial WHERE test_id ='$TestId'";
	$result = dbQuery($dbConn, $sql);
	$row    = dbFetchAssoc($result);
	extract($row);
?>
	
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Modify Testimonial</h1>
	</section>
	<!-- Main content -->
	<section class="content" >
		<!-- start any work here. -->
		<form name="frmAddMainNav" id="frmAddMainNav" method="post" action="processtesti.php?action=modify"  enctype="multipart/form-data" onsubmit="return validate(this)">
			<input type="hidden" name="HidId" id="hidId"  value="<?php echo $TestId;?>"/>
            
			<div class="container-fluid container_block">
				<div class="row inner_heading">
					<h1>Modify Testimonial Details</h1><hr>
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
						<label>Name</label></br>
						<input type="text" name="txtTitle" id="txtTitle" value="<?php echo $test_name;?>" class="formField" required="required"/>
					</div>
					<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
						<label>Designation</label></br>
						<input type="text" name="txtDesignation" id="txtDesignation" value="<?php echo $test_desig;?>" class="formField" required="required"/>
					</div>
                    <div class="col-md-4 col-sm-4" style="margin-bottom:30px;">
						<label>Image (158 X 158)</label></br>
						<input type="file" name="workImg" id="workImg"/><?php echo $test_img;?>
					</div>
					<div class="col-md-12 col-sm-12" style="margin-bottom:20px;">
						<label>Description</label></br>
						<textarea name="txtdesc" class="form-control"><?php echo $test_desc;?></textarea>
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
		