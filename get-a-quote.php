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
	<script language="JavaScript" type="text/JavaScript">
		function numericFilter(txb){
			txb.value = txb.value.replace(/[^\0-9]/ig, "");
		}
		function alphabetFilter(txb){
		   txb.value = txb.value.replace(/[^\a-z ]/ig, "");
		}
		
		$(document).ready(function () {
			$('#quotebtn').click(function(e){
				e.preventDefault();
				var txtquote = document.getElementById('txtquote').value;	
				$.ajax( {
					type: 'post',
					//our baseurl variable in action will call a method in our default controller
					url: 'getaquote.php',
					data: { txtquote: txtquote},
					success: function ( result ){
						//Ajax call success and we can show the value returned by our controller function
						$( '#quoteans' ).html( result ).fadeIn( 'slow' ).delay( 3000 );	
					},
					error: function ( result ){	
						//Ajax call failed, so we inform the user something went wrong	
						$( '#quoteans' ).html( 'Server unavailable now: please, retry later.' ).fadeIn( 'slow' ).delay( 3000 );	
					}
				} );
			});
		} ); 
	
	</script>
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
						<div class="productoptionbox ">
							<h1>Your Selections</h1>
						</div>
					</div>
					<div class="col-md-4 category-image">
						<div class="productoptionbox active">
							<h1>Get a quote</h1>
						</div>
					</div>
				</div>
				<div class="space"></div>
				<div class="row">
					<section class="col-sm-12 col-md-12">
						<div class="bg-white quotebox">
							
							<h3 class="acc-title lg">Quantity</h3>
							<div class="space"></div>
							<form id="contact-form" class="form-validate form-horizontal" method="post" action="#">
								<div class="row">
									<div class="col-md-5">
										<label>Please enter your quantity to get a quote*</label>
										<input type="text" id="txtquote" class="form-control" value="<?php echo $pro_min_qty;?>" required onKeyUp="numericFilter(this);" />
										
										<button type="submit" class="btn butn" id="quotebtn" >Get a Quote</button>
										<div class="space"></div>
										<label>Price does not include VAT or delivery. Free Delivery Available</label>
										<label>Proceed to checkout for full delivery options</label>
									</div>
									<div class="col-md-7">
										<div id="quoteans">
											
										</div>
									</div>
								</div>
							</form>
								
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
