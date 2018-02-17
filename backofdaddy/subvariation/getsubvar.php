<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';
	checkUser();
	
	if(isset($_GET['VarTypeId'])){
		$VarTypeId = $_REQUEST['VarTypeId'];
		$sql = "SELECT * FROM tbl_variation WHERE var_type_id = '$VarTypeId'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0){
			while($row = dbFetchAssoc($result)){
				echo $list = "<option value='" . $row['var_id'] ."'" .">" . strtoupper($row['var_title']) ."</option>\r\n"; ;
			}
		}
		
		
	}
?> 