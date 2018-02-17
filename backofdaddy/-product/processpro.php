
<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';
	checkUser();
	$action = isset($_GET['action']) ? $_GET['action'] : '';

	switch ($action) {
		
		case 'add' :
			addPro($dbConn);
			break;
		case 'vartype' :
			addvartype($dbConn);
			break;
		case 'provar' :
			addProvar($dbConn);
			break;
		case 'delete' :
			deletePro($dbConn);
			break;
		case 'modify' :
			modifyPro($dbConn);
			break;
		case 'modvartype' :
			modvartype($dbConn);
			break;
		case 'modifprovar' :
			modifprovar($dbConn);
			break;
		
		default :
			redirect('index.php');
	}
	//modify variation
	function modifprovar($dbConn){
		$txtProId	= mysqli_real_escape_string($dbConn, $_POST['txtProId']);
		$vtype_id 	= $_SESSION['vtype_id'];
		if(!empty($vtype_id)){
			foreach($vtype_id as $VarTypeId) {
				$sql = "SELECT * FROM tbl_variation WHERE var_type_id = '$VarTypeId' ORDER BY var_id ASC";
				$result = dbQuery($dbConn, $sql);
				if(dbNumRows($result) >0){
					while($row = dbFetchAssoc($result)){
						extract($row);
						if(!empty($_POST['variation'.$var_id])){
							$postVariId = $_POST['variation'.$var_id];
							if($postVariId == 1){
								$cost 		= $_POST['cost_price'.$var_id];
								$wholesale 	= $_POST['wholesale_price'.$var_id];
								$retail 	= $_POST['retail_price'.$var_id];
								
								$sql2 = "SELECT * FROM tbl_pro_var WHERE pro_id = '$txtProId' AND var_type_id = '$VarTypeId' AND var_id = '$var_id'";
								$result2 = dbQuery($dbConn, $sql2);
								if(dbNumRows($result2)){
									$sql3 = "UPDATE tbl_pro_var SET pv_cost = '$cost', pv_wholesale = '$wholesale', pv_retail = '$retail' WHERE pro_id = '$txtProId' AND var_type_id = '$VarTypeId' AND var_id = '$var_id'";
									$result3 = dbQuery($dbConn, $sql3);
									
								}else{
									$sql3 = "INSERT INTO tbl_pro_var(pro_id, var_type_id, var_id, pv_cost, pv_wholesale, pv_retail) VALUES ('$txtProId', '$VarTypeId', '$var_id', '$cost', '$wholesale', '$retail')";
									$result3 = dbQuery($dbConn, $sql3);
								}
								
							}
						}
					}
				}
			}
			unset($_SESSION['vtype_id']);
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Product variation updated successfully.";
			redirect("index.php?view=list");
		}else{
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "danger";
			$_SESSION['errorMessage'] = "Please select atleast one variation type.";
			redirect("index.php?view=add-vari-type");
		}
	}
	
	//modify variation types
	function modvartype($dbConn){
		$txtProId		= mysqli_real_escape_string($dbConn, $_POST['txtProId']);
		if(!empty($_POST['vtype_id'])) {
			/* Loop to store and display values of individual checked checkbox.
			foreach($_POST['vtype_id'] as $VarTypeId) {
				$sql = "INSERT INTO tbl_pro_var (pro_id, var_type_id)VALUES ('$txtProId', '$VarTypeId')";
				$result = dbQuery($dbConn, $sql);
				echo $VarTypeId . "<br>";
			}*/
			$_SESSION['vtype_id'] = $_POST['vtype_id'];
			$_SESSION['txtProId'] = $txtProId;
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Variation added successfully";
			redirect("index.php?view=modif-vari&PI=".$txtProId);
			
		}else{
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "danger";
			$_SESSION['errorMessage'] = "Please Select Atleast One Variation type.";
			redirect("index.php?view=mod-var-type&PI=".$txtProId);
		}
	}
	//Modify product detail
	function modifyPro($dbConn){
		$hidId			= mysqli_real_escape_string($dbConn, $_POST['hidId']);
		
		$txtCat			= mysqli_real_escape_string($dbConn, $_POST['txtCat']);
		$txtsubCat		= mysqli_real_escape_string($dbConn, $_POST['txtsubCat']);
		$txtTitle		= mysqli_real_escape_string($dbConn, $_POST['txtTitle']);
		$txtPrice		= mysqli_real_escape_string($dbConn, $_POST['txtPrice']);
		$txtMinqty		= mysqli_real_escape_string($dbConn, $_POST['txtMinqty']);
		$txtMultiqty	= mysqli_real_escape_string($dbConn, $_POST['txtMultiqty']);
		$txtPrintSheet	= mysqli_real_escape_string($dbConn, $_POST['txtPrintSheet']);
		$txtItemPrinted	= mysqli_real_escape_string($dbConn, $_POST['txtItemPrinted']);
		$txtLength		= mysqli_real_escape_string($dbConn, $_POST['txtLength']);
		$txtWidth		= mysqli_real_escape_string($dbConn, $_POST['txtWidth']);
		$txtdesc		= mysqli_real_escape_string($dbConn, $_POST['txtdesc']);
		
		$txtItemCod		= mysqli_real_escape_string($dbConn, $_POST['txtItemCod']);
		$txtQty			= mysqli_real_escape_string($dbConn, $_POST['txtQty']);
		$txtQtyRem		= mysqli_real_escape_string($dbConn, $_POST['txtQtyRem']);
		$txtCostPrice	= mysqli_real_escape_string($dbConn, $_POST['txtCostPrice']);
		$txtWholePrice	= mysqli_real_escape_string($dbConn, $_POST['txtWholePrice']);
		$txtRetailPrice	= mysqli_real_escape_string($dbConn, $_POST['txtRetailPrice']);
		
		$MainImg		= $_FILES['MainImg']['name'];
		$Img1			= $_FILES['Img1']['name'];
		$Img2			= $_FILES['Img2']['name'];
		$Img3			= $_FILES['Img3']['name'];
		$Img4			= $_FILES['Img4']['name'];
		//Select already exist to ni krta.
		
		$sql = "SELECT pro_id FROM tbl_product WHERE cat_id='$txtCat' AND sub_cat_id = '$txtsubCat' AND pro_title = '$txtTitle'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			
			$sql3 = "SELECT pro_main_img, pro_img_1, pro_img_2, pro_img_3, pro_img_4 FROM tbl_product WHERE pro_id = '$hidId'";
			$result3 = dbQuery($dbConn, $sql3);
			if(dbNumRows($result3) > 0){
				$row3 = dbFetchAssoc($result3);
				
				if ($MainImg != ''){
					@unlink( ABS_PATH ."upload/product/" . $row3['pro_main_img']);
					$main_img  =   uploadPagePic('MainImg' , ABS_PATH ."upload/product/", THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
				}else {
					$main_img = $row3['pro_main_img'];
				}
				if ($Img1 != '') {
					@unlink( ABS_PATH ."upload/product/" . $row3['pro_img_1']);
					$img_1 =   uploadPagePic('Img1' , ABS_PATH ."upload/product/", THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
				}else {
					$img_1 = $row3['pro_img_1'];
				}
				if ($Img2 != '') {
					@unlink( ABS_PATH ."upload/product/" . $row3['pro_img_2']);
					$img_2 =   uploadPagePic('Img2' , ABS_PATH ."upload/product/", THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
				}else {
					$img_2 = $row3['pro_img_2'];
				}
				if ($Img3 != '') {
					@unlink( ABS_PATH ."upload/product/" . $row3['pro_img_3']);
					$img_3 =   uploadPagePic('Img3' , ABS_PATH ."upload/product/", THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
				}else {
					$img_3 = $row3['pro_img_3'];
				}
				if ($Img4 != '') {
					@unlink( ABS_PATH ."upload/product/" . $row3['pro_img_4']);
					$img_4 =   uploadPagePic('Img4' , ABS_PATH ."upload/product/", THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
				}else {
					$img_4 = $row3['pro_img_4'];
				}
			}
			$sql2 = "UPDATE tbl_product SET pro_desc = '$txtdesc', pro_main_img = '$main_img', pro_img_1 = '$img_1', pro_img_2 = '$img_2', pro_img_3 = '$img_3', pro_img_4 = '$img_4', pro_price = '$txtPrice',
			pro_print_sheet = '$txtPrintSheet', pro_item_per_sheet = '$txtItemPrinted', pro_length = '$txtLength', pro_width = '$txtWidth', pro_min_qty = '$txtMinqty', pro_multi_qty = '$txtMultiqty',
			pro_s_item_cod = '$txtItemCod', pro_s_qty = '$txtQty', pro_s_qty_rim = '$txtQtyRem', pro_s_cost_price = '$txtCostPrice', pro_s_whole_price = '$txtWholePrice', pro_s_retail_price ='$txtRetailPrice'
			WHERE pro_id = '$hidId'";
			$result2 = dbQuery($dbConn, $sql2);
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Product updated.";
			if($txtItemCod > 0){
				redirect("index.php?view=list");
			}else{
				redirect("index.php?view=mod-var-type&PI=".$hidId);
			}
			
		}else{
			//Update all product information.
			$sql3 = "SELECT pro_main_img, pro_img_1, pro_img_2, pro_img_3, pro_img_4 FROM tbl_product WHERE pro_id = '$hidId'";
			$result3 = dbQuery($dbConn, $sql3);
			if(dbNumRows($result3) > 0){
				$row3 = dbFetchAssoc($result3);
				
				if ($MainImg != ''){
					@unlink( ABS_PATH ."upload/product/" . $row3['pro_main_img']);
					$main_img  =   uploadPagePic('MainImg' , ABS_PATH ."upload/product/", THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
				}else {
					$main_img = $row3['pro_main_img'];
				}
				if ($Img1 != '') {
					@unlink( ABS_PATH ."upload/product/" . $row3['pro_img_1']);
					$img_1 =   uploadPagePic('Img1' , ABS_PATH ."upload/product/", THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
				}else {
					$img_1 = $row3['pro_img_1'];
				}
				if ($Img2 != '') {
					@unlink( ABS_PATH ."upload/product/" . $row3['pro_img_2']);
					$img_2 =   uploadPagePic('Img2' , ABS_PATH ."upload/product/", THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
				}else {
					$img_2 = $row3['pro_img_2'];
				}
				if ($Img3 != '') {
					@unlink( ABS_PATH ."upload/product/" . $row3['pro_img_3']);
					$img_3 =   uploadPagePic('Img3' , ABS_PATH ."upload/product/", THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
				}else {
					$img_3 = $row3['pro_img_3'];
				}
				if ($Img4 != '') {
					@unlink( ABS_PATH ."upload/product/" . $row3['pro_img_4']);
					$img_4 =   uploadPagePic('Img4' , ABS_PATH ."upload/product/", THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
				}else {
					$img_4 = $row3['pro_img_4'];
				}
			}
			
			$sql2 = "UPDATE tbl_product SET cat_id = '$txtCat', sub_cat_id = '$txtsubCat', pro_title = '$txtTitle', pro_desc = '$txtdesc', 
			pro_main_img = '$main_img', pro_img_1 = '$img_1', pro_img_2 = '$img_2', pro_img_3 = '$img_3', pro_img_4 = '$img_4', pro_price = '$txtPrice',
			pro_print_sheet = '$txtPrintSheet', pro_item_per_sheet = '$txtItemPrinted', pro_length = '$txtLength', pro_width = '$txtWidth', pro_min_qty = '$txtMinqty', pro_multi_qty = '$txtMultiqty',
			pro_s_item_cod = '$txtItemCod', pro_s_qty = '$txtQty', pro_s_qty_rim = '$txtQtyRem', pro_s_cost_price = '$txtCostPrice', pro_s_whole_price = '$txtWholePrice', pro_s_retail_price ='$txtRetailPrice'
			WHERE pro_id = '$hidId'";
			$result2 = dbQuery($dbConn, $sql2);
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Product updated.";
			if($txtItemCod > 0){
				redirect("index.php?view=list");
			}else{
				redirect("index.php?view=mod-var-type&PI=".$hidId);
			}
			
		}
	}
	
	
	
	//Delete product form tbl_product AND tbl_pro_var
	function deletePro($dbConn) {
		if(isset($_GET['ProId']) && ($_GET['ProId'])>0 ){
			$ProId = $_GET['ProId'];
		}else{
			redirect("index.php");
			exit();
		}
		
		$sql2 = "SELECT pro_main_img, pro_img_1, pro_img_2, pro_img_3, pro_img_4 FROM tbl_product WHERE pro_id = '$ProId'";
		$result2 = dbQuery($dbConn, $sql2);
		$row = dbFetchAssoc($result2);
		@unlink( ABS_PATH ."upload/product/" .$row['pro_main_img']);
		@unlink( ABS_PATH ."upload/product/" .$row['pro_img_1']);
		@unlink( ABS_PATH ."upload/product/" .$row['pro_img_2']);
		@unlink( ABS_PATH ."upload/product/" .$row['pro_img_3']);
		@unlink( ABS_PATH ."upload/product/" .$row['pro_img_4']);
		
		$sql    =	"DELETE FROM tbl_pro_var WHERE pro_id ='$ProId'";		
		$result = 	 dbQuery($dbConn, $sql);
		
		$sql3 = "DELETE FROM tbl_product WHERE pro_id = '$ProId'";
		$result3 = dbQuery($dbConn, $sql3);
		
		$_SESSION['count'] = 0;
		$_SESSION['data'] = "success";
		$_SESSION['errorMessage'] = "Product Delted Successfully";
		redirect("index.php?view=list");
	}
	//Add Product Variation which selected
	function addProvar($dbConn){
		$txtProId	= mysqli_real_escape_string($dbConn, $_POST['txtProId']);
		$vtype_id 	= $_SESSION['vtype_id'];
		if(!empty($vtype_id)){
			foreach($vtype_id as $VarTypeId) {
				$sql = "SELECT * FROM tbl_variation WHERE var_type_id = '$VarTypeId' ORDER BY var_id ASC";
				$result = dbQuery($dbConn, $sql);
				if(dbNumRows($result) >0){
					while($row = dbFetchAssoc($result)){
						extract($row);
						if(!empty($_POST['variation'.$var_id])){
							$postVariId = $_POST['variation'.$var_id];
							if($postVariId == 1){
								$cost 		= $_POST['cost_price'.$var_id];
								$wholesale 	= $_POST['wholesale_price'.$var_id];
								$retail 	= $_POST['retail_price'.$var_id];
								$sql2 = "INSERT INTO tbl_pro_var(pro_id, var_type_id, var_id, pv_cost, pv_wholesale, pv_retail) VALUES ('$txtProId', '$VarTypeId', '$var_id', '$cost', '$wholesale', '$retail')";
								$result2 = dbQuery($dbConn, $sql2);
							
							}
						}
					}
				}
			}
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Product variation added successfully.";
			redirect("index.php?view=list");
		}else{
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "danger";
			$_SESSION['errorMessage'] = "Please select atleast one variation type.";
			redirect("index.php?view=add-vari-type");
		}
	}
	//Add Product Variation Type
	function addvartype($dbConn){
		$txtProId		= mysqli_real_escape_string($dbConn, $_POST['txtProId']);
		if(!empty($_POST['vtype_id'])) {
			/* Loop to store and display values of individual checked checkbox.
			foreach($_POST['vtype_id'] as $VarTypeId) {
				$sql = "INSERT INTO tbl_pro_var (pro_id, var_type_id)VALUES ('$txtProId', '$VarTypeId')";
				$result = dbQuery($dbConn, $sql);
				echo $VarTypeId . "<br>";
			}*/
			$_SESSION['vtype_id'] = $_POST['vtype_id'];
			$_SESSION['txtProId'] = $txtProId;
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Variation added successfully";
			redirect("index.php?view=add-vari");
			
		}else{
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "danger";
			$_SESSION['errorMessage'] = "Please Select Atleast One Variation type.";
			redirect("index.php?view=add-vari-type");
		}
	}
	//Add Product
	function addPro($dbConn){
		$txtfeature		= mysqli_real_escape_string($dbConn, $_POST['txtfeature']);
		$txtCat			= mysqli_real_escape_string($dbConn, $_POST['txtCat']);
		$txtsubCat		= mysqli_real_escape_string($dbConn, $_POST['txtsubCat']);
		$txtTitle		= mysqli_real_escape_string($dbConn, $_POST['txtTitle']);
		$txtPrice		= mysqli_real_escape_string($dbConn, $_POST['txtPrice']);
		$txtMinqty		= mysqli_real_escape_string($dbConn, $_POST['txtMinqty']);
		$txtMultiqty	= mysqli_real_escape_string($dbConn, $_POST['txtMultiqty']);
		$txtPrintSheet	= mysqli_real_escape_string($dbConn, $_POST['txtPrintSheet']);
		$txtItemPrinted	= mysqli_real_escape_string($dbConn, $_POST['txtItemPrinted']);
		$txtLength		= mysqli_real_escape_string($dbConn, $_POST['txtLength']);
		$txtWidth		= mysqli_real_escape_string($dbConn, $_POST['txtWidth']);
		$txtdesc		= mysqli_real_escape_string($dbConn, $_POST['txtdesc']);
		
		$txtItemCod		= mysqli_real_escape_string($dbConn, $_POST['txtItemCod']);
		$txtQty			= mysqli_real_escape_string($dbConn, $_POST['txtQty']);
		$txtQtyRem		= mysqli_real_escape_string($dbConn, $_POST['txtQtyRem']);
		$txtCostPrice	= mysqli_real_escape_string($dbConn, $_POST['txtCostPrice']);
		$txtWholePrice	= mysqli_real_escape_string($dbConn, $_POST['txtWholePrice']);
		$txtRetailPrice	= mysqli_real_escape_string($dbConn, $_POST['txtRetailPrice']);
		
		$MainImg		= $_FILES['MainImg']['name'];
		$Img1			= $_FILES['Img1']['name'];
		$Img2			= $_FILES['Img2']['name'];
		$Img3			= $_FILES['Img3']['name'];
		$Img4			= $_FILES['Img4']['name'];
		
		$sql = "SELECT pro_id FROM tbl_product WHERE pro_title = '$txtTitle'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "danger";
			$_SESSION['errorMessage'] = "Product already exist.";
			redirect("index.php?view=add");
		}else{
			
			if ($MainImg != '') {
				$main_img =   uploadPagePic('MainImg' , ABS_PATH ."upload/product/", THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
			}else {
				$main_img =	'';
			}
			if ($Img1 != '') {
				$img_1 =   uploadPagePic('Img1' , ABS_PATH ."upload/product/", THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
			}else {
				$img_1 = '';
			}
			if ($Img2 != '') {
				$img_2 =   uploadPagePic('Img2' , ABS_PATH ."upload/product/", THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
			}else {
				$img_2 = '';
			}
			if ($Img3 != '') {
				$img_3 =   uploadPagePic('Img3' , ABS_PATH ."upload/product/", THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
			}else {
				$img_3 = '';
			}
			if ($Img4 != '') {
				$img_4 =   uploadPagePic('Img4' , ABS_PATH ."upload/product/", THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
			}else {
				$img_4 = '';
			}
			
			$sql2 = "INSERT INTO tbl_product(cat_id, sub_cat_id, pro_title, pro_desc, pro_main_img, pro_img_1, pro_img_2, pro_img_3, pro_img_4, pro_price, pro_print_sheet, pro_item_per_sheet, pro_length, pro_width, pro_min_qty, pro_multi_qty, pro_simple,pro_s_item_cod, pro_s_qty, pro_s_qty_rim, pro_s_cost_price, pro_s_whole_price, pro_s_retail_price) VALUES						 
			( '$txtCat', '$txtsubCat','$txtTitle', '$txtdesc', '$main_img','$img_1', '$img_2', '$img_3','$img_4', '$txtPrice','$txtPrintSheet', '$txtItemPrinted', '$txtLength','$txtWidth', '$txtMinqty','$txtMultiqty', '$txtfeature', '$txtItemCod', '$txtQty', '$txtQtyRem', '$txtCostPrice', '$txtWholePrice', '$txtRetailPrice')";
			$result2 = dbQuery($dbConn, $sql2);
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Product Added Successfully.";
			
			redirect("index.php?view=add-vari-type");
		
			
		}
	}

	// Upload Imge
	function uploadPagePic($inputName, $uploadDir,$newW, $newH){
		$image     = $_FILES[$inputName];
		$imagePath = '';
		$thumbnailPath = '';
		$imgSize = getimagesize($image['tmp_name']);
		// if a file is given
		if (trim($image['tmp_name']) != '') {
			$ext = substr(strrchr($image['name'], "."), 1); //$extensions[$image['type']];
			// generate a random new file name to avoid name conflict
			$imagePath = md5(rand() * time()) . ".$ext";
			list($width, $height, $type, $attr) = getimagesize($image['tmp_name']); 
			// make sure the image width does not exceed the
			// maximum allowed width
			if (LIMIT_PRODUCT_WIDTH && $width > $newW) {
				$result  = createThumbnail($image['tmp_name'], $uploadDir . $imagePath, $newW, $newH);
				$imagePath = $result;
			} else {
				$result = move_uploaded_file($image['tmp_name'], $uploadDir . $imagePath);
			}
			// make sure the image height does not exceed the
			// maximum allowed height
			
			if (LIMIT_PRODUCT_HEIGHT && $height > $newH) {
				$result  = createThumbnail($image['tmp_name'], $uploadDir . $imagePath, $newW, $newH);
				$imagePath = $result;
			} else {
				$result = move_uploaded_file($image['tmp_name'], $uploadDir . $imagePath);
			}
		}
		//return array('image' => $imagePath, 'thumbnail' => $thumbnailPath);
		return $imagePath;
	}
	
	

?>