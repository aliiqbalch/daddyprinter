<?php
	include('php/config.php');
	include('php/database.php');
	include('php/functions.php');
	
	if(isset($_POST['name'])){
		$data = $_POST['name'];
		//print_r($data);
		$search = explode('-', $data);
		$firstpart = $search[0];
		$secondprt = $search[1];
		$thirdpart = $search[2];
		$first = $firstpart . '-' . $secondprt; 
		//AGR ITEMS BLANK HA TO ARRAY GENERATE KRY GA OR AIK ARRAY BNAEN GA
		if(!isset($_SESSION['items'])){
			$_SESSION['items'] = array();
		}
		//chk krna ha k new product to add ni kr raha
		if(isset($_SESSION['items'])){
			foreach($_SESSION['items'] as $key => $chk){
				$CateId = $chk['productId'];
				if($CateId != $firstpart){
					unset($_SESSION['items']);
					$_SESSION['items'] = array();
				}
			}
		}
		//chk krna ha k already add ha
		$add = 0;
		foreach ($_SESSION['items'] as $key => $value) {
			if($first === $value['productId']."-".$value['variationtypeid']){
				unset($_SESSION['items'][$key]);
				//agr pahly say ha to usy upaer unset kry ga phr us main aik value add kr dy ga.
				$myarr = array(
					'productId' => $firstpart,
					'variationtypeid' => $secondprt,
					'variation' => $thirdpart
				);
				array_push($_SESSION['items'],$myarr);
				$add = 1;
			}
		}
		
		if($add == 0 || empty($_SESSION['items'])){
			$myarr = array(
				'productId' => $firstpart,
				'variationtypeid' => $secondprt,
				'variation' => $thirdpart
			);
			array_push($_SESSION['items'],$myarr);
		}
		
		/*echo "<pre>";
		print_r($_SESSION['items']);
		echo "</pre>";*/
		//unset($_SESSION['items']);
		//SHOW ALL FIELDS ON CART
		if(isset($_SESSION['items'])){
			foreach($_SESSION['items'] as $key => $row){
				$productId = $row['productId'];
				$variationtypeid = $row['variationtypeid'];
				$variation = $row['variation'];
				$sql4 = "SELECT * FROM tbl_variation WHERE var_id = '$variation'";
				$result4 = dbQuery($dbConn, $sql4);
				if(dbNumRows($result4) >0){
					$row4 = dbFetchAssoc($result4);
					//echo $row2 -> title .'.........'. $row2 ->var_title .'.........'. $row2->image .'..........' .$row2->retail_price .'<br>';
					?>
					<div class="itembox quotebox" >		
						<img src="upload/variation/<?php variationImage($dbConn, $row4['var_id']); ?>" alt="" class="img-responsive" />
						<p><?php variationtitle($dbConn, $row4['var_id']); ?></p>
					</div>
					<hr style="margin-bottom: 20px;"><?php
				}
			}
		}
		
	}

?>