<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	
?>
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Add Category</h1>
	</section>
	<!-- Main content -->
	<section class="content" >
		<!-- start any work here. -->
		<form name="frmAddMainNav" id="frmAddMainNav" method="post" action="processcat.php?action=add"  enctype="multipart/form-data" onsubmit="return validate(this)">
			
			<div class="container-fluid container_block">
				<div class="row inner_heading">
					<h1>Add Category Details</h1><hr>
				</div>
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
					<div class="col-md-6 col-sm-6" style="margin-bottom:20px;">
						<label>Category Name:</label></br>
						<input type="text" name="txtTitle" id="txtTitle" class="formField" required="required"/>
					</div>
					<div class="col-md-6 col-sm-6" style="margin-bottom:30px;">
						<label>Banner(849 X 227)</label></br>
						<input type="file" name="Catbanner" id="Catbanner"/>
					</div>
					<div class="col-md-12 col-sm-12" style="margin-bottom:20px;">
						<label>Description:</label></br>
						<textarea name="txtdesc" class="form-control"></textarea>
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
		