	
	
	<!--Footer : Begin-->
	<footer>
		<div class="footer-main">
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-sm-4 col-xs-12 about-us footer-col">
						<h2>About Us</h2>
						<div class="footer-content">
							<a href="#" title="daddyprinters logo footer" class="logo-footer">
								<img src="assets/images/logo/logo.png" alt="logo footer">
							</a>
							<ul class="info">
								<li>
									<i class="fa fa-home"></i>
									<span>DHA street no 123, Lahore Pakistan</span>
								</li>
								<li>
									<i class="fa fa-phone"></i>
									<span>(+92)423 716 5737</span>
								</li>
								<li>
									<i class="fa fa-envelope-o"></i>
									<span><a href="mailto:info@daddyprinters.com" title="send mail to daddyprinters">info@daddyprinters.com</a></span>
								</li>
							</ul>
							
						</div>
					</div>
					<div class="col-md-3 col-sm-4 col-xs-12 corporate footer-col">
						<h2>Corporate</h2>
						<div class="footer-content">
							<ul>
								<li><a href="about-us.php" >ABOUT US</a></li>
								<li><a href="#" >BLOG</a></li>
								<li><a href="#" >FAQ</a></li>
								<li><a href="#" >Terms of Service</a></li>
								<li><a href="#" >Privacy Policy</a></li>
								<li><a href="contact.php" >Contact Us</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-3 col-sm-4 col-xs-12 support footer-col">
						<h2>Category</h2>
						<div class="footer-content">
							<ul>
								<?php
								$fotsql = "SELECT * FROM tbl_category";
								$fotresult = dbQuery($dbConn, $fotsql);
								if(dbNumRows($fotresult) > 0){
									while($fotrow = dbFetchAssoc($fotresult)){ ?>
										<li>
											<a href="category.php?catid=<?php echo $fotrow['cat_id'];?>" ><?php echo $fotrow['cat_title'];?></a>
										</li> <?php
									}
								}
								?>
								
							</ul>
						</div>
					</div>
					<div class="col-md-3 col-xs-12 other-info footer-col hidden-sm">
						<h2>Other Info</h2>
						<div class="footer-content">
							<p>
								Daddyprinter is leading printers in Printing industry of Pakistan.After years of working within the printing & advertising industry , exporting our products & services all round the world.......
							</p>
							<ul class="footer-social">
								<li>
									<a href="#" title="Facebook">
										<i class="fa fa-facebook"></i>
									</a>
								</li>
								<li>
									<a href="#" title="Twiter">
										<i class="fa fa-twitter"></i>
									</a>
								</li>
								<li>
									<a href="#" title="Google plus">
										<i class="fa fa-google-plus"></i>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<p class="copy-right">Copyright © <?php echo date('Y');?> Daddy Printers. All Rights Reserved. </p>
						<a href="#" id="back-to-top" class="fixed">
							<i class="fa fa-chevron-up"></i>
							Top
						</a>
					</div>
				</div>
			</div>
		</div>
	</footer>