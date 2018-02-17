<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';

	checkUser();
	$action = isset($_GET['action']) ? $_GET['action'] : '';
	switch ($action) {
		case 'add' :
			addUser($dbConn);
			break;
			
		case 'modify' :
			modifyUser($dbConn);
			break;

		case 'addTask' :
			addTask($dbConn);
			break;
		case 'com' :
			complete($dbConn);
			break;

		case 'del' :
			del($dbConn);
			break;
		case 'atn' :
			atn($dbConn);
			break;

		case 'delete' :
			deleteUser($dbConn);
			break;
			
		case 'updateTask' :
			updateTask($dbConn);
			break;
			
		default :
			// if action is not defined or unknown
			// move to main index page
			redirect('index.php');
	}
	// Add New User
	function addUser($dbConn){
		$txtDepId       = mysqli_real_escape_string($dbConn,$_POST['txtDepId']);
		$txtDesgId		= mysqli_real_escape_string($dbConn, $_POST['txtDesgId']);
		$txtUserName 	= mysqli_real_escape_string($dbConn, $_POST['txtUserName']);
		$txtPassword 	= mysqli_real_escape_string($dbConn, md5($_POST['txtPassword']));
		$txtMob			= mysqli_real_escape_string($dbConn, $_POST['txtMob']);
		$txtFamMob		= mysqli_real_escape_string($dbConn, $_POST['txtFamMob']);
		$txtCity 	 	= mysqli_real_escape_string($dbConn, $_POST['txtCity']);
		$txtEmail 	 	= mysqli_real_escape_string($dbConn, $_POST['txtEmail']);
		$txtCnic		= mysqli_real_escape_string($dbConn, $_POST['txtCnic']);
		$txtAddress		= mysqli_real_escape_string($dbConn, $_POST['txtAddress']);
		$radStatus 	 	= mysqli_real_escape_string($dbConn, $_POST['radStatus']);
		
		$sql2 = "SELECT user_id FROM tbl_user WHERE user_name = '$txtUserName'";
		$result2 = dbQuery($dbConn, $sql2);
		if(dbNumRows($result2) > 0){
			$_SESSION['count'] = 0;
			$_SESSION['errorMessage'] = "User Name Already Added.";
			redirect('index.php?view=add');	
		}else{
			// Insert
			$sql   = "INSERT INTO tbl_user (dep_id,desig_id, user_name, user_password, user_mob, user_family_mob, user_city, user_email, user_cnic, user_img, user_address, user_regdate, user_last_login, user_status)
					  VALUES ('$txtDepId','$txtDesgId', '$txtUserName', '$txtPassword','$txtMob','$txtFamMob','$txtCity', '$txtEmail', '$txtCnic','','$txtAddress', NOW(),'', '$radStatus')";
			$result = dbQuery($dbConn, $sql);
			$_SESSION['count'] = 0;
			$_SESSION['errorMessage'] = "Member Added Successfully.";
			redirect('index.php');	
		}
		
	}
	//Modify User
	function modifyUser($dbConn) {
		$userId			= mysqli_real_escape_string($dbConn, $_POST['hidId']);
		$txtDepId       = mysqli_real_escape_string($dbConn, $_POST['txtDepId']);
		$txtDesgId		= mysqli_real_escape_string($dbConn, $_POST['txtDesgId']);
		$txtUserName 	= mysqli_real_escape_string($dbConn, $_POST['txtUserName']);
		$txtPassword 	= mysqli_real_escape_string($dbConn, md5($_POST['txtPassword']));
		$txtMob			= mysqli_real_escape_string($dbConn, $_POST['txtMob']);
		$txtFamMob		= mysqli_real_escape_string($dbConn, $_POST['txtFamMob']);
		$txtCity 	 	= mysqli_real_escape_string($dbConn, $_POST['txtCity']);
		$txtEmail 	 	= mysqli_real_escape_string($dbConn, $_POST['txtEmail']);
		$txtCnic		= mysqli_real_escape_string($dbConn, $_POST['txtCnic']);
		$txtAddress		= mysqli_real_escape_string($dbConn, $_POST['txtAddress']);
		$radStatus 	 	= mysqli_real_escape_string($dbConn, $_POST['radStatus']);
		// Update
		if($txtPassword == ""){
			$sql = "UPDATE tbl_user SET dep_id = $txtDepId, desig_id = $txtDesgId, user_name='$txtUserName',  user_mob = '$txtMob',user_family_mob = '$txtFamMob', user_city = '$txtCnic', user_email = '$txtEmail', user_cnic = '$txtCnic',
			user_address = '$txtAddress', user_status = '$radStatus' WHERE user_id = $userId";
			$result = dbQuery($dbConn, $sql);
			$_SESSION['count'] = 0;
			$_SESSION['errorMessage'] = "Member Updated Successfully.";
			redirect('index.php');	
		}else{
			$sql = "UPDATE tbl_user SET dep_id = $txtDepId, desig_id = $txtDesgId, user_name='$txtUserName',user_password = '$txtPassword',  user_mob = '$txtMob',user_family_mob = '$txtFamMob', user_city = '$txtCnic', user_email = '$txtEmail', user_cnic = '$txtCnic',
			user_address = '$txtAddress', user_status = '$radStatus' WHERE user_id = $userId";
			$result = dbQuery($dbConn, $sql);
			$_SESSION['count'] = 0;
			$_SESSION['errorMessage'] = "Member Updated Successfully.";
			redirect('index.php');
		}
	}

	function deleteUser($dbConn){
		if (isset($_GET['userId']) && (int)$_GET['userId']>0){
			$userId	=    $_GET['userId'];
		}
		$sql2 = "SELECT user_img FROM tbl_user WHERE userId = '$userId'";
		$result2 = dbQuery($dbConn, $sql2);
		$row2 = dbFetchAssoc($result2);
		@unlink( ABS_PATH ."upload/user/" .$row2['user_img']);
		$sql		=	"DELETE FROM tbl_user WHERE user_id=$userId";
		$result 	= 	dbQuery($dbConn, $sql);
		$_SESSION['count'] = 0;
		$_SESSION['errorMessage'] = "Member Deleted Successfully.";
		redirect('index.php');			
	}

	function addTask($dbConn){
		$user_id = $_POST['userId'];
		$tasks = $_POST['task'];
		$due_date =  $_POST['due_date'];
		$date = date("d-m-y");
		if(isset($_POST['oId']) && !empty($_POST['oId']) )
			$orderId=$_POST['oId'];
		else
			$orderId=0;
		$sql = "INSERT INTO `tasks`(`task_id`, `tasks`, `date`, `status`, `user_id`,`due_date`,order_id)
				VALUES (NULL ,'$tasks','$date',0,'$user_id','$due_date','".$orderId."')";
		
		$result = dbQuery($dbConn,$sql);
		if(isset($_POST['oId'])){
			redirect(WEB_ROOT_ADMIN."order/index.php?view=detail&orderId=".$_POST['oId']);
		}else{
			redirect("../");
		}
}
	function complete($dbConn){
		$taskId = $_GET['taskId'];
		$sql = "UPDATE `tasks` SET `status`= 1 WHERE `task_id` = '$taskId'";
		$result = dbQuery($dbConn,$sql);
		redirect("../");
	}
	function updateTask($dbConn){
		$taskId = $_GET['taskId'];
		$sql = "UPDATE `tasks` SET `is_accept`= 1 WHERE `task_id` = '$taskId'";
		$result = dbQuery($dbConn,$sql);
		redirect("../");
	}
	function del($dbConn){
		$taskId = $_GET['taskId'];
		$sql = "DELETE FROM `tasks` WHERE `task_id` = '$taskId'";
		$result = dbQuery($dbConn,$sql);
		redirect("../");
	}

function atn($dbConn){
	$user_id = $_POST['userId'];
	$attendance = $_POST['att'];
	$month = date("m");
	$day = date("d");
	$year = date("Y");
	$time = date("h:i:s A");
	$spend_hours=0;
	if( isset($_POST['spend_hours']) && !empty($_POST['spend_hours']) )
		$spend_hours=$_POST['spend_hours'];
	
	$sql = "INSERT INTO `attendance`(`id`, `attendance`, `month`, `time`, `user_id`, `day`, `year`,`spend_hours`)
						    VALUES (NULL ,'$attendance','$month','$time','$user_id','$day','$year','$spend_hours')";
							
	$result = dbQuery($dbConn,$sql);
	redirect("../");
}

?>