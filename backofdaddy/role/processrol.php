
<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';
	checkUser();
	$action = isset($_GET['action']) ? $_GET['action'] : '';

	switch ($action) {
		
		case 'add' :
			addRol($dbConn);
			break;
		case 'modify' :
			modifyRol($dbConn);
			break;
		case 'delete' :
			deleteRol($dbConn);
			break;
		
		default :
			redirect('index.php');
	}
	
	function deleteRol($dbConn) {
		if(isset($_GET['DesId']) && ($_GET['DesId'])>0 ){
			$DesId = $_GET['DesId'];
		}else{
			redirect("index.php");
			exit();
		}
		
		$sql    =	"DELETE FROM tbl_role WHERE desig_id ='$DesId'";		
		$result = 	 dbQuery($dbConn, $sql);
		$_SESSION['count'] = 0;
		$_SESSION['data'] = "success";
		$_SESSION['errorMessage'] = "Role Delted Successfully";
		redirect("index.php?view=list");
		
	}
	//Add Role
	function addRol($dbConn){
		$txtdesigId	= mysqli_real_escape_string($dbConn, $_POST['txtdesigId']);
		
		$sql = "SELECT role_id FROM tbl_role WHERE desig_id = '$txtdesigId'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "danger";
			$_SESSION['errorMessage'] = "Designation already exist.";
			redirect("index.php?view=add");
		}else{
			$sql2 = "SELECT mod_id FROM tbl_module";
			$result2 = dbQuery($dbConn, $sql2);
			if(dbNumRows($result2) >0){
				while($row2 = dbFetchAssoc($result2)){
					extract($row2);
					if(isset($_POST['view_'.$mod_id])){
						$view 	= $_POST['view_'.$mod_id];
					}else{
						$view = 0;
					}
					
					if(isset($_POST['add_'.$mod_id])){
						$add 	= $_POST['add_'.$mod_id];
					}else{
						$add = 0;
					}
					
					if(isset($_POST['update_'.$mod_id])){
						$update 	= $_POST['update_'.$mod_id];
					}else{
						$update = 0;
					}
					
					if(isset($_POST['delete_'.$mod_id])){
						$delete 	= $_POST['delete_'.$mod_id];
					}else{
						$delete = 0;
					}

					if($mod_id == 7){
						if(isset($_POST['costPrice_'.$mod_id])){
							$costPrice 	= $_POST['costPrice_'.$mod_id];
						}else{
							$costPrice = 0;
						}
						if(isset($_POST['wholeSale_'.$mod_id])){
							$wholeSale 	= $_POST['wholeSale_'.$mod_id];
						}else{
							$wholeSale = 0;
						}
						if(isset($_POST['variation_'.$mod_id])){
							$variation 	= $_POST['variation_'.$mod_id];
						}else{
							$variation = 0;
						}
					}
					if($mod_id == 8){
						if(isset($_POST['costPrice_'.$mod_id])){
							$costPrice 	= $_POST['costPrice_'.$mod_id];
						}else{
							$costPrice = 0;
						}
						if(isset($_POST['wholeSale_'.$mod_id])){
							$wholeSale 	= $_POST['wholeSale_'.$mod_id];
						}else{
							$wholeSale = 0;
						}
						if(isset($_POST['factor_'.$mod_id])){
							$factor 	= $_POST['factor_'.$mod_id];
						}else{
							$factor = 0;
						}
					}

					$sql3 = "INSERT INTO tbl_role(desig_id, mod_id, role_view, role_add, role_edit, role_delete,cost_price,whole_sale,variation,factor )
							VALUES ( '$txtdesigId', '$mod_id', $view, $add, $update, $delete, ";
					if($mod_id == 7){
						$sql3 .= "$costPrice, $wholeSale, $variation, 0 ";
					}else if($mod_id == 8){
						$sql3 .="$costPrice, $wholeSale, 0, $factor ";
					}else{
						$sql3 .= "0, 0, 0, 0";
					}
					$sql3 .= ")";
					$result3 = dbQuery($dbConn, $sql3);
				}
			}
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Role Added Successfully.";
			redirect("index.php?view=list");
		}
	}
	//Modify Role
	function modifyRol($dbConn){
		$DesId		= mysqli_real_escape_string($dbConn, $_POST['hidId']);
		$txtdesigId	= mysqli_real_escape_string($dbConn, $_POST['txtdesigId']);
		
		
		$sql = "SELECT role_id FROM tbl_role WHERE desig_id = '$txtdesigId'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$sql2 = "SELECT * FROM tbl_role WHERE desig_id = '$DesId' ORDER BY role_id ASC";
			$result2 = dbQuery($dbConn, $sql2);
			if(dbNumRows($result2) >0){
				while($row2 = dbFetchAssoc($result2)){
					extract($row2);
					if(isset($_POST['view_'.$role_id])){
						$view 	= $_POST['view_'.$role_id];
					}else{
						$view = 0;
					}
					
					if(isset($_POST['add_'.$role_id])){
						$add 	= $_POST['add_'.$role_id];
					}else{
						$add = 0;
					}
					
					if(isset($_POST['update_'.$role_id])){
						$update 	= $_POST['update_'.$role_id];
					}else{
						$update = 0;
					}
					
					if(isset($_POST['delete_'.$role_id])){
						$delete 	= $_POST['delete_'.$role_id];
					}else{
						$delete = 0;
					}
					if($mod_id == 7){
						if(isset($_POST['costPrice_'.$mod_id])){
							$costPrice 	= $_POST['costPrice_'.$mod_id];
						}else{
							$costPrice = 0;
						}
						if(isset($_POST['wholeSale_'.$mod_id])){
							$wholeSale 	= $_POST['wholeSale_'.$mod_id];
						}else{
							$wholeSale = 0;
						}
						if(isset($_POST['variation_'.$mod_id])){
							$variation 	= $_POST['variation_'.$mod_id];
						}else{
							$variation = 0;
						}
					}
					if($mod_id == 8){
						if(isset($_POST['costPrice_'.$mod_id])){
							$costPrice 	= $_POST['costPrice_'.$mod_id];
						}else{
							$costPrice = 0;
						}
						if(isset($_POST['wholeSale_'.$mod_id])){
							$wholeSale 	= $_POST['wholeSale_'.$mod_id];
						}else{
							$wholeSale = 0;
						}
						if(isset($_POST['factor_'.$mod_id])){
							$factor 	= $_POST['factor_'.$mod_id];
						}else{
							$factor = 0;
						}
					}

					$sql3 = "UPDATE tbl_role SET role_view = '$view', role_add='$add', role_edit = '$update', role_delete = '$delete', ";
					if($mod_id == 7){
						$sql3 .= "cost_price = '$costPrice', whole_sale = '$wholeSale', variation = '$variation', factor = '0'";
					}else if($mod_id == 8){
						$sql3 .= "cost_price = '$costPrice', whole_sale = '$wholeSale', variation = '0', factor = '$factor'";
					}else{
						$sql3 .= "cost_price = '0', whole_sale = '0', variation = '0', factor = '0'";
					}
					$sql3.= " WHERE role_id = '$role_id'";
					$result3 = dbQuery($dbConn, $sql3);
				}
			}
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Role Updated Successfully";
			redirect("index.php?view=list");
		}else{
			$sql2 = "SELECT * FROM tbl_role WHERE desig_id = '$DesId' ORDER BY role_id ASC";
			$result2 = dbQuery($dbConn, $sql2);
			if(dbNumRows($result2) >0){
				while($row2 = dbFetchAssoc($result2)){
					extract($row2);
					if(isset($_POST['view_'.$role_id])){
						$view 	= $_POST['view_'.$role_id];
					}else{
						$view = 0;
					}
					
					if(isset($_POST['add_'.$role_id])){
						$add 	= $_POST['add_'.$role_id];
					}else{
						$add = 0;
					}
					
					if(isset($_POST['update_'.$role_id])){
						$update 	= $_POST['update_'.$role_id];
					}else{
						$update = 0;
					}
					
					if(isset($_POST['delete_'.$role_id])){
						$delete 	= $_POST['delete_'.$role_id];
					}else{
						$delete = 0;
					}

					if($mod_id == 7){
						if(isset($_POST['costPrice_'.$mod_id])){
							$costPrice 	= $_POST['costPrice_'.$mod_id];
						}else{
							$costPrice = 0;
						}
						if(isset($_POST['wholeSale_'.$mod_id])){
							$wholeSale 	= $_POST['wholeSale_'.$mod_id];
						}else{
							$wholeSale = 0;
						}
						if(isset($_POST['variation_'.$mod_id])){
							$variation 	= $_POST['variation_'.$mod_id];
						}else{
							$variation = 0;
						}
					}
					if($mod_id == 8){
						if(isset($_POST['costPrice_'.$mod_id])){
							$costPrice 	= $_POST['costPrice_'.$mod_id];
						}else{
							$costPrice = 0;
						}
						if(isset($_POST['wholeSale_'.$mod_id])){
							$wholeSale 	= $_POST['wholeSale_'.$mod_id];
						}else{
							$wholeSale = 0;
						}
						if(isset($_POST['factor_'.$mod_id])){
							$factor 	= $_POST['factor_'.$mod_id];
						}else{
							$factor = 0;
						}
					}

					$sql3 = "UPDATE tbl_role SET role_view = '$view', role_add='$add', role_edit = '$update', role_delete = '$delete', ";
					if($mod_id == 7){
						$sql3 .= "cost_price = '$costPrice', whole_sale = '$wholeSale', variation = '$variation', factor = '0'";
					}else if($mod_id == 8){
						$sql3 .= "cost_price = '$costPrice', whole_sale = '$wholeSale', variation = '0', factor = '$factor'";
					}else{
						$sql3 .= "cost_price = '0', whole_sale = '0', variation = '0', factor = '0'";
					}
					$sql3.= " WHERE role_id = '$role_id'";
					$result3 = dbQuery($dbConn, $sql3);
				}
			}
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Category Updated Successfully.";
			redirect("index.php?view=list");
		}
	}


?>