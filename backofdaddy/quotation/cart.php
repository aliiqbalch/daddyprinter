<?php
require_once 'cart_item.php';
class Cart{
    public $itemId;
    private $items;
    
    public function __construct() {
        $this->itemId = 1;
        $this->items = array();
    }

    public function __get($name) {
        $method = "get_" . $name;
        if (!method_exists($this, $method)) {
            throw new Exception("GET: Property $name does not exist");
        }
        return $this->$method();
    }

    private function get_items(){
            return $this->items;
    }

    private function get_total(){
        $total = 0;
        foreach($this->items as $item){
            $total += $item->total;
        }

        return $total;
        
    }
        
    public function add_to_cart($cart_item){
       
		if(!$cart_item instanceof Cart_Item){
            throw new Exception("Invalid Cart Item");
        }
		
            $this->items[$cart_item->itemID] = $cart_item;
    }

    public function update_cart($cart_item){
		
        if(!$cart_item instanceof Cart_Item){
            throw new Exception("Invalid Cart Item");
        }
        if(array_key_exists($cart_item->itemID, $this->items)){
			
            $this->items[$cart_item->itemID]->total = $this->items[$cart_item->itemID]->qty * $cart_item->unitPrice;
            $this->items[$cart_item->itemID]->unitPrice = $cart_item->unitPrice;
			$this->items[$cart_item->itemID]->title = $cart_item->title;
			
        }
    }

    public function remove_item($cart_item){

        if(!$cart_item instanceof Cart_Item){
            throw new Exception("Invalid Cart Item");
        }
        
        if(array_key_exists($cart_item->itemID, $this->items)){
         
            unset($this->items[$cart_item->itemID]);
        }
        
    }
    
    public function empty_cart(){
        $this->items = array();
    }

    
}

?>