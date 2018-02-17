<?php 
	require_once '../library/config.php';
	require_once '../library/functions.php';

	$key = $_GET['key'];
    $array = array();
    $query = "SELECT pro_title FROM tbl_product WHERE pro_title LIKE '%{$key}%'";
    $result = mysqli_query($dbConn, $query);
    while($row=mysqli_fetch_assoc($result)){
		$array[] = $row['pro_title'];
    }
    echo json_encode($array);
?>
