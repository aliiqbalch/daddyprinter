<?php
	include('php/config.php');
	include('php/database.php');
	include('php/functions.php');
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
						<h1 class="mh-title">All Category</h1>
					</div>
					<div class="breadcrumb-w col-sm-6"> 
						<ul class="breadcrumb">
							<li>
								<a href="index.php">Home</a>
							</li>
							<li>
								<span>All Category</span>
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
							<?php
								$sql = "SELECT * FROM tbl_category ";
								$result = dbQuery($dbConn, $sql);
								if(dbNumRows($result) >0){
									while($row = dbFetchAssoc($result)){
										extract($row); ?>
										<div class="col-xs-12 category-image">
											<a href="category.php?catid=<?php echo $cat_id;?>" title="<?php echo $cat_title;?>">
												<img src="upload/category/<?php echo $cat_img;?>" alt="<?php echo $cat_title;?>" class="img-responsive" />
											</a>
										</div> <?php
									}
								} ?>
						</div>
						<div class="top-toolbar row"></div>
						
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
