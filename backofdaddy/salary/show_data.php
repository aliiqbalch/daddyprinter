<?php
require_once '../library/config.php';
require_once '../library/functions.php';

$UserID = $_REQUEST['user_id'];
$sql	=	"SELECT CONCAT(year,'-',month,'-',day) date_c,attendance FROM attendance WHERE DATE(CURRENT_DATE()) AND user_id='".$UserID."'";
$result		= dbQuery($dbConn,$sql);
$returnData = array();


while($row = dbFetchAssoc($result)) {
	if($row['attendance']=='P'){
		$className='grade-4';
	} elseif ($row['attendance']=='A'){
		$className='grade-1';
	} elseif ($row['attendance']=='L'){
		$className='grade-3';
	} elseif($row['attendance']=='H'){
		$className='grade-2';
	}elseif($row['attendance']=='S'){
		$className='purple';
	}
	
	$returnData[]= array ( 
		'date' => $row['date_c'],
		'badge' => false,
		'classname' => $className,
	);
}
echo json_encode($returnData);

?>