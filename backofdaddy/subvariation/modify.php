<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
	if(isset($_GET['VarId']) && ($_GET['VarId']) > 0){
		$VarId  = $_GET['VarId'];
	}else {
		redirect('index.php');
	}
	$sql = "SELECT * FROM tbl_variation WHERE var_id ='$VarId'";
	$result = dbQuery($dbConn, $sql);
	$row    = dbFetchAssoc($result);
	extract($row);
?>
	<script>
	function pricedouble(){
		var txtCostP = document.getElementById("txtCostP").value;
		var twntyfive = 25 / 100 * txtCostP;
		var sevntyfive = 75 / 100 * txtCostP;
		var wholesale = +txtCostP + +twntyfive;
		var retailp = +txtCostP + +sevntyfive;
		document.frmAddMainNav.txtWholesaleP.value = wholesale;
		document.frmAddMainNav.txtRetailp.value= retailp;
	}
	</script>
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Modify Variation</h1>
	</section>
	<!-- Main content -->
	<section class="content" >
		<!-- start any work here. -->
		<form name="frmAddMainNav" id="frmAddMainNav" method="post" action="processvar.php?action=modify"  enctype="multipart/form-data" onsubmit="return validate(this)">
			<input type="hidden" name="hidId" id="hidId"  value="<?php echo $VarId;?>"/>
            
			<div class="container-fluid container_block">
				<div class="row inner_heading">
					<h1>Modify Variation Details</h1><hr>
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
					<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
						<label>Variation Type:</label></br>
						<select name="txtVarType" class="form-control" >
							<?php
							$sql = "SELECT * FROM tbl_variation_type ";
							$result = dbQuery($dbConn, $sql);
							if(dbNumRows($result) >0 ){
								while($row = dbFetchAssoc($result)) { ?>
									<option value="<?php echo $row['var_type_id'];?>" <?php if($row['var_type_id'] == $var_type_id){echo "selected";}?> ><?php echo $row['var_type_title'];?></option>		
									<?php
								} //end while
							} ?>
						</select>
					</div>
					<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
						<label>Title</label></br>
						<input type="text" name="txtTitle" id="txtTitle" value="<?php echo $var_title;?>" class="formField" required="required"/>
					</div>
					<div class="col-md-4 col-sm-4" style="margin-bottom:30px;">
						<label>Image</label></br>
						<input type="file" name="varImg" id="varImg"/><?php echo $var_img;?>
					</div>
					<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
						<label>Sub Variation Exist:</label></br>
						<div class="radio">
							<label><input type="radio" name="txtSVexist" value="0" <?php if($var_flag== 0){echo "checked"; }?>>No</label>&nbsp;&nbsp;
							<label><input type="radio" name="txtSVexist" value="1" <?php if($var_flag== 1){echo "checked"; }?>>Yes</label>
						</div>
					</div>
					<div class="col-md-12 col-sm-12" style="margin-bottom:20px;">
						<label>Description</label></br>
						<textarea name="txtdesc" class="form-control"><?php echo $var_desc;?></textarea>
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
		