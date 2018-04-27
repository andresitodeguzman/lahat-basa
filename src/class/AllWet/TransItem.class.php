<?php
/**
 * All Wet
 * 2018
 * 
 * Class
 * TransItem
 */

namespace AllWet;

class TransItem {
  
  private $mysqli;

  public $transitem_id;
  public $transaction_id;
  public $product_id;
  public $transitem_quantity;
  
  function __construct($mysqli){
    $this->mysqli = $mysqli;
  }
  
  final public function getAll(){
    $transitem_array = array();
    
    $query = "SELECT * FROM `transitem`";
    
    if($result = $this->mysqli->query($query)){
      while($trans = $result->fetch_array()){
        $transitem_id = $trans['transitem_id'];
        $transaction_id = $trans['transaction_id'];
        $product_id = $trans['product_id'];
        $transitem_quantity = $trans['transitem_quantity'];
        
        $prep_arr = array(
          "transitem_id"=>$transitem_id,
          "transaction_id"=>$transaction_id,
          "product_id"=>$product_id,
          "transitem_quantity"=>$transitem_quantity
        );
        
        array_push($transitem_array, $prep_arr);
      }
    }
    
    return $transitem_array;
  }
  
  final public function get(Int $transitem_id){
    $this->transitem_id = $transitem_id;
    
    $stmt = $this->mysqli->prepare("SELECT * FROM `transitem` WHERE `transitem_id`=? LIMIT 1");
    $stmt->bind_param("i", $this->transitem_id);
    $stmt->execute();
    
    $stmt->bind_result($transitem_id, $transaction_id, $product_id, $transitem_quantity);
    
    $transitem_info = array();
    
    while($stmt->fetch()){
      $transitem_info = array(
        "transitem_id"=>$transitem_id,
        "transaction_id"=>$transaction_id,
        "product_id"=>$product_id,
        "transitem_quantity"=>$transitem_quantity
      );
    }
    
    return $transitem_info;
  }
  
  final public function getByTransactionId(Int $transaction_id){
    $this->transaction_id = $transaction_id;
    
    $stmt = $this->mysqli->prepare("SELECT * FROM `transitem` WHERE `transaction_id`=?");
    $stmt->bind_param("i", $this->transaction_id);
    $stmt->execute();
    
    $stmt->bind_result($transitem_id, $transaction_id, $product_id, $transitem_quantity);
    
    $transitem_info = array();
    
    while($stmt->fetch()){
      $prep_arr = array(
        "transitem_id"=>$transitem_id,
        "transaction_id"=>$transaction_id,
        "product_id"=>$product_id,
        "transitem_quantity"=>$transitem_quantity
      );
      array_push($transitem_info, $prep_arr);
    }
    
    return $transitem_info;
  }
  
  final public function getByProductId(Int $product_id){
    $this->product_id = $product_id;
    
    $stmt = $this->mysqli->prepare("SELECT * FROM `transitem` WHERE `product_id`=?");
    $stmt->bind_param("i", $this->product_id);
    $stmt->execute();
    
    $stmt->bind_result($transitem_id, $transaction_id, $product_id, $transitem_quantity);
    
    $transitem_info = array();
    
    while($stmt->fetch()){
      $prep_arr = array(
        "transitem_id"=>$transitem_id,
        "transaction_id"=>$transaction_id,
        "product_id"=>$product_id,
        "transitem_quantity"=>$transitem_quantity
      );
      array_push($transitem_info, $prep_arr);
    }
    
    return $transitem_info;
  }
  
  final public function delete(Int $transitem_id){
    $this->transitem_id = $transitem_id;
    
    $stmt = $this->mysqli->prepare("DELETE FROM `transitem` WHERE `transitem_id`=?");
    $stmt->bind_param("i",$this->transitem_id);
    
    if($stmt->execute()){
      return True;
    } else {
      return False;
    }
  }
  
  final public function deleteByTransactionId(Int $transaction_id){
    $this->transaction_id = $transaction_id;
    
    $stmt = $this->mysqli->prepare("DELETE FROM `transitem` WHERE `transaction_id`=?");
    $stmt->bind_param("i",$this->transaction_id);
    
    if($stmt->execute()){
      return True;
    } else {
      return False;
    }
  }
  
  final public function deleteByProductId(Int $product_id){
    $this->product_id = $product_id;
    
    $stmt = $this->mysqli->prepare("DELETE FROM `transitem` WHERE `product_id`=?");
    $stmt->bind_param("i",$this->product_id);
    
    if($stmt->execute()){
      return True;
    } else {
      return False;
    }
  }
  
  final public function add(Array $t_array){
    $this->transaction_id = $t_array['transaction_id'];
    $this->product_id = $t_array['product_id'];
    $this->transitem_quantity = $t_array['transitem_quantity'];
    
    $stmt = $this->mysqli->prepare("INSERT INTO `transitem`(`transaction_id`,`product_id`,`transitem_quantity`) VALUES(?,?,?)");
    $stmt->bind_param("iii", $this->transaction_id, $this->product_id, $this->transitem_quantity);
    
    if($stmt->execute()){
      return True;
    } else {
      return False;
    }
  }
  
  final public function update(Array $t_array){
    $this->transitem_id = $t_array['transitem_id'];
    $this->transaction_id = $t_array['transaction_id'];
    $this->product_id = $t_array['product_id'];
    $this->transitem_quantity = $t_array['transitem_quantity'];
    
    $stmt = $this->mysqli->prepare("UPDATE `transitem` SET `transaction_id`=?, `product_id`=?, `transitem_quantity`=? WHERE `transitem_id`=?");
    $stmt->bind_param("iiii", $this->transaction_id, $this->product_id, $this->transitem_quantity, $this->transitem_id);
    
    if($stmt->execute()){
      return True;
    } else {
      return False;
    }
  }
  
  final public function updateQuantity(Array $t_array){
    $this->transitem_id = $t_array['transitem_id'];
    $this->transitem_quantity = $t_array['transitem_quantity'];
    
    $stmt = $this->mysqli->prepare("UPDATE `transitem` SET `transitem_quantity` WHERE `transitem_id`=?");
    $stmt->bind_param("ii",$this->transitem_quantity,$this->transitem_id);
    
    if($stmt->execute()){
      return True;
    } else {
      return False;
    }
  }
  
  
}
?>