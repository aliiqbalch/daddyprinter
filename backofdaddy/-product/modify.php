<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
	if(isset($_GET['PI']) && ($_GET['PI']) > 0){
		$PI  = $_GET['PI'];
	}else {
		redirect('index.php');
	}
	$sql = "SELECT * FROM tbl_product WHERE pro_id ='$PI'";
	$result = dbQuery($dbConn, $sql);
	$row    = dbFetchAssoc($result);
	extract($row);
?>
	<script>
	
	function showSubCategory(CatId) {
		
		if (CatId == "") {
			document.getElementById("txtsubCat").innerHTML = "";
			return;
		} else { 
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("txtsubCat").innerHTML = this.responseText;
				}
			};
			xmlhttp.open("GET","getsubcat.php?CatId=" + CatId,true);
			xmlhttp.send();
		}
		
		if(CatId == 1){
			$("#offset").css("display", "inline");
			$("#txtPrice").css("display", "inline");
			$("#txtMinqty").css("display", "inline");
			$("#txtMultiqty").css("display", "inline");
		}
		else{
			$("#offset").css("display", "none");
		}
		if(CatId == 3){
			$("#outdoor").css("display", "inline");
			$("#txtPrice").css("display", "inline");
			$("#txtMinqty").css("display", "inline");
			$("#txtMultiqty").css("display", "inline");
		}
		else{
			$("#outdoor").css("display", "none");
		}
		
		if(CatId == 4){
			$("#promotional").css("display", "inline");
			$("#txtPrice").css("display", "none");
			$("#txtMinqty").css("display", "none");
			$("#txtMultiqty").css("display", "none");
		}
		else{
			$("#promotional").css("display", "none");
		}
	}
	
	
	</script>
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading" >
		<h1>Modify Product</h1>
	</section>
	<!-- Main content -->
	<section class="content" >
		<!-- start any work here. -->
		<form name="frmAddMainNav" id="frmAddMainNav" method="post" action="processpro.php?action=modify"  enctype="multipart/form-data" onsubmit="return validate(this)">
			<input type="hidden" name="hidId" id="hidId"  value="<?php echo $PI;?>"/>
            
			<div class="container-fluid container_block">
				<div class="row inner_heading">
					<h1>Modify Product Details</h1><hr>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="allstep" id="allstepactive" >
							<h2>Step 1</h2>
							<p>Modify Product</p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="allstep">
							<h2>Step 2</h2>
							<p>Modify Variation Type</p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="allstep">
							<h2>Step 3</h2>
							<p>Modify Variation</p>
						</div>
					</div>
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
					<div class="col-md-8">
						<div class="row">
							<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
								<label>Category:</label></br>
								<select name="txtCat" class="form-control" onchange="showSubCategory(this.value)" >
									<?php
									$sql2 = "SELECT * FROM tbl_category ";
									$result2 = dbQuery($dbConn, $sql2);
									if(dbNumRows($result2) > 0 ){
										while($row2 = dbFetchAssoc($result2)) { ?>
											<option value="<?php echo $row2['cat_id'];?>" <?php if($row2['cat_id'] == $cat_id){echo "selected";}?> ><?php echo $row2['cat_title'];?></option>
											<?php
										} //end while
									} ?>
								</select>
								
							</div>
							
							<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
								<label>Sub-Category:</label></br>
								<select name="txtsubCat" id="txtsubCat" class="form-control" required >
									<option>----</option>
									<?php
									$sql3 = "SELECT * FROM tbl_sub_category WHERE cat_id = '$cat_id'";
									$result3 = dbQuery($dbConn, $sql3);
									if(dbNumRows($result3) > 0){
										while($row3 = dbFetchAssoc($result3)){ ?>
											<option value="<?php echo $row3['sub_cat_id'];?>" <?php if($row3['sub_cat_id'] == $sub_cat_id){echo "selected";}?> ><?php echo $row3['sub_cat_title'];?></option>	<?php	
										}
									}
									?>
									
								</select>
							</div>
							<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
								<label>Title:</label></br>
								<input type="text" name="txtTitle" id="txtTitle" value="<?php echo $pro_title; ?>" class="formField" />
							</div>
							<div class="col-md-4 col-sm-4" style="margin-bottom:20px;<?php if($cat_id == 4){echo "display:none";}?>" id="txtPrice" >
								<label>Price:</label></br>
								<input type="text" name="txtPrice" value="<?php echo $pro_price; ?>" class="formField" />
							</div>
							<div class="col-md-4 col-sm-4" style="margin-bottom:20px;<?php if($cat_id == 4){echo "display:none";}?>" id="txtMinqty"  >
								<label>Minimum Quantity:</label></br>
								<input type="text" name="txtMinqty" value="<?php echo $pro_min_qty; ?>" class="formField" />
							</div>
							<div class="col-md-4 col-sm-4" style="margin-bottom:20px; <?php if($cat_id == 4){echo "display:none";}?>" id="txtMultiqty" >
								<label>Multiple of:</label></br>
								<input type="text" name="txtMultiqty" value="<?php echo $pro_multi_qty; ?>" class="formField" />
							</div>
							<div id="offset" style="<?php if($cat_id == 1){ }else{echo "display:none;";}?>" >
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Printing Sheets per 1000 *:</label></br>
									<input type="text" name="txtPrintSheet" value="<?php echo $pro_print_sheet;?>" class="formField" />
								</div>
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Item/printed sheet *:</label></br>
									<input type="text" name="txtItemPrinted" value="<?php echo $pro_item_per_sheet;?>" class="formField" />
								</div>
							</div>
							<div id="outdoor" style="<?php if($cat_id == 3){echo "display:inline"; }else{echo "display:none;";}?>" >
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Length:</label></br>
									<input type="text" name="txtLength" value="<?php echo $pro_length;?>" class="formField" />
								</div>
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Width:</label></br>
									<input type="text" name="txtWidth" value="<?php echo $pro_width;?>" class="formField" />
								</div>
							</div>
							<div id="promotional" style="display:<?php if($cat_id == 4){echo "inline";}else{echo "none";}?>;" >
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Item Code:</label></br>
									<input type="text" name="txtItemCod" class="formField" value="<?php echo $pro_s_item_cod;?>" />
								</div>
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Quantity:</label></br>
									<input type="text" name="txtQty" class="formField" value="<?php echo $pro_s_qty;?>" />
								</div>
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Quantity Reminder:</label></br>
									<input type="text" name="txtQtyRem" class="formField" value="<?php echo $pro_s_qty_rim;?>" />
								</div>
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Cost price:</label></br>
									<input type="text" name="txtCostPrice" class="formField" value="<?php echo $pro_s_cost_price;?>"/>
								</div>
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Wholesale price:</label></br>
									<input type="text" name="txtWholePrice" class="formField" value="<?php echo $pro_s_whole_price;?>" />
								</div>
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Retail price:</label></br>
									<input type="text" name="txtRetailPrice" class="formField" value="<?php echo $pro_s_retail_price;?>" />
								</div>
								
								
							</div>
							<div class="col-md-12 col-sm-12" style="margin-bottom:20px;">
								<label>Description</label></br>
								<textarea name="txtdesc" class="form-control"><?php echo $pro_desc;?></textarea>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="row">
							<div class="col-md-12 col-sm-12" style="margin-bottom:30px;">
								<label>Main Image</label></br>
								<input type="file" name="MainImg" id="MainImg"/><?php echo $pro_main_img; ?>
							</div>
							<div class="col-md-12 col-sm-12" style="margin-bottom:30px;">
								<label>Image-1</label></br>
								<input type="file" name="Img1" id="Img1"/><?php echo $pro_img_1; ?>
							</div>
							<div class="col-md-12 col-sm-12" style="margin-bottom:30px;">
								<label>Image-2</label></br>
								<input type="file" name="Img2" id="Img2"/><?php echo $pro_img_2; ?>
							</div>
							<div class="col-md-12 col-sm-12" style="margin-bottom:30px;">
								<label>Image-3</label></br>
								<input type="file" name="Img3" id="Img3"/><?php echo $pro_img_3; ?>
							</div>
							<div class="col-md-12 col-sm-12" style="margin-bottom:30px;">
								<label>Image-4</label></br>
								<input type="file" name="Img4" id="Img4"/><?php echo $pro_img_4; ?>
							</div>
						</div>
					</div>
				</div>
				<div style="min-height: 20px;"></div>
			</div>
			<div class="row">
				<div class="col-md-offset-5 col-xs-offset-3 col-sm-offset-5">
					<input type="submit" name="btnButton" value="Update" class="butn" /> &nbsp;
					<input type="button" name="btnCanlce" value="Back" class="butn" onclick="window.location.href='index.php'"/>
				</div>
			</div>
		</form>
	</section><!-- /.content -->
		