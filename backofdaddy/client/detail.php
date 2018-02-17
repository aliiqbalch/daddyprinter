<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

	if (isset($_GET['CliId']) && $_GET['CliId'] > 0) {
		$CliId = $_GET['CliId'];
	} else {
		redirect('index.php');
	}

	// get Page info
	$sql 	= 	"SELECT * FROM tbl_client WHERE client_id = $CliId";
	$result = 	 dbQuery($dbConn, $sql) ;
	$row    = 	 dbFetchAssoc($result);
	extract($row);
?> 
	<section class="content-header top_heading">
		<h1>Detail Client</h1>
	</section>
	<!-- Main content -->
	<section class="content" >
		
			<div class="container-fluid container_block">
				<div class="row inner_heading">
					<h1>Client Details</h1><hr>
				</div>
				
				<div class="row">
					
					<div class="col-md-12">
						<div class="row">
							<div class="table-responsive tbl-respon">
								<table class="table table-bordered tbl-respon2">
									<tbody>
										<tr>
											<td style="width: 150px;">Company Name</td>
											<td><?php echo $client_cmpy_name;?></td>
										</tr>
										<tr>
											<td>Name</td>
											<td><?php echo $client_name;?></td>
										</tr>
										<tr>
											<td>Registration Date</td>
											<td><?php echo $client_reg_date;?></td>
										</tr>
										<tr>
											<td>Phone No</td>
											<td><?php echo $client_phone;?></td>
										</tr>
										<tr>
											<td>Email</td>
											<td><?php echo $client_email;?></td>
										</tr>
										<tr>
											<td>Address</td>
											<td><?php echo $client_address;?></td>
										</tr>
										<tr>
											<td>City</td>
											<td><?php echo $client_city;?></td>
										</tr>
										<tr>
											<td>Reffernce</td>
											<td><?php referenceName($dbConn, $user_id);?></td>
										</tr>
										<tr>
											<td>Notes</td>
											<td><?php echo $client_notes;?></td>
										</tr>
										<tr>
											<td>Next Follow Up Date</td>
											<td><?php echo $client_nxt_folow_date;?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
				</div>
				
				<div style="min-height: 20px;"></div>
			</div>
			<div class="row">
				<div class="col-md-offset-5 col-xs-offset-3 col-sm-offset-5">
					<input type="button" name="btnCanlce" value="Back" class="butn" onclick="window.location.href='index.php'"/>
				</div>
			</div>
		
	</section><!-- /.content -->
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	