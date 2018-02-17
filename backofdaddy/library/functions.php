<?php

	function checkUser(){
		// if the session id is not set, redirect to login page
		if (!isset($_SESSION['userId'])) {
			redirect( WEB_ROOT_ADMIN . 'login.php');
			exit;
		}
		// the user want to logout
		if (isset($_GET['logout'])) {
			doLogout();
		}
	}
	//User Login Function
	function doLogin($dbConn){
		// if we found an error save the error message in this variable
		$errorMessage = '';
		$userName = mysqli_real_escape_string($dbConn, $_POST['txtUserName']);
		$password = mysqli_real_escape_string($dbConn, md5($_POST['txtPassword']));
		// first, make sure the username & password are not empty
		if ($userName == '') {
			$errorMessage = 'You must enter your username';
		} else if ($password == '') {
			$errorMessage = 'You must enter the password';
		} else {
			// check the database and see if the username and password combo do match
			$sql = "SELECT user_id, user_name, desig_id FROM tbl_user WHERE  user_name = '$userName' AND user_password = '$password' AND user_status = 1 ";
			$result = dbQuery($dbConn, $sql);
			if (dbNumRows($result) == 1) {
				$row = dbFetchAssoc($result);
				$_SESSION['userId'] 	= 	$row['user_id'];
				$_SESSION['username'] 	= 	$row['user_name']; 
				@$_SESSION['userlevel'] = 	$row['desig_id'];
				$ses = $row['user_id']; //tell freichat the userid of the current user
				setcookie("freichat_user", "LOGGED_IN", time()+3600, "/"); // *do not change -> freichat code
				// log the time when the user last login
				if(isset($_SESSION['userId'])>0){
					$sql2 = "UPDATE tbl_user SET user_last_login = NOW() WHERE user_id = ". $row['user_id'];
					dbQuery($dbConn, $sql2);
					redirect('index.php');
				}
			}else {
				$errorMessage = 'Your Account is suspend';
				$ses = null; //tell freichat that the current user is a guest
				setcookie("freichat_user", null, time()+3600, "/"); // *do not change -> freichat code
			}
		}
		return $errorMessage;
	}
	/* Set User Permissions*/
	function checkUserPermission() {
		/* for Super Admin. He can only  view the record*/
		if ($_SESSION['branchId'] == 0) {
			$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
			if ($view == 'add' || $view == 'modify' || $view == 'modifyParent' || $view == 'addParent'  || $view == 'modify') {
				redirect('index.php?error=forbidden');	
				exit();
			}  //end permission if
			$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';
			if ($action == 'delete') {	
				redirect('index.php?error=forbidden');
				exit();
			}
		}
	}
	

/* My Own Function */
	/*Main gallery title */
	function maingalleryimg($dbConn, $mgallery_id){
		$sql = "SELECT * FROM tbl_mgallery WHERE mgallery_id = '$mgallery_id'";
		$result = dbQuery($dbConn, $sql);
		$row = dbFetchAssoc($result);
		echo	$name = $row['mgallery_title'];
	}
	//show category
	function category($dbConn){
		$sql = "SELECT * FROM tbl_category ";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			while($row = dbFetchAssoc($result)) {
				// build combo box options
				echo $list = "<option value='" . $row['cat_id'] ."'" .">" . strtoupper($row['cat_title']) ."</option>\r\n"; ;
						
			} //end while
		}
	}
	//show Category Name
	function categoryName($dbConn, $cat_id){
		$sql = "SELECT * FROM tbl_category WHERE cat_id = '$cat_id'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$row = dbFetchAssoc($result);
			echo $row['cat_title'];
		}
	}

	function categoryNamePr($dbConn, $cat_id){
		$sql = "SELECT * FROM tbl_category WHERE cat_id = '$cat_id'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$row = dbFetchAssoc($result);
			return $row['cat_title'];
		}
	}
	//show variation Type
	function variationtype($dbConn){
		$sql = "SELECT * FROM tbl_variation_type ";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			while($row = dbFetchAssoc($result)) {
				// build combo box options
				echo $list = "<option value='" . $row['var_type_id'] ."'" .">" . strtoupper($row['var_type_title']) ."</option>\r\n"; ;
						
			} //end while
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
	// show variation which have sub variation
	function flagvariationtype($dbConn){
		$sql = "SELECT * FROM tbl_variation WHERE var_flag = 1 ";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			while($row = dbFetchAssoc($result)) {
				// build combo box options
				echo $list = "<option value='" . $row['var_id'] ."'" .">" . strtoupper($row['var_title']) ."</option>\r\n"; ;
						
			} //end while
		}
	}
	//show variation title
	function variationtitle($dbConn, $var_id){
		$sql = "SELECT * FROM tbl_variation WHERE var_id = '$var_id'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			while($row = dbFetchAssoc($result)) {
				//echo($row['var_id']);
				// build combo box options
				echo $row['var_title'];
				//die("SSSS");
			} //end while
		}
	}

function variationtitlePr($dbConn, $var_id){
	$sql = "SELECT * FROM tbl_variation WHERE var_id = '$var_id'";
	$result = dbQuery($dbConn, $sql);
	if(dbNumRows($result) >0 ){
		while($row = dbFetchAssoc($result)) {
			//echo($row['var_id']);
			// build combo box options
			return $row['var_title'];
			//die("SSSS");
		} //end while
	}
}
	//Show Last added product id
	function lastproductid($dbConn){
		$sql = "SELECT pro_id FROM tbl_product ORDER BY pro_id DESC LIMIT 1";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$row = dbFetchAssoc($result);
			echo $row['pro_id'];
		}
	}
	//checked all chek box in modification mod. which already added in pro_var
	function chekaddvariationtype($dbConn, $PI, $var_type_id){
		$sql = "SELECT * FROM tbl_pro_var WHERE pro_id = '$PI' AND var_type_id = '$var_type_id'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			echo "checked";
		}
	}
	//cheked all variation which can b added on pro_var show on modif-vari
	function chkaddvariation($dbConn, $PI,$VarTypeId, $var_id){
		$sql = "SELECT * FROM tbl_pro_var WHERE pro_id = '$PI' AND var_type_id = '$VarTypeId' AND var_id = '$var_id'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			echo "checked";
		}
	}
	//cost price show on modif-vari
	function chkcostmodvariprice($dbConn, $PI,$VarTypeId, $var_id){
		$sql = "SELECT pv_cost FROM tbl_pro_var WHERE pro_id = '$PI' AND var_type_id = '$VarTypeId' AND var_id = '$var_id'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$row = dbFetchAssoc($result);
			echo $row['pv_cost'];
		}
	}
	//Whole sale price show on modif-vari
	function chkwholesalemodvariprice($dbConn, $PI,$VarTypeId, $var_id){
		$sql = "SELECT pv_wholesale FROM tbl_pro_var WHERE pro_id = '$PI' AND var_type_id = '$VarTypeId' AND var_id = '$var_id'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$row = dbFetchAssoc($result);
			echo $row['pv_wholesale'];
		}
	}
	//Retail price show on modif-vari
	function chkretailmodvariprice($dbConn, $PI,$VarTypeId, $var_id){
		$sql = "SELECT pv_retail FROM tbl_pro_var WHERE pro_id = '$PI' AND var_type_id = '$VarTypeId' AND var_id = '$var_id'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$row = dbFetchAssoc($result);
			echo $row['pv_retail'];
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
	//show variation images
	function variationImg($dbConn, $var_id){
		$sql = "SELECT var_img FROM tbl_variation WHERE var_id = '$var_id' ";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			$row = dbFetchAssoc($result); 
			// build combo box options
			return $row['var_img'];
		}
	}
	//show sheet depend
	function sheetdepend($dbConn, $var_type_id){
		$sql = "SELECT var_type_sheet_depend FROM tbl_variation_type WHERE var_type_id = '$var_type_id'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0 ){
			$row = dbFetchAssoc($result);
			echo $row['var_type_sheet_depend'];
		}
	}
	//show Module
	function designationName($dbConn){
		$sql = "SELECT * FROM tbl_designation";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			while($row = dbFetchAssoc($result)) {
				// build combo box options
				echo $list = "<option value='" . $row['desig_id'] ."'" .">" . strtoupper($row['desig_title']) ."</option>\r\n"; ;
						
			} //end while
		}
	}
	//Show designation Name
	function designaame($dbConn, $desig_id){
		$sql = "SELECT * FROM tbl_designation WHERE desig_id = '$desig_id'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			$row = dbFetchAssoc($result);
			echo $row['desig_title'];
		}
	}



	function departmentsName($dbConn){
		$sql = "SELECT * FROM department";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			while($row = dbFetchAssoc($result)) {
				// build combo box options
				echo $list = "<option value='" . $row['dep_id'] ."'" .">" . strtoupper($row['dep_name']) ."</option>\r\n"; ;

			} //end while
		}
	}
	//Show designation Name
	function departmentnaame($dbConn, $dep_id){
		$sql = "SELECT * FROM department WHERE dep_id = '$dep_id'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			$row = dbFetchAssoc($result);
			echo $row['dep_name'];
		}
	}

	//Show Module Name
	function moduleName($dbConn, $mod_id){
		$sql = "SELECT * FROM tbl_module WHERE mod_id = '$mod_id'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			$row = dbFetchAssoc($result);
			echo $row['mod_title'];
		}
	}

function getUserNameById($dbConn,$user_id){
	$sql = "SELECT * FROM tbl_user WHERE user_id = '$user_id'";
	$result = dbQuery($dbConn, $sql);
	if(dbNumRows($result) >0 ){
		$row = dbFetchAssoc($result);
		echo $row['user_name'];
	}
}

function getUserNameBy($dbConn,$user_id){
	$sql = "SELECT * FROM tbl_user WHERE user_id = '$user_id'";
	$result = dbQuery($dbConn, $sql);
	if(dbNumRows($result) >0 ){
		$row = dbFetchAssoc($result);
		return $row['user_name'];
	}
}

function getUsers($dbConn){
	$sql = "SELECT `user_id`,`user_name` FROM tbl_user";
	$result = dbQuery($dbConn, $sql);
	if(dbNumRows($result) >0 ){
		$users = [];
		while($row = dbFetchAssoc($result)){
			extract($row);
			$users[$user_id] = "$user_name";
		}
		return $users;
	}
}

function gettasks($dbConn){
	$sql = "SELECT * FROM tasks";
	$result = dbQuery($dbConn, $sql);
	if(dbNumRows($result) >0 ){
		$tasks = [];
		while($row = dbFetchAssoc($result)){
			$tasks[] = $row;
		}
		return $tasks;
	}else{
		return 0;
	}
}

function getTasksByUser($dbConn,$user_id){
	$sql = "SELECT * FROM tasks WHERE user_id = '$user_id' AND status = 0 order by task_id desc";
	$result = dbQuery($dbConn, $sql);
	if(dbNumRows($result) >0 ){
		$tasks = [];
		while($row = dbFetchAssoc($result)){
			$clientQuery="SELECT c.client_cmpy_name from `order` o ,tbl_client c where order_id='".$row['order_id']."' AND o.client_id=c.client_id";
			$clientResult = dbQuery($dbConn, $clientQuery);
			$rowClient = dbFetchAssoc($clientResult);
			$orderUrl=WEB_ROOT_ADMIN."order/index.php?view=detail&orderId=".$row['order_id'];
			$clientName=$rowClient['client_cmpy_name'];
			if(!empty($row['order_id']))
				$row['tasks']=$row['tasks']." (<a href='$orderUrl'>$clientName</a>)";
			
			$tasks[] = $row;
		}
		return $tasks;
	}else{
		return 0;
	}
}

function getAttByUser($dbConn,$user_id){
	$sql = "SELECT * FROM attendance WHERE user_id = '$user_id'";
	$result = dbQuery($dbConn, $sql);
	if(dbNumRows($result) >0 ){
		$att = [];
		while($row = dbFetchAssoc($result)){
			$att[] = $row;
		}
		return $att;
	}else{
		return 0;
	}
}


function echoItem($item){
	echo $item;
}
	// Show Unit Price
	function getunitPrice($qty,$total){
		$total = $total / $qty;
		echo $total;
	}
function getunitPricePdf($qty,$total){
	$total = $total / $qty;
	return $total;
}

	//USER NAME SHOW WHICH LOGIN
	function username($dbConn){
		if(isset($_SESSION['username'])){
			echo $_SESSION['username'];
		}else{
			echo "No-Name";
		}
	}



	//USER PERMISSIONS ALL



	//MODULE VIEW PERMISSION
	function modPerView($dbConn, $modid){
		$desgiId = $_SESSION['userlevel'];
		$sql = "SELECT role_view FROM tbl_role WHERE desig_id = '$desgiId' AND mod_id = '$modid'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$row = dbFetchAssoc($result);
			if($row['role_view'] == 1){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
// //MODULE Modify PERMISSION
	function modPerModify($dbConn, $modid){
		$desgiId = $_SESSION['userlevel'];
		$sql = "SELECT role_edit FROM tbl_role WHERE desig_id = '$desgiId' AND mod_id = '$modid'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$row = dbFetchAssoc($result);
			if($row['role_edit'] == 1){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
// //MODULE Modify PERMISSION
	function modPerDelete($dbConn, $modid){
		$desgiId = $_SESSION['userlevel'];
		$sql = "SELECT role_delete FROM tbl_role WHERE desig_id = '$desgiId' AND mod_id = '$modid'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$row = dbFetchAssoc($result);
			if($row['role_delete'] == 1){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
// //MODULE Modify PERMISSION
function modPerCostPrice($dbConn, $modid){
	$desgiId = $_SESSION['userlevel'];
	$sql = "SELECT cost_price FROM tbl_role WHERE desig_id = '$desgiId' AND mod_id = '$modid'";
	$result = dbQuery($dbConn, $sql);
	if(dbNumRows($result) > 0){
		$row = dbFetchAssoc($result);
		if($row['cost_price'] == 1){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}

// //MODULE Modify PERMISSION
function modPerWholeSale($dbConn, $modid){
	$desgiId = $_SESSION['userlevel'];
	$sql = "SELECT whole_sale FROM tbl_role WHERE desig_id = '$desgiId' AND mod_id = '$modid'";
	$result = dbQuery($dbConn, $sql);
	if(dbNumRows($result) > 0){
		$row = dbFetchAssoc($result);
		if($row['whole_sale'] == 1){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}

// //MODULE Modify PERMISSION
function modPerVariation($dbConn, $modid){
	$desgiId = $_SESSION['userlevel'];
	$sql = "SELECT variation FROM tbl_role WHERE desig_id = '$desgiId' AND mod_id = '$modid'";
	$result = dbQuery($dbConn, $sql);
	if(dbNumRows($result) > 0){
		$row = dbFetchAssoc($result);
		if($row['variation'] == 1){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}

// //MODULE Modify PERMISSION
function modPerFactor($dbConn, $modid){
	$desgiId = $_SESSION['userlevel'];
	$sql = "SELECT factor FROM tbl_role WHERE desig_id = '$desgiId' AND mod_id = '$modid'";
	$result = dbQuery($dbConn, $sql);
	if(dbNumRows($result) > 0){
		$row = dbFetchAssoc($result);
		if($row['factor'] == 1){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}
	//MODULE ADD PERMISSION
	function modPerAdd($dbConn, $modid){
		$desgiId = $_SESSION['userlevel'];
		$sql = "SELECT role_add FROM tbl_role WHERE desig_id = '$desgiId' AND mod_id = '$modid'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$row = dbFetchAssoc($result);
			if($row['role_add'] == 1){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	//SHOW USER NAME WITH REFRENCE
	function referenceName($dbConn, $userid){
		$sql = "SELECT user_name FROM tbl_user WHERE user_id = '$userid'";
		$result = dbQuery($dbConn, $sql);
		$row = dbFetchAssoc($result);
		echo $row['user_name'];
	}
	//SHOW company Name
	function clientCampnyName($dbConn){
		$sql = "SELECT * FROM tbl_client";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			while($row = dbFetchAssoc($result)) {
				// build combo box options
				echo $list = "<option value='" .$row['client_id'] ."'" .">" . strtoupper($row['client_cmpy_name']) ."</option>\r\n"; ;
						
			} //end while
		}
	}

	function clientIdFromOrder($dbConn,$id){
		$sql = "SELECT client_id FROM `order` WHERE order_id ='$id'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			$client_id = dbFetchAssoc($result);
			return $client_id['client_id'];
		}
	}

	function paymentMethod($dbConn,$id){
		$sql = "SELECT payment_method FROM bill WHERE bill_id ='$id'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			$payment_method = dbFetchAssoc($result);
			return $payment_method['payment_method'];
		}
	}


	function billDate($dbConn,$id){
		$sql = "SELECT `date` FROM bill WHERE bill_id ='$id'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			$date = dbFetchAssoc($result);
			return $date['date'];
		}
	}

	function updateBillID($dbConn){
		$billId = 0;
		if(lastBillId($dbConn)){
			$billId = 1+ lastBillId($dbConn);
		}else{
			$billId= 1001;
		}
		return $billId;
	}

	function clientCampnyNameByID($dbConn,$id){
		$sql = "SELECT client_cmpy_name FROM tbl_client WHERE client_id ='$id'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			$client_cmpy_name = dbFetchAssoc($result);
			echo ($client_cmpy_name['client_cmpy_name']);
		}
	}
function clientCampnyNameByIDPr($dbConn,$id){
	$sql = "SELECT client_cmpy_name FROM tbl_client WHERE client_id ='$id'";
	$result = dbQuery($dbConn, $sql);
	if(dbNumRows($result) >0 ){
		$client_cmpy_name = dbFetchAssoc($result);
		return $client_cmpy_name['client_cmpy_name'];
	}
}
		function clientIDByCampnyName($dbConn,$id){
			$sql = "SELECT client_id FROM tbl_client WHERE client_cmpy_name ='$id'";
			$result = dbQuery($dbConn, $sql);
			if(dbNumRows($result) >0 ){
				$client_cmpy_name = dbFetchAssoc($result);
				return $client_cmpy_name['client_id'];
			}
		}

	function clientCampnyAddress($dbConn,$id){
		$sql = "SELECT client_address FROM tbl_client WHERE client_id ='$id'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			$client_cmpy_name = dbFetchAssoc($result);
			echo ($client_cmpy_name['client_address']);
		}
	}

function clientCampnyAddressPd($dbConn,$id){
	$sql = "SELECT client_address FROM tbl_client WHERE client_id ='$id'";
	$result = dbQuery($dbConn, $sql);
	if(dbNumRows($result) >0 ){
		$client_cmpy_name = dbFetchAssoc($result);
		return $client_cmpy_name['client_address'];
	}
}

	// Show Client Name

	function clientName($dbConn, $clientId){
		$sql = "SELECT client_name FROM tbl_client WHERE client_id ='$clientId'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			$clientName = dbFetchAssoc($result);
			echo ($clientName['client_name']);
		}
	}

function clientNamePdf($dbConn, $clientId){
	$sql = "SELECT client_name FROM tbl_client WHERE client_id ='$clientId'";
	$result = dbQuery($dbConn, $sql);
	if(dbNumRows($result) >0 ){
		$clientName = dbFetchAssoc($result);
		return ($clientName['client_name']);
	}
}

	//Show Sale Agents

	function saleAgents($dbConn){
		$sql = "SELECT * FROM tbl_user WHERE desig_id = '8'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			while($row = dbFetchAssoc($result)) {
				// build combo box options
				echo $list = "<option value='" . $row['user_id'] ."'" .">" . strtoupper($row['user_name']) ."</option>\r\n"; ;
			} //end while
		}
	}


	// Show Client Number

	function clienNumber($dbConn, $clientId){
		$sql = "SELECT client_phone FROM tbl_client WHERE client_id ='$clientId'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			$client_phone = dbFetchAssoc($result);
			echo ($client_phone['client_phone']);
		}
	}

function clienNumberPdf($dbConn, $clientId){
	$sql = "SELECT client_phone FROM tbl_client WHERE client_id ='$clientId'";
	$result = dbQuery($dbConn, $sql);
	if(dbNumRows($result) >0 ){
		$client_phone = dbFetchAssoc($result);
		return ($client_phone['client_phone']);
	}
}

	function clienEmail($dbConn, $clientId){
		$sql = "SELECT client_email FROM tbl_client WHERE client_id ='$clientId'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			$client_phone = dbFetchAssoc($result);
			echo ($client_phone['client_email']);
		}
	}

	function lastorderid($dbConn){
	$sql = "SELECT order_id FROM `order` ORDER BY order_id DESC LIMIT 1";
	$result = dbQuery($dbConn, $sql);
	$row = dbFetchAssoc($result);
	return $row['order_id'];
}

function getIdByNamePr($dbConn,$name){
	$sql = "SELECT id FROM `account` WHERE account_title = '$name'";
	$result = dbQuery($dbConn, $sql);
	if(dbNumRows($result) > 0){
		$row = dbFetchAssoc($result);
		return $row['id'];

	}
}

function getIdByName($dbConn,$name){
	$sql = "SELECT id FROM `account` WHERE account_title = '$name'";
	$result = dbQuery($dbConn, $sql);
	if(dbNumRows($result) > 0){
		$row = dbFetchAssoc($result);
		return $row['id'];
		return true;
	}else{
		return false;
	}
//	$row = dbFetchAssoc($result);
//	return $row['id'];
}
function lastAccountid($dbConn){
	$sql = "SELECT code FROM `account` ORDER BY id DESC LIMIT 1";
	$result = dbQuery($dbConn, $sql);
	$row = dbFetchAssoc($result);
	return $row['code'];
}

function lastJobId($dbConn){
	$sql = "SELECT Job_id FROM `job_order` ORDER BY Job_id DESC LIMIT 1";
	$result = dbQuery($dbConn, $sql);
	$row = dbFetchAssoc($result);
	return $row['Job_id'];
}

function jobName($dbConn,$id){
	$sql = "SELECT job_name FROM `job_order` WHERE Job_id = $id";
	$result = dbQuery($dbConn, $sql);
	$row = dbFetchAssoc($result);
	return $row['job_name'];
}

function pro_qty($dbConn,$id){
	$sql = "SELECT pro_s_qty FROM `tbl_product` WHERE pro_id = $id";
	$result = dbQuery($dbConn, $sql);
	$row = dbFetchAssoc($result);
	return $row['pro_s_qty'];
}

function getAccountName($dbConn,$id){
	$sql = "SELECT account_title FROM `account` WHERE id = '$id'";
	$result = dbQuery($dbConn, $sql);
	$row = dbFetchAssoc($result);
	return $row['account_title'];
}

function getBillId($dbConn,$id){
	$sql = "SELECT bill_id FROM `bill` WHERE order_id = '$id'";
	$result = dbQuery($dbConn, $sql);
	$row = dbFetchAssoc($result);
	return $row['bill_id'];
}

function account($dbConn){
	$sql = "SELECT * FROM `account`";
	$result = dbQuery($dbConn, $sql);
	$list = array();
	while($row = dbFetchAssoc($result)){
		$list[] = $row;
	}
	return $list;
}

function lastBillId($dbConn){
	$sql = "SELECT bill_id FROM bill ORDER BY bill_id DESC LIMIT 1";
	$result = dbQuery($dbConn, $sql);
	$row = dbFetchAssoc($result);
	return $row['bill_id'];
}

	function order_detail_id($dbConn){
		$sql = "SELECT order_detail_id FROM order_detail ORDER BY order_detail_id DESC LIMIT 1";
		$result = dbQuery($dbConn, $sql);
		$row = dbFetchAssoc($result);
		return $row['order_detail_id'];
	}

	function orderDetail($dbConn,$id){
		$sql = "SELECT * FROM order_detail WHERE order_detail_id  = '$id'";
		$result = dbQuery($dbConn,$sql);
		if(dbNumRows($result) > 0){
			$row = dbFetchAssoc($result);
			return $row;
		}
	}

function orderDetailPID($dbConn,$id){
	$sql = "SELECT product_id FROM order_detail WHERE order_detail_id  = '$id'";
	$result = dbQuery($dbConn,$sql);
	$row = dbFetchAssoc($result);
	return $row['product_id'];
}

	//SHOW company Name
	function viewCampnyName($dbConn, $ClientId){
		$sql = "SELECT * FROM tbl_client WHERE client_id = '$ClientId'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0 ){
			$row = dbFetchAssoc($result);
			echo $row['client_cmpy_name'];
		}
	}
	//===================================
	//SHOW DASHBOARD TOTAL DETAIL START==
	//===================================
	function totalCategory($dbConn){
		$sql = "SELECT * FROM tbl_category";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			echo dbNumRows($result);
		}
	}
	//SHOW OFF-SET PRINTING TOTAL COUNT
	function totalOffSetPrinting($dbConn){
		$sql = "SELECT * FROM tbl_sub_category WHERE cat_id = 1 ";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			echo dbNumRows($result);
		}else{
			echo 0;
		}
	}
	//SHOW Digital Printing TOTAL COUNT
	function totalDigitalPrinting($dbConn){
		$sql = "SELECT * FROM tbl_sub_category WHERE cat_id = 2 ";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			echo dbNumRows($result);
		}else{
			echo 0;
		}
	}
	//SHOW Outdoor & Indoor Branding TOTAL COUNT
	function totalOutdoorIndoor($dbConn){
		$sql = "SELECT * FROM tbl_sub_category WHERE cat_id = 3 ";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			echo dbNumRows($result);
		}else{
			echo 0;
		}
	}
	//SHOW Promotional Giveaways TOTAL COUNT
	function totalPromotionalGiveaways($dbConn){
		$sql = "SELECT * FROM tbl_sub_category WHERE cat_id = 4 ";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			echo dbNumRows($result);
		}else{
			echo 0;
		}
	}
	//SHOW Variation Type TOTAL COUNT
	function totalVariationType($dbConn){
		$sql = "SELECT * FROM tbl_variation_type";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			echo dbNumRows($result);
		}else{
			echo 0;
		}
	}
	//SHOW TOtal product 
	function totalProduct($dbConn){
		$sql = "SELECT * FROM tbl_product";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			echo dbNumRows($result);
		}else{
			echo 0;
		}
	}

	// show Product name
	function productName($dbConn, $productid){
		$sql = "SELECT * FROM tbl_product WHERE pro_id = '$productid'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$row = dbFetchAssoc($result);
			echo $row['pro_title'];
		}
	}

function productNamePr($dbConn, $productid){
	$sql = "SELECT * FROM tbl_product WHERE pro_id = '$productid'";
	$result = dbQuery($dbConn, $sql);
	if(dbNumRows($result) > 0){
		$row = dbFetchAssoc($result);
		return $row['pro_title'];
	}
}

	function productCatId($dbConn, $productid){
		$sql = "SELECT cat_id FROM tbl_product WHERE pro_id = '$productid'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$row = dbFetchAssoc($result);
			return $row['cat_id'];
		}
	}

		function productQty($dbConn, $productid){
			$sql = "SELECT pro_s_qty FROM tbl_product WHERE pro_id = '$productid'";
			$result = dbQuery($dbConn, $sql);
			if(dbNumRows($result) > 0){
				$row = dbFetchAssoc($result);
				return $row['pro_s_qty'];
			}
		}

function productQtyRi($dbConn, $productid){
	$sql = "SELECT pro_s_qty_rim FROM tbl_product WHERE pro_id = '$productid'";
	$result = dbQuery($dbConn, $sql);
	if(dbNumRows($result) > 0){
		$row = dbFetchAssoc($result);
		return $row['pro_s_qty_rim'];
	}
}

	function getDiscount($dbConn,$ordId){
		$sql = "SELECT * FROM discount WHERE order_id = '$ordId'";
		$result = dbQuery($dbConn,$sql);
		if(dbNumRows($result) > 0 ){
			$row = dbFetchAssoc($result);
			return $row['amount'];
		}
	}

	function getDetDiscount($dbConn,$id){
		$sql = "SELECT * FROM disdetails WHERE order_detail_Id = '$id'";
		$result = dbQuery($dbConn,$sql);
		if(dbNumRows($result) > 0){
			$row = dbFetchAssoc($result);
			return $row['amount'];
		}
	}

	function getTax($dbConn,$ordId){
		$sql = "SELECT * FROM tax WHERE order_id = '$ordId'";
		$result = dbQuery($dbConn,$sql);
		if(dbNumRows($result) > 0 ){
			$row = dbFetchAssoc($result);
			return $row['amount'];
		}
	}

	function getDetDiscountId($dbConn,$id){
		$sql = "SELECT * FROM disdetails WHERE	order_detail_Id = '$id'";
		$result = dbQuery($dbConn,$sql);
		if(dbNumRows($result) > 0){
			$row = dbFetchAssoc($result);
			return $row['dis_det_Id'];
		}
	}

	function getDiscountId($dbConn,$id){
		$sql = "SELECT * FROM discount WHERE order_id = '$id'";
		$result = dbQuery($dbConn,$sql);
		if(dbNumRows($result) > 0){
			$row = dbFetchAssoc($result);
			return $row['dis_det_Id'];
		}
	}
	//SHOW Total Clients
	function totalClients($dbConn){
		$sql = "SELECT * FROM tbl_client";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			echo dbNumRows($result);
		}else{
			echo 0;
		}
	}
	//SHOW TOtal Current Pipeline
	function totalPipeline($dbConn){
		$sql = "SELECT * FROM tbl_order";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			echo dbNumRows($result);
		}else{
			echo 0;
		}
	}
	//SHOW TOTAL VENDERS
	function totalVender($dbConn){
		$sql = "SELECT * FROM tbl_vender";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			echo dbNumRows($result);
		}else{
			echo 0;
		}
	}

	function getVender($dbConn){
		$sql = "SELECT * FROM tbl_vender";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$list = array();
			while($row = dbFetchAssoc($result)){
				$list[$row['ven_id']] = $row['ven_cmp_name'];
			}
			return $list;
		}
	}

	function getVenderById($dbConn,$id){
		$sql = "SELECT * FROM tbl_vender WHERE ven_id = '$id'";
		$result = dbQuery($dbConn,$sql);
		if(dbNumRows($result) > 0){
			$row = dbFetchAssoc($result);
			return $row;
		}
	}

	//SHOW TOTAL BANKS
	function totalBank($dbConn){
		$sql = "SELECT * FROM tbl_bank";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			echo dbNumRows($result);
		}else{
			echo 0;
		}
	}
	//SHOW TOTAL TESTIMONIAL
	function totalTestimonial($dbConn){
		$sql = "SELECT * FROM tbl_testimonial";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			echo dbNumRows($result);
		}else{
			echo 0;
		}
	}



	//===================================
	//SHOW DASHBOARD TOTAL DETAIL END====
	//===================================
	function accountamount($dbConn, $BankId){
		$sql ="SELECT bank_current_blance FROM tbl_bank WHERE bank_id = '$BankId'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$row = dbFetchAssoc($result);
		echo	$BankCurrentBlance = $row['bank_current_blance'];
		}
	}
	function totalamnt($dbConn, $BankId){
		$sql ="SELECT bank_current_blance FROM tbl_bank WHERE bank_id = '$BankId'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$row = dbFetchAssoc($result);
			$BankCurrentBlance = $row['bank_current_blance'];
			return $BankCurrentBlance;
		}
	}
	function BankName($dbConn, $BankId){
		$sql ="SELECT bank_name FROM tbl_bank WHERE bank_id = '$BankId'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$row = dbFetchAssoc($result);
		echo	$BankName = $row['bank_name'];
		}
	}
	function orderNo($dbConn){
		$sql = "SELECT order_id FROM `order` ORDER BY order_id DESC LIMIT 1";
		$result = dbQuery($dbConn, $sql);
		$row = dbFetchAssoc($result);
		$orderID = $row['order_id'] + 1;
		return $orderID;
	}
	function categorychk($dbConn){
		$sql2 = "SELECT pro_id FROM tbl_product ORDER BY pro_id DESC LIMIT 1";
		$result2 = dbQuery($dbConn, $sql2);
		if(dbNumRows($result2) > 0){
			$row2 = dbFetchAssoc($result2);
			$lastporductid  =  $row2['pro_id'];
		}
		
		$sql = "SELECT * FROM tbl_product WHERE pro_id = '$lastporductid'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$row = dbFetchAssoc($result);
			extract($row);
			if($cat_id == 4){
				return false;
			}else{
				return true;
			}
		}
	}

	function accountRP($dbConn){
		$sql = "SELECT * FROM `account`";
		$result = dbQuery($dbConn,$sql);
		$RP = array();
		if(dbNumRows($result)){
			while($row = dbFetchAssoc($result)){
				if($row['type'] == 'R'){
					$RP[] = $row['id'];
				}elseif($row['type'] == 'P'){
					$RP[] = $row['id'];
				}
			}
		}
		return $RP;
	}
function accountR($dbConn){
	$sql = "SELECT * FROM `account`";
	$result = dbQuery($dbConn,$sql);
	$R = array();
	if(dbNumRows($result)){
		while($row = dbFetchAssoc($result)){
			if($row['type'] == 'R'){
				$R[] = $row['id'];
			}
		}
	}
	return $R;
}

function accountP($dbConn){
	$sql = "SELECT * FROM `account`";
	$result = dbQuery($dbConn,$sql);
	$P = array();
	if(dbNumRows($result)){
		while($row = dbFetchAssoc($result)){
			if($row['type'] == 'P'){
				$P[] = $row['id'];
			}
		}
	}
	return $P;
}

/* My Own Function END*/
/*
	Logout a user
*/
	function doLogout(){
		if (isset($_SESSION['userId'])) {
			unset($_SESSION['userId']);
			unset($_SESSION['username']);
			unset($_SESSION['desig_id']);
			unset($_SESSION['login_return_url']);
		}	
		//header('Location: login.php');
		redirect('login.php');
		exit;
	}
/*
	Create the paging links
*/
	function getPagingNav($sql, $pageNum, $rowsPerPage, $queryString = ''){
		$result  = mysql_query($sql) or die('Error, query failed. ' . mysql_error());
		$row     = mysql_fetch_array($result, MYSQL_ASSOC);
		$numrows = $row['numrows'];
		// how many pages we have when using paging?
		$maxPage = ceil($numrows/$rowsPerPage);
		$self = $_SERVER['PHP_SELF'];
		// creating 'previous' and 'next' link
		// plus 'first page' and 'last page' link
		// print 'previous' link only if we're not
		// on page one
		if ($pageNum > 1){
			$page = $pageNum - 1;
			$prev = " <a href=\"$self?page=$page{$queryString}\">[Prev]</a> ";
		
			$first = " <a href=\"$self?page=1{$queryString}\">[First Page]</a> ";
		}else{
			$prev  = ' [Prev] ';       // we're on page one, don't enable 'previous' link
			$first = ' [First Page] '; // nor 'first page' link
		}
		// print 'next' link only if we're not
		// on the last page
		if ($pageNum < $maxPage){
			$page = $pageNum + 1;
			$next = " <a href=\"$self?page=$page{$queryString}\">[Next]</a> ";
		
			$last = " <a href=\"$self?page=$maxPage{$queryString}{$queryString}\">[Last Page]</a> ";
		}else{
			$next = ' [Next] ';      // we're on the last page, don't enable 'next' link
			$last = ' [Last Page] '; // nor 'last page' link
		}
		// return the page navigation link
		return $first . $prev . " Showing page <strong>$pageNum</strong> of <strong>$maxPage</strong> pages " . $next . $last; 
	}
/*
	Create a thumbnail of $srcFile and save it to $destFile.
	The thumbnail will be $width pixels.
*/
	function createThumbnail($srcFile, $destFile, $width, $height, $quality = 75){
		$thumbnail = '';
		if (file_exists($srcFile)  && isset($destFile)){
			$size        = getimagesize($srcFile);
			$old_width  = $size[0];
			$old_height = $size[1];
			// next we will calculate the new dimensions for the thumbnail image
			// the next steps will be taken:
			// 1. calculate the ratio by dividing the old dimensions with the new ones
			// 2. if the ratio for the width is higher, the width will remain the one define in WIDTH variable and the height will be calculated so the image ratio will not change
			// 3. otherwise we will use the height ratio for the image as a result, only one of the dimensions will be from the fixed ones
			$ratio1=$old_width/$width;
			$ratio2=$old_height/$height;
			if($ratio1> $ratio2) {
				$w = $width;
				$h = $old_height/$ratio1;
			}else {
				$h=$height;
				$w=$old_width/$ratio2;
			}
			$thumbnail =  copyImage($srcFile, $destFile, $w, $h, $quality);
		}
		// return the thumbnail file name on sucess or blank on fail
		return basename($thumbnail);
	}

/*
	Copy an image to a destination file. The destination
	image size will be $w X $h pixels
*/
	function copyImage($srcFile, $destFile, $w, $h, $quality = 75){
		$tmpSrc     = pathinfo(strtolower($srcFile));
		$tmpDest    = pathinfo(strtolower($destFile));
		$size       = getimagesize($srcFile);
		if ($tmpDest['extension'] == "gif" || $tmpDest['extension'] == "jpg"){
		   $destFile  = substr_replace($destFile, 'jpg', -3);
		   $dest      = imagecreatetruecolor($w, $h);
		   imageantialias($dest, TRUE);
		} elseif ($tmpDest['extension'] == "png") {
		   $dest = imagecreatetruecolor($w, $h);
		   imageantialias($dest, TRUE);
		} else {
		  return false;
		}

		switch($size[2]){
			case 1:       //GIF
			   $src = imagecreatefromgif($srcFile);
			   break;
			case 2:       //JPEG
			   $src = imagecreatefromjpeg($srcFile);
			   break;
			case 3:       //PNG
			   $src = imagecreatefrompng($srcFile);
			   break;
			default:
			   return false;
			   break;
		}

		imagecopyresampled($dest, $src, 0, 0, 0, 0, $w, $h, $size[0], $size[1]);

		switch($size[2]){
		   case 1:
		   case 2:
			   imagejpeg($dest,$destFile, $quality);
			   break;
		   case 3:
			   imagepng($dest,$destFile);
		}
		return $destFile;
	}
/**************************** For File Size (Irfan) ***************************************/
function format_size($size, $round = 0) {
    //Size must be bytes!
    $sizes = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    for ($i=0; $size > 1024 && isset($sizes[$i+1]); $i++) $size /= 1024;
    return round($size,$round).$sizes[$i];
}
	
///******************** Function for date formatting  ********************/
	function formatMySQLDate($mySQLDateTime, $dateFormat) { 
		$year = substr($mySQLDateTime,0,4);
		$mon  = substr($mySQLDateTime,5,2);
		$day  = substr($mySQLDateTime,8,2);
		$hour = substr($mySQLDateTime,11,2);
		$min  = substr($mySQLDateTime,14,2);
		$sec  = substr($mySQLDateTime,17,2);
		
		return date($dateFormat, mktime($hour,$min,$sec,$mon,$day,$year));
	}
	
	/* Conver dd-mm-yyyy format to MySQL DATE fromat */
	function conMySQLDate($date) { 
				
		//$date = date('Y-m-d', strtotime(str_replace('-', '/', $date)));
		$date = date('Y-m-d', strtotime($date));
		return $date;
	}
	
	/* Conver 02/07/2009 00:07:00 format to MySQL DATE fromat */
	function conMySQLDateTime($date) { 
				
		$date = $date = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $date);
		return $date;
	}
	
///******************** Function for Redirection ********************/
	function redirect($url) { 
		echo "<html><head><meta http-equiv=refresh content=0;URL=" . $url . "></head><body></body></html>";
	}


/******************************** Function for Filter Words (Irfan) **********************************/

function filterWords($str)
{
    $words = array("<script", "</script>", "<html", "</html>","<head", "</head>", "<meta>", "'");

    for($i=0; $i < count($words); $i++)
    {
        $strNew = eregi_replace($words[$i], htmlspecialchars($words[$i], ENT_QUOTES), $str);
		//$strNew = str_replace("'", "&rsquo;", $str2);	
    }
    
    return $strNew;
}

function filterWordsSpecial($str)
{
    $words   = array("'", "-");
	$replace = array("&rsquo", "&ndash;");

    for($i=0; $i < count($words); $i++)
    {
        $strNew = str_replace($words[$i], $replace[$i], $str);
    }
    
    return $strNew;
}  


/******************** Count Records *************************/

function countRecords($table, $where=1) {
		$sqlCount = "SELECT count(*) AS numRecords FROM " . $table . " WHERE " . $where;
		if($rsCount = mysql_query($sqlCount)) {
			if($recCount = mysql_fetch_array($rsCount)) {
				return $recCount["numRecords"];
			}
		}
		return FALSE;
	}
/**************** Week Days for Time Table ***********************/
function dbClassDays($classId) {
	
 $sql = "SELECT DISTINCT (day_id)
			FROM time_table
			WHERE class_id=$classId
			ORDER BY day_id";
	$result = dbQuery($sql);

	while($row = dbFetchAssoc($result)) {
		$dbDays[]	= $row['day_id'];	
	}
	
	return $dbDays;
}



/********************************/
/**************** Date for Time Table ***********************/
function dbClassDate($examId) {
	
 $sql = "SELECT DISTINCT (date_paper)
			FROM date_sheet
			WHERE exam_id=$examId
			ORDER BY date_paper";
	$result = dbQuery($sql);

	while($row = dbFetchAssoc($result)) {
		$dbDate[]	= $row['date_paper'];	
	}
	
	return $dbDate;
}



/********************************/
// Generate activation key

function activationKey(){
  
       mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
       $charid = strtoupper(md5(uniqid(rand(), true)));
       $hyphen = chr(45);// "-"
       $uuid = substr($charid, 0, 8)
               .substr($charid, 8, 4)
               .substr($charid,12, 4)
               .substr($charid,16, 4)
               .substr($charid,20,12);
       return $uuid;

}


//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 
function summarize($string, $characters) {

	if (strlen($string) > $characters){
		return substr($string, 0, $characters) . "...";
		
	} else {
		return $string;
	}

}

/************************************** Show Errors Function ***************************/

function showError($errorNo) {

	
	$errorList = '';
	require_once 'errors.php';

	if (isset($errorNo)) {
		
		$errorList .=  '<p class="showError">';
		
			$errorList .= $error[$errorNo];
		
		$errorList .= '</p>';
	
	}	//end if
	
	return $errorList;
}
//++++++++++++++++++++++++== Auto Increment +++++++++++++++++++++++++
//This function is used where we do not want mysql auto increment we want our own unique id (Irfan) 

function mysql_autoid($id,$table){
	$query = 'SELECT MAX('.$id.') AS last_id FROM '.$table;
	$result = mysql_query($query);
	$result = mysql_fetch_array($result);
	
	return $result['last_id']+1; 
}

function autoChallNo($id,$table){
	$query = 'SELECT MAX('.$id.') AS last_id FROM '.$table;
	$result = mysql_query($query);
	$result = mysql_fetch_array($result);
	
	return $result['last_id']; 
}
// Last Value

function last_id($table, $id_column) {
 if ($table && $id_column) {
   $result = mysql_query("SELECT MAX(".$id_column.") AS maxid FROM ".$table);
   $stuff = mysql_fetch_assoc($result);
   return $stuff['maxid'];
 } else {
   return false;
 }
}


/*
	Generate combo box options containing the categories we have.
	if $catId is set then that category is selected
*/
function buildClassOptions($semester = false)
{

if (isset($_GET['classId']) && (int)$_GET['classId'] > 0) {
	$classId = (int)$_GET['classId'];
}


	$sql = "SELECT *
			FROM classinfo i, programs p
			WHERE i.classname  = p.programid AND i.classstatus = 1
			ORDER BY i.classname ";
	$result = dbQuery($sql) or die('Cannot get Data. ' . mysql_error());
	
	$list = '';
	while($row = dbFetchAssoc($result)) {
	
	if ($semester == true) {
		$resultSemester	=	convertToOrdinal($row['classsemester']);
	}
	
		
	// build combo box options
	$list .= "<option value='" . $row['classinfoid'] ."'";
			if (@$row['classinfoid'] == @$classId) {
				$list.= " selected";
			}
			
			$list .= ">" . strtoupper($row['programname']) . " " . $resultSemester . " "   .  " (" . ucwords($row['classshift']) . ") " . 
					  $row['classsession'] ."</option>\r\n";
} //end while
	
	return $list;
	
}


/* 
	Course
*/ 

function buildCourseOptions($courseId = '') {

if (isset($_GET['courseId']) && (int)$_GET['courseId'] > 0) {
	$courseId = (int)$_GET['courseId'];
}

	$sql = "SELECT *
			FROM course
			WHERE coursedeptid = " . $_SESSION['deptId'] . "
			ORDER BY coursename ASC";
	$result = dbQuery($sql) or die('Cannot get Product. ' . mysql_error());
	
	$list = '';
	while($row = dbFetchAssoc($result)) {
	
	// build combo box options
	$list .= "<option value='" . $row['courseid'] ."'";
			if (@$row['courseid'] == @$courseId) {
				$list.= " selected";
			}
			
			$list .= ">" . ucwords($row['coursename']) . " (" . $row['coursecode'] . ")" . "</option>\r\n";
	} //end while
	
	return $list;
}

/* 
	Course according to semester
*/ 

function buildSemCourseOptions($programmId = '', $semesterId = '', $classId = '') {

if (isset($_GET['programId']) && (int)$_GET['programId'] > 0) {
	$programmId = (int)$_GET['programId'];
	$semesterId = (int)$_GET['sem'];
}

if (isset($_GET['courseId']) && (int)$_GET['courseId'] > 0) {
	$courseId = (int)$_GET['courseId'];
}

if (isset($_GET['classId']) && (int)$_GET['classId'] > 0) {
	$classId = (int)$_GET['classId'];
}

	$sql = "SELECT *
			FROM semestercourses sc, course c
			WHERE sc.sccourseid = c.courseid AND sc.scprogramid = $programmId AND sc.scsemester = $semesterId
			ORDER BY coursename";

	$result = dbQuery($sql) or die('Cannot get data. ' . mysql_error());
	
	
	
	$list = '';
	while($row = dbFetchAssoc($result)) {
	
	// build combo box options
	$list .= "<option value='" . $row['courseid'] ."'";
			if (@$row['courseid'] == @$courseId) {
				$list.= " selected";
			}
			
		echo 	$sqlCourse = "SELECT *
						 FROM resultinfo
						 WHERE resultclassid = $classId AND resultsemester = $semesterId";

			$resultCourse = dbQuery($sqlCourse) or die('Cannot get data. ' . mysql_error());
			while ($rowCourse = dbFetchAssoc($resultCourse)) {
			
				if (@$row['courseid'] == @$rowCourse['resultcourseid']) {
					$list.= " disabled='disabled'";
				}
				
			} //end course while
			
			$list .= ">" . $row['coursecode'] . ": " . ucwords($row['coursename']) .  @$resultcourseid . "</option>\r\n";
	} //end while
	
	return $list;
}


/*
	Roll No.
*/

function buildRollNoOptions($classId)
{

if (isset($_GET['studentId']) && (int)$_GET['studentId'] > 0) {
	$stuCode = (int)$_GET['cboStudentCode'];
}

	$sql = "SELECT *
			FROM students
			WHERE studentclassid = $classId
			ORDER BY studentrollno";
	$result = dbQuery($sql) or die('Cannot get Roll No. ' . mysql_error());
	
	$list = '';
	while($row = dbFetchAssoc($result)) {
	
	// build combo box options
	$list .= "<option value='" . $row['studentid'] ."'";
			if (@$row['studentid'] == @$stuCode) {
				$list.= " selected";
			}
			
			$list .= ">" . $row['studentrollno'] . "</option>\r\n";
	} //end while
	
	return $list;
}

///******************** Insert Deshes in CniC ********************/ 
function madeCnicDash($number) {
	
	 $number = substr($number, 0, 5) . '-' . substr($number, 5); 
	 // now $number = '36203-73068913'; 
	 $number = substr($number, 0, 13) . '-' . substr($number, 13); 
	 // now $number = '36203-7306891-3'; 
	 return $number; 
	 } 


/****************** Get Teacher Name from Time Table ******************/
function getTeacher($classId, $courseId) {

	$sql = "SELECT *
			FROM classinfo i, timetableinfo t,  timetable tt, teachers ts
			WHERE i.classinfoid = t.ttinfoclassid AND i.classinfoid = $classId AND tt.ttinfo = t.ttinfoid AND tt.ttcourseid = $courseId AND tt.ttteacherid = ts.teacherid";
	$result = dbQuery($sql) or die('Cannot get Programm ' . mysql_error());
	$row = dbFetchAssoc($result);
	$teacherName	=	$row['teachername'];
	$teacherId		=	$row['teacherid'];
	
	return array('teacherId' => $teacherId, 'teacherName' => $teacherName);
}

/******************** Get Program From Class ID ******************/


function getProgram($classId) {

if (isset($_GET['classId']) && (int)$_GET['classId'] > 0) {
	$classId = (int)$_GET['classId'];

	$sql = "SELECT *
			FROM classinfo
			WHERE classinfoid = $classId
			ORDER BY classname";
	$result = dbQuery($sql) or die('Cannot get Programm ' . mysql_error());
	$row = dbFetchAssoc($result);
	
	$programmId	=	$row['classname'];
	
	return $programmId;
	}
}

////////////////////////////// fine /////////////////////
function buildFineOptions($fineId = '')
{

	 $sql = "SELECT *
			FROM fee_fine WHERE branch_id=".$_SESSION['branchId'];
			
	$result = dbQuery($sql) or die('Cannot get Program ' . mysql_error());
	
	$list = '';
	while($row = dbFetchAssoc($result)) {
	
	// build combo box options
	$list .= "<option value='" . $row['ff_id'] ."'";
			if (@$row['ff_id'] == @$fineId) {
				$list.= " selected";
			}
			
			$list .= ">" . ucwords($row['ff_title']) . "</option>\r\n";
	} //end while
	
	return $list;
}


////////////////////////////// Class /////////////////////
function buildClass1Options($classId = '')
{

	 $sql = "SELECT *
			FROM class 
			WHERE class_status=1";
			
	
	$result = dbQuery($sql) or die('Cannot get Program ' . mysql_error());
	
	$list = '';
	while($row = dbFetchAssoc($result)) {
	
	// build combo box options
	$list .= "<option value='" . $row['class_id'] ."'";
			if (@$row['class_id'] == @$classId) {
				$list.= " selected";
			}
			
			$list .= ">" . ucwords($row['class_title']) . "</option>\r\n";
	} //end while
	
	return $list;
}


////////////////////////////// Class For Admin /////////////////////
function buildClassAdminOptions($classId = '')
{

	  $sql = "SELECT *
			FROM class 
			WHERE class_status=1 AND branch_id=".$_SESSION['branchId'];
			
	
	$result = dbQuery($sql) or die('Cannot get Program ' . mysql_error());
	
	$list = '';
	while($row = dbFetchAssoc($result)) {
	
	// build combo box options
	$list .= "<option value='" . $row['class_id'] ."'";
			if (@$row['class_id'] == @$classId) {
				$list.= " selected";
			}
			
			$list .= ">" . ucwords($row['class_title']) . "</option>\r\n";
	} //end while
	
	return $list;
}


////////////////////////////// Class Option with brach admin /////////////////////
function buildClasses($classId = '')
{

	 $sql = "SELECT *
			FROM class c, branches b 
			WHERE c.class_status=1 AND c.branch_id=b.branch_id AND c.branch_id=".$_GET['branchId'];
			
	
	$result = dbQuery($sql) or die('Cannot get Program ' . mysql_error());
	
	$list = '';
	while($row = dbFetchAssoc($result)) {
	
	// build combo box options
	$list .= "<option value='" . $row['class_id'] ."'";
			if (@$row['class_id'] == @$classId) {
				$list.= " selected";
			}
			
			$list .= ">" . ucwords($row['class_title']) . "</option>\r\n";
	} //end while
	
	return $list;
}

////////////////////////////// Class Option with brach admin /////////////////////
function buildClassesGetbrachId($classId = '') {
	
	if (isset($_GET['branchId']) && $_GET['branchId'] > 0) {
		$branchSql	=	"AND c.branch_id = ". $_GET['branchId'];	
	} else {
		$branchSql	=	'';	
	}

	 $sql = "SELECT *
			FROM class c, branches b 
			WHERE c.class_status=1 AND c.branch_id=b.branch_id $branchSql";
			
	
	$result = dbQuery($sql) or die('Cannot get Program ' . mysql_error());
	
	$list = '';
	while($row = dbFetchAssoc($result)) {
	
	// build combo box options
	$list .= "<option value='" . $row['class_id'] ."'";
			if (@$row['class_id'] == @$classId) {
				$list.= " selected";
			}
			
			$list .= ">" . ucwords($row['class_title']) . "</option>\r\n";
	} //end while
	
	return $list;
}

////////////////////////////// Section /////////////////////
function buildSectionOptions($sectionId = '')
{
if(isset ($_SESSION['branchId']) && $_SESSION['branchId']==0 && isset($_GET['branchId']) &&  $_GET['branchId']>0){
	$branchId= $_GET['branchId'];
	 $sql = "SELECT *
			FROM section WHERE branch_id=$branchId";
}else
	{
		if(isset ($_SESSION['branchId']) && $_SESSION['branchId']>0){
		$branchId= $_SESSION['branchId'];
			$sql = "SELECT *
			FROM section WHERE branch_id=$branchId";
	}
}
			
	$result = dbQuery($sql) or die('Cannot get Program ' . mysql_error());
	
	$list = '';
	while($row = dbFetchAssoc($result)) {
	
	// build combo box options
	$list .= "<option value='" . $row['section_id'] ."'";
			if (@$row['section_id'] == @$sectionId) {
				$list.= " selected";
			}
			
			$list .= ">" . ucwords($row['section_title']) . "</option>\r\n";
	} //end while
	
	return $list;
}


////////////////////////////// Branch /////////////////////
function buildBranchOption($branchId = '')
{

	 $sql = "SELECT *
			FROM  branches WHERE branch_status=1";
			
	$result = dbQuery($sql) or die('Cannot get Program ' . mysql_error());
	
	$list = '';
	while($row = dbFetchAssoc($result)) {
	
	// build combo box options
	$list .= "<option value='" . $row['branch_id'] ."'";
			if (@$row['branch_id'] == @$branchId) {
				$list.= " selected";
			}
			
			$list .= ">" . ucwords($row['branch_name']) . "</option>\r\n";
	} //end while
	
	return $list;
}




////////////////////////////// Exam Type /////////////////////
function buildExamType($examId = '')
{

	 $sql = "SELECT *
			FROM examination_info WHERE exam_status=1 AND branch_id=".$_SESSION['branchId'];
			
	
	$result = dbQuery($sql) or die('Cannot get Program ' . mysql_error());
	
	$list = '';
	while($row = dbFetchAssoc($result)) {
	
	// build combo box options
	$list .= "<option value='" . $row['exam_id'] ."'";
			if (@$row['exam_id'] == @$examId) {
				$list.= " selected";
			}
			
			$list .= ">" . ucwords($row['exam_title']) ." ". " ("  .formatMySQLDate(($row['exam_start_date']), 'd-m-Y').  ")"."</option>\r\n";
	} //end while
	
	return $list;
}

////////////////////////////////////Teacher List/////////////////////

function teachersOptions($teacherId = '')
{

	 $sql = "SELECT *
			FROM teachers
			WHERE teacher_status=1 AND branch_id=".$_SESSION['branchId'];
			
	
	$result = dbQuery($sql) or die('Cannot get Program ' . mysql_error());
	
	$list = '';
	while($row = dbFetchAssoc($result)) {
	
	// build combo box options
	$list .= "<option value='" . $row['teacher_id'] ."'";
			if (@$row['teacher_id'] == @$teacherId) {
				$list.= " selected";
			}
			
			$list .= ">" . ucwords($row['teacher_first_name']) ." ". ucwords($row['teacher_last_name']) . "</option>\r\n";
	} //end while
	
	return $list;
}

////////////////////////////////////Subject List/////////////////////

function subjectsOptions($subjectId = '')
{

	 $sql = "SELECT *
			FROM  subjects";
	$result = dbQuery($sql) or die('Cannot get Program ' . mysql_error());
	
	$list = '';
	while($row = dbFetchAssoc($result)) {
	
	// build combo box options
	$list .= "<option value='" . $row['subject_id'] ."'";
			if (@$row['subject_id'] == @$subjectId) {
				$list.= " selected";
			}
			
			$list .= ">" . ucwords($row['subject_title']). "-" .ucwords($row['subject_code'])."</option>\r\n";
	} //end while
	
	return $list;
}


////////////////////////////// Department Menu List /////////////////////
function buildDepartmentOptions($eduFacultyId, $campusId)
{

if (isset($_GET['eduFacultyId']) && (int)$_GET['eduFacultyId'] > 0) {
	$eduFacultyId = (int)$_GET['eduFacultyId'];
	$campusId 	  = (int)$_GET['campusId'];
}

if (isset($_GET['deptId']) && (int)$_GET['deptId'] > 0) {
	$deptId	=	(int)$_GET['deptId'];
}

	 $sql = "SELECT *
			FROM department
			WHERE deptcampusid = $campusId AND deptfacultyid = $eduFacultyId
			ORDER BY deptname ASC";
	
	$result = dbQuery($sql) or die('Cannot get Department ' . mysql_error());
	
	$list = '';
	while($row = dbFetchAssoc($result)) {
	
	// build combo box options
	$list .= "<option value='" . $row['deptid'] ."'";
			if (@$row['deptid'] == @$deptId) {
				$list.= " selected";
			}
			
			$list .= ">" . ucwords($row['deptname']) . "</option>\r\n";
	} //end while
	
	return $list;
}

////////////////////////////// Student Menu /////////////////////
function buildStudentsOpt($studentId = '') {

if (isset($_GET['classId']) && (int)$_GET['classId'] > 0 && isset($_GET['sectionId']) && (int)$_GET['sectionId'] > 0 ) {
	$classId 		= 		(int)$_GET['classId'];
	$sectionId		=		$_GET['sectionId'];
}

	 $sql = "SELECT *
			FROM students
			WHERE class_id = $classId AND section_id=$sectionId";
	$result = dbQuery($sql) or die('Cannot get Semester ' . mysql_error());
	
	$list = '';
	$list .= "<option value=''>Choose Student</option>";
	if (dbNumRows($result) > 0) {
		
		while($row = dbFetchAssoc($result)) {
		
		// build combo box options
				
				$list .= "<option value='" . $row['student_id'] ."'";
					if (@$row['student_id'] == $studentId) {
						$list.= " selected";
					}
					
				$list .= ">" . ucwords($row['student_first_name']) . " " . ucwords($row['student_last_name']);
				$list .=  "</option>\r\n";
			}  // end while
			
	} else {
			$list .= "<option value='' style='color:#FF0000'>No Record Found</option>\r\n";	
	} //end if dbNumRows
	 
	 return $list;	
}

////////////////////////////// Student Menu /////////////////////
function buildStudentsOptions($studentId = '') {

if (isset($_GET['classId']) && (int)$_GET['classId'] > 0  ) {
	$classId 		= 		(int)$_GET['classId'];
	
}

	 $sql = "SELECT *
			FROM students
			WHERE class_id = $classId AND student_status=1";
	$result = dbQuery($sql) or die('Cannot get Semester ' . mysql_error());
	
	$list = '';
	if (dbNumRows($result) > 0) {
		
		while($row = dbFetchAssoc($result)) {
		
		// build combo box options
				
				$list .= "<option value='" . $row['student_id'] ."'";
					if (@$row['student_id'] == $studentId) {
						$list.= " selected";
					}
					
				$list .= ">" . ucwords($row['student_first_name']) . " " . ucwords($row['student_last_name']);
				$list .=  "</option>\r\n";
			}  // end while
			
	} else {
			$list .= "<option value='' style='color:#FF0000'>No Record Found</option>\r\n";	
	} //end if dbNumRows
	 
	 return $list;	
}





////////////////////////////// Student Menu /////////////////////
function buildStudentOption($studentId = '') {

if (isset($_GET['classId']) && (int)$_GET['classId'] > 0  && isset($_GET['sectionId']) && (@$_GET['sectionId'] > 0) ){
	$classId 		= 		(int)$_GET['classId'];
	$sectionId		=		$_GET['sectionId'];
	
}

	 $sql = "SELECT *
			FROM students
			WHERE class_id = $classId AND section_id=$sectionId AND student_status=1";
	$result = dbQuery($sql) or die('Cannot get Semester ' . mysql_error());
	
	$list = '';
	if (dbNumRows($result) > 0) {
		
		while($row = dbFetchAssoc($result)) {
		
		// build combo box options
				
				$list .= "<option value='" . $row['student_id'] ."'";
					if (@$row['student_id'] == $studentId) {
						$list.= " selected";
					}
					
				$list .= ">" . ucwords($row['student_first_name']) . " " . ucwords($row['student_last_name']);
				$list .=  "</option>\r\n";
			}  // end while
			
	} else {
			$list .= "<option value='' style='color:#FF0000'>No Record Found</option>\r\n";	
	} //end if dbNumRows
	 
	 return $list;	
}
///////////////////////////////////////////////////////////////////////////////////////
function StudentOption($studentId = '',$classId, $sectionId) {


	 $sql = "SELECT *
			FROM students
			WHERE class_id = $classId AND section_id=$sectionId AND student_status=1";
	$result = dbQuery($sql) or die('Cannot get Semester ' . mysql_error());
	
	$list = '';
	if (dbNumRows($result) > 0) {
		
		while($row = dbFetchAssoc($result)) {
		
		// build combo box options
				
				$list .= "<option value='" . $row['student_id'] ."'";
					if (@$row['student_id'] == $studentId) {
						$list.= " selected";
					}
					
				$list .= ">" . ucwords($row['student_first_name']) . " " . ucwords($row['student_last_name']);
				$list .=  "</option>\r\n";
			}  // end while
			
	} else {
			$list .= "<option value='' style='color:#FF0000'>No Record Found</option>\r\n";	
	} //end if dbNumRows
	 
	 return $list;	
}



////////////////////////////// Student Menu for Result /////////////////////
function studentsOptions($studentId = '') {

if (isset($_GET['classId']) && (int)$_GET['classId'] > 0) {
	$classId = (int)$_GET['classId'];


	 $sql = "SELECT *
			FROM students
			WHERE class_id = $classId";
	$result = dbQuery($sql) or die('Cannot get Semester ' . mysql_error());
	
	$list = '';
	$list .= "<option value=''>Choose Student</option>";
	if (dbNumRows($result) > 0) {
		
		while($row = dbFetchAssoc($result)) {
		
		// build combo box options
				
				$list .= "<option value='" . $row['student_id'] ."'";
					if (@$row['student_id'] == $studentId) {
						$list.= " selected";
					}
					
				$list .= ">" . ucwords($row['student_first_name']) . " " . ucwords($row['student_last_name']);
				$list .=  "</option>\r\n";
			}  
	}
}

elseif (isset($_GET['classId2']) && (int)$_GET['classId2'] > 0) {
	$classId2 = (int)$_GET['classId2'];

	 $sql = "SELECT *
			FROM students
			WHERE class_id = $classId2";
	$result = dbQuery($sql) or die('Cannot get Semester ' . mysql_error());
	
	$list = '';
	$list .= "<option value=''>Choose Student</option>";
	if (dbNumRows($result) > 0) {
		
		while($row = dbFetchAssoc($result)) {
		
		// build combo box options
				
				$list .= "<option value='" . $row['student_id'] ."'";
					if (@$row['student_id'] == $studentId) {
						$list.= " selected";
					}
					
				$list .= ">" . ucwords($row['student_first_name']) . " " . ucwords($row['student_last_name']);
				$list .=  "</option>\r\n";
			}  // end while
	}
}
			
	 else {
			$list .= "<option value='' style='color:#FF0000'>No Record Found</option>\r\n";	
	} //end if dbNumRows
	 
	 return $list;	
}


////////////////////////////// Subject Menu /////////////////////
function buildSubjects($subjectId = '') {

if (isset($_GET['classId']) && (int)$_GET['classId'] > 0) {
	$classId = (int)$_GET['classId'];
}

	echo $sql = "SELECT *
					FROM subjects
					WHERE class_id = $classId";
	$result = dbQuery($sql) or die('Cannot get Subject ' . mysql_error());
	
	$list = '';
	$list .= "<option value=''>--Subject--</option>";
	if (dbNumRows($result) > 0) {
		
		while($row = dbFetchAssoc($result)) {
		
		// build combo box options
				
				$list .= "<option value='" . $row['subject_id'] ."'";
					if (@$row['subject_id'] == $subjectId) {
						$list.= " selected";
					}
					
				$list .= ">" . ucwords($row['subject_title']) . " - " . ucwords($row['subject_code']);
				$list .=  "</option>\r\n";
			}  // end while
			
	} else {
			$list .= "<option value='' style='color:#FF0000'>No Record Found</option>\r\n";	
	} //end if dbNumRows
	 
	 return $list;	
}




/* Build Semester Option with Class */
function buildClassSemesterOptions($classId) {

	 $sql = "SELECT *
			FROM classinfo
			WHERE classinfoid  = $classId";
	$result = dbQuery($sql) or die('Cannot get Semester ' . mysql_error());
	
	//$list = '';
	$row = dbFetchAssoc($result);
	$currentSemester	=	$row['classsemester'];
	
	// build combo box options
	$list = '';
	  for ($sem = 1; $sem <= $currentSemester; $sem++) {			
		$list .= "<option value='" . $sem ."'";
				if (@$sem == @$_GET['sem']) {
					$list.= " selected";
				}
				
				$list .= ">" . convertToOrdinal($sem) . "</option>\r\n";
	 } //end for
	 
	 return $list;	
}



/********************** Faculty List Menu *********************/
function buildFacultyOptions($deptId) {

if (isset($_GET['facultyId']) && (int)$_GET['facultyId'] > 0) {
	$facultyId = (int)$_GET['facultyId'];
}

	$sql = "SELECT *
			FROM teachers 
			WHERE teacherdeptid = $deptId
			ORDER BY teachername ASC";
	$result = dbQuery($sql) or die('Cannot get data. ' . mysql_error());
	
	$list = '';
	while($row = dbFetchAssoc($result)) {
	
	// build combo box options
		if ($row['teacherid'] != 0) {
			$list .= "<option value='" . $row['teacherid'] ."'";
				if (@$row['teacherid'] == @$facultyId) {
					$list.= " selected";
				}
				
			$list .= ">" . ucwords($row['teachername']);
				if ($row['teacherdesignation'] == "nts") {
					$list .=  " (Non Teaching Staff)";
				} 
			$list .=  "</option>\r\n";
		} // end of
	} //end while
	
	return $list;
}

/********************* Week Days List Menu *********************/
function buildDaysOptions($day_id='') {

if (isset($_GET['day_id'])) {
	$day_id = $_GET['day_id'];
}

$weekDays = array( 1 => 'Monday', 2 =>'Tuesday',  3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday');

$daysOfWeek = '';
	foreach($weekDays as $key => $daysName){
		$daysOfWeek .= "<option value=\"$key\"";
		if ($key == @$day_id) {
			$daysOfWeek .= " selected";
		}
		
		$daysOfWeek .= ">" . ucwords($daysName) . "</option>\r\n";
	}	
	
	return $daysOfWeek;
}

/* Convert int value into english gregorian day */
function covertDay($dayInt) {

	$weekDays = array(1 => 'Monday', 2 =>'Tuesday',  3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday');

	return $weekDays[$dayInt];

}

////////////// Convert Geogorian Day into int day//////////////////
function covertDayToInt($day) {

	$weekDays = array('Monday' => 1, 'Tuesday' => 2,  'Wednesday' => 3, 'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6);

	return $weekDays[$day];

}

////////////// Convert Geogorian Month into int Month//////////////////
function covertMonthToInt($month) {

	$yearMonths = array('January' => 1, 'February' => 2,  'March' => 3, 'April' => 4, 'May' => 5, 'June' => 6, 'July' => 7, 'August' => 8, 'September' => 9, 'October' => 10, 'November' => 11, 'December' => 12);

	return $yearMonths[$month];

}
/* Convert int value into english gregorian day */
function covertMonth($monthInt) {

	$yearMonths = array(1 => 'January', 2 =>'February',  3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 =>'July' ,  8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 =>'December');

	return $yearMonths[$monthInt];

}

function covertTerm($number) {
$examType =  array(1=>'Monthly Test', 2=>'Term', 3=>'Final');
return $examType[$number];
}

function UserLevelOption($number) {
$adminType =  array( 1=>'Branch Admin', 2=>'Teacher');
return $adminType[$number];
}

/******************** Percent Function *****************/

function marksPercentage($marksObtained, $totalMarks) {

	$percentMakrs = ($marksObtained/$totalMarks) * 100;
	
return $percentMakrs;
}

/******************** Grade Calculation Function *****************/

function gradeCalculation($marks) {
	
	if ($marks >= 95 &&  $marks <= 100) {
		$grade = "A+";
	} 
	
	if ($marks >= 85 &&  $marks <= 94.99) {
		$grade = "A";
	} 
	
	if ($marks >= 70 &&  $marks <= 84.99) {
		$grade = "B";
	}
	
	if ($marks >= 60 &&  $marks <= 69.99) {
		$grade = "C";
	} 
	
	if ($marks < 60) {
		$grade = "F";
	}
	
	return $grade;
}


/******************** Grade From Database *****************/

function gradeMarks($marks) {
	
	$sql="SELECT * FROM grade_info";
	$result=dbQuery($sql);
	
	while ($row=dbFetchAssoc($result))
	
		if($row['grade_percentage_to']<=$marks && $row['grade_percentage_from']>= $marks){
			$grade=$row['grade_title']  ."  ". " <br>" . $row['grade_remarks'] ;
		}
	
	return $grade;
}


function gradeSystem($marks) {
	
	$sql="SELECT * FROM grade_info";
	$result=dbQuery($sql);
	
	while ($row=dbFetchAssoc($result))
	
		if($row['grade_percentage_to']<=$marks && $row['grade_percentage_from']>= $marks){
			$grade=$row['grade_title']  ;
	return $grade;
		}
}

/******************** Grade Point/ Quality Point Function *****************/

function gradePoint($grade) {
	
	if ($grade == "A+") {
		$gradePoint = 4.0;
	}
	
	if ($grade == "A") {
		$gradePoint = 4.0;
	} 
	
	if ($grade == "B") {
		$gradePoint = 3.0;
	}  
	
	if ($grade == "C") {
		$gradePoint = 2.0;
	} 
	
	if ($grade == "D") {
		$gradePoint = 0;
	}
	
	if ($grade == "F") {
		$gradePoint = 1;
	} 
	
	return $gradePoint;
}


/******************** Prdinal Conversion *****************/

function convertToOrdinal($num){
		$pf = array(0=>'th', 1=>'st', 2=>'nd', 3=>'rd', 4=>'th', 5=>'th', 6=>'th',7=>'th',8=>'th',9=>'th');
                $num = (string) ((int) $num);
		$strNum = $num;
		return $num . $pf[substr($strNum, strlen($strNum)-1, 1)];
}
/////////////////////////////////////////////////////////// Get marks ////////////////////

function getMarks($resultId, $studentId) {
	$sqlMarks = "SELECT *
				FROM result 
				WHERE resultinfoid = $resultId AND resultstudentid = $studentId";	
		
	$resultMarks = dbQuery($sqlMarks);
	$rowMarks	 = dbFetchAssoc($resultMarks);
	
	return  array('mid'=>$rowMarks['resultmidmarks'],'final'=>$rowMarks['resultfinalmarks'], 'sessional'=>$rowMarks['resultsessionalmarks']);
}

///////////////// Get Session From DATABASE  And Creat List menu /////////////////////////////

function getSessionOptions()
{

if (isset($_GET['session']) && (int)$_GET['session'] > 0) {
	$session = (int)$_GET['session'];
}

	$sql = "SELECT DISTINCT (classsession)
			FROM classinfo
			ORDER BY classsession DESC";
	$result = dbQuery($sql) or die('Cannot get Session ' . mysql_error());
	
	$list = '';
	while($row = dbFetchAssoc($result)) {
	
	// build combo box options
	$list .= "<option value='" . $row['classsession'] ."'";
			if (@$row['classsession'] == @$session) {
				$list.= " selected";
			}
			
			$list .= ">" . $row['classsession'] . "</option>\r\n";
	} //end while
	
	return $list;
}

/* Get Time Difference */
function getTimeDiff($t1,$t2) {
	$a1 = explode(":",$t1);
	$a2 = explode(":",$t2);
	
	$time1 = (($a1[0]*60*60)+($a1[1]*60));
	$time2 = (($a2[0]*60*60)+($a2[1]*60));
	
	$diff = abs($time1-$time2);
	$hours = floor($diff/(60*60));
	$mins = floor(($diff-($hours*60*60))/(60));
	
	$diff = $hours.":".$mins;
	
	return $diff;
}

function addHours($t, $h) {
	$a1 = explode(":", $t);
	$a2 = explode(":", $h);
	
	$time1 = (($a1[0]*60*60)+($a1[1]*60));
	$time2 = (($a2[0]*60*60)+($a2[1]*60));
	
	$diff = abs($time1+$time2);
	$hours = floor($diff/(60*60));
	$mins = floor(($diff-($hours*60*60))/(60));
	
	if ($mins == 0) {
		$mins = "00";
	}
	
	$newTime = $hours.":". $mins;
	
	return $newTime;
}

/*********************** Time List Menu *******************/
function time24Format($time) {

	$convertTime24	=	strftime("%H%M", strtotime($time));
	return $convertTime24;
}

function makeTime($time) {

	$newTime1	=	substr($time,0,2);
	$newTime2	=	substr($time,2,2);
	
	$newTime	=	$newTime1 . ":" . $newTime2;
	
	return $newTime;
}

function time24To12($time) {

	$convertTime24	=	strftime("%I:%M %p", strtotime($time));
	return $convertTime24;
}



/* For Teacher Workload */
function dbClassDaysTeacher($facultyId) {
	
 $sql = "SELECT DISTINCT (ttday)
			FROM timetable t, timetableinfo ti
			WHERE t.ttinfo = ti.ttinfoid AND ti.ttinfostatus = 1 AND t.ttteacherid = $facultyId
			ORDER BY t.ttday ASC";
	$result = dbQuery($sql);

	while($row = dbFetchAssoc($result)) {
		$dbDays[]	= $row['ttday'];	
	}
	
	return $dbDays;
}

/* Count Teacher Leacture Per day */
function facultyLecturePerDay($facultyId, $day = 0) {

if (isset($day) && $day > 0) {	
	$sql 	= "SELECT COUNT(ttteacherid) as perdaylec
				FROM timetable t, timetableinfo ti
				WHERE t.ttinfo = ti.ttinfoid AND ti.ttinfostatus = 1 AND t.ttteacherid = $facultyId AND t.ttday = $day";
} else {
	$sql 	= "SELECT COUNT(ttteacherid) as perdaylec
				FROM timetable t, timetableinfo ti
				WHERE t.ttinfo = ti.ttinfoid AND ti.ttinfostatus = 1 AND t.ttteacherid = $facultyId";

}
$result = dbQuery($sql);
$row 	= dbFetchAssoc($result);

	return $row['perdaylec'];
}

/* Update Time table status  */
function chackTimetableStatus($ttEndDate, $ttInfoId) {

	$currentDate	=	date("Y-m-d");
	
	if ($currentDate > $ttEndDate) {
		
		$sqlStatus = "UPDATE timetableinfo
					  SET ttinfostatus = 0 
			          WHERE ttinfoid = $ttInfoId";
		$resultStatus = dbQuery($sqlStatus);
	
	}	
}

//////////////////////////// Educational Faculty ///////////////////////////////////

function buildEduFacultyOptions() {

if (isset($_GET['eduFacultyId']) && (int)$_GET['eduFacultyId'] > 0) {
	$eduFacultyId = (int)$_GET['eduFacultyId'];
}

	$sql = "SELECT *
			FROM faculty 
			ORDER BY facultyname ASC";
	$result = dbQuery($sql) or die('Cannot get data. ' . mysql_error());
	
	$list = '';
	while($row = dbFetchAssoc($result)) {
	
	// build combo box options
	$list .= "<option value='" . $row['facultyid'] ."'";
			if (@$row['facultyid'] == @$eduFacultyId) {
				$list.= " selected";
			}
			
			$list .= ">" . ucwords($row['facultyname']) . "</option>\r\n";
	} //end while
	
	return $list;
}

/* Campus */

function buildCampusOptions() {

if (isset($_GET['campusId']) && (int)$_GET['campusId'] > 0) {
	echo $campusId = (int)$_GET['campusId'];
}

	$sql = "SELECT *
			FROM campuses 
			ORDER BY campusname ASC";
	$result = dbQuery($sql) or die('Cannot get data. ' . mysql_error());
	
	$list = '';
	while($row = dbFetchAssoc($result)) {
	
	// build combo box options
	$list .= "<option value='" . $row['campusid'] ."'";
			if (@$row['campusid'] == @$campusId) {
				$list.= " selected";
			}
			
			$list .= ">" . ucwords($row['campusname']) . "</option>\r\n";
	} //end while
	
	return $list;
}


/******************** Occupation Menu ******************/

function listbox_array ($list, $default=0, $associative=0) {
   // $result="<select name='$name'>n";
   $result = '';
    while (list($key, $val) = each($list)) {
        if ($associative) {
            if ($default  == $key) {$selected="selected";} else {$selected="";}
            $result.="<option value='$key' $selected>$val</option>n";
        } else {
            if ($default == $val) {$selected="selected";} else {$selected="";}
            $result.="<option value='$val' $selected>$val</option>n";
        }
    }
    //$result.="</select>n";
return $result;
}

/////////////////////////////////////////////////////// FOR MONTH ////////////////////////////////

function getMonth ($month='') {

	$sql = "SELECT DISTINCT(fine_month) as month
			FROM montly_fee 
			ORDER BY month DESC";
	$result = dbQuery($sql) or die('Cannot get data. ' . mysql_error());
	
	$list = '';
	while($row = dbFetchAssoc($result)) {
	
	// build combo box options
	$list .= "<option value='" . $row['month'] ."'";
			if (@$row['month'] == @$month) {
				$list.= " selected";
			}
			
			$list .= ">" . ucwords($row['month']) . "</option>\r\n";
	} //end while
	
	return $list;
	
}


/////////////////////////////////////////////////////// FOR YEAR ////////////////////////////////

function getYear($year='') {

	$sql = "SELECT DISTINCT(fine_year) as year
			FROM montly_fee 
			ORDER BY year DESC";
	$result = dbQuery($sql) or die('Cannot get data. ' . mysql_error());
	
	$list = '';
	while($row = dbFetchAssoc($result)) {
	
	// build combo box options
	$list .= "<option value='" . $row['year'] ."'";
			if (@$row['year'] == @$year) {
				$list.= " selected";
			}
			
			$list .= ">" . ucwords($row['year']) . "</option>\r\n";
	} //end while
	
	return $list;
	
}



/////////////////////////////////////////////////////// FOR Page Association ////////////////////////////////

	function getNav($dbConn, $CategoryId='') {
		$sql = "SELECT * FROM category ORDER BY Category_id ASC";
		$result = dbQuery($dbConn, $sql);
		$list = '';
		while($row = dbFetchAssoc($result)) {
		// build combo box options
		$list .= "<option value='" . $row['Category_id'] ."'";
				if (@$row['Category_id'] == @$CategoryId) {
					$list.= " selected";
				}
				$list .= ">" . ucwords($row['Category_name']) . "</option>\r\n";
		} //end while	
		return $list;
	}

function getPage2($pageId='') {
	
	

	$sql = "SELECT *
			FROM tbl_pages WHERE page_relation=0 AND page_id=pageId
			ORDER BY page_id ASC";
	$result = dbQuery($sql) or die('Cannot get data. ' . mysql_error());
	
	$list = '';
	while($row = dbFetchAssoc($result)) {
	
	// build combo box options
	$list .= "<option value='" . $row['page_id'] ."'";
			if (@$row['page_id'] == @$year) {
				$list.= " selected";
			}
			
			$list .= ">" . ucwords($row['page_name']) . "</option>\r\n";
	} //end while
	
	return $list;
	
}

///////////////////////////////////////////////////////////
/////////////////////////////////////////////////////// FOR NAV Association ////////////////////////////////

function assMainNav($navId='') {

	$sql = "SELECT *
			FROM tbl_footer_nav WHERE nav_association=0 
			ORDER BY nav_id ASC";
	$result = dbQuery($sql) or die('Cannot get data. ' . mysql_error());
	
	$list = '';
	while($row = dbFetchAssoc($result)) {
	
	// build combo box options
	$list .= "<option value='" . $row['nav_id'] ."'";
			if (@$row['nav_id'] == @$navId) {
				$list.= " selected";
			}
			
			$list .= ">" . ucwords($row['nav_title']) . "</option>\r\n";
	} //end while
	
	return $list;
	
}


function getAssMainNav($navId='') {

	$sql = "SELECT *
			FROM tbl_footer_nav WHERE nav_association=0 
			ORDER BY nav_id ASC";
	$result = dbQuery($sql) or die('Cannot get data. ' . mysql_error());
	
	$list = '';
	while($row = dbFetchAssoc($result)) {
	
	// build combo box options
	$list .= "<option value='" . $row['nav_id'] ."'";
			if (@$row['nav_id'] == @$navId) {
				$list.= " selected";
			}
			
			$list .= ">" . ucwords($row['nav_title']) . "</option>\r\n";
	} //end while
	
	return $list;
	
}



//////////////////////// Status  //////////////////////////


function getStatus ($dbConn){
	$sql = "SELECT * FROM tbl_status";
	$result = dbQuery($dbConn, $sql);
	if(dbNumRows($result) >0 ){
		while($row = dbFetchAssoc($result)) {
			// build combo box options
			echo $list = "<option value='" . $row['status_id'] ."'" .">" . strtoupper($row['status']) ."</option>\r\n"; ;

		} //end while
	}
}

function getStatusByID ($dbConn,$statusId){
	$sql = "SELECT * FROM tbl_status WHERE status_id = '$statusId'";
	$result = dbQuery($dbConn, $sql);
	if(dbNumRows($result) >0 ){
		$row = dbFetchAssoc($result);
			echo "<option value='" . $row['status_id'] ."'" .">" . strtoupper($row['status']) ."</option>\r\n";
	}
}


////////////////////////// Department ///////////////////////////////


function getDepartment ($dbConn){
	$sql = "SELECT * FROM department";
	$result = dbQuery($dbConn, $sql);
	if(dbNumRows($result) >0 ){
		while($row = dbFetchAssoc($result)) {
			// build combo box options
			echo $list = "<option value='" . $row['dep_id'] ."'" .">" . strtoupper($row['dep_name']) ."</option>\r\n";

		} //end while
	}
}

function getDepartmentAr ($dbConn){
	$sql = "SELECT * FROM department";
	$result = dbQuery($dbConn, $sql);
	if(dbNumRows($result) >0 ){
		$db = array();
		while($row = dbFetchAssoc($result)) {
			$id = $row['dep_id'];
			$db[$id] = $row['dep_name'];
		} //end while
		return $db;
	}
}


function getDepartmentByID ($dbConn,$depId){
	$sql = "SELECT * FROM department WHERE dep_id = '$depId'";
	$result = dbQuery($dbConn, $sql);
	if(dbNumRows($result) >0 ){
		$row = dbFetchAssoc($result);
			echo strtoupper($row['dep_name']);
	}
}



///////////////// PRINT R FUNCTION ///////////////////////

function printR($array) {
	echo "<pre>";
		print_r($array);
	echo "</pre>";
}


?>