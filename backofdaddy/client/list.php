<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$rowsPerPage = 20;
  	$sql		=	"SELECT * FROM tbl_client";

	$result     = dbQuery($dbConn, getPagingQuery($sql, $rowsPerPage));
	$pagingLink = getPagingLink($dbConn, $sql, $rowsPerPage);
 	
?>
	<?php include(THEME_PATH . '/tb_link.php');?>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Client's</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Client's</li>
		</ol>
    </section>
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid container_block">
			<div>
				<?php 
				if(isset($_SESSION['errorMessage']) && isset($_SESSION['count'])){
					if($_SESSION['count'] <= 1){
						$_SESSION['count'] +=1; ?>
						<div class="space"></div>
						<p class="alert alert-success"><?php echo $_SESSION['errorMessage'];  ?></p> <?php
						unset($_SESSION['errorMessage']);
					}
				} ?>
			</div>
			<?php if(modPerAdd($dbConn,"14")){?>
			<div class="row">
				<div class="col-md-10 col-sm-11 col-xs-11" style="margin-top: 15px;">
					<input type="submit" name="btnButton" value="Add New Client" class="butn" onclick="addClient()"  />
				</div>
			</div>
			<?php }?>
			<div class="row bord-right-space" >
				
				<div class="table-responsive tbl-respon">
					<table class="table table-bordered tbl-respon2">
						<thead>
							<tr>
								<th>Sr.No</th>
								<th>Company Name</th>
								<th>Name</th>
								<th style="width: 120px;">Phone No</th>
								<th>Notes</th>
								<th style="width: 120px;">Folow Up Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (dbNumRows($result) > 0){
								if(isset($_GET['page'])){
									$page = $_GET['page'] - 1;
									$i = $rowsPerPage * $page +1;
								}else{
									$i = 1;
								}
								while($row = dbFetchAssoc($result)) {
									extract($row);
									?>
									<tr>
										<td><?php echo $i++;?></td>
										<td><?php echo $client_cmpy_name; ?></td>
										<td><?php echo $client_name; ?></td>
										<td><?php echo $client_phone; ?></td>
										<td><?php echo $client_notes; ?></td>
										<td><?php echo $client_nxt_folow_date; ?></td>
										<td>
											<?php if(modPerView($dbConn,"14")){?>
											<a href="javascript:detailclient(<?php echo $client_id; ?>)"><i class="fa fa-eye"></i></a> <br>
										<?php } if(modPerModify($dbConn,"14")){?>
											<a href="javascript:clientUpdate(<?php echo $client_id; ?>)"><i class="fa fa-edit"></i></a> <br>
										<?php } if(modPerDelete($dbConn,"14")){?>
											<a href="javascript:deleteClient(<?php echo $client_id; ?>)"><i class="fa fa-trash"></i></a>
											<?php }?>
										</td>
									</tr><?php
								}
							}else { ?>
								<tr >
									<td height="20" colspan="8" align="center">No User/ Admin Added Yet</td>
								</tr>
								<?php 
							} //end while ?>
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
			