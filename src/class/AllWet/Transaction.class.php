<?php
/**
 * All Wet
 * 2018
 * 
 * Class
 * Transaction
 */

namespace AllWet;

class Transaction{
  
  // Properties
  private $mysqli;

  public $transaction_id = 0;
  public $transaction_date;
  public $transaction_time;
  public $customer_id;
  public $transaction_count = 0;
  public $transaction_price = 0;
  public $transaction_payment_method;
  public $transaction_status;
  public $transaction_longitude = "";
  public $transaction_latitude = "";
  public $transaction_address = "";

  function __construct($mysqli){
    $this->mysqli = $mysqli;    
  }
  
  final public function getAll(){
    $transaction_array = array();
    
    $query = "SELECT * FROM `transaction` WHERE `transaction_status` <> 'DELIVERED'";
    
    if($result = $this->mysqli->query($query)){
      while($trans = $result->fetch_array()){
        $transaction_id = $trans['transaction_id'];
        $transaction_date = $trans['transaction_date'];
        $transaction_time = $trans['transaction_time'];
        $customer_id = $trans['customer_id'];
        $transaction_count = $trans['transaction_count'];
        $transaction_price = $trans['transaction_price'];
        $transaction_payment_method = $trans['transaction_payment_method'];
        $transaction_status = $trans['transaction_status'];
        $transaction_longitude = $trans['transaction_longitude'];
        $transaction_latitude = $trans['transaction_latitude'];
        $transaction_address = $trans['transaction_address'];
        
        $prep_arr = array(
          "transaction_id"=>$transaction_id,
          "transaction_date"=>$transaction_date,
          "transaction_time"=>$transaction_time,
          "customer_id"=>$customer_id,
          "transaction_count"=>$transaction_count,
          "transaction_price"=>$transaction_price,
          "transaction_payment_method"=>$transaction_payment_method,
          "transaction_status"=>$transaction_status,
          "transaction_longitude"=>$transaction_longitude,
          "transaction_latitude"=>$transaction_latitude,
          "transaction_address"=>$transaction_address
        );
        
        array_push($transaction_array, $prep_arr);
      }
    }
    
    return $transaction_array;
  }
  
  final public function get(Int $transaction_id){
    $this->transaction_id = $transaction_id;
    
    $stmt = $this->mysqli->prepare("SELECT `transaction_id`, `transaction_date`, `transaction_time`, `customer_id`, `transaction_count`, `transaction_price`, `transaction_payment_method`, `transaction_status`, `transaction_longitude`, `transaction_latitude`, `transaction_address` FROM `transaction` WHERE `transaction_id`=? LIMIT 1");
    $stmt->bind_param("i",$this->transaction_id);
    $stmt->execute();
    $stmt->bind_result($transaction_id, $transaction_date, $transaction_time, $customer_id, $transaction_count, $transaction_price, $transaction_payment_method, $transaction_status, $transaction_longitude, $transaction_latitude, $transaction_address);

    $transaction_info = array();

    while($stmt->fetch()){
      $transaction_info = array(
        "transaction_id"=>$transaction_id,
        "transaction_date"=>$transaction_date,
        "transaction_time"=>$transaction_time,
        "customer_id"=>$customer_id,
        "transaction_count"=>$transaction_count,
        "transaction_price"=>$transaction_price,
        "transaction_payment_method"=>$transaction_payment_method,
        "transaction_status"=>$transaction_status,
        "transaction_longitude"=>$transaction_longitude,
        "transaction_latitude"=>$transaction_latitude,
        "transaction_address"=>$transaction_address
      );
    }
    
    return $transaction_info;
  }
  
  final public function getByCustomerId(Int $customer_id){
    $this->customer_id = $customer_id;
    
    $stmt = $this->mysqli->prepare("SELECT `transaction_id`, `transaction_date`, `transaction_time`, `customer_id`, `transaction_count`, `transaction_price`, `transaction_payment_method`, `transaction_status`, `transaction_longitude`, `transaction_latitude`, `transaction_address` FROM `transaction` WHERE `customer_id`=?");
    $stmt->bind_param("i",$this->customer_id);
    $stmt->execute();
    $stmt->bind_result($transaction_id, $transaction_date, $transaction_time, $customer_id, $transaction_count, $transaction_price, $transaction_payment_method, $transaction_status, $transaction_longitude, $transaction_latitude, $transaction_address);
    
    $transaction_array = array();
    
    while($stmt->fetch()){
     $prep_arr = array(
      "transaction_id"=>$transaction_id,
      "transaction_date"=>$transaction_date,
      "transaction_time"=>$transaction_time,
      "customer_id"=>$customer_id,
      "transaction_count"=>$transaction_count,
      "transaction_price"=>$transaction_price,
      "transaction_payment_method"=>$transaction_payment_method,
      "transaction_status"=>$transaction_status,
      "transaction_longitude"=>$transaction_longitude,
      "transaction_latitude"=>$transaction_latitude,
      "transaction_address"=>$transaction_address
     );
     
      array_push($transaction_array, $prep_arr);
    }
    
    return $transaction_array;
  }
  
  final public function delete(Int $transaction_id){
    $this->transaction_id = $transaction_id;
    
    $stmt = $this->mysqli->prepare("DELETE FROM `transaction` WHERE `transaction_id`=?");
    $stmt->bind_param("i", $this->transaction_id);
    
    if($stmt->execute()){
      return True;
    } else {
      return False;
    }
  }

  final public function add(Array $t_array){
    date_default_timezone_set("Asia/Manila");
    $this->transaction_date = (String) date("M-d-Y");
    $this->transaction_time = (String) date("h:i:s A");
    $this->customer_id = $t_array['customer_id'];
    $this->transaction_count = $t_array['transaction_count'];
    $this->transaction_price = $t_array['transaction_price'];
    $this->transaction_payment_method = $t_array['transaction_payment_method'];
    $this->transaction_status = $t_array['transaction_status'];
    $this->transaction_longitude = "";
    $this->transaction_latitude = "";
    if(isset($t_array['transaction_longitude'])) $this->transaction_longitude = $t_array['transaction_longitude'];
    if(isset($t_array['transaction_latitude'])) $this->transaction_latitude = $t_array['transaction_latitude'];
    $this->transaction_address = $t_array['transaction_address'];
    
    $stmt = $this->mysqli->prepare("INSERT INTO `transaction`(`transaction_date`,`transaction_time`,`customer_id`,`transaction_count`,`transaction_price`,`transaction_payment_method`,`transaction_status`,`transaction_longitude`,`transaction_latitude`,`transaction_address`) VALUES(?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssssss", $this->transaction_date, $this->transaction_time, $this->customer_id, $this->transaction_count, $this->transaction_price, $this->transaction_payment_method, $this->transaction_status, $this->transaction_longitude, $this->transaction_latitude, $this->transaction_address);
    
    if($stmt->execute()){
      return $this->mysqli->insert_id;
    } else {
      return False;
    }
  }
  
  final public function update(Array $t_array){
    $this->transaction_id = $t_array['transaction_id'];
    $this->customer_id = $t_array['customer_id'];
    $this->transaction_count = $t_array['transaction_count'];
    $this->transaction_price = $t_array['transaction_price'];
    $this->transaction_payment_method = $t_array['transaction_payment_method'];
    $this->transaction_status = $t_array['transaction_status'];
    $this->transaction_longitude = "";
    $this->transaction_latitude = "";
    if(isset($t_array['transaction_longitude'])) $this->transaction_longitude = $t_array['transaction_longitude'];
    if(isset($t_array['transaction_latitude'])) $this->transaction_latitude = $t_array['transaction_latitude'];
    $this->transaction_address = $t_array['transaction_address'];
    
    $stmt = $this->mysqli->prepare("UPDATE `transaction` SET `customer_id`=?, `transaction_count`=?, `transaction_price`=?, `transaction_payment_method`=?, `transaction_status`=?, `transaction_longitude`=?, `transaction_latitude`=?, `transaction_address`=? WHERE `transaction_id`=?");
    $stmt->bind_param("sssssssss", $this->customer_id, $this->transaction_count, $this->transaction_price, $this->transaction_payment_method, $this->transaction_status, $this->transaction_longitude, $this->transaction_latitude, $this->transaction_address, $this->transaction_id);
    
    if($stmt->execute()){
      return True;
    } else {
      return False;
    }
  }
  
  final public function updateStatus(Array $t_array){
    $this->transaction_id = $t_array['transaction_id'];
    $this->transaction_status = $t_array['transaction_status'];
    
    $stmt = $this->mysqli->prepare("UPDATE `transaction` SET `transaction_status`=? WHERE `transaction_id`=?");
    $stmt->bind_param("si", $this->transaction_status, $this->transaction_id);
    
    if($stmt->execute()){
      return True;
    } else {
      return False;
    }
  }
  
  final public function updateCount(Array $t_array){
    $this->transaction_id = $t_array['transaction_id'];
    $this->transaction_count = $t_array['transaction_count'];
    
    $stmt = $this->mysqli->prepare("UPDATE `transaction` SET `transaction_count`=? WHERE `transaction_id`=?");
    $stmt->bind_param("si", $this->transaction_count, $this->transaction_id);
    
    if($stmt->execute()){
      return True;
    } else {
      return False;
    }
  }
  
  final public function updatePrice(Array $t_array){
    $this->transaction_id = $t_array['transaction_id'];
    $this->transaction_price = $t_array['transaction_price'];
    
    $stmt = $this->mysqli->prepare("UPDATE `transaction` SET `transaction_price`=? WHERE `transaction_id`=?");
    $stmt->bind_param("si", $this->transaction_price, $this->transaction_id);
    
    if($stmt->execute()){
      return True;
    } else {
      return False;
    }
  }
  
  final public function updatePaymentMethod(Array $t_array){
    $this->transaction_id = $t_array['transaction_id'];
    $this->transaction_payment_method = $t_array['transaction_payment_method'];
    
    $stmt = $this->mysqli->prepare("UPDATE `transaction` SET `transaction_payment_method`=? WHERE `transaction_id`=?");
    $stmt->bind_param("si", $this->transaction_payment_method, $this->transaction_id);
    
    if($stmt->execute()){
      return True;
    } else {
      return False;
    }
  }
  
}
?>