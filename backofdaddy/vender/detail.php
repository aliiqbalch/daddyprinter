<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	if (isset($_GET['VenId']) && $_GET['VenId'] > 0) {
		$VenId = $_GET['VenId'];
		
		$sql = "SELECT * FROM tbl_vender WHERE ven_id = $VenId";
		$result = dbQuery($dbConn, $sql) ;
		$row    = dbFetchAssoc($result);
		extract($row);
	}else {
		// redirect to index.php if user id is not present
		redirect('index.php');
	}
	
?>
	<?php include(THEME_PATH . '/tb_link.php');?>
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Vender Detail</h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid container_block">
			<div style="margin-top: 10px;">
				<?php 
				if(isset($_SESSION['errorMessage']) && isset($_SESSION['count'])){
					if($_SESSION['count'] <= 1){
						$_SESSION['count'] +=1; ?>
						<p class="alert alert-<?php echo $_SESSION['data'];?>"><?php echo $_SESSION['errorMessage'];  ?></p> <?php
						unset($_SESSION['errorMessage']);
					}
				} ?>
			</div>
			<div class="row bord-right-space" >
				<div class="col-md-12">
					<div class="row">
						<div class="table-responsive ">
							<table class="table table-bordered">
								<tbody>
									<tr>
										<td colspan="2">
											<?php
											if ($pic != '') { ?>
												<img src="<?php echo WEB_ROOT."upload/vender/". $pic; ?>" width="70px" height="70px" />
												<?php 
											}else{ ?>
												<img src="<?php echo WEB_ROOT."upload/blank.png";?>" width="70px" height="70px" /> <?php
											} ?>
										</td>
									</tr>
									<tr>
										<td class="heading3"><strong>Name</strong></td>
										<td><?php echo $ven_name;?></td>
									</tr>
									<tr>
										<td class="heading3"><strong>Company Name</strong></td>
										<td><?php echo $ven_cmp_name;?></td>
									</tr>
									<tr>
										<td class="heading3"><strong>Phone</strong></td>
										<td><?php echo $phone;?></td>
									</tr>
									<tr>
										<td class="heading3"><strong>Email</strong></td>
										<td><?php echo $email;?></td>
									</tr>
									<tr>
										<td class="heading3"><strong>City</strong></td>
										<td><?php echo $city;?></td>
									</tr>
									<tr>
										<td class="heading3"><strong>Address</strong></td>
										<td><?php echo $address;?></td>
									</tr>
									<tr>
										<td colspan="2">&nbsp;</td>
										
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!--- End Table ---------------->
		</div>
		<div class="row">
			<div class="col-md-offset-5 col-xs-offset-3 col-sm-offset-5">
				<input type="submit" name="btnButton" value="Modify" class="butn" onclick="modifyven(<?php echo $ven_id;?>)" /> &nbsp;
				<input type="button" name="btnCanlce" value="Back" class="butn" onclick="window.location.href='index.php'"/>
			</div>
		</div>
	</section><!-- /.content -->
		