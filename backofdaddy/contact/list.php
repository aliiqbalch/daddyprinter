<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$rowsPerPage = 10;
	$sql =  "SELECT * FROM tbl_contact ORDER BY con_id DESC";
	$result     = dbQuery($dbConn, getPagingQuery($sql, $rowsPerPage));
	$pagingLink = getPagingLink($dbConn, $sql, $rowsPerPage);
	
?>
	<?php include(THEME_PATH . '/tb_link.php');?>
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Contact Us View</h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid container_block">
			<div style="margin-top: 5px;">
				<?php 
				if(isset($_SESSION['errorMessage']) && isset($_SESSION['count'])){
					if($_SESSION['count'] <= 1){
						$_SESSION['count'] +=1; ?>
						<p class="alert alert-success"><?php echo $_SESSION['errorMessage'];  ?></p> <?php
						unset($_SESSION['errorMessage']);
					}
				} ?>
			</div>
			
			<div class="row bord-right-space" >
				<div class="table-responsive tbl-respon">
					<table class="table table-bordered tbl-respon2">
						<thead>
							<tr>
								<th >Sr.No</th>
								<th >First Name</th>
								<th >Last Name</th>
								<th >Email</th>
								<th >Phone No</th>
								<th >Country</th>
								<th >Message</th>
								<th >Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (dbNumRows($result) > 0) {
								$i = 1;
								while($row = dbFetchAssoc($result)){
									extract($row); ?>
									<tr>
										<td><?php echo $i++;?></td>
										<td><?php echo $con_fname;?></td>
										<td><?php echo $con_lname;?></td>
										<td><?php echo $con_email;?></td>
										<td><?php echo $con_phone;?></td>
										<td><?php echo $con_country;?></td>
										<td><?php echo $con_msg;?></td>
										<td>
											<a href="javascript:replyfeedback(<?php echo $con_id;?>)">
												<i class="fa fa-envelope"></i></a>&nbsp;
											</a>
											<a href="javascript:deletefeedback(<?php echo $con_id;?>)"><i class="fa fa-trash"></i> </a>
										</td>
									</tr><?php
								}
							} ?>
							<tr height="20">
								<td align="center" colspan="8" class="pagingStyle"><?php echo $pagingLink;?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
				<!--- End Table ---------------->
		</div>
		
	</section><!-- /.content -->
		