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
  
  
}
?>