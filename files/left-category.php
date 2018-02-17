	
	
	<h3 class="sidebar-title">Category</h3>
	<ul id="cate_list" class="cate_list">
		<?php
		$headsql = "SELECT * FROM tbl_category";
		$headres = dbQuery($dbConn, $headsql);
		if(dbNumRows($headres) >0){
			while($headrow = dbFetchAssoc($headres)){ ?>
				<li class="level0 parent" id="leftcat">
					<a href="#" title="<?php echo $headrow['cat_title'];?>">
						<span><?php echo $headrow['cat_title'];?></span>
						<i class="fa fa-minus"></i><i class="fa fa-plus"></i>
					</a>
					<ul class="level0">
						<?php
						$catid = $headrow['cat_id'];
						$headsql2 = "SELECT * FROM tbl_sub_category WHERE cat_id = '$catid' ";
						$headres2 = dbQuery($dbConn, $headsql2);
						if(dbNumRows($headres2) >0){
							while($headrow2 = dbFetchAssoc($headres2)){ ?>
								<li class="level1 nav-1-1 first item">
									<a href="product.php?catid=<?php echo $headrow['cat_id']?>&subcat=<?php echo $headrow2['sub_cat_id'];?>" title="<?php echo $headrow2['sub_cat_title'];?>">
										<?php echo $headrow2['sub_cat_title'];?>
										<span class="count-item"><?php countproduct($dbConn, $headrow2['sub_cat_id']);?></span>
									</a>
								</li> <?php
							}
						} ?>
					</ul>
				</li> 
				<?php
			}
		} ?>
		
	</ul>
	<div class="category-left-banner">
		<a href="#" title="category left banner">
			<img src="assets/images/banner/category/left-banner.jpg" alt="Left banner">
		</a>
	</div>
	
	
	
	
	
	