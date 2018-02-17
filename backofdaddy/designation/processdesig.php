
<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';
	checkUser();
	$action = isset($_GET['action']) ? $_GET['action'] : '';

	switch ($action) {
		
		case 'add' :
			addDesig($dbConn);
			break;
		case 'modify' :
			modifyDesig($dbConn);
			break;
		case 'delete' :
			deleteDesig($dbConn);
			break;
		
		default :
			redirect('index.php');
	}
	
	function deleteDesig($dbConn) {
		if(isset($_GET['DesigId']) && ($_GET['DesigId'])>0 ){
			$DesigId = $_GET['DesigId'];
		}else{
			redirect("index.php");
			exit();
		}
		
		$sql    =	"DELETE FROM tbl_designation WHERE desig_id ='$DesigId'";		
		$result = 	 dbQuery($dbConn, $sql);
		$_SESSION['count'] = 0;
		$_SESSION['data'] = "success";
		$_SESSION['errorMessage'] = "Designation Delted Successfully";
		redirect("index.php?view=list");
		
	}
	//Add Designation
	function addDesig($dbConn){
		$txtTitle		= mysqli_real_escape_string($dbConn, $_POST['txtTitle']);
		$txtColor		= mysqli_real_escape_string($dbConn, $_POST['txtColor']);
		$txtdesc		= mysqli_real_escape_string($dbConn, $_POST['txtdesc']);
		$sql = "SELECT desig_id FROM tbl_designation WHERE desig_title = '$txtTitle'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "danger";
			$_SESSION['errorMessage'] = "Designation already exist.";
			redirect("index.php?view=add");
		}else{
			$sql2 = "INSERT INTO tbl_designation(desig_title, desig_desc, desig_color) VALUES ( '$txtTitle', '$txtdesc', '$txtColor')";	
			$result2 = dbQuery($dbConn, $sql2);
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Designation Added Successfully.";
			redirect("index.php?view=list");
		}
	}
	//Modify Category
	function modifyDesig($dbConn){
		$DesigId		= mysqli_real_escape_string($dbConn, $_POST['hidId']);
		$txtTitle		= mysqli_real_escape_string($dbConn, $_POST['txtTitle']);
		$txtColor		= mysqli_real_escape_string($dbConn, $_POST['txtColor']);
		$txtdesc		= mysqli_real_escape_string($dbConn, $_POST['txtdesc']);
		
		$sql = "SELECT desig_id FROM tbl_designation WHERE desig_title = '$txtTitle'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$sql3 = "SELECT desig_desc,desig_color  FROM tbl_designation WHERE desig_id = '$DesigId'";
			$result3 = dbQuery($dbConn, $sql3);
			$row = dbFetchAssoc($result3);
			if($row['desig_desc'] == $txtdesc && $row['desig_color'] == $txtColor){
				$_SESSION['count'] = 0;
				$_SESSION['data'] = "danger";
				$_SESSION['errorMessage'] = "Designation already exist.";
				redirect("index.php?view=modify&DesigId=".$DesigId);
			}else{
				$sql2 = "UPDATE tbl_designation SET desig_desc ='$txtdesc', desig_color = '$txtColor' WHERE desig_id = '$DesigId' ";
				$result2 = dbQuery($dbConn, $sql2);
				$_SESSION['count'] = 0;
				$_SESSION['data'] = "success";
				$_SESSION['errorMessage'] = "Designation Updated Successfully.";
				redirect("index.php?view=list");
			}
		}else{
			$sql2 = "UPDATE tbl_designation SET desig_title ='$txtTitle', desig_desc ='$txtdesc', desig_color = '$txtColor' WHERE  desig_id = '$DesigId' ";		
			$result2 = dbQuery($dbConn, $sql2);
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Designation Updated Successfully.";
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