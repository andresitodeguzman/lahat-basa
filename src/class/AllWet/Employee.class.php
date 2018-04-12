<?php
/**
 * All Wet
 * 2018
 * 
 * Class
 * Employee
 */

namespace AllWet;

class Employee {

    // Properties
    public $mysqli;

    public $employee_array;

    public $employee_id;
    public $employee_name;
    public $employee_username;
    public $employee_password;
    public $employee_image;

    // Methods

    /**
     * __construct
     * @param: $mysqli
     * @return: void
     */
    function __construct($mysqli){
        $this->mysqli = $mysqli;
    }
  
    /**
     * add
     * 
     * @param: Array $e_array
     * @return: Boolean
     */
    final public function add(Array $e_array){
        // Handle Params
        $this->employee_name = $e_array['employee_name'];
        $this->employee_username = $e_array['employee_username'];
        $this->employee_password = $e_array['employee_password'];
        $this->employee_image = $e_array['employee_image'];

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
                $stmt = $this->mysqli->prepare("INSERT INTO `employee` (`employee_name`, `employee_username`, `employee_password`, `employee_image`) VALUES (?,?,?,?)");
                $stmt->bind_param("ssss", $this->employee_name, $this->employee_username, $this->employee_password, $this->employee_image);
                $stmt->execute();

                // Return true
                return True;
            }
        }

    }
  
   /**
     * delete
     * 
     * @param: Int $employee_id
     * @return: Boolean
     */
    final public function delete(Int $employee_id){
        // Handle Param
        $this->employee_id = $employee_id;

        // Delete in DB
        $stmt = $this->mysqli->prepare("DELETE FROM `employee` WHERE `employee_id` = ?");
        $stmt->bind_param("s", $this->employee_id);
        $stmt->execute();

        // Check if Delete was successful
        $stmt = $this->mysqli->prepare("SELECT `employee_id` FROM `employee` WHERE `employee_id` = ? LIMIT 1");
        $stmt->bind_param("s", $this->employee_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $result = $result->fetch_assoc();

        if(empty($result)){
            return True;
        } else {
            return False;
        }
    }

    /**
     * usernameExists
     * 
     * @param: String $employee_username
     * @return: Boolean
     */
    final public function usernameExists(String $employee_username){
        // Handle Param
        $this->employee_username = $employee_username;

        // Query in DB
        $stmt = $this->mysqli->prepare("SELECT `employee_id` FROM `employee` WHERE `employee_username` = ?");
        $stmt->bind_param("s", $this->employee_username);
        $stmt->execute();

        $result = $stmt->get_result();
        if($result->fetch_assoc()){
            return True;
        } else {
            return False;
        }
    }

    /**
     * getAll
     * 
     * @param: none
     * @return: Array
     */
    final public function getAll(){
        // Query in DB
        $stmt = $this->mysqli->prepare("SELECT `employee_id`, `employee_name`, `employee_username`, `employee_image` FROM `employee`");
        $stmt->execute();
        $result = $stmt->get_result();                                          
        
        // Create Empty Placeholder
        $this->employee_array = array();

        // Loop along data
        while($emp = $result->fetch_array()){
            $employee_id = $emp['employee_id'];
            $employee_name = $emp['employee_name'];
            $employee_username = $emp['employee_username'];
            $employee_image = $emp['employee_image'];

            $prep_arr = array(
                "employee_id" => $this->employee_id,
                "employee_name" => $this->employee_name,
                "employee_username" => $this->employee_username,
                "employee_image" => $this->employee_image
            );


            array_push($this->employee_array, $prep_arr);
        }

        // Return array
        return $this->employee_array;
    }

    /**
     * get
     * 
     * @param: Int $employee_id
     * @return: Array
     */
    final public function get(Int $employee_id){
        // Handle Param
        $this->employee_id = $employee_id;

        // Query in DB
        $stmt = $this->mysqli->prepare("SELECT `employee_name`, `employee_username`, `employee_image` FROM `employee` WHERE `employee_id` = ?");
        $stmt->bind_param("s", $this->employee_id);
        $stmt->execute();

        $result = $stmt->get_result();

        // Return Result
        return $result->fetch_assoc();
    }

    /**
     * getByUsername
     * 
     * @param: String $employee_username
     * @return: Array
     */
    final public function getByUsername(String $employee_username){
        // Handle Param
        $this->employee_username = $employee_username;

        // Query in DB
        $stmt = $this->mysqli->prepare("SELECT `employee_id`, `employee_name`, `employee_username`, `employee_image` FROM `employee` WHERE `employee_username` = ?");
        $stmt->bind_param("s", $this->employee_username);
        $stmt->execute();

        $result = $stmt->get_result();

        // Return result
        return $result->fetch_assoc();
    }
    

  /**
   * update
   * 
   * @param: $e_array
   * @return: Bool
   */
  final public function update(Array $e_array){
    $this->employee_id = $e_array['employee_id'];
    $this->employee_name = $e_array['employee_name'];
    $this->employee_image = $e_array['employee_image'];
    
    if($this->get($this->employee_id)){
      $stmt = $this->mysqli->prepare("UPDATE `employee` SET `employee_name`=?, `employee_image`=? WHERE `employee_id`=?");
      $stmt->bind_param("sss", $this->employee_name, $this->employee_image, $this->employee_id);
      $stmt->execute();
      
      $inf = $this->get($this->employee_id);
      if($inf['employee_name'] === $this->employee_name){
        return True;
      } else {
        return False;
      }
    } else {
      return False;
    }
  }
  
  /**
   * updatePassword
   * 
   * @param: Int $employee_id
   * @param: String $employee_password
   * @param: String $employee_new_password
   * @return: Boolean
   */
    final public function updatePassword(Int $employee_id, String $employee_password, String $employee_new_password){
        $this->employee_id = $employee_id;
        $this->employee_password = $employee_password;

        if($this->verifyPassword($this->employee_password)){
            $nw_pw = password_hash(employee_new_password, PASSWORD_DEFAULT);

            $stmt = $this->mysqli->prepare("UPDATE `employee` SET `employee_password` = ? WHERE `employee_id` = ?");
            $stmt->bind_param("ss", $nw_pw, $this->employee_id);
            $stmt->execute();

            return True;

        }  else {
            return "Wrong Password";        
        }   
    }
  
  /**
   * updateUsername
   * 
   * @param: Int $employee_id
   * @param: String $employee_username
   * @return: Boolean
   */
    final public function updateUsername(Int $employee_id, String $employee_username){
        $this->employee_id = $employee_id;
        $this->employee_username = $employee_username;

        $inf = $this->get($this->employee_username);
        $current_username = $inf['employee_username'];
        if($current_username == $this->employee_username){
            return False;
        } else {
            $stmt = $this->mysqli->prepare("SELECT employee_id FROM `employee` WHERE employee_username = ? EXCEPT employee_id = `?` LIMIT 1");
            $stmt->bind_param("ss", $this->employee_username, $this->employee_id);
            $stmt->execute();

            $result = $stmt->get_result();
            $result = $stmt->fetch_assoc();

            if($result){

                return "Username already in use";

            } else {

                $stmt = $this->mysqli->prepare("UPDATE `employee` SET `employee_username`=? WHERE `employee_id`=?");
                $stmt->bind_param("ss", $this->employee_username, $this->employee_id);
                $stmt->execute();

                return True;

            }
        }
    }

  
  /**
   * verifyPassword
   * 
   * @param: String $employee_username
   * @param: String $employee_password
   * @return: Boolean
   */
  final public function verifyPassword(String $employee_username, String $employee_password){
    $this->employee_username = $employee_username;
    $this->employee_password = $employee_password;
    
    $stmt = $this->mysqli->prepare("SELECT `employee_password` FROM `employee` WHERE `employee_username` = ? LIMIT 1");
    $stmt->bind_param("s", $this->employee_password);
    $stmt->execute();

    $result = $stmt->get_result();
    $result = $result->fetch_assoc();
    
    if(password_verify($this->employee_password, $result['employee_password'])){
      return True;      
    } else {
      return False;
    }
  }


}
?>