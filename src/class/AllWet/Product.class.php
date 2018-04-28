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
  
  final public function get(Int $product_id){
    $this->product_id = $product_id;
    
    $stmt = $this->mysqli->prepare("SELECT * FROM `product` WHERE `product_id`=? LIMIT 1");
    $stmt->bind_param("i", $this->product_id);
    $stmt->execute();
      
    $stmt->bind_result($product_id, $product_code, $product_name, $product_description, $product_available, $category_id, $product_price, $product_image);
    
    $product_info = array();
    
    while($stmt->fetch()){
      $prep_arr = array(
        "product_id"=>$product_id,
        "product_code"=>$product_code,
        "product_name"=>$product_name,
        "product_description"=>$product_description,
        "product_available"=>$product_available,
        "category_id"=>$category_id,
        "product_price"=>$product_price,
        "product_image"=>$product_image
      );
      $product_info = $prep_arr;
    }
    
    return $product_info;
  }
  
  final public function getByProductCode(String $product_code){
    $this->product_code = $product_code;
    
    $stmt = $this->mysqli->prepare("SELECT * FROM `product` WHERE `product_code`=? LIMIT 1");
    $stmt->bind_param("s", $this->product_code);
    $stmt->execute();
      
    $stmt->bind_result($product_id, $product_code, $product_name, $product_description, $product_available, $category_id, $product_price, $product_image);
    
    $product_info = array();
    
    while($stmt->fetch()){
      $prep_arr = array(
        "product_id"=>$product_id,
        "product_code"=>$product_code,
        "product_name"=>$product_name,
        "product_description"=>$product_description,
        "product_available"=>$product_available,
        "category_id"=>$category_id,
        "product_price"=>$product_price,
        "product_image"=>$product_image
      );
      $product_info = $prep_arr;
    }
    
    return $product_info;
  }
  
  final public function getByCategoryId(Int $category_id){
    $this->category_id = $category_id;
    
    $stmt = $this->mysqli->prepare("SELECT * FROM `product` WHERE `category_id`=?");
    $stmt->bind_param("s", $this->category_id);
    $stmt->execute();
    $stmt->bind_result($product_id, $product_code, $product_name, $product_description, $product_available, $category_id, $product_price, $product_image);
    
    $product_info = array();
    
    while($stmt->fetch()){
      $prep_arr = array(
        "product_id"=>$product_id,
        "product_code"=>$product_code,
        "product_name"=>$product_name,
        "product_description"=>$product_description,
        "product_available"=>$product_available,
        "category_id"=>$category_id,
        "product_price"=>$product_price,
        "product_image"=>$product_image
      );
      array_push($product_info, $prep_arr);
    }
    
    return $product_info;
  }
  
  final private function codeExists(String $product_code){
    $this->product_code = $product_code;
    
    $stmt = $this->mysqli->prepare("SELECT product_code FROM product WHERE product_code=?");
    $stmt->bind_param("s",$this->product_code);
    $stmt->execute();
    
    $stmt->bind_result($p_code);
    $stmt->fetch();
    
    if($p_code == $this->product_code){
      return True;
    } else {
      return False;
    }
  }
  
  final public function add(Array $p_array){
    $this->product_code = $p_array['product_code'];
    $this->product_name = $p_array['product_name'];
    if($p_array['product_description']) $this->product_description = $p_array['product_description'];
    $this->product_available = $p_array['product_available'];
    $this->category_id = $p_array['category_id'];
    $this->product_price = $p_array['product_price'];
    $this->product_image = $p_array['product_image'];
    
    if($this->codeExists($this->product_code)){
      return "Product code already in use";
    } else {
      $stmt = $this->mysqli->prepare("INSERT INTO product(product_code, product_name, product_description, product_available, category_id, product_price, product_image) VALUES (?,?,?,?,?,?,?)");
      $stmt->bind_param("sssssss",$this->product_code, $this->product_name, $this->product_description, $this->product_available,$this->category_id, $this->product_price, $this->product_image);
      
      if($stmt->execute()){
        return True;
      } else {
        return False;
      }
    }
    
  }
  
  final public function delete(Int $product_id){
    $this->product_id = $product_id;
    
    $stmt = $this->mysqli->prepare("DELETE FROM product WHERE product_id=?");
    $stmt->bind_param("i", $this->product_id);
    
    if($stmt->execute()){
      return True;
    } else {
      return False;
    }
  }
  
  final public function update(Array $p_array){
    $product_id = $p_array['product_id'];
    $product_name = $p_array['product_name'];
    $product_code = $p_array['product_code'];
    if($p_array['product_description']) $this->product_description = $p_array['product_description'];
    $this->product_available = $p_array['product_available'];
    $this->category_id = $p_array['category_id'];
    $this->product_price = $p_array['product_price'];
    $this->product_image = $p_array['product_image'];
    
    $product_info = $this->get($this->product_id);
    
    if($product_info['product_code'] == $this->product_code){
      $stmt = $this->mysqli->prepare("UPDATE `product` SET `product_name`=?, `product_description`=?, `product_available`=?, `category_id`=?, `product_price`=?, `product_image`=? WHERE `product_id`=?");
      $stmt->bind_param("sssissi", $this->product_name, $this->product_description, $this->product_available, $this->category_id, $this->product_price, $this->product_image, $this->product_id);
      if($stmt->execute()){
        return True;
      } else {
        return False;
      }
    } else {
      if($this->codeExists($this->product_code) === True){
        return "Product code already in use";
      } else {
        $stmt = $this->mysqli->prepare("UPDATE `product` SET `product_name`=?, `product_code`=?, `product_description`=?, `product_available`=?, `category_id`=?, `product_price`=?, `product_image`=? WHERE `product_id`=?");
        $stmt->bind_param("ssssissi", $this->product_name, $this->product_code, $this->product_description, $this->product_available, $this->category_id, $this->product_price, $this->product_image, $this->product_id);
        if($stmt->execute()){
          return True;
        } else {
          return False;
        }
      }
    }
  }

  final public function updateCategoryId(Array $p_array){
    $this->product_id = $p_array['product_id'];
    $this->category_id = $p_array['category_id'];

    $stmt = $this->mysqli->prepare("UPDATE `product` SET category_id=? WHERE product_id=?");
    $stmt->bind_param("ii", $this->category_id, $this->product_id);

    if($stmt->execute()){
      return True;
    } else {
      return False;
    }
  }

}
?>