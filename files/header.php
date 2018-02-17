	
	
	<!--Header: Begin-->
	<header>
		<!--Top Header: Begin-->
		<section id="top-header" class="clearfix">
			<div class="container">
				<div class="row">
					<div class="top-links col-lg-7 col-md-6 col-sm-5 col-xs-6">
						<ul>
							
							<li class="hidden-xs">
								<a href="https://www.facebook.com/Daddyprinter/">
									<i class="fa fa-facebook"></i>
									<!-- Connect with facebook -->
								</a>
							</li>
							<li class="hidden-xs">
								<a href="#">
									<i class="fa fa-twitter"></i> 
								</a>
							</li>
							<li class="hidden-xs">
								<a href="#">
									<i class="fa fa-linkedin"></i>
								</a>
							</li>
						</ul>
					</div>
					<div class="top-header-right f-right col-lg-5 col-md-6 col-sm-7 col-xs-6">
						<div class="w-header-right">
							<div class="th-hotline">
								<i class="fa fa-envelope"></i>
								<span>info@daddyprinters.com</span>
							</div> 
							<div class="th-hotline">
								<i class="fa fa-phone"></i>
								<span>(+92) 0423 569 0914</span>
							</div> 
						</div>
					</div>
				</div>
			</div>
		</section><!--Top Header: End-->
		<!--Main Header: Begin-->
		<section class="main-header">
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-2 col-sm-4 col-xs-5 w-logo">
						<div class="logo hd-pd ">
							<a href="index.php">
								<img src="assets/images/logo/logo.png" alt="Daddy Printers" style="height: 64px;">
							</a>
						</div>	
					</div>
					<div class="col-lg-7 col-md-8 visible-md visible-lg">
						<nav id="main-menu" class="main-menu clearfix">
							<ul>
								<li class="level0 hd-pd"><a href="index.php" >Home</a></li>
								<li class="level0 hd-pd"><a href="about-us.php">About Us</a></li> 
								<li class="level0 parent col1 all-product hd-pd">
									<a href="categories.php"><span>All Products</span><i class="fa fa-chevron-down"></i></a>
									<ul class="level0" style="height: auto;">
										<li class="level1">
											<ul class="level1">
												<?php
												$headsql = "SELECT * FROM tbl_category";
												$headres = dbQuery($dbConn, $headsql);
												if(dbNumRows($headres) >0){
													while($headrow = dbFetchAssoc($headres)){
														extract($headrow); ?>
														<li class="level2">
															<a href="category.php?catid=<?php echo $cat_id;?>" title="<?php echo $cat_title; ?>"><?php echo $cat_title; ?></a>
															<ul class="level2">
																<li><span class="menu-title"><?php echo $cat_title; ?></span></li>
																<?php
																$headsql2 = "SELECT * FROM tbl_sub_category WHERE cat_id = $cat_id";
																$headres2 = dbQuery($dbConn, $headsql2);
																if(dbNumRows($headres2) >0){
																	while($headrow2 = dbFetchAssoc($headres2)){ 
																		extract($headrow2);?>
																		<li>
																			<a href="product.php?catid=<?php echo $cat_id?>&subcat=<?php echo $sub_cat_id;?>" title="<?php echo $sub_cat_title;?>"><?php echo $sub_cat_title;?></a>
																		</li> <?php
																	}
																} ?>
																<li><img src="assets/images/banner/menu/menu-cate-calendar.png" alt="Calendar"></li>
															</ul>
														</li>
														<?php
													}
												} ?>
											</ul>
										</li>
									</ul>
								</li>
								<li class="level0 hd-pd" ><a href="#">Blog</a></li>
								<li class="level0 hd-pd" ><a href="contact.php">Contact Us</a></li>
							</ul>
						</nav>
					</div>
					<div class="col-sm-1 col-sm-offset-5 col-xs-offset-2 col-xs-2 visible-sm visible-xs mbmenu-icon-w">
						<span class="mbmenu-icon hd-pd">
							<i class="fa fa-bars"></i>
						</span>
					</div>
					<div class="col-lg-1 col-md-2 col-sm-2 col-xs-3 headerCS">
						
						<div class="search-w SC-w hd-pd ">
							<span class="search-icon dropdowSCIcon">
								<i class="fa fa-search"></i>
							</span>
							<div class="search-safari">
								<div class="search-form dropdowSCContent">
									<form method="POST" action="#">
										<input type="text" name="search" placeholder="Search" />
										<input type="submit" name="search" value="Search">
										<i class="fa fa-search"></i>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section><!--Main Header: End-->
	</header><!--Header: End-->
	
