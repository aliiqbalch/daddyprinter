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
	<!--Header: Begin-->
	<?php include('files/header.php');?>
	<!--Main index : End-->
	<main class="main">
		<section class="header-page aboutuspg">
			<div class="container">
				<div class="row">
					<div class="col-sm-3 hidden-xs">
						<h1 class="mh-title">About Us</h1>
					</div>
					<div class="breadcrumb-w col-sm-9">
						<ul class="breadcrumb">
							<li>
								<a href="#">Home</a>
							</li>
							<li>
								<span>About Us</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</section>
		<section id="aboutus" class="pr-main">
			<div class="container">			
				<div class="col-md-6 col-sm-6 col-xs-12">
					<img src="assets/images/abouts/about01.jpg">
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="top">
						<h2><span>Welcome To Daddy Printers</span></h2>
						<p class="text-justify">After years of working within the printing & advertising industry , exporting our products & services all round the world , we attained perfection and realized the gap in Pakistan. We realized that printers & advertisers in Pakistan lackexposure , creativity & perfection. We are here to provide our prestigious clients high quality branding with creativity &innovation , serving high quality printables& outdoor material make us “ Daddyprinters”. Our mission statement at Daddyprinters is “ not to compromise in perfection “ . Not only deailing with perfection is our main core job , but Daddyprinters is proud to announce the first online printing portal of Pakistan , where you can shop , benchmark & assess why we are different. This makes us Daddyprinters. </p>
					</div>
					
				</div>
				
			</div>
		</section>
		
	</main><!--Main index : End-->

	<?php include('files/footer.php');?>
	<?php include('files/mobile-menu.php');?>
	<?php include('files/bottom-script.php');?>
</body>
</html>
