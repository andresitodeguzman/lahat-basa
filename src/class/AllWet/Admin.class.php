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
  public $admin_image = "";
  
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
  
  final public function usernameExists(String $admin_username){
    $this->admin_username = $admin_username;
    
    $stmt = $this->mysqli->prepare("SELECT `admin_username` FROM `admin` WHERE `admin_username`=? LIMIT 1");
    $stmt->bind_param("s",$this->admin_username);
    $stmt->execute();
    
    $stmt->bind_result($a_username);
    $stmt->fetch();
    
    if($a_username == $this->admin_username){
      return True;
    } else {
      return False;
    }
  }
  
  final public function add(Array $a_array){
    $this->admin_name = $a_array['admin_name'];
    $this->admin_username = $a_array['admin_username'];
    $this->admin_password = $a_array['admin_password'];
    $this->admin_image = $a_array['admin_image'];
        
    if($this->usernameExists($this->admin_username)){
      return "Username already in use";
    } else {
      if(strlen($this->admin_password) < 8){
        return "Password too short";
      } else {
        $this->admin_password = password_hash($this->admin_password, PASSWORD_DEFAULT);
        
        $stmt = $this->mysqli->prepare("INSERT INTO `admin`(`admin_name`,`admin_username`,`admin_password`,`admin_image`) VALUES(?,?,?,?)");
        $stmt->bind_param("ssss", $this->admin_name, $this->admin_username, $this->admin_password, $this->admin_image);
        
        if($stmt->execute()){
          return True;
        } else {
          return False;
        }
      }
    }
  }
  
  final public function update(Array $a_array){
    $this->admin_id = $a_array['admin_id'];
    $this->admin_name = $a_array['admin_name'];
    $this->admin_username = $a_array['admin_username'];
    $this->admin_password = $a_array['admin_password'];
    $this->admin_image = $a_array['admin_image'];
    
    $admin_info = $this->get($this->admin_id);
    if($admin_info['admin_username'] == $this->admin_username){
      $stmt = $this->mysqli->prepare("UPDATE `admin` SET `admin_name`=?, `admin_image`=? WHERE `admin_id`=?");
      $stmt->bind_param("ssi",$this->admin_name, $this->admin_image, $this->admin_id);
      if($stmt->execute()){
        if(!empty($this->admin_password)){
          $a_array = array(
            "admin_id"=>$this->admin_id,
            "admin_password"=>$this->admin_password
          );
          $res = $this->updatePassword($a_array);
          if($res === True){
            return True;
          } else {
            return False;
          }
        }
      } else {
        return False;
      }
    } else {
      if($this->usernameExists($this->admin_username)){
        return "Username already in use";
      } else {
        $stmt = $this->mysqli->prepare("UPDATE `admin` SET `admin_name`=?, `admin_username`=?, `admin_image`=? WHERE `admin_id`=?");
        $stmt->bind_param("sssi", $this->admin_name, $this->admin_username, $this->admin_image, $this->admin_id);
        if($stmt->execute()){
          if(!empty($this->admin_password)){
            $a_array = array(
              "admin_id"=>$this->admin_id,
              "admin_password"=>$this->admin_password
            );
            $res = $this->updatePassword($a_array);
            if($res === True){
              return True;
            } else {
              return False;
            }
          }
        } else {
          return False;
        }
      }
    }
    
  }
  
  final public function updatePassword(Array $a_array){
    $this->admin_id = $a_array['admin_id'];
    $this->admin_password = $a_array['admin_password'];
    
    if(strlen($this->admin_password) < 8){
      return "Password too short";
    } else {
      $this->admin_password = password_hash($this->admin_password, PASSWORD_DEFAULT);
      
      $stmt = $this->mysqli->prepare("UPDATE `admin` SET `admin_password`=? WHERE `admin_id`=?");
      $stmt->bind_param("si", $this->admin_password, $this->admin_id);
      if($stmt->execute()){
        return True;
      } else {
        return False; 
      }
    }
  }
  
  final public function verifySignIn(Array $a_array){
    $this->admin_username = $a_array['admin_username'];
    $this->admin_password = $a_array['admin_password'];
    
    $stmt = $this->mysqli->prepare("SELECT `admin_id`, `admin_username`, `admin_password` FROM `admin` WHERE `admin_username`=?");
    $stmt->bind_param("s", $this->admin_username);
    $stmt->execute();
    $stmt->bind_result($admin_id, $admin_username, $admin_password);
    $stmt->fetch();
    
    $wronginfo = "Username or Password is incorrect";
    
    if($admin_username){
      $c_p = password_verify($this->admin_password, $admin_password);
      if($c_p){
        return True;
      } else {
        return $wronginfo;
      }
    } else {
      return $wronginfo;
    }
  }

}
?>