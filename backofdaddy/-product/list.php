<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	
	$rowsPerPage = 20;
	$sql =  "SELECT * FROM tbl_product ORDER BY pro_id DESC";
	$result     = dbQuery($dbConn, getPagingQuery($sql, $rowsPerPage));
	$pagingLink = getPagingLink($dbConn, $sql, $rowsPerPage);
?>
	
	<?php include(THEME_PATH . '/tb_link.php');?>
	<script>
		function getCategory(CatId) {
			$.ajax({
			type: "POST",
			url: "category.php",
			data:'CatId='+ CatId,
			success: function(html){
				$("#shocategory").html(html);
			}
			});
		}
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
	</script>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Product</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo WEB_ROOT_ADMIN ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Product</li>
		</ol>
    </section>
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid container_block">
			
				<div class="row">
					<?php
					if(modPerAdd($dbConn, "7")){ ?>
						<div class="col-md-3">
							<div style="margin: 10px 0px 0px 5px;">
								<button type="submit" name="btnButton"  class="butn" onclick="addPro()"  ><i class="fa fa-plus"></i> Add Product</button>
							</div>
						</div><?php
					}?>
					<div class="col-md-4">
						<div style="margin: 10px 0px 0px 5px;">
							<select name="txtCategory" class="formField" onChange="getCategory(this.value);">
								<option value="0">Select Category</option>
								<?php
								$sql2 = "SELECT * FROM tbl_category";
								$result2 = dbQuery($dbConn, $sql2);
								if(dbNumRows($result2) >0){
									while($row2 = dbFetchAssoc($result2)){
										extract($row2); ?>
										<option value="<?php echo $cat_id;?>"><?php echo $cat_title;?></option> <?php
									}
								} ?>
							</select>
						</div>
					</div>
					<div class="col-md-4 col-sm-4" style="margin: 10px 0px 0px 5px;">
						<div class="box-tools">
							<div class="input-group input-group-sm" style="width: 95%;">
								<input type="text" id="txtsearch" name="txtsearch" class="typeahead formField" placeholder="Search" />
								<div class="input-group-btn">
									<button type="submit" class="butn" id="searchPro" ><i class="fa fa-search"></i></button>
								</div>
							</div>
						</div>
					</div>
				</div>
				
			<div class="row" id="alertmsg" style="margin: 10px 0px 0px 5px;" >
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
			<div class="row bord-right-space" id="loadProducts" >
				<div class="table-responsive tbl-respon">
					<table  class="table table-bordered table-striped tbl-respon2">
						<thead>
							<tr>
								<th >Sr.No</th>
								<th >Category</th>
								<th >Image</th>
								<th >Title</th>
								<th >Minimum Qty</th>
								<th >Multiple Qty</th>
								<th >Action</th>
							</tr>
						</thead>
						<tbody id="shocategory">
							<?php
							if (dbNumRows($result) > 0) {
								if(isset($_GET['page'])){
									$page = $_GET['page'] - 1;
									$i = $rowsPerPage * $page +1;
								}else{
									$i = 1;
								}
								while($row = dbFetchAssoc($result)){
									extract($row);
									 ?>
									<tr>
										<td><?php echo $i++;?></td>
										<td><?php categoryName($dbConn, $cat_id);?></td>
										<td>
											<?php  
												if ($pro_main_img != '') { ?>
													<img src="<?php echo WEB_ROOT."upload/product/". $row['pro_main_img']; ?>"  width="70px" height="70px"/>
													<?php 
												}else{ 
													echo "";
												}
											?>
										</td>
										<td><?php echo $pro_title;?></td>
										<td><?php echo $pro_min_qty;?></td>
										<td><?php echo $pro_multi_qty;?></td>
										<td>
											<a href="javascript:viewpro(<?php echo $pro_id;?>)">
												<i class="fa fa-eye"></i>&nbsp;
											</a>
											<a href="javascript:modifyPro(<?php echo $pro_id;?>)">
												<i class="fa fa-edit"></i>&nbsp;
											</a>
											<a href="javascript:deletePro(<?php echo $pro_id;?>)">
												<i class="fa fa-trash"></i>
											</a>
										</td>
									</tr><?php
								}
							} ?>
							<tr height="20">
								<td align="center" colspan="7" class="pagingStyle"><?php echo $pagingLink;?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
				<!--- End Table ---------------->
		</div>
        
		
	</section><!-- /.content -->
		