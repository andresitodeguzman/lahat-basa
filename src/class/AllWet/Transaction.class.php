<?php
/**
 * All Wet
 * 2018
 * 
 * Class
 * Transaction
 */

namespace AllWet;

class Transaction {
    
    // Properties
    public $mysqli;

    public $transaction_array;

    public $transaction_id = 0;
    public $transaction_date;
    public $transaction_time;
    public $customer_id;
    public $transaction_items;
    public $transaction_count;
    public $transaction_price;
    public $transaction_payment_method;
    public $transaction_status;
    public $transaction_longitude;
    public $transaction_latitude;
    public $transaction_address;
    
    // Methods

    /**
     * __construct
     * @param: 
     * @return: void
     */
    function __construct($mysqli){
        $this->mysqli = $mysqli;
    }
  
    final public function add($t_array){
        $this->transaction_date = $t_array['transaction_date'];
        $this->transaction_ = $t_array['transaction_time'];
        $this->customer_id = $t_array['customer_id'];
        $this->transaction_items = $t_array['transaction_items'];
        $this->transaction_count = $t_array['transaction_count'];
        $this->transaction_price = $t_array['transaction_price'];
        $this->transaction_status = $t_array['transaction_status'];
        $this->transaction_longitude = $t_array['transaction_longitude'];
        $this->transaction_latitude = $t_array['transaction_latitude'];
        $this->transaction_address = $t_array['transaction_address'];

        $stmt = $this->mysqli->prepare("INSERT INTO `transaction` (transaction_date, transaction_time, customer_id, transaction_items, transaction_count, transaction_price, transaction_status, transaction_longitude, transaction_latitude, transaction_address)");
        $stmt->bind_param("ssssssssss", $this->transaction_date, $this->transaction_time, $this->customer_id, $this->transaction_items, $this->transaction_count, $this->transaction_price, $this->transaction_status, $this->transaction_longitude, $this->transaction_latitude, $this->transaction_address);
        $stmt->execute();

        return True;
    }
  
    final public function delete($transaction_id){
        $this->transaction_id = $transaction_id;

        $stmt = $this->mysqli->prepare("DELETE FROM `transaction` WHERE `transaction_id` = ?");
        $stmt->bind_param("s", $this->transaction_id);
        $stmt->execute();
    
        if($this->get($this->transaction_id)){
            return False;
        } else {
            return True;
        }
    }

    final public function get($transaction_id){
        $this->transaction_id = $transaction_id;

        $stmt = $this->mysqli->prepare("SELECT * FROM `transaction` WHERE `transaction_id` = ? LIMIT 1");
        $stmt->bind_param("s", $this->transaction_id);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc();

    }
  
    final public function getAll(){
        $stmt = $this->mysqli->prepare("SELECT * FROM `transaction`");
        $stmt->execute();
        $result = $stmt->get_result();        

        $this->transaction_array = array();

        while($trans = $result->fetch_array()){
            array_push($this->transaction_array, $trans);
        }

        return $this->transaction_array;
    }

    final public function getAllByCustomerId($customer_id){
        $this->customer_id = $customer_id;

        $stmt = $this->mysqli->prepare("SELECT * FROM `transaction` WHERE `customer_id` = ?");
        $stmt->bind_param("s", $this->customer_id);
        $stmt->exec();

        $result = $stmt->get_result();
        return $result->fetch_array();
    }

    final public function update($t_array){
        $this->transaction_id = $t_array['transaction_id'];
        $this->transaction_date = $t_array['transaction_date'];
        $this->transaction_time = $t_array['transaction_time'];
        $this->customer_id = $t_array['customer_id'];
        $this->transaction_items = $t_array['transaction_items'];
        $this->transaction_count = $t_array['transaction_count'];
        $this->transaction_price = $t_array['transaction_price'];
        $this->transaction_status = $t_array['transaction_status'];
        $this->transaction_longitude = $t_array['transaction_longitude'];
        $this->transaction_latitude = $t_array['transaction_latitude'];
        $this->transaction_address = $t_array['transaction_address'];

        $stmt = $this->mysqli->prepare("UPDATE `transaction` SET `transaction_date` = ?, `transaction_time` = ?,`customer_id` = ?,`transaction_items` = ?,`transaction_count` = ?,`transaction_price` = ?,`transaction_status` = ?,`transaction_longitude` = ?,`transaction_latitude` = ?,`transaction_address` = ? WHERE `transaction_id` = ?");
        $stmt->bind_param("sssssssssss", $this->transaction_date, $this->transaction_time, $this->customer_id, $this->transaction_items, $this->transaction_count, $this->transaction_price, $this->transaction_status, $this->transaction_longitude, $this->transaction_latitude, $this->transaction_address,$this->transaction_id);
        $stmt->execute();

        return True;
    }

    final public function updateStatus($transaction_id, $transaction_status){
        $this->transaction_id = $transaction_id;
        $this->transaction_status = $transaction_status;
        
        $stmt = $this->mysqli->prepare("UPDATE `transaction` SET `transaction_status` = ? WHERE `transaction_id` =?");
        $stmt->bind_param("ss", $this->transaction_status, $this->transaction_id);
        $stmt->execute();

        return True;
    }
    
}
?>