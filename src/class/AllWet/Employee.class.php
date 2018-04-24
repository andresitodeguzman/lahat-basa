<?php
/*
 * All Wet
 * 2018
 * 
 * Class
 * Employee
 */

namespace AllWet;

class Employee {
  
  private $mysqli;
  
  public $employee_id;
  public $employee_name;
  public $employee_username;
  public $employee_password;
  public $employee_image = "";
  
  function __construct($mysqli){
    $this->mysqli = $mysqli;
  }
  
  function getAll(){
    // Create Empty Placeholder
    $employee_array = array();
    
    $query = "SELECT `employee_id`, `employee_name`, `employee_username`, `employee_image` FROM `employee` LIMIT 50";
    
    if($result = $this->mysqli->query($query)){
      while($emp = $result->fetch_array()){
        $employee_id = $emp['employee_id'];
        $employee_name = $emp['employee_name'];
        $employee_username = $emp['employee_username'];
        $employee_image = $emp['employee_image'];
        
        $prep_arr = array(
          "employee_id" => $employee_id,
          "employee_name" => $employee_name,
          "employee_username" => $employee_username,
          "employee_image" => $employee_image
        );
        
        array_push($employee_array, $prep_arr);
      }
    }
    
    // Return array
    return $employee_array;
    
  }
  
  final public function get(Int $employee_id){
    $this->employee_id = $employee_id;
    
    // Query in DB
    $stmt = $this->mysqli->prepare("SELECT `employee_name`, `employee_username`, `employee_image` FROM `employee` WHERE `employee_id` = ? LIMIT 1");
    $stmt->bind_param("s", $this->employee_id);
    $stmt->execute();
    
    $stmt->bind_result($employee_name, $employee_username, $employee_image);
          
    $employee_info = array();  
    
    while($stmt->fetch()){
      $employee_info = array(
        "employee_name"=>$employee_name,
        "employee_username"=>$employee_username,
        "employee_image"=>$employee_image
      );
    }

    $result = $employee_info;

    // Return Result
    return $result;
  }
  
  final public function usernameExists(String $employee_username){
    // Handle Param
    $this->employee_username = $employee_username;

    // Query in DB
    $stmt = $this->mysqli->prepare("SELECT `employee_id` FROM `employee` WHERE `employee_username` = ?");
    $stmt->bind_param("s", $this->employee_username);
    $stmt->execute();

    $stmt->bind_result($employee_id);
    while($stmt->fetch()){
      if($employee_id){
        return True;
      } else {
        return False;
      }
    }
  }
  
  final public function add(Array $e_array){
    // Handle Params
    $this->employee_name = $e_array['employee_name'];
    $this->employee_username = $e_array['employee_username'];
    $this->employee_password = $e_array['employee_password'];
    if($e_array['employee_image']) $this->employee_image = $e_array['employee_image'];
    
    // Check if username already exists
    if($this->usernameExists($this->employee_username)){
        return "Username already exist";
    } else {
        // Check if password length is okay
        if(strlen($this->employee_password) < 8){
            return "Password less than 8 characters";
        } else {

            // Hash password
            $this->employee_password = password_hash($this->employee_password, PASSWORD_DEFAULT);

            // Insert into DB
            $stmt = $this->mysqli->prepare("INSERT INTO `employee` (employee_name,employee_username,employee_password,employee_image ) VALUES (?,?,?,?)");
            $stmt->bind_param("ssss", $this->employee_name, $this->employee_username, $this->employee_password, $this->employee_image);
            if($stmt->execute()){
              // Return true
              return True;              
            } else {
              return False;
            }
        }
    }
  }
  
  final public function delete(Int $employee_id){
    // Handle Param
    $this->employee_id = $employee_id;

    // Delete in DB
    $stmt = $this->mysqli->prepare("DELETE FROM `employee` WHERE `employee_id` = ?");
    $stmt->bind_param("s", $this->employee_id);
    
    if($stmt->execute()){
      return True;
    } else {
      return False;
    }
    
    
  }
  
  final public function  getByUsername(String $employee_username){
    return True;
  }

}
?>