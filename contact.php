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
	<!--Main index : End-->
	<main class="main">
		<section class="header-page contactpg">
			<div class="container">
				<div class="row">
					<div class="col-sm-4 hidden-xs">
						<h1 class="mh-title">Contact Us</h1>
					</div>
					<div class="breadcrumb-w col-sm-8">
						<ul class="breadcrumb">
							<li>
								<a href="index.php">Home</a>
							</li>
							<li>
								<span>Contact Us</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</section>
		<section id="pr-contact" class="" style="padding: 33px 0px 0px;">
			<div class="container">
				<div class="space-md"></div>
				<h1 class="heading01"><span>Contact us</span></h1>
			</div>
			<div class="container">
				<div class="col-md-3 col-sm-3 col-xs-12">
					<div class="address">
						<i class="fa fa-home"></i>
						<p><span>Address, DHA Lahore</span><br/></p>
					</div>
					<div class="phone">
						<i class="fa fa-phone"></i>
						<p><span>Telephone: 	(+92)423 716 5737</span></p>
					</div>
					<div class="website">
						<i class="fa fa-envelope-o"></i>
						<p>
						<span>info@daddyprinters.com </span>						
						</p>
					</div>
				</div>
				<form id="contact-form" class="form-validate form-horizontal" method="post" action="#">
					<div class="col-md-6 col-sm-6 col-xs-12">
							<label>Message*:</label>
							<textarea aria-required="true" required="required" class="required invalid" rows="10" cols="50" id="jform_contact_message" name="contact_message" aria-invalid="true" placeholder="Message *"></textarea>
						<p>Ask us a question and we'll write back to you promptly! Simply fill out the form below and click Send Email.</p>
						<p>Thanks. Items marked with an asterisk (<span class="star">*</span>) are required fields.</p>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-12">
						<label>Name*:</label>
						<input class="name" type="text" value="" placeholder="Enter your name *" />
						<label>Email*:</label>
						<input class="email" type="text" value="" placeholder="Enter E-mail *" />
						<label>Message*:</label>
						<input class="mesage" type="text" value="" placeholder="Enter Mesage Subject *" />
						
						<button type="submit" class="sendmail">Submit</button>
					</div>
				</form>
			</div>
			<div class="space-lg"></div>
			<div class="contact-map">
				<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d715.2925887976421!2d74.39440493781062!3d31.482273790613!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2s!4v1483615467736" width="100%" height="300" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" ></iframe>
			</div>
			
		</section>
	</main><!--Main index : End-->

	<!--Footer : Begin-->
	<?php include('files/footer.php');?>
	<div id="sitebodyoverlay"></div>
	<?php include('files/mobile-menu.php');?>
	<?php include('files/bottom-script.php');?>
</body>

</html>
