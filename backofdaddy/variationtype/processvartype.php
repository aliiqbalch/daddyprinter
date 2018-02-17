
<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';
	checkUser();
	$action = isset($_GET['action']) ? $_GET['action'] : '';

	switch ($action) {
		
		case 'add' :
			addVarType($dbConn);
			break;
		case 'modify' :
			modifyVarType($dbConn);
			break;
		case 'delete' :
			deleteVarType($dbConn);
			break;
		
		default :
			redirect('index.php');
	}
	
	function deleteVarType($dbConn) {
		if(isset($_GET['VarType']) && ($_GET['VarType'])>0 ){
			$VarType = $_GET['VarType'];
		}else{
			redirect("index.php");
			exit();
		}
		
		$sql    =	"DELETE FROM tbl_variation_type WHERE var_type_id ='$VarType'";		
		$result = 	 dbQuery($dbConn, $sql);
		$_SESSION['count'] = 0;
		$_SESSION['data'] = "success";
		$_SESSION['errorMessage'] = "Variation Type Delted Successfully";
		redirect("index.php?view=list");
		
	}
	//Add Variation TYpe
	function addVarType($dbConn){
		$txtTitle		= mysqli_real_escape_string($dbConn, $_POST['txtTitle']);
		if(isset($_POST['txtpaper'])){
			$paper	= mysqli_real_escape_string($dbConn, $_POST['txtpaper']);
		}else{
			$paper = 0;
		}
		if(isset($_POST['txtsheet'])){
			$sheet	= mysqli_real_escape_string($dbConn, $_POST['txtsheet']);
		}else{
			$sheet = 0;
		}
		if(isset($_POST['txtisaddon'])){
			$isaddon	= mysqli_real_escape_string($dbConn, $_POST['txtisaddon']);
		}else{
			$isaddon = 0;
		}if(isset($_POST['txtdesign'])){
			$design = mysqli_real_escape_string($dbConn,$_POST['txtdesign']);
		}else{
			$design = 0;
		}

		$txtdesc		= mysqli_real_escape_string($dbConn, $_POST['txtdesc']);
		
		$sql = "SELECT var_type_id FROM tbl_variation_type WHERE var_type_title = '$txtTitle'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "danger";
			$_SESSION['errorMessage'] = "Variation Type already exist.";
			redirect("index.php?view=add");
		}else{
			$sql2 = "INSERT INTO tbl_variation_type(var_type_title, var_type_desc, var_type_paper_meterial, var_type_sheet_depend, var_type_is_addon ) VALUES 
			( '$txtTitle', '$txtdesc','$paper', "; if($design == 2){$sql2 .= "'$design', ";}else{$sql2 .= "'$sheet', ";} $sql2 .= " '$isaddon')";
			$result2 = dbQuery($dbConn, $sql2);
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Variation Type Added Successfully.";
			redirect("index.php?view=list");
		}
	}
	//Modify Category
	function modifyVarType($dbConn){
		$VarTypeId		= mysqli_real_escape_string($dbConn, $_POST['hidId']);
		$txtTitle		= mysqli_real_escape_string($dbConn, $_POST['txtTitle']);
		
		if(isset($_POST['txtpaper'])){
			$paper	= mysqli_real_escape_string($dbConn, $_POST['txtpaper']);
		}else{
			$paper = 0;
		}
		if(isset($_POST['txtsheet'])){
			$sheet	= mysqli_real_escape_string($dbConn, $_POST['txtsheet']);
		}else{
			$sheet = 0;
		}
		if(isset($_POST['txtisaddon'])){
			$isaddon	= mysqli_real_escape_string($dbConn, $_POST['txtisaddon']);
		}else{
			$isaddon = 0;
		}if(isset($_POST['txtdesign'])){
			$design = mysqli_real_escape_string($dbConn,$_POST['txtdesign']);
		}else{
			$design = 0;
		}
		$txtdesc		= mysqli_real_escape_string($dbConn, $_POST['txtdesc']);

		printR($_POST);

		$sql = "SELECT var_type_id FROM tbl_variation_type WHERE var_type_title = '$txtTitle'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			
			$sql2 = "UPDATE tbl_variation_type SET  var_type_desc ='$txtdesc', var_type_paper_meterial = '$paper',"; if($design == 2){$sql2 .= " var_type_sheet_depend = '$design',"; }else{$sql2 .= " var_type_sheet_depend = '$sheet'," ;} $sql2 .=  " var_type_is_addon = '$isaddon'
			WHERE var_type_id = '$VarTypeId' ";
			$result2 = dbQuery($dbConn, $sql2);
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Variation Type Updated Successfully.";
			redirect("index.php?view=list");
			
		}else{
			$sql2 = "UPDATE tbl_variation_type SET var_type_title ='$txtTitle', var_type_desc ='$txtdesc', var_type_paper_meterial = '$paper',";if($design == 2){$sql2 .= " var_type_sheet_depend = '$design',"; }else{$sql2 .= " var_type_sheet_depend = '$sheet'," ;} $sql2 .=" var_type_is_addon = '$isaddon'
			WHERE var_type_id = '$VarTypeId' ";
			$result2 = dbQuery($dbConn, $sql2);
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Variation Type Updated Successfully.";
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