<?php
	include('php/config.php');
	include('php/database.php');
	include('php/functions.php');
	if(isset($_GET['catid']) && $_GET['catid'] > 0 && isset($_GET['subcat']) && $_GET['subcat'] > 0){
		$CatId = $_GET['catid'];
		$SubCatId = $_GET['subcat'];
		$sqlcat = "SELECT * FROM tbl_sub_category WHERE cat_id = '$CatId' AND sub_cat_id = '$SubCatId'";
		$resultcat = dbQuery($dbConn, $sqlcat);
		if(dbNumRows($resultcat) >0 ){
			$rowcat = dbFetchAssoc($resultcat);
			
		}
	}else{
		header('location:index.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include('files/links.php');?>
</head>
<body>
	<?php include('files/header.php');?>
	<!--Main category : Begin-->
	<main id="main category">
		<section class="header-page categorypg">
			<div class="container">
				<div class="row">
					<div class="col-sm-6 hidden-xs">
						<h1 class="mh-title"><?php echo $rowcat['sub_cat_title'];?></h1>
					</div>
					<div class="breadcrumb-w col-sm-6"> 
						<ul class="breadcrumb">
							<li>
								<a href="index.php">Home</a>
							</li>
							<li>
								<span><?php echo $rowcat['sub_cat_title'];?></span>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</section>
		<section class="category-w parten-bg">
			<div class="container">
				<div class="row">
					<aside id="sidebar_cate" class="col-sm-3 hidden-xs">
						<?php include('files/left-category.php');?>
						<div class="clearfix"></div>
						<div class="space-lg"></div>
					</aside>
					<!--Category product grid : Begin -->
					<section class="category grid col-sm-9 col-xs-12">
						<div class="row">
							<div class="col-xs-12 category-image">
								<a href="#" title="<?php echo $rowcat['sub_cat_title'];?>">
									<img src="upload/subcategory/<?php echo $rowcat['sub_cat_banner'];?>" alt="<?php echo $rowcat['sub_cat_title'];?>" class="img-responsive" />
								</a>
							</div>
							
						</div>
						<div class="top-toolbar row">
							
						</div>
						<div class="row products-grid category-product">
							<ul>
								<?php
								$sql = "SELECT * FROM tbl_product WHERE cat_id = '$CatId' AND sub_cat_id = '$SubCatId'";
								$result = dbQuery($dbConn, $sql);
								if(dbNumRows($result) >0){
									while($row = dbFetchAssoc($result)){
										extract($row); ?>
										<li class="pro-item col-md-4 col-sm-6 col-xs-12">
											<a href="#">
												<div class="product-image-action probox">
													<img src="upload/product/<?php echo $pro_main_img;?>" alt="<?php echo $pro_title;?>">
												</div>
											</a>
											<div class="product-info">
												<a href="#" title="<?php echo $pro_title;?>" class="product-name"><?php echo $pro_title;?></a>
												<?php
												if($CatId == 1){ ?>
													<a href="quotation.php?product=<?php echo $pro_id;?>" class="btn-readmore order-now">Instant Quote / Buy Now</a> <?php
												}else if($CatId == 2){ 
												}else if($CatId == 3){ ?>
													<a href="prom-quote.php?product=<?php echo $pro_id;?>" class="btn-readmore order-now">Instant Quote / Buy Now</a> <?php
												}else if($CatId == 4){ ?>
													<div class="price-box">
														<span class="normal-price">PKR-<?php echo $pro_s_retail_price;?></span>
													</div> <?php

												}
												?>
												
											</div>
										</li><?php
									}
								}else{
									echo "<h1 style='font-size: 30px;padding-left: 20px;'>Products Coming Soon!</h1>";
								} ?>
								
							</ul>	
							
						</div>
						<!--Here place the pagignation-->
						<div class="space-lg"></div>
						<div class="space-lg"></div>
					</section>
					<!-- Category product grid : End -->
				</div>
				
			</div>
		</section>
	</main><!-- Main Category: End -->
	<!--Footer : Begin-->
	<!--Footer : Begin-->
	<?php include('files/footer.php');?>
	<div id="sitebodyoverlay"></div>
	<?php include('files/mobile-menu.php');?>
	<?php include('files/bottom-script.php');?>
</body>
</html>
