<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';
	
	if(isset($_POST['CatId']) && $_POST['CatId'] > 0){
		$CatId = $_POST['CatId'];
		$sql =  "SELECT * FROM tbl_product WHERE cat_id = '$CatId' ORDER BY pro_id DESC";
		$result     = dbQuery($dbConn, $sql);
		
		if (dbNumRows($result) > 0) {
			if(isset($_GET['page'])){
				$page = $_GET['page'] - 1;
				$i = $rowsPerPage * $page +1;
			}else{
				$i = 1;
			}
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
		} 
	}
?>
	
	
					
					
					
					
					