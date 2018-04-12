<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Transaction
 * getAll
 */

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Transaction($mysqli);
$customer = new AllWet\Customer($mysqli);

$data = $obj->getAll();

if(!empty($data)){
    $t_array = array();
    
    foreach($data as $trans){
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
        
        $customer_array = $customer->get($customer_id);
        
        foreach($customer_array as $cust){
            $customer_name = $cust['customer_name'];
            $customer_number = $cust['customer_number'];
        }
        
        $a_arr = array(
            "transaction_id"=>$transaction_id,
            "transaction_date"=>$transaction_date,
            "transaction_time"=>$transaction_time,
            "customer_id"=>$customer_id,
            "customer_name"=>$customer_name,
            "customer_number"=>$customer_number,
            "transaction_count"=>$transaction_count,
            "transaction_price"=>$transaction_price,
            "transaction_payment_method"=>$transaction_payment_method,
            "transaction_status"=>$transaction_status,
            "transaction_longitude"=>$transaction_longitude,
            "transaction_latitude"=>$transaction_latitude,
            "transaction_address"=>$transaction_address         
        );
        array_push($t_array,$a_arr);
    }
    $data = json_encode(array());
} else {
    $data = json_encode($data);
}

echo $data;

?>