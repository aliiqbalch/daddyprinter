<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';

	checkUser();
	$action = isset($_GET['action']) ? $_GET['action'] : '';
	switch ($action) {
		
		case 'add' :
			addClient($dbConn);
			break;
			
		case 'modify' :
			modifyClient($dbConn);
			break;
		case 'delete' :
			deleteClient($dbConn);
			break;

		default :
			// if action is not defined or unknown
			// move to main index page
			redirect('index.php');
	}
	// Add New User
	function addClient($dbConn){
		$txtCmpName		= mysqli_real_escape_string($dbConn, $_POST['txtCmpName']);
		$txtName 		= mysqli_real_escape_string($dbConn, $_POST['txtName']);
		$txtPhone 		= mysqli_real_escape_string($dbConn, $_POST['txtPhone']);
		$txtEmail		= mysqli_real_escape_string($dbConn, $_POST['txtEmail']);
		$txtCity		= mysqli_real_escape_string($dbConn, $_POST['txtCity']);
		$txtFolowDate	= mysqli_real_escape_string($dbConn, $_POST['txtFolowDate']);
		$txtAddress 	= mysqli_real_escape_string($dbConn, $_POST['txtAddress']);
		$txtNotes		= mysqli_real_escape_string($dbConn, $_POST['txtNotes']);
		$userId			= $_SESSION['userId'];
		$regDate		= date('Y-m-d');
		
		$sql2 = "SELECT client_cmpy_name FROM tbl_client WHERE client_cmpy_name = '$txtCmpName'";
		$result2 = dbQuery($dbConn, $sql2);
		if(dbNumRows($result2) > 0){
			$_SESSION['count'] = 0;
			$_SESSION['errorMessage'] = "Company Name Already Added.";
			redirect('index.php?view=add');
		}else{
			// Insert
			$sql   = "INSERT INTO tbl_client (client_cmpy_name, client_name, client_reg_date, client_phone, client_email, client_address, client_city, user_id, client_notes, client_nxt_folow_date)
					  VALUES ('$txtCmpName', '$txtName', '$regDate','$txtPhone','$txtEmail','$txtAddress', '$txtCity', '$userId','$txtNotes', '$txtFolowDate')";
			$result = dbQuery($dbConn, $sql);
			addAccount($dbConn,$txtCmpName);
			$_SESSION['count'] = 0;
			$_SESSION['errorMessage'] = "Clients Added Successfully.";
			if(@$_POST['quotation']){
				redirect('../quotation/index.php?view=quotation');
			}else {
				redirect('index.php');
			}
		}
		
	}

	function addAccount($dbConn, $txtCmpName){
		$code = 0;
		if(lastAccountid($dbConn)){
			$code = 1 + lastAccountid($dbConn);
		}else{
			$code= 700;
		}
		$txtCmpName = $txtCmpName." Account";
		$sql = "INSERT INTO `account`(`id`, `account_title`, `code`,'type') VALUES (NULL ,'$txtCmpName','$code','R')";
		$result = dbQuery($dbConn,$sql);
	}

	//Modify User
	function modifyClient($dbConn) {
		$ClientId		= mysqli_real_escape_string($dbConn, $_POST['hidId']);
		$txtCmpName		= mysqli_real_escape_string($dbConn, $_POST['txtCmpName']);
		$txtName 		= mysqli_real_escape_string($dbConn, $_POST['txtName']);
		$txtPhone 		= mysqli_real_escape_string($dbConn, $_POST['txtPhone']);
		$txtEmail		= mysqli_real_escape_string($dbConn, $_POST['txtEmail']);
		$txtCity		= mysqli_real_escape_string($dbConn, $_POST['txtCity']);
		$txtFolowDate	= mysqli_real_escape_string($dbConn, $_POST['txtFolowDate']);
		$txtAddress 	= mysqli_real_escape_string($dbConn, $_POST['txtAddress']);
		$txtNotes		= mysqli_real_escape_string($dbConn, $_POST['txtNotes']);
		$sql = "UPDATE tbl_client SET client_cmpy_name = '$txtCmpName', client_name = '$txtName', client_phone='$txtPhone',client_email = '$txtEmail',  client_city = '$txtCity',client_nxt_folow_date = '$txtFolowDate', client_address = '$txtAddress', client_notes = '$txtNotes' WHERE client_id = $ClientId";
		$result = dbQuery($dbConn, $sql);
		$_SESSION['count'] = 0;
		$_SESSION['errorMessage'] = "Client Infomation Updated Successfully.";
		redirect('index.php');
	}
	
	//DELETE
	function deleteClient($dbConn) {
		if(isset($_GET['CliId']) && ($_GET['CliId'])>0 ){
			$CliId = $_GET['CliId'];
		}else{
			redirect("index.php");
			exit();
		}
		$sql = "DELETE FROM tbl_client WHERE client_id = $CliId";
		$result = dbQuery($dbConn, $sql);
		$_SESSION['count'] = 0;
		$_SESSION['errorMessage'] = "Client Delete Successfully.";
		redirect('index.php');
	}


?>