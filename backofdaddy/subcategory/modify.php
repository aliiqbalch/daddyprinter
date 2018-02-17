<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
	if(isset($_GET['SCI']) && ($_GET['SCI']) > 0){
		$SCI  = $_GET['SCI'];
	}else {
		redirect('index.php');
	}
	$sql = "SELECT * FROM tbl_sub_category WHERE sub_cat_id ='$SCI'";
	$result = dbQuery($dbConn, $sql);
	$row    = dbFetchAssoc($result);
	extract($row);
?>
	
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Modify Sub-Category</h1>
	</section>
	<!-- Main content -->
	<section class="content" >
		<!-- start any work here. -->
		<form name="frmAddMainNav" id="frmAddMainNav" method="post" action="processsubcat.php?action=modify"  enctype="multipart/form-data" onsubmit="return validate(this)">
			<input type="hidden" name="hidId" id="hidId"  value="<?php echo $SCI;?>"/>
            
			<div class="container-fluid container_block">
				<div class="row inner_heading">
					<h1>Modify Sub-Category Details</h1><hr>
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
					<div class="col-md-3 col-sm-6" style="margin-bottom:20px;">
						<label>Category:</label></br>
						<select name="txtCat" class="form-control" >
							<?php
							$sql = "SELECT * FROM tbl_category";
							$result = dbQuery($dbConn, $sql);
							if(dbNumRows($result) >0 ){
								while($row = dbFetchAssoc($result)) { ?>
									<option value="<?php echo $row['cat_id'];?>" <?php if($row['cat_id'] == $cat_id){echo "selected";}?> ><?php echo $row['cat_title'];?></option>
									<?php
								} //end while
							} ?>
						</select>
					</div>
					<div class="col-md-3 col-sm-6" style="margin-bottom:20px;">
						<label>Name</label></br>
						<input type="text" name="txtTitle" id="txtTitle" value="<?php echo $sub_cat_title;?>" class="formField" required="required"/>
					</div>
					<div class="col-md-3 col-sm-6" style="margin-bottom:30px;">
						<label>Image(263 X 263)</label></br>
						<input type="file" name="subcatImg" id="subcatImg"/><?php echo $sub_cat_img;?>
					</div>
					<div class="col-md-3 col-sm-6" style="margin-bottom:30px;">
						<label>Banner (850 X 230)</label></br>
						<input type="file" name="subcatbanner" id="subcatbanner"/><?php echo $sub_cat_banner;?>
					</div>
					<div class="col-md-12 col-sm-12" style="margin-bottom:20px;">
						<label>Description</label></br>
						<textarea name="txtdesc" class="form-control"><?php echo $sub_cat_desc;?></textarea>
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
		