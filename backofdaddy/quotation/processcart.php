<?php
require_once '../library/config.php';
require_once '../library/functions.php';

require_once 'cart.php';

if(isset($_SESSION['objItems'])){
    $objItems = unserialize($_SESSION['objItems']);
}
else{
    $objItems = new Cart();
}

if(isset($_SESSION['itemId'])){
    $itemId = unserialize($_SESSION['itemId']);
    $itemId++;
}else{
    $itemId = 1;
}

if(isset($_SESSION['items'])){
    $items = $_SESSION['items'];
}else{
    $items = array();
}
if(isset($_POST['action'])){

    switch ($_POST['action']) {
        case "add_to_cart":
            $catID = $_POST['catid'];
			
            if($catID == 3) {
                $cart_item = new Cart_Item($itemId,$_POST['txtqty'], 0,"",$_POST['proid'],$_POST['catid'], $_POST['txtProprice'],0, 0, array(), $_POST['total'],$_POST['txtLength'],$_POST['txtWidth'],$_POST['txtRate']);
            }else {
                $cart_item = new Cart_Item($itemId, $_POST['txtqty'],0,"",$_POST['proid'], $_POST['catid'], $_POST['txtProprice'],$_POST['tcost'], $_POST['twholesale'], $items, $_POST['total']);
            }
            $objItems->add_to_cart($cart_item);
            unsetItems();
            break;
        case "update_cart":
			
            $cart_item = new Cart_Item($_POST['itemID'],0,$_POST['unitPrice'],$_POST['title']);
			 
            $objItems->update_cart($cart_item);
            break;
    }
}
elseif (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case "remove_item":
            $cart_item = @new Cart_Item($_GET['itemID']);
            $objItems->remove_item($cart_item);
            break;
        case "empty_cart":
            unsetItems();
            $objItems->empty_cart();
            break;
    }
}

function unsetItems(){
    if(isset($_SESSION['items'])){
        unset($_SESSION['items']);
    }
}
$_SESSION['objItems'] = serialize($objItems);
$_SESSION['itemId'] = serialize($itemId);
redirect("index.php");


?>