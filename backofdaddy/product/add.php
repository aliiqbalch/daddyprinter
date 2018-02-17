<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	
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
			$("#txtPrice").css("display", "none");
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
	<section class="content-header top_heading">
		<h1>Add Product</h1>
	</section>
	<!-- Main content -->
	<section class="content" >
		<!-- start any work here. -->
		<form name="frmAddMainNav" id="frmAddMainNav" method="post" action="processpro.php?action=add"  enctype="multipart/form-data" onsubmit="return validate(this)">
			
			<div class="container-fluid container_block">
				<div class="row inner_heading">
					<h1>Add Product Details</h1><hr>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="allstep" id="allstepactive" >
							<h2>Step 1</h2>
							<p>Add Product</p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="allstep">
							<h2>Step 2</h2>
							<p>Add Variation Type</p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="allstep">
							<h2>Step 3</h2>
							<p>Add Variation</p>
						</div>
					</div>
				</div>
				<div class="space"></div>
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
							<input type="hidden" name="txtfeature" class="formField" value="1" />
							<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
								<label>Category:</label></br>
								<select name="txtCat" class="form-control" onchange="showSubCategory(this.value)" >
									<option value="0">----</option>
									<?php category($dbConn); ?>
								</select>
							</div>
							<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
								<label>Sub-Category:</label></br>
								<select name="txtsubCat" id="txtsubCat" class="form-control"  >
									<option>----</option>
								</select>
							</div>
							<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
								<label>Title:</label></br>
								<input type="text" name="txtTitle" id="txtTitle" class="formField" />
							</div>
							<div class="col-md-4 col-sm-4" style="margin-bottom:20px;" id="txtPrice">
								<label>Price:</label></br>
								<input type="text" name="txtPrice"  class="formField" />
							</div>
							<div class="col-md-4 col-sm-4" style="margin-bottom:20px;" id="txtMinqty">
								<label>Minimum Quantity:</label></br>
								<input type="text" name="txtMinqty"  class="formField" />
							</div>
							<div class="col-md-4 col-sm-4" style="margin-bottom:20px;" id="txtMultiqty">
								<label>Multiple of:</label></br>
								<input type="text" name="txtMultiqty"  class="formField" />
							</div>
							<div id="offset" style="display:none;" >
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Printing Sheets per 1000 *:</label></br>
									<input type="text" name="txtPrintSheet" class="formField" />
								</div>
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Item/printed sheet *:</label></br>
									<input type="text" name="txtItemPrinted" class="formField" />
								</div>
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Machine</label></br>
									<input type="text" name="txtMachine" class="formField" />
								</div>
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Printing Size</label></br>
									<input type="text" name="txtPrintingSize" class="formField" />
								</div>
							</div>
							<div id="outdoor" style="display:none;" >
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Length:</label></br>
									<input type="text" name="txtLength" class="formField" />
								</div>
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Width:</label></br>
									<input type="text" name="txtWidth" class="formField" />
								</div>
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Cost price:</label></br>
									<input type="text" name="txtCostPriceOutDoor" id="txtCostPrice" class="formField" value="" />
								</div>
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Wholesale price:</label></br>
									<input type="text" name="txtWholePriceOutDoor" class="formField" value="" />
								</div>
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Retail price:</label></br>
									<input type="text" name="txtRetailPriceOutDoor" class="formField" value="" />
								</div>
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Design:</label></br>
									<input type="text" name="txtDesignOutdoor" class="formField" value=""  />
								</div>
							</div>
							<div id="promotional" style="display:none;" >
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Item Code:</label></br>
									<input type="text" name="txtItemCod" class="formField" value="0" />
								</div>
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Quantity:</label></br>
									<input type="text" name="txtQty" class="formField" value="0" />
								</div>
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Quantity Reminder:</label></br>
									<input type="text" name="txtQtyRem" class="formField" value="0" />
								</div>
<!--								<script>-->
<!--									function pricetriple(){-->
<!--										var txtCostPrice = document.getElementById("txtCostPrice").value;-->
<!--										//alert(txtCostPrice);-->
<!--										var onehund = txtCostPrice * 2;-->
<!--										var twohundfiv = txtCostPrice * 3.5;-->
<!---->
<!--										document.frmAddMainNav.txtWholePrice.value = onehund;-->
<!--										document.frmAddMainNav.txtRetailPrice.value= twohundfiv;-->
<!--									}-->
<!--								</script>-->
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Cost price:</label></br>
									<input type="text" name="txtCostPrice" id="txtCostPrice" class="formField" value="" />
								</div>
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Wholesale price:</label></br>
									<input type="text" name="txtWholePrice" class="formField" value=""  />
								</div>
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Retail price:</label></br>
									<input type="text" name="txtRetailPrice" class="formField" value=""  />
								</div>
								<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
									<label>Design:</label></br>
									<input type="text" name="txtDesignPromotional" class="formField" value=""  />
								</div>
							</div>
							
							<div class="col-md-12 col-sm-12" style="margin-bottom:20px;">
								<label>Description:</label></br>
								<textarea name="txtdesc" class="form-control"></textarea>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="row">
							<div class="col-md-12 col-sm-12" style="margin-bottom:30px;">
								<label>Main Image</label></br>
								<input type="file" name="MainImg" id="MainImg"/>
							</div>
							<div class="col-md-12 col-sm-12" style="margin-bottom:30px;">
								<label>Image-1</label></br>
								<input type="file" name="Img1" id="Img1"/>
							</div>
							<div class="col-md-12 col-sm-12" style="margin-bottom:30px;">
								<label>Image-2</label></br>
								<input type="file" name="Img2" id="Img2"/>
							</div>
							<div class="col-md-12 col-sm-12" style="margin-bottom:30px;">
								<label>Image-3</label></br>
								<input type="file" name="Img3" id="Img3"/>
							</div>
							<div class="col-md-12 col-sm-12" style="margin-bottom:30px;">
								<label>Image-4</label></br>
								<input type="file" name="Img4" id="Img4"/>
							</div>
						</div>
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
		