
	<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';
	if(isset($_REQUEST['pro']) && isset($_REQUEST['vtype']) && isset($_REQUEST['varid'])){

		$pro	= $_REQUEST['pro'];
		$vtype 	= $_REQUEST['vtype'];
		$varid 	= $_REQUEST['varid'];

		$sql = "SELECT * FROM tbl_pro_var WHERE pro_id = '$pro' AND var_type_id = '$vtype' AND var_id = '$varid'";
		$result = dbQuery($dbConn, $sql);
		if(dbNumRows($result) > 0){
			$row = dbFetchAssoc($result);
			extract($row); ?>

			<input type="hidden" value="<?php echo $pv_cost; ?>" name="txtCost<?php echo $vtype;?>" id="txtCost<?php echo $vtype;?>" />
			<input type="hidden" value="<?php echo $pv_wholesale; ?>" name="txtWholesale<?php echo $vtype;?>" id="txtWholesale<?php echo $vtype;?>" />
			<input type="hidden" value="<?php echo $pv_retail; ?>" name="txtRetail<?php echo $vtype;?>" id="txtRetail<?php echo $vtype;?>" />
			<?php
		}
		//Variation store in session
		//====================================================
		$firstpart = $pro;
		$secondprt = $vtype;
		$thirdpart = $varid;
		$first = $firstpart . '-' . $secondprt;
		if(!isset($_SESSION['items'])){
			$_SESSION['items'] = array();
		}
		//chk krna ha k new product to add ni kr raha
		if(isset($_SESSION['items'])){
			foreach($_SESSION['items'] as $key => $chk){
				$ProdId = $chk['productid'];
				if($ProdId != $firstpart){
					unset($_SESSION['items']);
					$_SESSION['items'] = array();
				}
			}
		}
		//chk krna ha k already add ha
		$add = 0;
		foreach ($_SESSION['items'] as $key => $value) {
			if($first === $value['productid']."-".$value['variationtypeid']){
				unset($_SESSION['items'][$key]);
				//agr pahly say ha to usy upaer unset kry ga phr us main aik value add kr dy ga.
				$myarr = array(
					'productid' => $firstpart,
					'variationtypeid' => $secondprt,
					'variationid' => $thirdpart
				);
				array_push($_SESSION['items'],$myarr);
				$add = 1;
			}
		}
		if($add == 0 || empty($_SESSION['items'])){
			$myarr = array(
				'productid' => $firstpart,
				'variationtypeid' => $secondprt,
				'variationid' => $thirdpart
			);
			array_push($_SESSION['items'],$myarr);
		}

//
//		echo "<pre>";
//		print_r($_SESSION['items']);
//		echo "</pre>";

		//====================================================
	}else{
		
	}
	
	?>	
	
	
	
		
		