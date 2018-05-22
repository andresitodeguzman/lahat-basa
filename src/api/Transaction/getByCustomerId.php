<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Transaction
 * getByCustomerId
 */

$perm = 2;

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Transaction($mysqli);
$transitem = new AllWet\TransItem($mysqli);
$product = new AllWet\Product($mysqli);

if(empty($_REQUEST['customer_id'])) throwError("Empty Customer id");

$id = $_REQUEST['customer_id'];

$data = $obj->getByCustomerId($id);


if(empty($data)){
    $data = json_encode(array());
} else {
    $d_array = array();

    foreach($data as $d){
        $transaction_id = $d['transaction_id'];
        $transitem_info = $transitem->getByTransactionId($transaction_id);

        $ti_array = array();
        foreach($transitem_info as $ti){
            $product_id = $ti['product_id'];
            $product_info = $product->get($product_id);
            $product_name = "";
            if(@$product_info['product_name']) $product_name = $product_info['product_name'];
            $ti['product_name'] = $product_name;
            array_push($ti_array, $ti);
        }

        $d['transitem'] = $ti_array;

        array_push($d_array,$d);

    }

    $d_array = json_encode(array_reverse($d_array));
    $data = $d_array;
}

echo $data;

?>