<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';
	
	if(isset($_POST['CatId']) && $_POST['CatId'] > 0){
		$CatId = $_POST['CatId'];
		$sql =  "SELECT * FROM tbl_sub_category WHERE cat_id = '$CatId' ORDER BY sub_cat_id DESC";
		$result     = dbQuery($dbConn, $sql);
		if (dbNumRows($result) > 0) {
			$i = 1;
			while($row = dbFetchAssoc($result)){
				extract($row);
				 ?>
				<tr>
					<td><?php echo $i++;?></td>
					<td><?php categoryName($dbConn, $cat_id);?></td>
					<td><?php echo $sub_cat_title;?></td>
					<td>
						<?php  
							if ($sub_cat_img != '') { ?>
								<img src="<?php echo WEB_ROOT."upload/subcategory/". $row['sub_cat_img']; ?>"  width="70px" height="70px"/>
								<?php 
							}else{ 
								echo "";
							}
						?>
					</td>
					<td>
						<?php  
							if ($sub_cat_banner != '') { ?>
								<img src="<?php echo WEB_ROOT."upload/subcategory/". $row['sub_cat_banner']; ?>"  width="100px" height="70px"/>
								<?php 
							}else{ 
								echo "";
							}
						?>
					</td>
					<td><?php echo $sub_cat_desc;?></td>
					<td>
						<a href="javascript:modifySubCat(<?php echo $sub_cat_id;?>)">
							<i class="fa fa-edit"></i>&nbsp;
						</a>
						<a href="javascript:deleteSubCat(<?php echo $sub_cat_id;?>)">
							<i class="fa fa-trash"></i>
						</a>
					</td>
				</tr><?php
			}
		}
	}
?>
	
	
					
					
					
					
					