<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	
?>
	<script>
	function sall(oid){
		modId = 'mod_'+oid;
		var a = document.getElementById(modId).checked;
		if(oid == 7){
			if(a){
				document.getElementById('view_'+oid).checked=true;
				document.getElementById('add_'+oid).checked=true;
				document.getElementById('update_'+oid).checked=true;
				document.getElementById('delete_'+oid).checked=true;
				document.getElementById('costPrice_'+oid).checked=true;
				document.getElementById('wholeSale_'+oid).checked=true;
				document.getElementById('variation_'+oid).checked=true;
			}else{
				document.getElementById('view_'+oid).checked = false;
				document.getElementById('add_'+oid).checked = false;
				document.getElementById('update_'+oid).checked = false;
				document.getElementById('delete_'+oid).checked = false;
				document.getElementById('costPrice_'+oid).checked=false;
				document.getElementById('wholeSale_'+oid).checked=false;
				document.getElementById('variation_'+oid).checked=false;
			}
		}else if(oid == 8){
			if(a){
				document.getElementById('view_'+oid).checked=true;
				document.getElementById('add_'+oid).checked=true;
				document.getElementById('update_'+oid).checked=true;
				document.getElementById('delete_'+oid).checked=true;
				document.getElementById('costPrice_'+oid).checked=true;
				document.getElementById('wholeSale_'+oid).checked=true;
				document.getElementById('factor_'+oid).checked=true;
			}else{
				document.getElementById('view_'+oid).checked = false;
				document.getElementById('add_'+oid).checked = false;
				document.getElementById('update_'+oid).checked = false;
				document.getElementById('delete_'+oid).checked = false;
				document.getElementById('costPrice_'+oid).checked=false;
				document.getElementById('wholeSale_'+oid).checked=false;
				document.getElementById('factor_'+oid).checked=false;
			}
		}else{
			if(a){
				document.getElementById('view_'+oid).checked=true;
				document.getElementById('add_'+oid).checked=true;
				document.getElementById('update_'+oid).checked=true;
				document.getElementById('delete_'+oid).checked=true;
			}else{
				document.getElementById('view_'+oid).checked = false;
				document.getElementById('add_'+oid).checked = false;
				document.getElementById('update_'+oid).checked = false;
				document.getElementById('delete_'+oid).checked = false;
			}
		}

	}
    </script>
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Add Role</h1>
	</section>
	<!-- Main content -->
	<section class="content" >
		<!-- start any work here. -->
		<form name="frmAddMainNav" id="frmAddMainNav" method="post" action="processrol.php?action=add"  enctype="multipart/form-data" onsubmit="return validate(this)">
			
			<div class="container-fluid container_block">
				<div class="row inner_heading">
					<h1>Permission Level</h1><hr>
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
					<div class="col-md-offset-1 col-md-5">
						<label>Select Designation:</label></br>
						<select name="txtdesigId" class="formField">
							<?php designationName($dbConn); ?>
						</select>
					</div>
					
					<?php
					$sql = "SELECT * FROM tbl_module ORDER BY mod_id ASC";
					$result = dbQuery($dbConn, $sql);
					if(dbNumRows($result) > 0){
						while($row = dbFetchAssoc($result) ){ 
							extract($row);?>
							<div class="col-md-offset-1 col-md-11">
								<h3><?php echo $mod_title;?></h3>
							</div>
							<div class="col-md-offset-1 <?php if($mod_id == 7 || $mod_id == 8){echo "col-sm-1";}else{echo"col-sm-2";} ?> col-sm-2" style="margin-bottom:20px;">
								<div class="checkbox">
									<label><input type="checkbox" value="1" name="view_<?php echo $mod_id;?>" id="view_<?php echo $mod_id;?>" >View</label>
								</div>
							</div>
							<div class="<?php if($mod_id == 7 || $mod_id == 8){echo "col-sm-1";}else{echo"col-sm-2";} ?>" style="margin-bottom:20px;">
								<div class="checkbox">
									<label><input type="checkbox" value="1" name="add_<?php echo $mod_id;?>" id="add_<?php echo $mod_id;?>" >Add</label>
								</div>
							</div>
							<div class="<?php if($mod_id == 7 || $mod_id == 8){echo "col-sm-1";}else{echo"col-sm-2";} ?>" style="margin-bottom:20px;">
								<div class="checkbox">
									<label><input type="checkbox" value="1" name="update_<?php echo $mod_id;?>" id="update_<?php echo $mod_id;?>" >Update / Edit</label>
								</div>
							</div>
							<div class="<?php if($mod_id == 7 || $mod_id == 8){echo "col-sm-1";}else{echo"col-sm-2";} ?>" style="margin-bottom:20px;">
								<div class="checkbox">
									<label><input type="checkbox" value="1" name="delete_<?php echo $mod_id;?>" id="delete_<?php echo $mod_id;?>" >Delete</label>
								</div>
							</div>
							<?php if($mod_id == 7){

								?>
								<div class="<?php if($mod_id == 7 || $mod_id == 8){echo "col-sm-1";}else{echo"col-sm-2";} ?>" style="margin-bottom:20px;">
									<div class="checkbox">
										<label><input type="checkbox" value="1" name="costPrice_<?php echo $mod_id;?>" id="costPrice_<?php echo $mod_id;?>" >CostPrice</label>
									</div>
								</div>
								<div class="<?php if($mod_id == 7 || $mod_id == 8){echo "col-sm-1";}else{echo"col-sm-2";} ?>" style="margin-bottom:20px;">
									<div class="checkbox">
										<label><input type="checkbox" value="1" name="wholeSale_<?php echo $mod_id;?>" id="wholeSale_<?php echo $mod_id;?>" >WholeSale</label>
									</div>
								</div>
								<div class="<?php if($mod_id == 7 || $mod_id == 8){echo "col-sm-2";}else{echo"col-sm-2";} ?>" style="margin-bottom:20px;">
									<div class="checkbox">
										<label><input type="checkbox" value="1" name="variation_<?php echo $mod_id;?>" id="variation_<?php echo $mod_id;?>" >Variation</label>
									</div>
								</div>
								<?php
							}
							if($mod_id == 8){
								?>
								<div class="<?php if($mod_id == 7 || $mod_id == 8){echo "col-sm-1";}else{echo"col-sm-2";} ?>" style="margin-bottom:20px;">
									<div class="checkbox">
										<label><input type="checkbox" value="1" name="costPrice_<?php echo $mod_id;?>" id="costPrice_<?php echo $mod_id;?>" >CostPrice</label>
									</div>
								</div>
								<div class="<?php if($mod_id == 7 || $mod_id == 8){echo "col-sm-1";}else{echo"col-sm-2";} ?>" style="margin-bottom:20px;">
									<div class="checkbox">
										<label><input type="checkbox" value="1" name="wholeSale_<?php echo $mod_id;?>" id="wholeSale_<?php echo $mod_id;?>" >WholeSale</label>
									</div>
								</div>
								<div class="<?php if($mod_id == 7 || $mod_id == 8){echo "col-sm-2";}else{echo"col-sm-2";} ?>" style="margin-bottom:20px;">
									<div class="checkbox">
										<label><input type="checkbox" value="1" name="factor_<?php echo $mod_id;?>" id="factor_<?php echo $mod_id;?>" >Factor</label>
									</div>
								</div>
								<?php
							}?>
							<div class="col-md-2 col-sm-2" style="margin-bottom:20px;">
								<div class="checkbox">
									<label><input type="checkbox" value="1" name="mod_<?php echo $mod_id;?>" id="mod_<?php echo $mod_id;?>" onclick="sall('<?php echo $mod_id;?>')" >Check / Uncheck All</label>
								</div>
							</div> <?php
							
						}
					}
					?>
					
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
		