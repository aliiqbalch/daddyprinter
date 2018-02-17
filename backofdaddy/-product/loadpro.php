
	<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';
	if(isset($_REQUEST['txtsearch'])){
		
		$txtTitle = $_REQUEST['txtsearch'];
		if(!empty($txtTitle)){
			
			$sql = "SELECT * FROM tbl_product WHERE pro_title = '$txtTitle'";
			$result = dbQuery($dbConn, $sql);
			?>
			<div class="row bord-right-space" >
				<div class="table-responsive tbl-respon">
					<table  class="table table-bordered table-striped tbl-respon2">
						<thead>
							<tr>
								<th >Sr.No</th>
								<th >Category</th>
								<th >Image</th>
								<th >Title</th>
								<th >Minimum Qty</th>
								<th >Multiple Qty</th>
								<th >Action</th>
							</tr>
						</thead>
						<tbody id="shocategory">
							<?php
							if (dbNumRows($result) > 0) {
								$i = 1;
								while($row = dbFetchAssoc($result)){
									extract($row);
									 ?>
									<tr>
										<td><?php echo $i++;?></td>
										<td><?php categoryName($dbConn, $cat_id);?></td>
										<td>
											<?php  
												if ($pro_main_img != '') { ?>
													<img src="<?php echo WEB_ROOT."upload/product/". $row['pro_main_img']; ?>"  width="70px" height="70px"/>
													<?php 
												}else{ 
													echo "";
												}
											?>
										</td>
										<td><?php echo $pro_title;?></td>
										<td><?php echo $pro_min_qty;?></td>
										<td><?php echo $pro_multi_qty;?></td>
										<td>
											<a href="javascript:viewpro(<?php echo $pro_id;?>)">
												<i class="fa fa-eye"></i>&nbsp;
											</a>
											<a href="javascript:modifyPro(<?php echo $pro_id;?>)">
												<i class="fa fa-edit"></i>&nbsp;
											</a>
											<a href="javascript:deletePro(<?php echo $pro_id;?>)">
												<i class="fa fa-trash"></i>
											</a>
										</td>
									</tr><?php
								}
							} ?>
							
						</tbody>
					</table>
				</div>
			</div>
			<div class="space"></div> <?php
		}
		
	}else{
		
	}
	
	?>	
	
	
	
		
		