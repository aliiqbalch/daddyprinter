
<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';
	checkUser();
	$action = isset($_GET['action']) ? $_GET['action'] : '';

	switch ($action) {
		
		case 'add' :
			addSubCat($dbConn);
			break;
		case 'modify' :
			modifySubCat($dbConn);
			break;
		case 'delete' :
			deletesubcat($dbConn);
			break;
		
		default :
			redirect('index.php');
	}
	
	function deletesubcat($dbConn) {
		if(isset($_GET['SCI']) && ($_GET['SCI'])>0 ){
			$SCI = $_GET['SCI'];
		}else{
			redirect("index.php");
			exit();
		}
		
		$sqli = "SELECT sub_cat_img, sub_cat_banner FROM tbl_sub_category WHERE sub_cat_id = '$SCI'";
		$result2 = dbQuery($dbConn, $sqli);
		$row = dbFetchAssoc($result2);
		@unlink( ABS_PATH ."upload/subcategory/" .$row['sub_cat_banner']);
		@unlink( ABS_PATH ."upload/subcategory/" .$row['sub_cat_img']);
	
		
		
		$sql    =	"DELETE FROM tbl_sub_category WHERE sub_cat_id ='$SCI'";		
		$result = 	 dbQuery($dbConn, $sql);
		$_SESSION['count'] = 0;
		$_SESSION['data'] = "success";
		$_SESSION['errorMessage'] = "Sub Category Delted Successfully";
		redirect("index.php?view=list");
		
	}
	//Add Sub-Category
	function addSubCat($dbConn){
		$txtCat		= mysqli_real_escape_string($dbConn, $_POST['txtCat']);
		$txtTitle		= mysqli_real_escape_string($dbConn, $_POST['txtTitle']);
		$txtdesc		= mysqli_real_escape_string($dbConn, $_POST['txtdesc']);
		$subcatbanner	= $_FILES['subcatbanner']['name'];
		$subcatImg		= $_FILES['subcatImg']['name'];
		
		$sql = "SELECT sub_cat_id FROM tbl_sub_category WHERE sub_cat_title = '$txtTitle'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "danger";
			$_SESSION['errorMessage'] = "Sub Category already exist.";
			redirect("index.php?view=add");
		}else{
			
			if ($subcatbanner != '') {
				$Sub_Cat_bann =   uploadPagePic('subcatbanner' , ABS_PATH ."upload/subcategory/", THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
			}else {
				$Sub_Cat_bann =	'';
			}
			
			if ($subcatImg != '') {
				$Sub_Cat_Img =   uploadPagePic('subcatImg' , ABS_PATH ."upload/subcategory/", THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
			}else {
				$Sub_Cat_Img =	'';
			}
			
			$sql2 = "INSERT INTO tbl_sub_category(sub_cat_title,sub_cat_img, sub_cat_banner, sub_cat_desc, cat_id ) VALUES 
			( '$txtTitle','$Sub_Cat_Img', '$Sub_Cat_bann','$txtdesc', '$txtCat')";
			$result2 = dbQuery($dbConn, $sql2);
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Sub Category Added Successfully.";
			redirect("index.php?view=list");
		}
	}
	//Modify Category
	function modifySubCat($dbConn){
		$SubCatId		= mysqli_real_escape_string($dbConn, $_POST['hidId']);
		$txtCat			= mysqli_real_escape_string($dbConn, $_POST['txtCat']);
		$txtTitle		= mysqli_real_escape_string($dbConn, $_POST['txtTitle']);
		$txtdesc		= mysqli_real_escape_string($dbConn, $_POST['txtdesc']);
		$subcatbanner	= $_FILES['subcatbanner']['name'];
		$subcatImg		= $_FILES['subcatImg']['name'];
		
		$sql3 = "SELECT sub_cat_img, sub_cat_banner FROM tbl_sub_category WHERE sub_cat_id = '$SubCatId' ";
		$result3 = dbQuery($dbConn, $sql3);
		$row3 = dbFetchAssoc($result3);
		if ($subcatbanner != ''){
			@unlink( ABS_PATH ."upload/subcategory/" . $row3['sub_cat_banner']);
			$Sub_Cat_bann  =   uploadPagePic('subcatbanner' , ABS_PATH ."upload/subcategory/", THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
		}else {
			$Sub_Cat_bann = $row3['sub_cat_banner'];
		}
		if ($subcatImg != ''){
			@unlink( ABS_PATH ."upload/subcategory/" . $row3['sub_cat_img']);
			$Sub_Cat_Img  =   uploadPagePic('subcatImg' , ABS_PATH ."upload/subcategory/", THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
		}else {
			$Sub_Cat_Img = $row3['sub_cat_img'];
		}
		
		$sql = "SELECT sub_cat_id FROM tbl_sub_category WHERE sub_cat_title = '$txtTitle'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			
			$sql2 = "UPDATE tbl_sub_category SET sub_cat_img = '$Sub_Cat_Img', sub_cat_banner ='$Sub_Cat_bann', sub_cat_desc ='$txtdesc' , cat_id = '$txtCat' WHERE sub_cat_id = '$SubCatId' ";		
			$result2 = dbQuery($dbConn, $sql2);
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Sub Category Updated Successfully.";
			redirect("index.php?view=list");
		}else{
			$sql2 = "UPDATE tbl_sub_category SET sub_cat_title ='$txtTitle',sub_cat_img = '$Sub_Cat_Img', sub_cat_banner ='$Sub_Cat_bann', sub_cat_desc ='$txtdesc' , cat_id = '$txtCat' WHERE sub_cat_id = '$SubCatId' ";	
			$result2 = dbQuery($dbConn, $sql2);
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Sub Category Updated Successfully.";
			redirect("index.php?view=list");
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