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

	<!--Main index : Begin-->
	<main class="main index">
		<?php include('files/slider.php');?>
		<!--Home Category : Begin-->
		<section class="home-category">
			<div class="container">
				<div class="row"> 
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 block block-left">
						<a href="#" class="image">
							<img src="assets/images/banner/category/leaflet.jpg" alt="leaflet"/>
						</a>
						<div class="info" id="convasbox">
							<a href="#">LEAFLET</a>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 block block-center">
						<div class="inner-top">
							<div class="box-left">
								<a href="#" class="image frist">
									<img src="assets/images/banner/category/visiting-card.jpg" alt="visiting-card"/>
								</a>
								<div class="info" id="convasbox">
									<a href="#">VISITING CARD</a>
								</div>
							</div>
							<div class="box-right">
								<a href="#" class="image">
									<img src="assets/images/banner/category/business-folder.jpg" alt="business-folder"/>
								</a>
								<div class="info" id="convasbox">
									<a href="#">BUSINESS FOLDER</a>
								</div>
							</div>
						</div>
						<div class="inner-bottom">
							<a href="#" class="image">
								<img src="assets/images/banner/category/files.jpg" alt="files"/>
							</a>
							<div class="info" id="convasbox">
								<a href="#">FILES</a>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 block block-right">
						<div class="inner-top">
							<a href="#" class="image">
								<img src="assets/images/banner/category/flyer.jpg" alt="flyer"/>
							</a>
							<div class="info" id="convasbox">
								<a href="#">FLYER</a>
							</div>
						</div>
						<div class="inner-bottom">
							<a href="#" class="image">
								<img src="assets/images/banner/category/broucher.jpg" alt="broucher"/>
							</a>
							<div class="info" id="convasbox">
								<a href="#">BROUCHER</a>
							</div>
						</div>
					</div> 
				</div>
			</div>
		</section>
		
		<!--Home Promotions Products : Begin -->
		<section class="home-promotion-product home-product parten-bg">
			<div class="container">
				<div class="row">
					<div class="block-title-w">
						<h2 class="block-title">Latest Products</h2> 
						<span class="icon-title">
							<span></span>
							<i class="fa fa-star"></i>
						</span>
					</div>
					<ul class="slider-w slider-owl">
						<?php
						$sql = "SELECT * FROM tbl_product ORDER BY RAND()";
						$result = dbQuery($dbConn, $sql);
						if(dbNumRows($result) >0){
							while($row = dbFetchAssoc($result)){
								extract($row); ?>
								<li class="pro-item">
									<div class="product-image-action">
										<img src="upload/product/<?php echo $pro_main_img;?>" alt="<?php echo $pro_title;?>">
										<div class="action">
											<a href="#" data-toggle="tooltip" data-placement="top" title="View-Detail" class="quick-view"><i class="fa fa-eye"></i></a>			
										</div>
										<span class="product-icon sale-icon">New!</span>
									</div>
									<div class="product-info">
										<a href="#"  class="product-name"><?php echo $pro_title;?></a> 
									</div>
								</li> <?php
							}
						} ?>
					
						
					</ul>
				</div>
			</div>
		</section><!--Home Promotions Products : End -->
		<!--Home New print Template : Begin -->
		<section class="home-new-product home-product parten-bg">
			
		</section><!--Home New Products : End -->
		<!--Home blog : Begin -->
		<section class="home-blog">
			<div class="container">
				<div class="row">
					<div class="block-title-w">
						<h2 class="block-title">recent blog post</h2> 
						<span class="icon-title">
							<span></span>
							<i class="fa fa-star"></i>
						</span> 
					</div>
					<div class="blog-content-w" id="blog-content-w">
						<div class="slider">
							<div class="slider-inner">
								<!--wrap-item wali div ko dubra repeat krny say blog bny ga complete-->
								<div class="wrap-item"> 
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 item">
										<div class="inner"> 
											<a class="image" href="#">
												<img src="assets/images/blog/1.jpg" alt="blog-01"/>
											</a>
											<div class="info">
												<div class="title">
													<a href="#">Happy New Year 2017</a>
												</div>
												<div class="sub-title">
													<p>
														Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam...
													</p>
												</div>
												<a href="#" class="read-more">Read more</a>
											</div>
										</div>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 item item-even">
										<div class="inner">
											<div class="info">
												<div class="title">
													<a href="#">Happy Holidays Photo Cards</a>
												</div>
												<div class="sub-title">
													<p>
														Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam...
													</p>
												</div>
												<a href="#" class="read-more">Read more</a>
											</div>
											<a class="image" href="#">
												<img src="assets/images/blog/2.jpg" alt="blog-01"/>
											</a>
										</div>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 item">
										<div class="inner">
											<a class="image" href="#">
												<img src="assets/images/blog/3.jpg" alt="blog-01"/>
											</a>
											<div class="info">
												<div class="title">
													<a href="#">Happy Holidays Photo Cards</a>
												</div>
												<div class="sub-title">
													<p>
														Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam...
													</p>
												</div>
												<a href="#" class="read-more">Read more</a>
											</div>
										</div>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 item item-even">
										<div class="inner">
											<div class="info">
												<div class="title">
													<a href="#">Happy Holidays Photo Cards</a>
												</div>
												<div class="sub-title">
													<p>
														Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam...
													</p>
												</div>
												<a href="#" class="read-more">Read more</a>
											</div>
											<a class="image" href="#">
												<img src="assets/images/blog/4.jpg" alt="blog-01"/>
											</a>
										</div>
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--Home make print : Begin -->
		<section class="home-make-print">
			<div class="container">
				<div class="row">
					<div class="block-title-w">
						<h2 class="block-title">HOW WE MAKE PRINTING AS EASY</h2> 
						<span class="icon-title">
							<span></span>
							<i class="fa fa-star"></i>
						</span> 
					</div><!--make print Title : End -->
					<div class="print-content">
						<div class="col-md-4 col-sm-4 print-block print-block-left">
							<div class="w-print-block frist">
								<div class="print-icon">
									<i class="fa fa-hand-o-up"></i>
									<i class="fa fa-newspaper-o"></i>
								</div>
								<div class="print-title">
									<a href="#">Select Options</a>
								</div>
								<div class="print-number">
									<span>01</span>
								</div>
								<div class="print-txt">
									<p>Choose options that you want for your prints.We will make you happy with your choices.</p>
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 print-block print-block-center">
							<div class="w-print-block">
								<div class="print-icon">
									<i class="fa fa-file-text-o"></i> 
									<i class="fa fa-arrow-circle-o-up"></i>
								</div>
								<div class="print-title">
									<a href="#">View your options</a>
								</div>
								<div class="print-number">
									<span>02</span>
								</div> 
								<div class="print-txt">
									<p>View your finished design here and we'll print it for you with your choices</p>
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 print-block print-block-right">
							<div class="w-print-block">
								<div class="print-icon">
									<i class="fa fa-shopping-cart"></i>
								</div>
								<div class="print-title">
									<a href="#">Checkout & Order</a>
								</div>
								<div class="print-number">
									<span>03</span>
								</div> 
								<div class="print-txt">
									<p>Checkout and finish your order very easy with one step checkout extension.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="bg_make_print">
				
			</div>
		</section>
		
		<section class="or-service">
			<div class="container">
				<div class="row">
					<div class="block-title-w">
						<h2 class="block-title">our services</h2>
						<span class="icon-title">
							<span></span>
							<i class="fa fa-star"></i>
						</span>
						<span class="sub-title">Choose the design path that is right before upload file</span>
					</div>
					<div class="or-service-w">
						<div class="col-md-3 col-sm-6 col-xs-6 or-block">
							<div class="or-image">
								<a href="#">
									<img src="assets/images/our_service/1.png" alt="service-01"/>
								</a>
							</div>
							<div class="or-title">
								<a href="#">graphic Design</a>
							</div>
							<div class="or-text">
								<p>
									let us design your next print project!
								</p>
							</div>
							<a href="#" class="btn-readmore order-now">View Detail</a>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-6 or-block">
							<div class="or-image">
								<a href="#">
									<img src="assets/images/our_service/2.png" alt="service-02"/>
								</a>
							</div>
							<div class="or-title">
								<a href="#">Mailing</a>
							</div>
							<div class="or-text">
								<p>
									Delivery, we can hand it all for you!
								</p>
							</div>
							<a href="#" class="btn-readmore order-now">View Detail</a>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-6 or-block">
							<div class="or-image">
								<a href="#">
									<img src="assets/images/our_service/3.png" alt="service-03"/>
								</a>
							</div>
							<div class="or-title">
								<a href="#">custom prints</a>
							</div>
							<div class="or-text">
								<p>
									we'll bring all your creative ideas to life!
								</p>
							</div>
							<a href="#" class="btn-readmore order-now">View Detail</a>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-6 or-block">
							<div class="or-image">
								<a href="#">
									<img src="assets/images/our_service/4.png" alt="service-04"/>
								</a>
							</div>
							<div class="or-title">
								<a href="#">free file check</a>
							</div>
							<div class="or-text">
								<p>
									we'll if your file is ready to print!
								</p>
							</div>
							<a href="#" class="btn-readmore order-now">View Detail</a>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--Home out recent : Begin -->
		
		<!--Home Testimonials : Begin -->
		<section class="home-testimonial">
			<div class="container">
				<div class="row">
					<div class="tes-block" id="testimonial"> 
						<div class="slider-inner">
							<div class="wrap-item">
								<?php 
								$sql1 = "SELECT * FROM tbl_testimonial ORDER BY test_id DESC LIMIT 3";
								$result1 = dbQuery($dbConn, $sql1);
								if(dbNumRows($result1) > 0){
									while($row2 = dbFetchAssoc($result1)){ ?>
										<div class="item">
											<div class="inner">
												<div class="image">
													<a href="#"><img src="upload/testimonial/<?php echo $row2['test_img'];?>" class="img-circle" alt="terminal-01" style="width: 158px;" /></a>
												</div>
												<div class="tes-name">
													<a href="#"><?php echo $row2['test_name'];?></a>
												</div>
												<div class="tes-job">
													<span><?php echo $row2['test_desig'];?></span>
												</div>
												<div class="tes-decs">
													<p><?php echo $row2['test_desc'];?></p>
												</div>
											</div>
										</div> <?php
									}
								} ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="bran-block">
						<div class="item col-md-2 col-sm-4 col-xs-6">
							<a href="#" class="image">
								<img src="assets/images/brands/al-meezan.jpg" alt="al-meezan"/>
							</a>
						</div>
						<div class="item col-md-2 col-sm-4 col-xs-6">
							<a href="#" class="image">
								<img src="assets/images/brands/omega.jpg" alt="omega"/>
							</a>
						</div>
						<div class="item col-md-2 col-sm-4 col-xs-6">
							<a href="#" class="image">
								<img src="assets/images/brands/gloria-jeans.jpg" alt="gloria-jeans"/>
							</a>
						</div>
						<div class="item col-md-2 col-sm-4 col-xs-6">
							<a href="#" class="image">
								<img src="assets/images/brands/hyatt-lahore.jpg" alt="hyatt-lahore"/>
							</a>
						</div>
						<div class="item col-md-2 col-sm-4 col-xs-6">
							<a href="#" class="image">
								<img src="assets/images/brands/athar.jpg" alt="athar"/>
							</a>
						</div>
						<div class="item col-md-2 col-sm-4 col-xs-6">
							<a href="#" class="image">
								<img src="assets/images/brands/gabz.jpg" alt="gabz"/>
							</a>
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>  
	<!--Footer : Begin-->
	<?php include('files/footer.php');?>
	<div id="sitebodyoverlay"></div>
	<?php include('files/mobile-menu.php');?>
	<?php include('files/bottom-script.php');?>
</body>
</html>
