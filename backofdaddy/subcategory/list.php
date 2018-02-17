<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	
	$sql =  "SELECT * FROM tbl_sub_category ORDER BY sub_cat_id DESC";
	$result     = dbQuery($dbConn, $sql);
	
	
?>
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
	</script>
	<?php include(THEME_PATH . '/tb_link.php');?>
	
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Sub-Category</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo WEB_ROOT_ADMIN ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Sub-Category</li>
		</ol>
    </section>
	
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid container_block">
			<?php
			if(modPerAdd($dbConn, "2")){ ?>
				<div class="row">
					<div class="col-md-3">
						<div style="margin: 10px 0px 0px 5px;">
							<button type="submit" name="btnButton"  class="butn" onclick="addSubCat()"  ><i class="fa fa-plus"></i> Add Sub-Category</button>
						</div>
					</div>
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
								}
								?>
								
							</select>
						</div>
					</div>
				</div>
				<?php
			}?>
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
			<div class="row bord-right-space" >
				<div class="table-responsive tbl-respon">
					<table class="table table-bordered table-striped tbl-respon2">
						<thead>
							<tr>
								<th >Sr.No</th>
								<th >Category</th>
								<th >Title</th>
								<th >Img</th>
								<th >Banner</th>
								<th >Description</th>
								<th >Action</th>
							</tr>
						</thead>
						<tbody id="shocategory">
							<?php
							if (dbNumRows($result) > 0) {
								$i = 1;
								while($row = dbFetchAssoc($result)){
									extract($row);
									 ?>
									<tr>
										<td><?php echo $i++;?></td>
										<td><?php categoryName($dbConn, $cat_id);?></td>
										<td><?php echo $sub_cat_title;?></td>
										<td>
											<?php  
												if ($sub_cat_img != '') { ?>
													<img src="<?php echo WEB_ROOT."upload/subcategory/". $row['sub_cat_img']; ?>"  width="70px" height="70px"/>
													<?php 
												}else{ 
													echo "";
												}
											?>
										</td>
										<td>
											<?php  
												if ($sub_cat_banner != '') { ?>
													<img src="<?php echo WEB_ROOT."upload/subcategory/". $row['sub_cat_banner']; ?>"  width="100px" height="70px"/>
													<?php 
												}else{ 
													echo "";
												}
											?>
										</td>
										<td><?php echo $sub_cat_desc;?></td>
										<td>
											<?php if(modPerModify($dbConn,"2")){?>
											<a href="javascript:modifySubCat(<?php echo $sub_cat_id;?>)">
												<i class="fa fa-edit"></i>&nbsp;
											</a>
										<?php } if(modPerDelete($dbConn,"2")){?>
											<a href="javascript:deleteSubCat(<?php echo $sub_cat_id;?>)">
												<i class="fa fa-trash"></i>
											</a>
										<?php }?>
										</td>
									</tr><?php
								}
							} ?>
							
						</tbody>
					</table>
				</div>
			</div>
				<!--- End Table ---------------->
		</div>
        
		
	</section><!-- /.content -->
		