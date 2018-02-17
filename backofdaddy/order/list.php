<?php
	
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$rowsPerPage = 10;
	$result=null;
	if(isset($_GET['order_search_btn']) && !empty($_GET['order_search_btn'])){
								$serach_param = $_GET['order_search'];
								$sql		=	"SELECT * FROM `order` WHERE status = 0 and client_id= $serach_param ORDER BY order_time desc";
								//echo $sql;
								$result     = dbQuery($dbConn, getPagingQuery($sql, $rowsPerPage));
								$url_query = "order_search=$serach_param&order_search_btn=Search";
								$pagingLink = getPagingLink($dbConn, $sql, $rowsPerPage, $url_query);
								
							}else{
								
  	$sql		=	"SELECT * FROM `order` WHERE status = 0 ORDER BY order_time desc";
		
	$result     = dbQuery($dbConn, getPagingQuery($sql, $rowsPerPage));
		
	$pagingLink = getPagingLink($dbConn, $sql, $rowsPerPage);
								}
	
?>
	<?php include(THEME_PATH . '/tb_link.php');?>
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Order Que Management</h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid container_block">
		<div class="row">
				<form action="" method='get'>
				<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
					<select name ='order_search' id='order_search' class='formField' style="margin-top: 26px;">
						<option value="1">Select Company</option>
						<?php
                    
					$sql1 = "SELECT * FROM tbl_client";
					$result1 = dbQuery($dbConn,$sql1);
					//print_r($result1);
					
					
                    //loop
                    foreach ($result1 as $row){
                ?>
                        <option value="<?php echo $row["client_id"];?>"><?php echo $row["client_cmpy_name"];
						?></option>
						
                <?php
                    $clientid=$row["client_id"];}
				
					   
                ?>
						
					</select>
				</div>
				<div class="col-md-8 col-sm-8" style="margin-bottom: 30px;">
					<label>&nbsp;</label></br>
					<input type="submit" id="order_search_btn" name="order_search_btn" value="Search" class="butn" />
				
				</form>
				
			</div>

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
			<div class="row bord-right-space" >
				<div class="table-responsive tbl-respon">
					<table class="table table-bordered tbl-respon2">
						<thead>
							<tr>
								<th>Sr.No</th>
							
								<th>Company Name</th>
								<th>Name</th>
								<th>Phone Number</th>
								<th>Email</th>
								<th>Quotation No</th>
								<th>Status</th>
								<th>Sale Agent</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							
							if (dbNumRows($result) > 0){
								$i = 1;
								while($row = dbFetchAssoc($result)) {
									extract($row);
									
									?>
									<tr>
										<td><?php echo $i++;?></td>
										<td><a href="javascript:viewPendingOrderDetail(<?php echo $order_id; ?>)"><?=clientCampnyNameByID($dbConn, $client_id); ?></a></td>
										<td><?=clientName($dbConn, $client_id) ?></td>
										<td><?=clienNumber($dbConn,$client_id)?></td>
										<td><?=clienEmail($dbConn,$client_id) ?></td>
										<td><?=$order_id?></td>
										<td><?php
												if($status_id == 101){
													echo "Quotation";
												}elseif($status_id == 102){
													echo "Process";
												}
											?></td>
										<td><?=getUserNameById($dbConn,$user_id)?></td>
										<td>
											<?php if(modPerView($dbConn,"24")){?>
												<a href="processOrder.php?action=inact&orderId=<?=$order_id?>" title="<?php if($status_id == 101){echo'In Active';}else{echo'Complete';} ?>"><i class="fa"></i> -- </a>&nbsp;
										<?php } if(modPerModify($dbConn,"24")){?>
												<a href="../bill/index.php?view=detail&orderId=<?=$order_id?>" title="Bill"><i class="fa fa-bank"></i></a>&nbsp;
										<?php } if(modPerDelete($dbConn,"24")){?>
											<a href="javascript:deletePendingOrder(<?php echo $order_id; ?>)" title="Delete"><i class="fa fa-trash"></i></a>
										<?php }?>
										</td>
									</tr><?php
								}
							}else { ?>
								<tr>
									<td height="20">No Quotation Added Yet</td>
								</tr>
								<?php 
							} //end while ?>
							<tr height="20">
						<td align="center" colspan="9" class="pagingStyle"><?php echo $pagingLink;?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
				<!--- End Table ---------------->
				
		</div>
	</section><!-- /.content -->
			