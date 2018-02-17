<?php
	include('php/config.php');
	include('php/database.php');
	include('php/functions.php');
	if(isset($_GET['product']) && $_GET['product'] > 0){
		$ProId = $_GET['product'];
		$sql = "SELECT * FROM tbl_product WHERE pro_id = '$ProId'";
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
						<div class="productoptionbox active">
							<h1>Product Options</h1>
						</div>
					</div>
					<div class="col-md-4 category-image">
						<div class="productoptionbox">
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
					<section class="col-sm-8 col-md-8">
						
						<div class="row">
							<?php
							$sql2 = "SELECT DISTINCT var_type_id FROM tbl_pro_var WHERE pro_id = '$ProId' ORDER BY pv_id DESC";
							$result2 = dbQuery($dbConn, $sql2);
							if(dbNumRows($result2) >0){
								$count = 0;
								while($row2 = dbFetchAssoc($result2)){ 
									$vartypeid = $row2['var_type_id']; ?>
									
									<aside class="col-md-12 col-sm-12 col-xs-12">
										<h3 class="acc-title lg"><?php variationtypeName($dbConn, $row2['var_type_id']); ?></h3>
										<div class="bg-white quotebox">
											<div class="row ">
												<?php
												$sql3 = "SELECT * FROM tbl_pro_var WHERE pro_id = '$ProId' AND  var_type_id = '$vartypeid' ORDER BY var_type_id ASC";
												$result3 = dbQuery($dbConn,$sql3);
												if(dbNumRows($result3) > 0){
													while($row3 = dbFetchAssoc($result3)){ 
														?>
														<div class="col-md-3" >
															<script>
																$(document).ready(function () {
																	$('#<?php echo $count;?>').click(function(e){
																		e.preventDefault();
																		//we grab all fields values to create our email
																		var name =  $('#<?php echo $count;?>').data('value');
																		//if it's all right we proceed
																		$.ajax( {
																			type: 'post',
																			//dataType : 'json',
																			//our baseurl variable in action will call a method in our default controller
																			url: 'quoteadd.php',	
																			data: { name: name},
																			success: function ( result ){
																				//alert(result);
																				//Ajax call success and we can show the value returned by our controller function	
																				$( '#response' ).html( result ).fadeIn( 'slow' ).delay( 3000 );
																			},	
																			error: function ( result ){	
																				//Ajax call failed, so we inform the user something went wrong	
																				$( '#response' ).html( 'Server unavailable now: please, retry later.' ).fadeIn( 'slow' ).delay( 3000 );
																			}
																		} );
																	});
																} ); 
															</script>
															<div class="itembox<?php echo $vartypeid;?> itembox" id="<?php echo $count;?>" data-value="<?php echo $ProId.'-'.$vartypeid .'-'. $row3['var_id']; ?>"  >		
																<img src="upload/variation/<?php variationImage($dbConn, $row3['var_id']); ?>" alt="" class="img-responsive" />
																<p><?php variationtitle($dbConn, $row3['var_id']); ?></p>
															</div>
														</div> <?php
														$count++;
													}
												} ?>
											</div>
										</div>
									</aside> 
									<script>
										$('.itembox<?php echo $vartypeid;?>').click(function() {
											$('.itembox<?php echo $vartypeid;?>').not($(this))
											.css( "border", "none" );
											$(this).css('border','2px solid #D18428');
										});
									</script>
									<?php
								}
							} ?>
							<div class="col-md-12 text-center">
								<div id="showDiv">
									<form method="POST" action="show-selection.php">
										<input type="hidden" name="txtProId" value="<?php echo $ProId; ?>" />
										<input type="submit" name="btnShowQuote" class="btn butn" value="NEXT STEP" />
									</form>
								</div>
							</div>
						</div>
						<!--Here place the pagignation-->
						<div class="space-lg"></div>
						<div class="space-lg"></div>
					</section>
					<!-- Category product grid : End -->
					<aside id="sidebar_cate" class="col-sm-4 hidden-xs">
						<h3 class="sidebar-title">Summary</h3>
						<div id="response"> <?php
							if(chkproductsame($dbConn, $ProId)){
								
							}
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
										<div class="itembox quotebox" >		
											<img src="upload/variation/<?php variationImage($dbConn, $row4['var_id']); ?>" alt="" class="img-responsive" />
											<p><?php variationtitle($dbConn, $row4['var_id']); ?></p>
										</div>
										<hr style="margin-bottom: 20px;"><?php
									}
								}
							} ?>
						</div>
						
						
						<div class="clearfix"></div>
						<div class="space-lg"></div>
					</aside>
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
