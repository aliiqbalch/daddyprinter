<?php

class Cart_Item{
    
    private $itemID;
    private $productID;
    private $catID;
    private $qty;
    private $unitPrice;
    private $basePrice;
    private $costPrice;
    private $wholesalePrice;
    private $length;
    private $width;
    private $rate;
    private $itemsValue;
    private $total;

    public function __construct($itemID,$qty=0,$unitPrice=0,$productID=0,$catID=0,$basePrice=0,$costPrice=0,$wholesalePrice=0,$itemsValue = array(), $total=0,$length=0,$width =0,$rate=0) {
        $this->itemsValue = array();
        $this->set_itemID($itemID);
        $this->set_productID($productID);
        $this->set_catID($catID);
        $this->set_qty($qty);
        $this->set_basePrice($basePrice);
        $this->set_costPrice($costPrice);
        $this->set_wholesalePrice($wholesalePrice);
        $this->set_length($length);
        $this->set_width($width);
        $this->set_rate($rate);
        $this->set_itemsValue($itemsValue);
        $this->set_total($total);
        $this->set_unitPrice($unitPrice);
    }
    
    public function __set($name, $value) {
     
        $allowed_fields = array("itemID","productID","catID","qty","basePrice","wholesalePrice","itemsValue","length","width","rate","total","unitPrice");
        
        if(!in_array($name, $allowed_fields)){
            throw new Exception("Public set access of $name not allowed");
        }
        
        $method = "set_" . $name;

        if (!method_exists($this, $method)) {
            throw new Exception("SET: Property $name does not exist");
        }

        $this->$method($value);
    }

    public function __get($name) {
        $method = "get_" . $name;
        if (!method_exists($this, $method)) {
            throw new Exception("GET: Property $name does not exist");
        }
        return $this->$method();
    }

    private function set_itemID($itemID){
    
        if($itemID <= 0 || !is_numeric($itemID)){
            throw new Exception("Invalid/Missing Item ID");
        }
        $this->itemID = $itemID;
    }
    
    private function get_itemID(){
        return $this->itemID;
    }

    private function set_productID($productID){
        $this->productID = $productID;
    }

    private function get_productID(){
        return $this->productID;
    }

    private function set_catID($catID){
        $this->catID = $catID;
    }

    private function get_catID(){
        return $this->catID;
    }

    private function set_qty($qty){
        $this->qty = $qty;
    }

    private function get_qty(){
        return $this->qty;
    }

    private function set_length($length){
        $this->length = $length;
    }

    private function get_length(){
        return $this->length;
    }

    private function set_width($width){
        $this->width = $width;
    }

    private function get_width(){
        return $this->width;
    }

    private function set_rate($rate){
        $this->rate = $rate;
    }

    private function get_rate(){
        return $this->rate;
    }

    private function set_basePrice($basePrice){
        $this->basePrice = $basePrice;
    }

    private function get_basePrice(){
        return $this->basePrice;
    }

    private function set_costPrice($costPrice){
        $this->costPrice = $costPrice;
    }

    private function get_costPrice(){
        return $this->costPrice;
    }

    private function set_wholesalePrice($wholesalePrice){
        $this->wholesalePrice = $wholesalePrice;
    }

    private function get_wholesalePrice(){
        return $this->wholesalePrice;
    }

    private function set_itemsValue($itemsValue){
        $this->itemsValue = $itemsValue;
    }
    
    private function get_itemsValue(){
        return $this->itemsValue;
    }

    private function set_total($total){
        $this->total = $total;
    }

    private function get_total(){
        return $this->total;
    }

    private function set_unitPrice($unitPrice){
        if($unitPrice == 0){
            $this->unitPrice = $this->total / $this->qty;
        }else{
        $this->unitPrice = $unitPrice;
        }
    }

    private function get_unitPrice(){
        return $this->unitPrice;
    }
}
?>