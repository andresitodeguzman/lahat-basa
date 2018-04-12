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
    public $mysqli;

    public $customer_id;
    public $customer_number;
    public $customer_name;
    public $customer_longitude;
    public $customer_latitude;
    public $customer_address;
    public $customer_image;
    public $customer_access_token;

    // Methods

    /**
     * __construct
     * @param: none
     * @return: Void
     */
    function __construct($mysqli){
        $this->mysqli = $mysqli;
    }
  
    /**
     * add
     * 
     * @param: Array $c_array
     * @return: Boolean
     */
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
        $stmt->execute();

        return True;
    }
  
    /**
     * delete
     * 
     * @param: Int $customer_id
     * @return: Boolean
     */
    final public function delete($customer_id){
        $this->customer_id = $customer_id;
        $stmt = $this->mysqli->prepare("DELETE FROM `customer` WHERE `customer_id` = ?");
        $stmt->bind_param("s", $this->customer_id);
        $stmt->execute();

        if($this->get($this->customer_id)){
            return True;
        } else {
            return False;
        }

    }

    /**
     * get
     * 
     * @param: Int $customer_id
     * @return: Array
     */
    final public function get(Int $customer_id){
        $this->customer_id = $customer_id;
        $stmt = $this->mysqli->prepare("SELECT `customer_id`, `customer_number`, `customer_name`, `customer_longitude`, `customer_latitude`, `customer_address`, `customer_image` FROM `customer` WHERE `customer_id` = ? LIMIT 1");
        $stmt->bind_param("s", $this->customer_id);
        $stmt->execute();
        $result = $this->get_result();

        return $result->fetch_assoc();
    }

    /**
     * getAll
     * 
     * @param: none
     * @return: Array
     */
    final public function getAll(){
        $stmt = $this->mysqli->prepare("SELECT `customer_id`, `customer_number`, `customer_name`, `customer_longitude`, `customer_latitude`, `customer_address`, `customer_image` FROM `customer`");
        $stmt->execute();
        $result = $this->get_result();

        return $result->fetch_array();
    }

    /**
     * getByCustomerNumber
     * 
     * @param: String $customer_number
     * @return: Array
     */
    final public function getByCustomerNumber(String $customer_number){
        $this->customer_number = $customer_number;

        $stmt = $this->mysqli->prepare("SELECT `customer_id`, `customer_number`, `customer_name`, `customer_longitude`, `customer_latitude`, `customer_address`, `customer_image` FROM `customer` WHERE `customer_number` = ? LIMIT 1");
        $stmt->bind_param("s", $this->customer_number);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * getNumberByAccessToken
     * 
     * @param: String $customer_access_token
     * @return: Int
     */
    final public function getNumberByAccessToken($customer_access_token){
        $this->customer_access_token = $customer_access_token;

        $stmt = $this->mysqli->prepare("SELECT `customer_number` FROM `customer` WHERE `customer_access_token` = ? LIMIT 1");
        $stmt->bind_param("s", $this->customer_access_token);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
  

    /**
     * getByCustomerAccessToken
     * 
     * @param: String $customer_access_token
     * @return: Array
     */
    final public function getByCustomerAccessToken(String $customer_access_token){
        $this->customer_access_token = $customer_access_token;

        $stmt = $this->mysqli->prepare("SELECT `customer_id`, `customer_number`, `customer_name`, `customer_longitude`, `customer_latitude`, `customer_address`, `customer_image` FROM `customer` WHERE `customer_access_token` = ? LIMIT 1");
        $stmt->bind_param("s", $this->customer_access_token);
        $stmt->execute();

        $result = $this->get_result();
        return $result->fetch_assoc();
    }

    /**
     * numberExists
     * 
     * @param: String $customer_number
     * @return: Boolean
     */
    final public function numberExists($customer_number){
        $this->customer_number = $customer_number;

        $stmt = $this->mysqli->prepare("SELECT * FROM `customer` WHERE `customer_number` = ?");
        $stmt->bind_param("s", $this->customer_number);
        $stmt->execute();

        $result = $stmt->get_result();
        if($result->fetch_assoc()){
            return True;
        } else {
            return False;
        }
    }
    

    /**
     * update
     * 
     * @param: Array $c_array
     * @return: Boolean
     */
    final public function update($c_array){
        if($c_array['customer_id']) $this->customer_id = $c_array['customer_id'];
        if($c_array['customer_number']) $this->customer_number = $c_array['customer_number'];
        if($c_array['customer_name']) $this->customer_name = $c_array['customer_name'];
        if($c_array['customer_longitude']) $this->customer_longitude = $c_array['customer_longitude'];
        if($c_array['customer_latitude']) $this->customer_latitude = $c_array['customer_latitude'];
        if($c_array['customer_address']) $this->customer_address = $c_array['customer_address'];
        if($c_array['customer_image']) $this->customer_image = $c_array['customer_image'];

        if($this->get($this->customer_id)){
            $stmt = $this->mysqli->prepare("UPDATE `customer` SET `customer_number` = ?, `customer_name` = ?, `customer_longitude` = ?, `customer_latitude` = ?, `customer_address` = ?, `customer_image` = ? WHERE `customer_id` = ?");
            $stmt->bind_param("ssssss", $this->customer_number, $this->customer_name, $this->customer_longitude, $this->customer_latitude, $this->customer_latitude, $this->customer_address, $this->customer_image, $this->customer_id);
            $stmt->execute();

            return True;
        } else {
            return False;
        }
    }

    /**
     * updateAccessToken
     * 
     * @param: Int $customer_id
     * @param: String $customer_access_token
     * @return: Boolean
     */
    final public function updateAccessToken(Int $customer_id, String $customer_access_token){
        $this->customer_id = $customer_id;
        $this->customer_access_token = $customer_access_token;

        $stmt = $this->mysqli->prepare("UPDATE `customer` SET `customer_access_token` = ? WHERE `customer_id` = ?");
        $stmt->bind_param("ss", $this->customer_access_token, $this->customer_id);
        $stmt->execute();
        
        return True;
    }
}
?>