<?php
/**
 * All Wet
 * 2018
 * 
 * Class
 * Category
 */

namespace AllWet;

class Category {
  // Properties
  private $mysqli;

  public $category_id;
  public $category_name;
  public $category_description = "";
  public $category_code;
  
  function __construct($mysqli){
    $this->mysqli = $mysqli;
  }
  
  final public function getAll(){
    $category_array = array();
    
    $query = "SELECT * FROM `category` LIMIT 50";
    
    if($result = $this->mysqli->query($query)){
      while($cat = $result->fetch_array()){
        $category_id = $cat['category_id'];
        $category_name = $cat['category_name'];
        $category_description = $cat['category_description'];
        $category_code = $cat['category_code'];

        $prep_arr = array(
            "category_id"=>$category_id,
            "category_name"=>$category_name,
            "category_description"=>$category_description,
            "category_code"=>$category_code
        );

        // Push to placeholder array
        array_push($category_array,$prep_arr);
      }
    }
    
    return $category_array;
  }
  
  final public function get($category_id){
    // Handle Param
    $this->category_id = $category_id;

    // Prepare Statement
    $stmt = $this->mysqli->prepare("SELECT * FROM `category` WHERE `category_id` = ? LIMIT 1");
    // Bind and execute
    $stmt->bind_param("s",$this->category_id);
    $stmt->execute();

    $stmt->bind_result($category_id ,$category_name, $category_description, $category_code);
    
    $category_info = array();
    
    while($stmt->fetch()){
      $category_info = array(
        "category_id"=>$category_id,
        "category_name"=>$category_name,
        "category_description"=>$category_description,
        "category_code"=>$category_code
      );
    }
    
    return $category_info;

  }
  
  final public function getByCode(String $category_code){
    $this->category_code = $category_code;
    
    // Prepare Statement
    $stmt = $this->mysqli->prepare("SELECT * FROM `category` WHERE `category_code` = ? LIMIT 1");
    // Bind and execute
    $stmt->bind_param("s",$this->category_code);
    $stmt->execute();

    $stmt->bind_result($category_id ,$category_name, $category_description, $category_code);
    
    $category_info = array();
    
    while($stmt->fetch()){
      $category_info = array(
        "category_id"=>$category_id,
        "category_name"=>$category_name,
        "category_description"=>$category_description,
        "category_code"=>$category_code
      );
    }
    
    return $category_info;
  }
  
  final public function codeExists(String $category_code){
    $this->category_code = $category_code;
    
    $stmt = $this->mysqli->prepare("SELECT `category_code` FROM `category` WHERE `category_code`=?");
    $stmt->bind_param("s", $this->category_code);
    $stmt->execute();
    
    $stmt->bind_result($c_code);
    $stmt->fetch();
    
    if($c_code == $this->category_code){
      return True;
    } else {
      return False;
    }
  }
  
  final public function add(Array $c_array){
    $this->category_name = $c_array['category_name'];
    $this->category_code = $c_array['category_code'];
    if($c_array['category_description']) $this->category_description = $c_array['category_description'];
    
    if($this->codeExists($this->category_code)){
      return "Category Code already in use";
    } else {
      
      $stmt = $this->mysqli->prepare("INSERT INTO `category` (category_name, category_code, category_description) VALUES(?,?,?)");
      $stmt->bind_param("sss", $this->category_name, $this->category_code, $this->category_description);
      
      if($stmt->execute()){
        return True;
      } else {
        return False;
      }
      
    }
  }
  
  final public function delete(Int $category_id){
    $this->category_id = $category_id;
    
    $stmt = $this->mysqli->prepare("DELETE FROM `category` WHERE category_id=?");
    $stmt->bind_param("i",$this->category_id);
    
    if($stmt->execute()){
      return True;
    } else {
      return False;
    }
  }
  
  final public function update(Array $c_array){
    $this->category_id = $c_array['category_id'];
    $this->category_name = $c_array['category_name'];
    $this->category_code = $c_array['category_code'];
    if($c_array['category_description']) $this->category_description = $c_array['category_description'];
    
    $category_info = $this->get($this->category_id);
    
    if($category_info['category_code'] == $this->category_code){
        
      $stmt = $this->mysqli->prepare("UPDATE `category` SET category_name=?, category_description=? WHERE category_id=?");
      $stmt->bind_param("ssi", $this->category_name, $this->category_description, $this->category_id);
      
      if($stmt->execute()){
        return True;
      } else {
        return False;
      }
      
    } else {
    
      if($this->codeExists($this->category_code)){
        return "Category Code already in use";
      } else {

        $stmt = $this->mysqli->prepare("UPDATE `category` SET category_code=?, category_name=?, category_description=? WHERE category_id=?");
        $stmt->bind_param("sssi", $this->category_code, $this->category_name, $this->category_description, $this->category_id);

        if($stmt->execute()){
          return True;
        } else {
          return False;
        }

      }
      
    }
    
  }
  
}
?>