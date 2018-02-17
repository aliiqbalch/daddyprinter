<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';
    require_once'cart.php';
	if(isset($_REQUEST['txtsearch'])){
		
		$txtTitle = $_REQUEST['txtsearch'];
		if(!empty($txtTitle)){
			
			$sql = "SELECT * FROM tbl_product WHERE pro_title = '$txtTitle'";
			$result = dbQuery($dbConn, $sql);
			if(dbNumRows($result) > 0){
				$row = dbFetchAssoc($result);
				extract($row);

				?>
                <form action="processcart.php" method="post">
                    <input type="hidden" name="action" value="add_to_cart" />
                    <input type="hidden" name="proid" value="<?=$pro_id?>">
                    <input type="hidden" name="catid" value="<?=$cat_id?>">
                    <input type="hidden" name="subcatid" value="<?=$sub_cat_id?>">


				<?php if($cat_id == 1 || $cat_id == 2){?>
					<div class="row">
						<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
							<label>Base Price:</label></br>
							<input type="text" name="txtProprice" id="txtProprice" value="<?php echo $pro_price; ?>" class="formField" required="required" readonly />
						</div>
						<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
							<label>Quantity:</label></br>
							<input type="text" name="txtqty" id="txtqty" class="formField" value="<?php echo $pro_min_qty;?>" required="required" />
						</div>
						<div class="col-md-12">
								<div class="table-responsive tbl-respon">
									<table class="table table-bordered table-striped tbl-respon2">
										<thead>
										<tr>
											<th >Var Type</th>
											<th >Variations</th>
											<th >Sheet Dependent</th>
											<?php if(modPerFactor($dbConn,"8")){?>
											<th >Price X Factor</th>
						<?php } if(modPerCostPrice($dbConn,"8")){?>
											<th >Cost Price</th>
						<?php } if(modPerWholeSale($dbConn,"8")){?>
											<th >Wholesale Price</th>
						<?php }?>
											<th >Retail Price</th>
										</tr>
										</thead>
										<tbody>
										<?php
										$sql2 = "SELECT DISTINCT var_type_id FROM tbl_pro_var WHERE pro_id = '$pro_id'";
										$result2 = dbQuery($dbConn, $sql2);
										if(dbNumRows($result2) > 0){
											while($row2 = dbFetchAssoc($result2)){
												extract($row2); ?>
												<tr>
													<input type="hidden" name="txtPrintSheet<?php echo $var_type_id;?>" id="txtPrintSheet<?php echo $var_type_id;?>" value="<?php echo $pro_print_sheet; ?>" />
													<td ><?php variationtypeName($dbConn, $var_type_id); ?></td>
													<td >
														<select name="<?=variationtypeName($dbConn, $var_type_id);?>" class="formField" id="selectvar<?php echo $var_type_id;?>" onchange="showtds(<?php echo $pro_id; ?>, <?php echo $var_type_id; ?>)" >
															<option value="0">Select Variations</option>
															<?php
															$sql3 = "SELECT * FROM tbl_pro_var WHERE pro_id = '$pro_id' AND var_type_id = '$var_type_id' ORDER BY pv_id ASC";
															$result3 = dbQuery($dbConn, $sql3);
															if(dbNumRows($result3) > 0){
																while($row3 = dbFetchAssoc($result3)){
																	extract($row3);  ?>
																	<option value="<?=$var_id; ?>"><?= variationtitle($dbConn, $var_id); ?></option> <?php
																}
															}?>
														</select>
													</td>
													<td name="sheettd<?php echo $var_type_id;?>" id="sheettd<?php echo $var_type_id;?>" ><?php sheetdepend($dbConn, $var_type_id);?></td>
													<?php if(modPerFactor($dbConn,"8")){?>
													<td name="qtytd<?php echo $var_type_id;?>" id="qtytd<?php echo $var_type_id;?>">&nbsp;</td>
													<?php } if(modPerCostPrice($dbConn,"8")){?>
													<td name="costtd<?php echo $var_type_id;?>" id="costtd<?php echo $var_type_id;?>" >0.00</td>
													<?php } if(modPerWholeSale($dbConn,"8")){?>
													<td name="wholesaletd<?php echo $var_type_id;?>" id="wholesaletd<?php echo $var_type_id;?>" >0.00</td>
													<?php }?>
													<td name="retailtd<?php echo $var_type_id;?>" id="retailtd<?php echo $var_type_id;?>" >0.00</td>
												</tr> <?php
											}
										}
										?>
										<tr class="lastchildtotal">
											<td colspan="<?php if(modPerFactor($dbConn,"8")){echo "4";}else{echo "3";}?>"><strong>Total Price</strong></td>
											<?php if(modPerCostPrice($dbConn,"8")){?>
											<td id="tcost"><?php echo $pro_price * 1000; ?></td>
											<?php } if(modPerWholeSale($dbConn,"8")){ ?>
											<td id="twholesale"><?php echo $pro_price * 1000; ?></td>
											<?php } ?>
											<td id="tretail"><?php echo $pro_price * 1000; ?> </td>
											<input type="hidden" name="tcost" id="tcosttotal" value="">
											<input type="hidden" name="twholesale" id="twholetotal" value="">
											<input type="hidden" name="total" id="gtotal" value="">
										</tr>

										</tbody>
									</table>
								</div>
							<!--- End Table ---------------->
						</div>
					</div>
					<?php
				}else if($cat_id == 3){ ?>
					<div class="row">
						<input type="hidden" name="txtProprice" value="">
						<?php if(modPerCostPrice($dbConn,"8")){?>
						<div class="col-md-2 col-sm-2" style="margin-bottom:20px;">
							<label>Cost price:</label></br>
							<input type="text" name="tcost" id="txtCostPrice" class="formField" value="<?=$pro_s_cost_price?>" readonly />
						</div>
						<?php } if(modPerWholeSale($dbConn,"8")){?>
						<div class="col-md-2 col-sm-2" style="margin-bottom:20px;">
							<label>Wholesale price:</label></br>
							<input type="text" name="twholesale" id="txtWholePrice" class="formField" value="<?=$pro_s_whole_price?>" readonly />
						</div>
						<?php }?>
						<div class="col-md-2 col-sm-2" style="margin-bottom:20px;">
							<label>Retail price:</label></br>
							<input type="text" name="txtRetailPrice" id="txtRetailPrice" class="formField" value="<?=$pro_s_retail_price?>"/>
						</div>
						<div class="col-md-1 col-sm-1" style="margin-bottom:20px;">
							<label>Quantity:</label></br>
							<input type="text" name="txtqty" id="txtqty" class="formField" value="<?php echo $pro_min_qty;?>" required="required" />
						</div>
						<div class="col-md-1 col-sm-1" style="margin-bottom:20px;">
							<label>Length:</label></br>
							<input type="text" name="txtLength" id="txtLength" class="formField" value="<?php echo $pro_length;?>" required="required" />
						</div>
						<div class="col-md-1 col-sm-1" style="margin-bottom:20px;">
							<label>Width:</label></br>
							<input type="text" name="txtWidth" id="txtWidth" class="formField" value="<?php echo $pro_width;?>" required="required" />
						</div>
						<div class="col-md-1 col-sm-1" style="margin-bottom:20px;">
							<label>Design</label></br>
							<input type="checkbox" name="txtDesign" id="txtDesign" class="" value="<?=$design_cost?>" /> <?=$design_cost?>
						</div>
						<div class="col-md-2 col-sm-2" style="margin-bottom: 30px;">
							<label>&nbsp;</label></br>
							<input type="button" id="btnCal"  value="Calculate" class="butn" onclick="outdoor()" />
						</div>
						<div class="col-md-12">
							<div class="table-responsive tbl-respon">
								<table class="table table-bordered table-striped tbl-respon2">
									<thead>
										<tr class="lastchildtotal">
											<td >Total Price</td>
											<td id="OutdoorPrice">0000</td>
											<input type="hidden" id="total" name="total" value="">
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<?php
				}else if($cat_id == 4){
					?>
					<div class="col-md-2 col-sm-2" style="margin-bottom:20px;">
						<input type="hidden" name="txtProprice" value="">
						<label>Item Code:</label></br>
						<input type="text" name="txtItemCod" class="formField" value="<?php echo $pro_s_item_cod;?>" readonly/>
					</div>
					<?php if(modPerCostPrice($dbConn,"8")){?>
					<div class="col-md-2 col-sm-2" style="margin-bottom:20px;">
						<label>Cost price:</label></br>
						<input type="text" name="tcost" class="formField" value="<?php echo $pro_s_cost_price;?>" readonly/>
					</div>
						<?php } if(modPerWholeSale($dbConn,"8")){?>
					<div class="col-md-2 col-sm-2" style="margin-bottom:20px;">
						<label>Wholesale price:</label></br>
						<input type="text" name="twholesale" class="formField" value="<?php echo $pro_s_whole_price;?>" readonly/>
					</div>
						<?php }?>
					<div class="col-md-2 col-sm-2" style="margin-bottom:20px;">
						<label>Retail price:</label></br>
						<input type="text" name="txtRetailPrice" class="formField" id="txtReatilPrice" value="<?php echo $pro_s_retail_price;?>" />
					</div>
					<div class="col-md-2 col-sm-2" style="margin-bottom:20px;">
						<label>Quantity:</label></br>
						<input type="text" name="txtqty" class="formField" id="txtqty" placeholder="<?php echo $pro_s_qty;?>" value=""/>
					</div>
					<div class="col-md-1 col-sm-1" style="margin-bottom:20px;">
						<label>Design</label></br>
						<input type="checkbox" name="txtDesign" id="txtDesign" class="" value="<?=$design_cost?>" /> <?=$design_cost?>
					</div>
					<div class="col-md-2 col-sm-2" style="margin-bottom: 30px;">
						<label>&nbsp;</label></br>
						<input type="button" id="btnCal"  value="Calculate" class="butn" onclick="promotional()" />
					</div>
					<div class="col-md-12">
						<div class="table-responsive tbl-respon">
							<table class="table table-bordered table-striped tbl-respon2">
								<thead>
								<tr class="lastchildtotal">
									<td >Total Price</td>
									<td id="promotionalPrice">0000</td>
									<input type="hidden" id="total" name="total" value="">
								</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
<!--					<div class="col-md-2 col-sm-2" style="margin-bottom:20px;">-->
<!--						<label>Quantity Reminder:</label></br>-->
<!--						<input type="text" name="txtQtyRem" class="formField" value="--><?php //echo $pro_s_qty_rim;?><!--" />-->
<!--					</div>-->
					<?php
				}
				?>
				<div class="row">
					<div class="col-md-12 col-sm-12" style="margin-bottom: 30px;">
							<label>&nbsp;</label>
							<!--                        <a href="#order" style="color:#ffffff;" class="butn pull-right">Order</a>-->
							<label>&nbsp;</label>
							<input type="submit" style="color:#ffffff; margin-right: 5px;" id="btnordersave" value="Add" class="butn pull-right">
							<label>&nbsp;</label>
							<a href="processcart.php?action=empty_cart" style="color:#ffffff; margin-right: 5px;" class="butn pull-right">Cancel</a>
						</div>
				</div>
				</form>
				<?php
			}
		}
		
	}else{
		
	}
	
	?>	
	
	
	
		
		