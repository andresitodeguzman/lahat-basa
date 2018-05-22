<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Transaction
 * getAll
 */

$perm = 4;

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Transaction($mysqli);
$customer = new AllWet\Customer($mysqli);
$transitem = new AllWet\TransItem($mysqli);
$product = new AllWet\Product($mysqli);

$data = $obj->getAll();

if(empty($data)){
    $data = json_encode(array());
} else {

    $d = array();
    foreach($data as $trans){
        $transaction_id = $trans['transaction_id'];
        $customer_id = $trans['customer_id'];
        $customer_info = $customer->get($customer_id);
        $transitem_info = $transitem->getByTransactionId($transaction_id);

        $ti_ar = array();

        foreach($transitem_info as $ti){
            $transitem_id = $ti['transitem_id'];
            $product_id = $ti['product_id'];
            $product_info = $product->get($product_id);
            if(@$product_info['product_name']){
                $ti['product_name'] = $product_info['product_name'];
            } else {
                $ti['product_name'] = "Unknown Product";
            }
            array_push($ti_ar, $ti);
        }

        $trans['customer'] = $customer_info;
        $trans['transitem'] = $ti_ar;

        array_push($d, $trans);
    }

    $data = json_encode($d);
}

echo $data;
?>