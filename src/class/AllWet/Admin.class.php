<?php
/**
 * All Wet
 * 2018
 * 
 * Class
 * Admin
 */

namespace AllWet;

class Admin {
  
  // Properties
  public $mysqli; 

  public $admin_id;
  public $admin_name;
  public $admin_username;
  public $admin_password;
  public $admin_image;
  
  function __construct($mysqli){
    $this->mysqli = $mysqli;
  }
  
  final function getAll(){
    $admin_array = array();
    
    $query = "SELECT `admin_id`, `admin_name`, `admin_username`, `admin_image` FROM `admin` LIMIT 50";
    
    if($result = $this->mysqli->query($query)){
      while($adm = $result->fetch_array()){
        $admin_id = $adm['admin_id'];
        $admin_name = $adm['admin_name'];
        $admin_username = $adm['admin_username'];
        $admin_image = $adm['admin_image'];
        
        $prep_arr = array(
          "admin_id"=>$admin_id,
          "admin_name"=>$admin_name,
          "admin_username"=>$admin_username,
          "admin_image"=>$admin_image
        );
        
        array_push($admin_array, $prep_arr);
        
      }
    }
    
    return $admin_array;
  }
  
  final public function get(Int $admin_id){
    $this->admin_id = $admin_id;
    
    $stmt = $this->mysqli->prepare("SELECT `admin_id`, `admin_name`, `admin_username`, `admin_image` FROM `admin` WHERE `admin_id`=? LIMIT 1");
    $stmt->bind_param("i", $this->admin_id);
    $stmt->execute();
    
    $stmt->bind_result($admin_id, $admin_name, $admin_username, $admin_image);
    
    $admin_info = array();
    
    while($stmt->fetch()){
      $admin_info = array(
        "admin_id"=>$admin_id,
        "admin_name"=>$admin_name,
        "admin_username"=>$admin_username,
        "admin_image"=>$admin_image
      );
    }
    
    return $admin_info;
  }
  
  
  final public function getByUsername(String $admin_username){
    $this->admin_username = $admin_username;
    
    $stmt = $this->mysqli->prepare("SELECT `admin_id`, `admin_name`, `admin_username`, `admin_image` FROM `admin` WHERE `admin_username`=? LIMIT 1");
    $stmt->bind_param("s", $this->admin_username);
    $stmt->execute();
    
    $stmt->bind_result($admin_id, $admin_name, $admin_username, $admin_image);
    
    $admin_info = array();
    
    while($stmt->fetch()){
      $admin_info = array(
        "admin_id"=>$admin_id,
        "admin_name"=>$admin_name,
        "admin_username"=>$admin_username,
        "admin_image"=>$admin_image
      );
    }
    
    return $admin_info;
  }
  
  final public function delete(Int $admin_id){
    $this->admin_id = $admin_id;
    
    $stmt = $this->mysqli->prepare("DELETE FROM `admin` WHERE `admin_id`=?");
    $stmt->bind_param("i", $this->admin_id);
    
    if($stmt->execute()){
      return True;
    } else {
      return False;
    }
  }

}
?>