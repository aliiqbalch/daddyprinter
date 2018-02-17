<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';
	
	if(isset($_POST['CatId']) && $_POST['CatId'] > 0){
		$CatId = $_POST['CatId'];
		$sql =  "SELECT * FROM tbl_product WHERE cat_id = '$CatId' ORDER BY pro_id DESC";
		$result     = dbQuery($dbConn, $sql);
		?>
		<thead>
		<tr>
			<th >Sr.No</th>
			<th >Category</th>
			<th >Image</th>
			<th >Title</th>
			<?php if($CatId == 4){?>
			<th >Qty</th>
			<th >Reminder Qty</th>
			<?php } else{?>
			<th >Minimum Qty</th>
			<th >Multiple Qty</th>
			<?php } ?>
			<th >Action</th>
		</tr>
		</thead>
		<?php
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
					<td><?php if($cat_id == 4){echo $pro_s_qty;}else {echo $pro_min_qty;}?></td>
					<td><?php if($cat_id == 4){echo $pro_s_qty_rim;}else {echo $pro_multi_qty;}?></td>
					<td>
						<?php if(modPerView($dbConn,"7")){?>
						<a href="javascript:viewpro(<?php echo $pro_id;?>)">
							<i class="fa fa-eye"></i>&nbsp;
						</a>
					<?php } if(modPerModify($dbConn,"7")){?>
						<a href="javascript:modifyPro(<?php echo $pro_id;?>)">
							<i class="fa fa-edit"></i>&nbsp;
						</a>
					<?php } if(modPerDelete($dbConn,"7")){?>
						<a href="javascript:deletePro(<?php echo $pro_id;?>)">
							<i class="fa fa-trash"></i>
						</a>
					<?php }?>
					</td>
				</tr><?php
			}
		} 
	}
?>
	
	
					
					
					
					
					