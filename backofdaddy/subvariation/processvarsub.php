
<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';
	checkUser();
	$action = isset($_GET['action']) ? $_GET['action'] : '';

	switch ($action) {
		
		case 'add' :
			addSubVar($dbConn);
			break;
		
		case 'delete' :
			deleteSubVar($dbConn);
			break;
		
		default :
			redirect('index.php');
	}
	
	function deleteSubVar($dbConn) {
		if(isset($_GET['SVId']) && ($_GET['SVId'])>0 ){
			$SVId = $_GET['SVId'];
		}else{
			redirect("index.php");
			exit();
		}
		$sql    =	"DELETE FROM tbl_subvar WHERE sv_id ='$SVId'";		
		$result = 	 dbQuery($dbConn, $sql);
		$_SESSION['count'] = 0;
		$_SESSION['data'] = "success";
		$_SESSION['errorMessage'] = "Sub Variation Delted Successfully";
		redirect("index.php?view=list");
	}
	//Add Variation
	function addSubVar($dbConn){
		$txtFlagType	= mysqli_real_escape_string($dbConn, $_POST['txtFlagType']);
		$txtsubVarType	= mysqli_real_escape_string($dbConn, $_POST['txtsubVarType']);
		$txtsubvar		= mysqli_real_escape_string($dbConn, $_POST['txtsubvar']);
		
		$sql2 = "INSERT INTO tbl_subvar(var_id, sv_type_id, sv_var_id) VALUES 
		( '$txtFlagType', '$txtsubVarType','$txtsubvar')";
		$result2 = dbQuery($dbConn, $sql2);
		$_SESSION['count'] = 0;
		$_SESSION['data'] = "success";
		$_SESSION['errorMessage'] = "Sub Variation Added Successfully.";
		redirect("index.php?view=list");
		
	}

?>