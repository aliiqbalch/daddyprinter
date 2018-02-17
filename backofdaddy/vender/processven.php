
<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';
	checkUser();
	$action = isset($_GET['action']) ? $_GET['action'] : '';

	switch ($action) {
		
		case 'add' :
			add($dbConn);
			break;
		case 'delete' :
			deleteven($dbConn);
			break;
		case 'modify' :
			modifysuplier($dbConn);
			break;
			
		default :
			redirect('index.php');
	}
	//Modify vender
	function modifysuplier($dbConn){
		$VenId			= mysqli_real_escape_string($dbConn, $_POST['hidId']);
		$venImg 	   	= $_FILES['venImg']['name'];
		$txtCompanyName	= mysqli_real_escape_string($dbConn, $_POST['txtCompanyName']);
		$txtVenName	   	= mysqli_real_escape_string($dbConn, $_POST['txtVenName']);
		$txtPhoneNo  	= mysqli_real_escape_string($dbConn, $_POST['txtPhoneNo']);
		$txtEmail   	= mysqli_real_escape_string($dbConn, $_POST['txtEmail']);
		$txtCity  		= mysqli_real_escape_string($dbConn, $_POST['txtCity']);
		$txtAddress  	= mysqli_real_escape_string($dbConn, $_POST['txtAddress']);
		
		$sql2 = "SELECT ven_id FROM tbl_vender WHERE ven_name = '$txtVenName'";
		$result2 = dbQuery($dbConn, $sql2);
		$rows2 = dbNumRows ($result2);
		if($rows2 > 0){
			$sqls = "SELECT pic FROM tbl_vender WHERE ven_id = '$VenId' ";
			$results = dbQuery($dbConn, $sqls);
			$row = dbFetchAssoc($results);
			if ($venImg != '') {
				@unlink( ABS_PATH ."upload/vender/" . $row['pic']);
				$ven_Img  =   uploadPagePic('venImg' , ABS_PATH ."upload/vender/", THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
			}else {
				$ven_Img = $row['pic'];
			}
			$sql = "UPDATE tbl_vender SET ven_cmp_name ='$txtCompanyName' ,phone ='$txtPhoneNo',email ='$txtEmail', city = '$txtCity', address='$txtAddress', pic = '$ven_Img' WHERE ven_id = '$VenId' ";
			$result = dbQuery($dbConn, $sql);
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Vender Information updated Successfully.";
			redirect('index.php?view=list');
		}
		else{
			$sqls = "SELECT pic FROM tbl_vender WHERE ven_id = '$VenId' ";
			$results = dbQuery($dbConn, $sqls);
			$row = dbFetchAssoc($results);
			if ($venImg != '') {
				@unlink( ABS_PATH ."upload/vender/" . $row['pic']);
				$ven_Img  =   uploadPagePic('venImg' , ABS_PATH ."upload/vender/", THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
			}else {
				$ven_Img = $row['pic'];
			}
			$sql = "UPDATE tbl_vender SET ven_cmp_name ='$txtCompanyName', ven_name ='$txtSuplierName',phone ='$txtPhoneNo',email ='$txtEmail', city = '$txtCity', address='$txtAddress', pic = '$ven_Img' WHERE ven_id = '$VenId' ";
			$result = dbQuery($dbConn, $sql);
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Vender Information Updated Successfully.";
			redirect("index.php?view=list");
		}
	}
	//Add Vender
	function add($dbConn){
		$txtCompanyName	= mysqli_real_escape_string($dbConn, $_POST['txtCompanyName']);
		$txtVenName		= mysqli_real_escape_string($dbConn, $_POST['txtVenName']);
		$txtPhoneNo  	= mysqli_real_escape_string($dbConn, $_POST['txtPhoneNo']);
		$txtEmail  		= mysqli_real_escape_string($dbConn, $_POST['txtEmail']);
		$txtCity   		= mysqli_real_escape_string($dbConn, $_POST['txtCity']);
		$venImg		 	= $_FILES['venImg']['name'];
		$txtAddress  	= mysqli_real_escape_string($dbConn, $_POST['txtAddress']);
		$sql2 = "SELECT ven_id FROM tbl_vender WHERE ven_name = '$txtCompanyName'";
		$result2 = dbQuery($dbConn, $sql2);
		$rows2 = dbNumRows ($result2);
		if($rows2 > 0){
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Vender Already Exist.";
			redirect('index.php?view=add');
		}else{
			if($txtEmail != ''){
				$txtEmail = $txtEmail;
			}else{
				$txtEmail = '';
			}
			if ($venImg != '') {
				$ven_Img =   uploadPagePic('venImg' , ABS_PATH ."upload/vender/", THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
			}else {
				$ven_Img =	'';
			}
			$sql = "INSERT INTO tbl_vender(ven_cmp_name, ven_name, phone, email, city, address, pic) 
			VALUES ( '$txtCompanyName' , '$txtVenName' ,'$txtPhoneNo' ,'$txtEmail' ,'$txtCity' ,'$txtAddress' ,'$ven_Img')";
			$result = dbQuery($dbConn, $sql);
			addAccount($dbConn,$txtCompanyName);
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Vender Added Successfully.";
			redirect("index.php?view=list");
		}
	}

function addAccount($dbConn, $txtCompanyName){
	$code = 0;
	if(lastAccountid($dbConn)){
		$code = 1 + lastAccountid($dbConn);
	}else{
		$code= 700;
	}
	$txtCompanyName = $txtCompanyName." Account";
	$sql = "INSERT INTO `account`(`id`, `account_title`, `code`,`type`) VALUES (NULL ,'$txtCompanyName','$code','P')";
	$result = dbQuery($dbConn,$sql);
}

	//DELETE Suplier
	function deleteven($dbConn) {
		if(isset($_GET['VenId']) && ($_GET['VenId'])>0 ){
			$VenId = $_GET['VenId'];
		}else{
			redirect("index.php");
			exit();
		}
		$sql = "SELECT pic FROM tbl_vender WHERE ven_id = '$VenId' ";
		$result = dbQuery($dbConn, $sql);
		$row = dbFetchAssoc($result);
		if ($row['pic'] == "blank.png") {
			
		}else{
			@unlink(ABS_PATH ."upload/vender/". $row['pic']);
		}
		$sql    =	"DELETE FROM tbl_vender WHERE ven_id = $VenId";		
		$result = 	 dbQuery($dbConn, $sql);
		$_SESSION['count'] = 0;
		$_SESSION['data'] = "success";
		$_SESSION['errorMessage'] = "vender delete Successfully.";
		redirect("index.php");
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