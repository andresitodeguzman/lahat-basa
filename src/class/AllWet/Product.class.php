<?php
/**
 * All Wet
 * 2018
 * 
 * Class
 * Product
 */

namespace AllWet;

class Product {
  // Properties
  private $mysqli;

  public $product_id;
  public $product_code;
  public $product_name;
  public $product_description;
  public $category_id;
  public $product_price;
  public $product_available;
  public $product_image;
  
  function __construct($mysqli){
    $this->mysqli = $mysqli;
  }
  
  final public function getAll(){
    $product_array = array();
    
    $query = "SELECT * FROM `product` LIMIT 150";
    
    if($result = $this->mysqli->query($query)){
      while($prod = $result->fetch_array()){
        $product_id = $prod['product_id'];
        $product_code = $prod['product_code'];
        $product_name = $prod['product_name'];
        $product_description = $prod['product_description'];
        $product_available = $prod['product_available'];
        $category_id = $prod['category_id'];
        $product_price = $prod['product_price'];
        $product_image = $prod['product_image'];

        $prep_arr = array(
            "product_id" => $product_id,
            "product_code" => $product_code,
            "product_name" => $product_name,
            "product_description" => $product_description,
            "product_available" => $product_available,
            "category_id" => $category_id,
            "product_price" => $product_price,
            "product_image" => $product_image
        );

        array_push($product_array, $prep_arr);
      }
    }
    
    return $product_array;
  }

}
?>