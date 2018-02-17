<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';
	checkUser();
	$action = isset($_GET['action']) ? $_GET['action'] : '';

	switch ($action) {
		
		case 'add' :
			addbank($dbConn);
			break;
		
		case 'modify' :
			modifybank($dbConn);
			break;
		case 'addrecept' :
			addreceptbank($dbConn);
			break;
			
		default :
			redirect('index.php');
	}
	function addreceptbank($dbConn){
		$BankId		  	= mysqli_real_escape_string($dbConn, $_POST['hidId']);
		$txtDcDate	= mysqli_real_escape_string($dbConn, $_POST['txtDcDate']);
		$txtDcTime  = mysqli_real_escape_string($dbConn, $_POST['txtDcTime']);
		$txtAcoutnType	= mysqli_real_escape_string($dbConn, $_POST['txtAcoutnType']);
		$txtAmount 	= mysqli_real_escape_string($dbConn, $_POST['txtAmount']);
		$txtdescrption		= mysqli_real_escape_string($dbConn, $_POST['txtdescrption']);
		$currentBlance = totalamnt($dbConn, $BankId);
		if($txtAcoutnType == 1){
			$debit = $txtAmount;
			$credit = "";
			$updateblance = $currentBlance + $debit;
		}else{
			$debit = "";
			$credit = $txtAmount;
			$updateblance = $currentBlance - $credit;
		}
		$sql2 = "UPDATE tbl_bank SET bank_current_blance = '$updateblance' WHERE bank_id = '$BankId' ";
		if($result2 = dbQuery($dbConn, $sql2)){
			$sql = "INSERT INTO tbl_bank_recept(bank_recept_date, bank_recept_time, recept_debit, recept_credit, recept_description, bank_id, avalable_amount)VALUES
			('$txtDcDate', '$txtDcTime', '$debit','$credit','$txtdescrption','$BankId', '$updateblance')";
			$result = dbQuery($dbConn, $sql);
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Bank Recept Added Successfully.";
			redirect('index.php?view=accdetail&BankId='.$BankId);
		}
	}
	//Modify bank
	function modifybank($dbConn){
		$BankId		  	= mysqli_real_escape_string($dbConn, $_POST['hidId']);
		$txtBankName	= mysqli_real_escape_string($dbConn, $_POST['txtBankName']);
		$txtBranchName  = mysqli_real_escape_string($dbConn, $_POST['txtBranchName']);
		$txtBranchCode	= mysqli_real_escape_string($dbConn, $_POST['txtBranchCode']);
		$txtAccTitle 	= mysqli_real_escape_string($dbConn, $_POST['txtAccTitle']);
		$txtAccNo		= mysqli_real_escape_string($dbConn, $_POST['txtAccNo']);
		$txtCurrBlance  = mysqli_real_escape_string($dbConn, $_POST['txtCurrBlance']);
		
		$sql2 = "SELECT bank_acount_no FROM tbl_bank WHERE bank_acount_no = '$txtAccNo'";
		$result2 = dbQuery($dbConn, $sql2);
		$rows2 = dbNumRows ($result2);
		if($rows2 > 0){
			$sql = "UPDATE tbl_bank SET bank_name ='$txtBankName', bank_branch_name='$txtBranchName', bank_branch_code= '$txtBranchCode',
			bank_acount_title='$txtAccTitle', bank_current_blance='$txtCurrBlance' WHERE bank_id = '$BankId' ";
			$result = dbQuery($dbConn, $sql);
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Bank Updated Successfully.";
			redirect('index.php?view=list');
		}else{
			$sql = "UPDATE tbl_bank SET bank_name ='$txtBankName', bank_branch_name='$txtBranchName', bank_branch_code= '$txtBranchCode',
			bank_acount_title='$txtAccTitle', bank_acount_no='$txtAccNo', bank_current_blance='$txtCurrBlance' WHERE bank_id = '$BankId' ";
			$result = dbQuery($dbConn, $sql);
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Bank Updated Successfully.";
			redirect("index.php?view=list");
		}
	}
	
	//Add Bank
	function addbank($dbConn){
		$txtBankName	= mysqli_real_escape_string($dbConn, $_POST['txtBankName']);
		$txtBranchName  = mysqli_real_escape_string($dbConn, $_POST['txtBranchName']);
		$txtBranchCode	= mysqli_real_escape_string($dbConn, $_POST['txtBranchCode']);
		$txtAccTitle 	= mysqli_real_escape_string($dbConn, $_POST['txtAccTitle']);
		$txtAccNo		= mysqli_real_escape_string($dbConn, $_POST['txtAccNo']);
		$txtCurrBlance  = mysqli_real_escape_string($dbConn, $_POST['txtCurrBlance']);
		$sql2 = "SELECT bank_acount_no FROM tbl_bank WHERE bank_acount_no = '$txtAccNo'";
		$result2 = dbQuery($dbConn, $sql2);
		$rows2 = dbNumRows ($result2);
		if($rows2 > 0){
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Account Already Exist";
			redirect('index.php?view=add');
		}else{
			$sql = "INSERT INTO tbl_bank(bank_name, bank_branch_name,bank_branch_code, bank_acount_title, bank_acount_no, bank_current_blance ) VALUES
			('$txtBankName', '$txtBranchName','$txtBranchCode','$txtAccTitle','$txtAccNo','$txtCurrBlance' )";
			$result = dbQuery($dbConn, $sql);
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Bank Detail Added Successfully.";
			redirect("index.php?view=list");
		}
	}
	
	//DELETE item
	function deleteitem($dbConn) {
		if(isset($_GET['ItemId']) && ($_GET['ItemId'])>0 ){
			$ItemId = $_GET['ItemId'];
		}else{
			redirect("index.php");
			exit();
		}
		$sql    =	"DELETE FROM tbl_item WHERE item_id = $ItemId";		
		$result = 	 dbQuery($dbConn, $sql);
		$_SESSION['count'] = 0;
		$_SESSION['data'] = "success";
		$_SESSION['errorMessage'] = "Item delete Successfully.";
		redirect("index.php");
	}
	
	

?>