
<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';
	checkUser();
	$action = isset($_GET['action']) ? $_GET['action'] : '';

	switch ($action) {
		
		case 'delete' :
			deletequote($dbConn);
			break;
		default :
			redirect('index.php');
	}


switch($_REQUEST){
	case $_POST:
		addtocart($_POST);
}
    // Add to session

	function addtocart($quts){
		$_SESSION['quts'] = $quts;
	}

	function deletequote($dbConn) {
		if(isset($_GET['QoId']) && ($_GET['QoId'])>0 ){
			$QoId = $_GET['QoId'];
		}else{
			redirect("index.php");
			exit();
		}
		
		$sqli = "DELETE FROM tbl_order_detail WHERE od_id = '$QoId'";
		$result2 = dbQuery($dbConn, $sqli);
		$row = dbFetchAssoc($result2);
		
		
		$sql    =	"DELETE FROM tbl_order WHERE od_id ='$QoId'";		
		$result = 	 dbQuery($dbConn, $sql);
		$_SESSION['count'] = 0;
		$_SESSION['data'] = "success";
		$_SESSION['errorMessage'] = "Order Delted Successfully";
		redirect("index.php?view=list");
		
	}
	

?>