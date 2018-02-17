
<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';
	checkUser();
	$action = isset($_GET['action']) ? $_GET['action'] : '';

	switch ($action) {
		
		case 'add' :
			addMod($dbConn);
			break;
		case 'modify' :
			modifyMod($dbConn);
			break;
		case 'delete' :
			deleteMod($dbConn);
			break;
		
		default :
			redirect('index.php');
	}
	
	function deleteMod($dbConn) {
		if(isset($_GET['ModId']) && ($_GET['ModId'])>0 ){
			$ModId = $_GET['ModId'];
		}else{
			redirect("index.php");
			exit();
		}
		
		$sql    =	"DELETE FROM tbl_module WHERE mod_id ='$ModId'";		
		$result = 	 dbQuery($dbConn, $sql);
		$_SESSION['count'] = 0;
		$_SESSION['data'] = "success";
		$_SESSION['errorMessage'] = "Module Delted Successfully";
		redirect("index.php?view=list");
		
	}
	//Add Category
	function addMod($dbConn){
		$txtTitle		= mysqli_real_escape_string($dbConn, $_POST['txtTitle']);
		$txtdesc		= mysqli_real_escape_string($dbConn, $_POST['txtdesc']);
		$sql = "SELECT mod_id FROM tbl_module WHERE mod_title = '$txtTitle'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "danger";
			$_SESSION['errorMessage'] = "Module already exist.";
			redirect("index.php?view=add");
		}else{
			$sql2 = "INSERT INTO tbl_module(mod_title, mod_desc ) VALUES ( '$txtTitle', '$txtdesc')";
			$result2 = dbQuery($dbConn, $sql2);
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Module Added Successfully.";
			redirect("index.php?view=list");
		}
	}
	//Modify Category
	function modifyMod($dbConn){
		$ModId			= mysqli_real_escape_string($dbConn, $_POST['hidId']);
		$txtTitle		= mysqli_real_escape_string($dbConn, $_POST['txtTitle']);
		$txtdesc		= mysqli_real_escape_string($dbConn, $_POST['txtdesc']);
		
		$sql = "SELECT mod_id FROM tbl_module WHERE mod_title = '$txtTitle'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$sql3 = "SELECT mod_desc FROM tbl_module WHERE mod_id = '$ModId'";
			$result3 = dbQuery($dbConn, $sql3);
			$row = dbFetchAssoc($result3);
			if($row['mod_desc'] == $txtdesc){
				$_SESSION['count'] = 0;
				$_SESSION['data'] = "danger";
				$_SESSION['errorMessage'] = "Module already exist.";
				redirect("index.php?view=modify&ModId=".$ModId);
			}else{
				$sql2 = "UPDATE tbl_module SET mod_desc ='$txtdesc' WHERE mod_id = '$ModId' ";
				$result2 = dbQuery($dbConn, $sql2);
				$_SESSION['count'] = 0;
				$_SESSION['data'] = "success";
				$_SESSION['errorMessage'] = "Module Updated Successfully.";
				redirect("index.php?view=list");
			}
		}else{
			$sql2 = "UPDATE tbl_module SET mod_title ='$txtTitle', mod_desc ='$txtdesc' WHERE  mod_id = '$ModId' ";		
			$result2 = dbQuery($dbConn, $sql2);
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Module Updated Successfully.";
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