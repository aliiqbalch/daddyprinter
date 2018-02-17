<?php
	include('php/config.php');
	include('php/database.php');
	include('php/functions.php');
	if(isset($_POST['btnShowQuote']) && $_POST['txtProId'] > 0){
		$txtProId = $_POST['txtProId'];
		$sql = "SELECT * FROM tbl_product WHERE pro_id = '$txtProId'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$row = dbFetchAssoc($result);
			extract($row);
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
						<h1 class="mh-title"><?php echo $pro_title;?></h1>
					</div>
					<div class="breadcrumb-w col-sm-6"> 
						<ul class="breadcrumb">
							<li><a href="index.php">Home</a></li>
							<li><a href="category.php?catid=<?php echo $row['cat_id'];?>"><?php categoryName($dbConn, $row['cat_id']); ?></a></li>
							<li><a href="product.php?catid=<?php echo $row['cat_id']?>&subcat=<?php echo $row['sub_cat_id'];?>"><?php subcategoryName($dbConn, $row['sub_cat_id']);?></a></li>
							<li><span><?php echo $pro_title;?></span></li>
						</ul>
					</div>
				</div>
			</div>
		</section>
		<section class="category-w parten-bg">
			<div class="container">
				<div class="row">
					<div class="col-md-4 category-image">
						<div class="productoptionbox ">
							<h1>Product Options</h1>
						</div>
					</div>
					<div class="col-md-4 category-image">
						<div class="productoptionbox active">
							<h1>Your Selections</h1>
						</div>
					</div>
					<div class="col-md-4 category-image">
						<div class="productoptionbox">
							<h1>Get a quote</h1>
						</div>
					</div>
				</div>
				<div class="space"></div>
				<div class="row">
					<section class="col-sm-12 col-md-12">
						<div class="bg-white quotebox">
							<div class="row">
								<?php
								if(isset($_SESSION['items'])){
									foreach($_SESSION['items'] as $key => $row){
										$productId = $row['productId'];
										$variationtypeid = $row['variationtypeid'];
										$variation = $row['variation'];
										$sql4 = "SELECT * FROM tbl_variation WHERE var_id = '$variation'";
										$result4 = dbQuery($dbConn, $sql4);
										if(dbNumRows($result4) >0){
											$row4 = dbFetchAssoc($result4);
											//echo $row2 -> title .'.........'. $row2 ->var_title .'.........'. $row2->image .'..........' .$row2->retail_price .'<br>';
											?>
											<div class="col-md-3" >
												<div class="itembox quotebox" >		
													<img src="upload/variation/<?php variationImage($dbConn, $row4['var_id']); ?>" alt="" class="img-responsive" />
													<p><?php variationtitle($dbConn, $row4['var_id']); ?></p>
												</div>
											</div><?php
										}
									}
								} ?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 text-center">
								<div id="showDiv">
									<form name="" method="POST" action="get-a-quote.php">
										<input type="hidden" name="txtProId" value="<?php echo $txtProId; ?>" />
										<input type="submit" name="btnShowQuote" class="btn butn" value="NEXT STEP" />
									</form>
								</div>
							</div>
						</div>
						<!--Here place the pagignation-->
						<div class="space-lg"></div>
						<div class="space-lg"></div>
					</section>
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
