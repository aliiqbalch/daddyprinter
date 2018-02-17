
<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';
	checkUser();
	$action = isset($_GET['action']) ? $_GET['action'] : '';

	switch ($action) {
		
		case 'add' :
			addVar($dbConn);
			break;
		case 'modify' :
			modifyVar($dbConn);
			break;
		case 'delete' :
			deleteVar($dbConn);
			break;
		
		default :
			redirect('index.php');
	}
	
	function deleteVar($dbConn) {
		if(isset($_GET['VarId']) && ($_GET['VarId'])>0 ){
			$VarId = $_GET['VarId'];
		}else{
			redirect("index.php");
			exit();
		}
		
		$sqli = "SELECT var_img FROM tbl_variation WHERE var_id = '$VarId'";
		$result2 = dbQuery($dbConn, $sqli);
		$row = dbFetchAssoc($result2);
		@unlink( ABS_PATH ."upload/variation/" .$row['var_img']);
		
		$sql    =	"DELETE FROM tbl_variation WHERE var_id ='$VarId'";		
		$result = 	 dbQuery($dbConn, $sql);
		$_SESSION['count'] = 0;
		$_SESSION['data'] = "success";
		$_SESSION['errorMessage'] = "Variation Delted Successfully";
		redirect("index.php?view=list");
	}
	//Add Variation
	function addVar($dbConn){
		$txtVarType		= mysqli_real_escape_string($dbConn, $_POST['txtVarType']);
		$txtTitle		= mysqli_real_escape_string($dbConn, $_POST['txtTitle']);
		$txtSVexist		= mysqli_real_escape_string($dbConn, $_POST['txtSVexist']);
		$varImg			= $_FILES['varImg']['name'];
		
		$txtdesc		= mysqli_real_escape_string($dbConn, $_POST['txtdesc']);
		
		$sql = "SELECT var_id FROM tbl_variation WHERE var_title = '$txtTitle' AND var_type_id = '$txtVarType'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "danger";
			$_SESSION['errorMessage'] = "Variation already exist.";
			redirect("index.php?view=add");
		}else{
			
			if ($varImg != '') {
				$Var_img =   uploadPagePic('varImg' , ABS_PATH ."upload/variation/", THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
			}else {
				$Var_img =	'';
			}
			$sql2 = "INSERT INTO tbl_variation(var_title, var_img, var_desc, var_type_id, var_flag ) VALUES 
			( '$txtTitle', '$Var_img','$txtdesc', '$txtVarType', '$txtSVexist')";
			$result2 = dbQuery($dbConn, $sql2);
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Variation Added Successfully.";
			redirect("index.php?view=list");
		}
	}
	//Modify Category
	function modifyVar($dbConn){
		$VarId		= mysqli_real_escape_string($dbConn, $_POST['hidId']);
		$txtVarType		= mysqli_real_escape_string($dbConn, $_POST['txtVarType']);
		$txtTitle		= mysqli_real_escape_string($dbConn, $_POST['txtTitle']);
		$varImg			= $_FILES['varImg']['name'];
		$txtSVexist		= mysqli_real_escape_string($dbConn, $_POST['txtSVexist']);
		$txtdesc		= mysqli_real_escape_string($dbConn, $_POST['txtdesc']);
		
		$sql3 = "SELECT var_img FROM tbl_variation WHERE var_id = '$VarId' ";
		$result3 = dbQuery($dbConn, $sql3);
		$row3 = dbFetchAssoc($result3);
		if ($varImg != ''){
			@unlink( ABS_PATH ."upload/variation/" . $row3['var_img']);
			$Var_img  =   uploadPagePic('varImg' , ABS_PATH ."upload/variation/", THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
		}else {
			$Var_img = $row3['var_img'];
		}
		
		
		$sql = "SELECT var_id FROM tbl_variation WHERE var_title = '$txtTitle' AND var_type_id = '$txtVarType'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			
			$sql2 = "UPDATE tbl_variation SET var_img ='$Var_img', var_desc ='$txtdesc', var_flag = '$txtSVexist'		
			WHERE var_id = '$VarId' ";
			$result2 = dbQuery($dbConn, $sql2);
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Category Updated Successfully.";
			redirect("index.php?view=list");
			
		}else{
			$sql2 = "UPDATE tbl_variation SET var_title ='$txtTitle', var_img ='$Var_img', var_desc ='$txtdesc' , var_type_id = '$txtVarType', var_flag = '$txtSVexist'		
			WHERE var_id = '$VarId' ";
			$result2 = dbQuery($dbConn, $sql2);
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Variation Updated Successfully.";
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