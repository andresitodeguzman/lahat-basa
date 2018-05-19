<?php
/**
 * All Wet
 * 2018
 * 
 * Class
 * Customer
 */

namespace AllWet;

class Customer {
 
  // Properties
  private $mysqli;

  public $customer_id;
  public $customer_number;
  public $customer_name;
  public $customer_longitude;
  public $customer_latitude;
  public $customer_address;
  public $customer_image;
  public $customer_access_token;
  
  function __construct($mysqli){
    $this->mysqli = $mysqli;
  }
  
  final public function getAll(){
    $customer_array = array();
    
    $query = "SELECT `customer_id`, `customer_number`, `customer_name`, `customer_longitude`, `customer_latitude`, `customer_address`, `customer_image` FROM `customer` LIMIT 100";
    
    if($result = $this->mysqli->query($query)){
      while($cust = $result->fetch_array()){
        $customer_id = $cust['customer_id'];
        $customer_number = $cust['customer_number'];
        $customer_name = $cust['customer_name'];
        $customer_longitude = $cust['customer_longitude'];
        $customer_latitude = $cust['customer_latitude'];
        $customer_address = $cust['customer_address'];
        $customer_image = $cust['customer_image'];
        
        $prep_arr = array(
          "customer_id"=>$customer_id,
          "customer_number"=>$customer_number,
          "customer_name"=>$customer_name,
          "customer_longitude"=>$customer_longitude,
          "customer_latitude"=>$customer_latitude,
          "customer_address"=>$customer_address,
          "customer_image"=>$customer_image
        );
        
        array_push($customer_array, $prep_arr);
      }      
    }
    
    return $customer_array;
  }
  
  final public function get(Int $customer_id){
    $this->customer_id = $customer_id;
    
    $stmt = $this->mysqli->prepare("SELECT `customer_id`, `customer_number`, `customer_name`, `customer_longitude`, `customer_latitude`, `customer_address`, `customer_image`,`customer_access_token` FROM `customer` WHERE `customer_id`=? LIMIT 1");
    $stmt->bind_param("i", $this->customer_id);
    $stmt->execute();
    
    $stmt->bind_result($customer_id, $customer_number, $customer_name, $customer_longitude, $customer_latitude, $customer_address, $customer_image,$customer_access_token);
    
    $customer_info = array();
    
    while($stmt->fetch()){
      $customer_info = array(
        "customer_id"=>$customer_id,
        "customer_number"=>$customer_number,
        "customer_name"=>$customer_name,
        "customer_longitude"=>$customer_longitude,
        "customer_latitude"=>$customer_latitude,
        "customer_address"=>$customer_address,
        "customer_image"=>$customer_image,
        "customer_access_token"=>$customer_access_token
      );
    }
    
    return $customer_info;
    
  }
  
  final public function getByCustomerNumber(String $customer_number){
    $this->customer_number = $customer_number;
    
    $stmt = $this->mysqli->prepare("SELECT `customer_id`, `customer_number`, `customer_name`, `customer_longitude`, `customer_latitude`, `customer_address`, `customer_image`, `customer_access_token` FROM `customer` WHERE `customer_number`=? LIMIT 1");
    $stmt->bind_param("s", $this->customer_number);
    $stmt->execute();
    
    $stmt->bind_result($customer_id, $customer_number, $customer_name, $customer_longitude, $customer_latitude, $customer_address, $customer_image,$customer_access_token);
    
    $customer_info = array();
    
    while($stmt->fetch()){
      $customer_info = array(
        "customer_id"=>$customer_id,
        "customer_number"=>$customer_number,
        "customer_name"=>$customer_name,
        "customer_longitude"=>$customer_longitude,
        "customer_latitude"=>$customer_latitude,
        "customer_address"=>$customer_address,
        "customer_image"=>$customer_image,
        "customer_access_token"=>$customer_access_token
      );
    }
    
    return $customer_info;
  }
  
  final public function getByAccessToken(String $customer_access_token){
    $this->customer_access_token = $customer_access_token;
    
    $stmt = $this->mysqli->prepare("SELECT `customer_id`, `customer_number`, `customer_name`, `customer_longitude`, `customer_latitude`, `customer_address`, `customer_image` FROM `customer` WHERE `customer_access_token`=? LIMIT 1");
    $stmt->bind_param("s", $this->customer_access_token);
    $stmt->execute();
    
    $stmt->bind_result($customer_id, $customer_number, $customer_name, $customer_longitude, $customer_latitude, $customer_address, $customer_image);
    
    $customer_info = array();
    
    while($stmt->fetch()){
      $customer_info = array(
        "customer_id"=>$customer_id,
        "customer_number"=>$customer_number,
        "customer_name"=>$customer_name,
        "customer_longitude"=>$customer_longitude,
        "customer_latitude"=>$customer_latitude,
        "customer_address"=>$customer_address,
        "customer_image"=>$customer_image
      );
    }
    
    return $customer_info;
  }
  
  final public function getNumberByAccessToken(String $customer_access_token){
    $this->customer_access_token = $customer_access_token;
    
    $stmt = $this->mysqli->prepare("SELECT `customer_number` FROM `customer` WHERE `customer_access_token`=? LIMIT 1");
    $stmt->bind_param("s", $this->customer_access_token);
    $stmt->execute();
    
    $stmt->bind_result($customer_number);

    $cust_num = "";
    
    while($stmt->fetch()){
      $cust_num = $customer_number;
    }
    
    return $cust_num;
  }
  
  final public function delete(Int $customer_id){
    $this->customer_id = $customer_id;
    
    $stmt = $this->mysqli->prepare("DELETE FROM `customer` WHERE `customer_id`=?");
    $stmt->bind_param("i", $this->customer_id);
    
    if($stmt->execute()){
      return True;
    } else {
      return False;
    }
  }
  
  final public function numberExists(String $customer_number){
    $this->customer_number = $customer_number;
    
    $stmt = $this->mysqli->prepare("SELECT `customer_number` FROM `customer` WHERE `customer_number`=? LIMIT 1");
    $stmt->bind_param("s", $this->customer_number);
    $stmt->execute();
    $stmt->bind_result($customer_number);
    $stmt->fetch();
    
    if($customer_number === $this->customer_number){
      return True;
    } else {
      return False;
    }
  }
  
  final public function add(Array $c_array){
    $this->customer_number = $c_array['customer_number'];
    $this->customer_name = $c_array['customer_name'];
    $this->customer_longitude = $c_array['customer_longitude'];
    $this->customer_latitude = $c_array['customer_latitude'];
    $this->customer_address = $c_array['customer_address'];
    $this->customer_image = $c_array['customer_image'];
    $this->customer_access_token = $c_array['customer_access_token'];

    $stmt = $this->mysqli->prepare("INSERT INTO `customer` (`customer_number`, `customer_name`, `customer_longitude`, `customer_latitude`, `customer_address`, `customer_image`, `customer_access_token`) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssss", $this->customer_number, $this->customer_name, $this->customer_longitude, $this->customer_latitude, $this->customer_address, $this->customer_image, $this->customer_access_token);
    
    if($stmt->execute()){
      return True;
    } else {
      return False;
    }
  }
  
  final public function updateAccessToken(Int $customer_id, String $customer_access_token){
    $this->customer_id = $customer_id;
    $this->customer_access_token = $customer_access_token;

    $stmt = $this->mysqli->prepare("UPDATE `customer` SET `customer_access_token` = ? WHERE `customer_id` = ?");
    $stmt->bind_param("ss", $this->customer_access_token, $this->customer_id);
    
    if($stmt->execute()){
      return True;
    } else {
      return False;
    }
  }

  final public function updateBasic(Array $c_array){
    $this->customer_id = $c_array['customer_id'];
    $this->customer_name = $c_array['customer_name'];
    $this->customer_address = $c_array['customer_address'];

    $stmt = $this->mysqli->prepare("UPDATE `customer` SET `customer_name`=?, `customer_address`=? WHERE `customer_id`=?");
    $stmt->bind_param("ssi", $this->customer_name, $this->customer_address, $this->customer_id);

    if($stmt->execute()){
      return True;
    } else {
      return False;
    }
  }

}
?>