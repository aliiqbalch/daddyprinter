
<?php

/* My Own Function */
	//show Category Name
	function categoryName($dbConn, $cat_id){
		$sql = "SELECT * FROM tbl_category WHERE cat_id = '$cat_id'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$row = dbFetchAssoc($result);
			echo $row['cat_title'];
		}
	}
	//show sub category name
	function subcategoryName($dbConn, $sub_cat_id){
		$sql = "SELECT * FROM tbl_sub_category WHERE sub_cat_id = '$sub_cat_id'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$row = dbFetchAssoc($result);
			echo $row['sub_cat_title'];
		}
	}
	//show Sub-Category Counting
	function countproduct($dbConn, $sub_cat_id){
		$sql = "SELECT * FROM tbl_product WHERE sub_cat_id = '$sub_cat_id'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			echo dbNumRows($result);
		}else{
			echo 0;
		}
	}
	//show category image
	function categoryImg($dbConn, $CatId){
		$sql = "SELECT cat_img FROM tbl_category WHERE cat_id = '$CatId'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			$row = dbFetchAssoc($result);
			echo $row['cat_img'];
		}
	}
	// show variation type name
	function variationtypeName($dbConn, $var_type_id){
		$sql = "SELECT * FROM tbl_variation_type WHERE var_type_id = '$var_type_id'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$row = dbFetchAssoc($result);
			echo $row['var_type_title'];
		}
	}
	//show variation title
	function variationtitle($dbConn, $var_id){
		$sql = "SELECT var_title FROM tbl_variation WHERE var_id = '$var_id' ";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			while($row = dbFetchAssoc($result)) {
				// build combo box options
				echo $row['var_title'];
			} //end while
		}
	}
	// Show variation image
	function variationImage($dbConn, $var_id){
		$sql = "SELECT var_img FROM tbl_variation WHERE var_id = '$var_id' ";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			while($row = dbFetchAssoc($result)) {
				// build combo box options
				echo $row['var_img'];
			} //end while
		}
	}
	//SHOW PRODUCT PRICE SINGLE
	function get_pro_price($dbConn, $prosingleid){
		$sql = "SELECT * FROM tbl_product WHERE pro_id = '$prosingleid'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			$row = dbFetchAssoc($result);
			return $row['pro_price'];
		}
	}
	//SHOW VARIATION TYPE PRODUCT SHEET DEPENDENT
	function get_sheet($dbConn, $variationtypeid){
		$sql = "SELECT var_type_sheet_depend FROM tbl_variation_type WHERE var_type_id = '$variationtypeid'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			$row = dbFetchAssoc($result);
			return $row['var_type_sheet_depend'];
		}
	}
	//SHOW VARIATION COST PRICE
	function get_var_retail_price($dbConn, $productId, $variation){
		$sql = "SELECT pv_retail FROM tbl_pro_var WHERE pro_id = '$productId' AND var_id = '$variation'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			$row = dbFetchAssoc($result);
			return $row['pv_retail'];
		}
	}
	//SHOW PRO_PRINT_SHEET FROM PRODUCT
	function get_pro_print_sheet($dbConn, $productId){
		$sql = "SELECT pro_print_sheet FROM tbl_product WHERE pro_id = '$productId'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			$row = dbFetchAssoc($result);
			return $row['pro_print_sheet'];
		}
	}
	function chkproductsame($dbConn, $ProId){
		if(isset($_SESSION['items'])){
			foreach($_SESSION['items'] as $key => $row){
				$productId = $row['productId'];
				if($productId == $ProId){
					
				}else{
					unset($_SESSION['items']);
				}
				
			}
		}
	}
	
/* My Own Function */










?>