
<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';
	checkUser();
	$action = isset($_GET['action']) ? $_GET['action'] : '';

	switch ($action) {
		
		case 'add' :
			add($dbConn);
			break;
		case 'modify' :
			modify($dbConn);
			break;
		case 'delete' :
			deletetest($dbConn);
			break;
		
		default :
			redirect('index.php');
	}
	
	function deletetest($dbConn) {
		if(isset($_GET['TestId']) && ($_GET['TestId'])>0 ){
			$TestId = $_GET['TestId'];
		}else{
			redirect("index.php");
			exit();
		}
		$sqli = "SELECT test_img FROM tbl_testimonial WHERE test_id = '$TestId'";
		$result2 = dbQuery($dbConn, $sqli);
		$row = dbFetchAssoc($result2);
		@unlink( ABS_PATH ."upload/testimonial/" .$row['test_img']);
	
		$sql    =	"DELETE FROM tbl_testimonial WHERE test_id ='$TestId'";		
		$result = 	 dbQuery($dbConn, $sql);
		$_SESSION['count'] = 0;
		$_SESSION['data'] = "success";
		$_SESSION['errorMessage'] = "Testimonial Delted Successfully";
		redirect("index.php?view=list");
		
	}
	function add($dbConn){
		$txtTitle		= mysqli_real_escape_string($dbConn, $_POST['txtTitle']);
		$txtDesignation	= mysqli_real_escape_string($dbConn, $_POST['txtDesignation']);
		$txtdesc		= mysqli_real_escape_string($dbConn, $_POST['txtdesc']);
		$workImg 		= $_FILES['workImg']['name'];
		
		if ($workImg != '') {
			$Work_Img   =   uploadPagePic('workImg' , ABS_PATH ."upload/testimonial/", THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
		}else {
			$Work_Img=	'';
		}
		
		$sql = "INSERT INTO tbl_testimonial(test_name, test_desig,test_desc,test_img) VALUES 
		( '$txtTitle' , '$txtDesignation', '$txtdesc', '$Work_Img')";
		$result = dbQuery($dbConn, $sql);
		$_SESSION['count'] = 0;
		$_SESSION['data'] = "success";
		$_SESSION['errorMessage'] = "Testimonials Added Successfully.";
		redirect("index.php?view=list");
	}
	//Modify Affiliation
	function modify($dbConn){
		$HidId			= mysqli_real_escape_string($dbConn, $_POST['HidId']);
		$txtTitle		= mysqli_real_escape_string($dbConn, $_POST['txtTitle']);
		$txtDesignation	= mysqli_real_escape_string($dbConn, $_POST['txtDesignation']);
		$txtdesc		= mysqli_real_escape_string($dbConn, $_POST['txtdesc']);
		$workImg 		= $_FILES['workImg']['name'];
		
		$sql = "SELECT test_img FROM tbl_testimonial WHERE test_id = '$HidId' ";
		$result = dbQuery($dbConn, $sql);
		$row = dbFetchAssoc($result);
		if ($workImg != ''){
			@unlink( ABS_PATH ."upload/testimonial/" . $row['test_img']);
			$Work_Img  =   uploadPagePic('workImg' , ABS_PATH ."upload/testimonial/", THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
		}else {
			$Work_Img = $row['test_img'];
		}
		
		$sql = "UPDATE tbl_testimonial SET test_name ='$txtTitle', test_desig = '$txtDesignation', test_desc ='$txtdesc', test_img = '$Work_Img'			
		WHERE test_id = '$HidId' ";
		$result = dbQuery($dbConn, $sql);
		$_SESSION['count'] = 0;
		$_SESSION['data'] = "success";
		$_SESSION['errorMessage'] = "Testimonial Updated Successfully.";
		redirect("index.php?view=list");
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