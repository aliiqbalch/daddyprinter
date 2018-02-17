<?php
	include('php/config.php');
	include('php/database.php');
	include('php/functions.php');
	
	if(isset($_POST['txtquote']) && !empty($_POST['txtquote'])){
		$txtquote = $_POST['txtquote'];
		$quoteqty = $txtquote;	
		//quantity must b greater ho 500 say other wise ya formula chaly ga.
		if($quoteqty < 500){
			$quoteqty = $quoteqty + 500;
		}
		//this is for product id 
		if(isset($_SESSION['items'])){	
			foreach($_SESSION['items'] as $key => $row){
				$productId = $row['productId'];
				$variationtypeid = $row['variationtypeid'];
				$variation = $row['variation'];
				$prosingleid = $productId;
			}
		}
		//product id pass ki or product ki price show krwai with different quantity k sath;
		$proprice = get_pro_price($dbConn, $prosingleid);
		//product price on the basis of product
		$productprice = $quoteqty * $proprice;
		// this is for actual formula in our the daddy printers
		if(isset($_SESSION['items'])){
			foreach($_SESSION['items'] as $key => $row){
				$productId			= $row['productId'];
				$variationtypeid	= $row['variationtypeid'];
				$variation			= $row['variation'];
				// select sheet id for variation 1 / 0
				$sheetid = get_sheet($dbConn, $variationtypeid);
				//pass variation id and get the price of variation
				$varpricecost =  get_var_retail_price($dbConn, $productId, $variation);
				// chek condition for sheet is 1 or 0
			   if($sheetid == 0){
					$productprice = $productprice + ($varpricecost * $quoteqty);
				}else if($sheetid == 1){
					$noofthousandsqty = ceil($quoteqty / 1000);
					//product k table ssay sheets ly k no or sheet
					$sheetqty = get_pro_print_sheet($dbConn, $productId);
					$sheetcount = $noofthousandsqty * $sheetqty;
					if($sheetcount <= 1000){
						$productprice = $productprice + $varpricecost;
					}else{	
						$noofthousandsimp = ceil($sheetcount/1000);
						$productprice = $productprice + ($varpricecost * $noofthousandsimp);
					}
				}
			}
			//unset($_SESSION['items']);
		}
		echo $productprice;
	}

?>