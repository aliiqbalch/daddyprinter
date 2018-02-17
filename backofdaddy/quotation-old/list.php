<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
require_once"cart.php";
require_once"../library/functions.php";
?>
	
	<?php include(THEME_PATH . '/tb_link.php');?>
	<script src="<?=WEB_ROOT_TEMPLATE?>/dist/js/printThis.js"></script>
	<script>
		$(document).ready(function(){
			$("#printThis").click(function(){
				if($("#discount").val() == 0) {
					$(".printHide").css("display","none");
				}
				$("#printQuation").printThis({
					loadCSS: "http://localhost/daddyprinters/backofdaddy/template/xpert/dist/css/print.css",  // path to additional css file - use an array [] for multiple
				});

				$(".printHide").delay("slow").show(10000);
			});
		});
	</script>
	<script>
	$(document).ready(function(){
		$('input.typeahead').typeahead({
			name: 'search',
			remote:'search.php?key=%QUERY',
			limit : 5
		});
	});
	//Search a product
	$(document).ready(function() {
		$('#searchPro').click(function () { 
			var txtsearch = document.getElementById("txtsearch").value;
			//alert(txtsearch);
			//PASS THE VALUE OF PAGES TO ANOTHER PAGES
			$.ajax({
				type:"POST", 
				url:"loadpro.php", 
				data: 'txtsearch='+txtsearch ,
				success: function (html) { 
					$('#loadProducts').html(html); 
				}
			}); 
			return false; 
		});
	});
	function ordercnfirm(){


		var notes 		= document.getElementById("txtNotes").value;
		var txtDelDay	=	document.getElementById("txtDelDay").value;
		var txtOrderNo	=	document.getElementById("txtOrderNo").value;
		var companyName = $("#companyName").val();
		console.log(txtOrderNo);
		$.ajax({
			type:"POST", 
			url:"order.php", 
			data: 'notes='+notes+'&txtDelDay='+txtDelDay+'&txtOrderNo='+txtOrderNo+'&companyName='+companyName,
			success: function(html){
				$('#ordeCnfom').html(html);
				
				document.getElementById("txtsearch").value = "";
			}
		});
	}
	
	//show variation in product
	function showtds(pro,vtype){
		var noofthousandsqty = 0;
		var noofthousandsimp = 0;
		var sheetcount = 0;
		var price = parseFloat($("#txtProprice").val());
		var qty = parseInt($("#txtqty").val());
		var baseprice = price * qty;
		var varid = $("#selectvar"+vtype).val();
		
		$.ajax({
			type:"POST", 
			url:"get-var.php", 
			data: 'pro='+pro+'&vtype='+vtype+'&varid='+varid ,

			success: function(html){
				$('#loadvariation').html(html);
				//VARIATION PRICE OF ANY PRODUCT
				var costPrice 		= parseFloat($("#txtCost"+vtype).val());
				var wholesalePrice 	= parseFloat($("#txtWholesale"+vtype).val());
				var retailPrice 	= parseFloat($("#txtRetail"+vtype).val());
				//SHOW THE Price X Factor
				$("#qtytd"+vtype).html(qty+' X '+costPrice);
				
				if(parseInt($("#sheettd"+vtype).html()) == 0){
					//Show price after multiplication of quantity
					$("#costtd"+vtype).html(costPrice * qty);
					$("#wholesaletd"+vtype).html(wholesalePrice * qty);
					$("#retailtd"+vtype).html(retailPrice * qty);
				}else if(parseInt($("#sheettd"+vtype).html()) == 1){
					//SELECT PRINT SHEET FROM TBL_PRODUCT
					var txtPrintSheet = parseFloat($("#txtPrintSheet"+vtype).val());
					noofthousandsqty = Math.ceil(qty / 1000);
					sheetcount = noofthousandsqty * parseInt(txtPrintSheet);
					if(sheetcount <= 1000){
						$("#costtd"+vtype).html(costPrice);
						$("#wholesaletd"+vtype).html(wholesalePrice);
						$("#retailtd"+vtype).html(retailPrice);
					}
					else{
						noofthousandsimp = Math.ceil(sheetcount / 1000);
						$("#costtd"+vtype).html(costPrice * noofthousandsimp);
						$("#wholesaletd"+vtype).html(wholesalePrice * noofthousandsimp);
						$("#retailtd"+vtype).html(retailPrice * noofthousandsimp);
					}
				}if(parseInt($("#sheettd"+vtype).html()) == 2){
					//VARIATION PRICE OF Design
					$("#costtd"+vtype).html(costPrice);
					$("#wholesaletd"+vtype).html(wholesalePrice);
					$("#retailtd"+vtype).html(retailPrice);
				}
				//Add all cost price
				//Calculate Total Cost Price
				var initailpricecost = 0.00;
				function ShowResultsc(value, index, ar) {
					initailpricecost+= parseFloat(value.innerHTML);
				}
				var inputc = $('td[name^=costtd]');
				var inputListc = Array.prototype.slice.call(inputc);
				inputListc.forEach(ShowResultsc);
				initailpricecost = initailpricecost + baseprice;
				
				//Calculate Total Wholesale Price
				var initailpricewhole = 0.00;
				function ShowResultsw(value, index, ar) {
					initailpricewhole += parseFloat(value.innerHTML);
				}
				var inputw = $('td[name^=wholesaletd]');
				var inputListw = Array.prototype.slice.call(inputw);
				inputListw.forEach(ShowResultsw);
				initailpricewhole = initailpricewhole + baseprice;
				
				//Calculate Total Retail Price
				var initailpriceretail = 0.00;
				function ShowResultsr(value, index, ar) {
					initailpriceretail+=parseFloat(value.innerHTML);
				}
				var inputr = $('td[name^=retailtd]');
				var inputListr = Array.prototype.slice.call(inputr);
				inputListr.forEach(ShowResultsr);
				initailpriceretail = initailpriceretail + baseprice;
				
				//Show all price (tc, whole, retail)
				$("#tcost").html(initailpricecost);
				$("#twholesale").html(initailpricewhole);
				$("#tretail").html(initailpriceretail);
				$("#tcosttotal").val(initailpricecost);
				$("#twholetotal").val(initailpricewhole);
				$("#gtotal").val(initailpriceretail);
				
				document.frmbillinfo.txtTCostPrice.value = initailpricecost;
				document.frmbillinfo.txtTWholesalePrice.value = initailpricewhole;
				document.frmbillinfo.txtTRetailPrice.value = initailpriceretail;
				
				
			}
		});
	}
	function outdoor() { 
		var txtqty 		= document.getElementById("txtqty").value;
		var txtLength 	= document.getElementById("txtLength").value;
		var txtWidth	= document.getElementById("txtWidth").value;
		var txtRetailPrice	= document.getElementById("txtRetailPrice").value;
		var sqrfit      = txtLength * txtWidth;
		var signleprice = sqrfit * txtRetailPrice;
		var TotPrice    = signleprice * txtqty;

		if(document.getElementById('txtDesign').checked){
			var txtDesign = document.getElementById('txtDesign').value;
			TotPrice += parseInt(txtDesign);
		}
		$("#OutdoorPrice").html(TotPrice);
		$("#total").val(TotPrice);
	}

	function promotional() {
		var txtqty 		= document.getElementById("txtqty").value;
		var txtReatilPrice	= document.getElementById("txtReatilPrice").value;
		var price      = txtReatilPrice * txtqty;
		if(document.getElementById('txtDesign').checked){
			var txtDesign = document.getElementById('txtDesign').value;
			price += parseInt(txtDesign);
		}
		$("#promotionalPrice").html(price);
		$("#total").val(price);
	}

    </script>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Quotation</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Quotation</li>
		</ol>
    </section>
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid container_block">
			<div class="row inner_heading">
				<h1>Product Detail</h1><hr>
			</div>
			<div class="row">
				<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
					<label>Product Name:</label></br>
					<input type="text" id="txtsearch" name="txtsearch" class="typeahead formField" value="" placeholder="Enter Search Name" required />
				</div>
				<div class="col-md-8 col-sm-8" style="margin-bottom: 30px;">
					<label>&nbsp;</label></br>
					<input type="submit" id="searchPro" name="btnButton" value="Search" class="butn" />
				</div>
				
			</div>
			<div class="space-lg"></div>
			<div class="row">
				<div class="col-md-12">
					<div id="loadProducts"></div>
					<div id="loadvariation" ></div>
				</div>
			</div>

			<div class="row">
				<?php
				if(isset($_SESSION['objItems'])) {
					$objItems = unserialize($_SESSION['objItems']);
				}
				else{
					$objItems = new Cart();
				}
				if($objItems->items){
					?>
					<div class="container-fluid">
						<div class="row">
							<div class="space-lg"></div>
							<div class="table-responsive tbl-respon">
								<table class="table table-bordered table-striped tbl-respon2">
									<thead>
									<tr>
										<th>Item #</th>
										<th>Description</th>
										<th>Size</th>
										<th>Quantity</th>
										<th>Unit Price</th>
										<th>Total</th>
										<th>Action</th>
									</tr>
									</thead>

									<tbody>
									<?php
									$i = 0;
									foreach($objItems->items as $item){

										?>
										<form action="processcart.php" method="post">
											<tr>
												<td class="text-bold"><?=++$i?></td>
												<td class="text-bold"><?=productName($dbConn,$item->productID)?></td>
												<?php
												if($item->catID == 3){
													?>
													<td><?=$item->width?> x <?=$item->length?></td>
													<?php
												}else{
													?>
													<td>Std</td>
													<?php
												}
												?>
												<td><?= $item->qty?></td>
												<td><input type="text" class="input-sm" name="unitPrice" value="<?=$item->unitPrice?>"></td>
												<td><?=$item->total?></td>
												<td class="text-center">
													<input type="hidden" name="action" value="update_cart">
													<input type="hidden" name="itemID" value="<?=$item->itemID?>">
													<input type="submit" class="btn btn-danger" value="Update">
													<a href="processcart.php?action=remove_item&itemID=<?=$item->itemID?>" style="color:white;" class="btn btn-danger">X</a>
												</td>
											</tr>
											<?php if($item->catID == 1 || $item->catID == 2){?>
											<tr>
												<td></td>
												<td colspan="6">
													<?php
													foreach($item->itemsValue as $itemId){
														@extract($itemId);
														?>
														<?=variationtitle($dbConn, $variationid);?> ,
														<?php
													}?>
												</td>
											</tr>
											<?php }?>
										</form>
										<?php
									}
									?>
									<tr>
										<td id="colorgry1" colspan="5"></td>
										<td><?=$objItems->total?></td>
										<td class="text-center"><a href="index.php?view=quotation" class="butn" style="color:white;">Quotation</a></td>
									</tr>
									</tbody>
								</table>
							</div
						</div>
					</div>

					<?php

				}
				?>
			</div>

		</div>
	</section><!-- /.content -->
	