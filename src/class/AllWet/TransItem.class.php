<?php
/**
 * All Wet
 * 2018
 * 
 * Class
 * TransItem
 */

class TransItem {

    private $mysqli;

    public $transitem_id;
    public $transaction_id;
    public $product_id;
    public $transitem_quantity;

    /**
     * __construct
     * 
     * @param: $mysqli
     * @return: None
     */
    function __construct($mysqli){
        $this->mysqli = $mysqli;
    }

    /**
     * add
     * 
     * @param: @t_array
     * @return: Int
     */
    final public function add(Array $t_array){
        if($t_array['transaction_id']) $this->transaction_id = $t_array['transaction_id'];
        if($t_array['product_id']) $this->product_id = $t_array['product_id'];
        if($t_array['transitem_quantity']) $this->transitem_quantity = $t_array['transitem_quantity'];

        $stmt = $this->mysqli->prepare("INSERT INTO `transitem` (transaction_id, product_id, transitem_quantity) VALUES (?,?,?)");
        $stmt->bind_param("s,s,s",$this->transaction_id, $this->product_id, $this->transitem_quantity);
        $stmt->execute();

        $stmt = $this->mysqli->prepare("SELECT `transitem_id` FROM `transitem` WHERE `transaction_id`=? AND `product_id`=? LIMIT  1");
        $stmt->bind_param("s,s", $this->transaction_id, $this->product_id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * get
     * 
     * @param: Int $transitem_id
     * @return: Array
     */
    final public function get(Int $transitem_id){
        $this->transitem_id = $transitem_id;

        $stmt = $this->mysqli->prepare("SELECT * FROM `transitem` WHERE `transitem_id`=? LIMIT 1");
        $stmt->bind_param("s", $this->transitem_id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_array();
    }

    /**
     * getByTransactionId
     * 
     * @param: Int $transaction_id
     * @return: Array
     */
    final public function getByTransactionId(Int $transaction_id){
        $this->transaction_id = $transaction_id;

        $stmt = $this->mysqli->prepare("SELECT * FROM `transitem` WHERE `transaction_id`=?");
        $stmt->bind_param("s", $this->transaction_id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_array();
    }

    /**
     * delete
     * 
     * @param: Int $transitem_id
     * @return: Boolean
     */
    final public function delete(Int $transitem_id){
        $this->transitem_id = $transitem_id;
        
        $stmt = $this->mysqli->prepare("DELETE FROM `transitem` WHERE `transitem_id`=?");
        $stmt->bind_param("s",$this->transitem_id);
        $stmt->execute();

        return True;
    }


    /**
     * deleteByTransactionId
     * 
     * @param: Int $transaction_id
     * @return: Boolean
     */
    final public function deleteByTransactionId(Int $transaction_id){
        $this->transaction_id = $transaction_id;

        $stmt = $this->mysqli->prepare("DELETE FROM `transitem` WHERE `transaction_id`=?");
        $stmt->bind_param("s",$this->transaction_id);
        $stmt->execute();

        return True;
    }

    /**
     * update
     * 
     * @param: Array $t_array
     * @return: Boolean
     */
    final public function update(Array $t_array){
        if($t_array['transitem_id']) $this->transitem_id = $t_array['transitem_id'];
        if($t_array['transaction_id']) $this->transaction_id = $t_array['transaction_id'];
        if($t_array['product_id']) $this->product_id = $t_array['product_id'];
        if($t_array['transitem_quantity']) $this->transitem_quantity = $t_array['transitem_quantity'];

        $stmt = $this->mysqli->prepare("UPDATE `transitem` SET `transaction_id`=?, `product_id`=?, `transitem_quantity`=? WHERE `transitem_id`=?");
        $stmt->bind_param("s,s,s,s", $this->transaction_id, $this->product_id, $this->transitem_quantity, $this->transitem_id);
        $stmt->execute();

        return True;
    }

    /**
     * updateQuantity
     * 
     * @param: Int $transitem_id
     * @param: Int $transitem_quantity
     * @return: Boolean
     */
    final public function updateQuantity(Int $transitem_id, Int $transitem_quantity){
        $this->transitem_id = $transitem_id;
        $this->transitem_quantity = $transitem_quantity;

        $stmt = $this->mysqli->prepare("UPDATE `transitem` SET `transitem_quantity`=? WHERE `transitem_id`=?");
        $stmt->bind_param("s,s", $this->transitem_quantity, $this->transitem_quantity);
        $stmt->execute();

        return True;
    }

}

?>