<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';
	checkUser();
	
	if(isset($_GET['CatId']) AND $_GET['CatId'] > 0){
		
		$CatId = $_GET['CatId'];
		$sql = "SELECT * FROM tbl_sub_category WHERE cat_id = '$CatId'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) >0){
			while($row = dbFetchAssoc($result)){
				echo $list = "<option value='" . $row['sub_cat_id'] ."'" .">" . strtoupper($row['sub_cat_title']) ."</option>\r\n"; ;
			}
		}
		
		
	}
?> 