<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Transitem
 * getByTransactionId
 */

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\TransItem($mysqli);
$prod = new AllWet\Product($mysqli);

if(empty($_REQUEST['transaction_id'])) throwError("Empty Transaction ID");

$id = $_REQUEST['transaction_id'];

$data = $obj->getByTransactionId($id);

if(empty($data)){
    $data = json_encode(array());
} else {
	$t_arr = array();
	foreach($data as $d){
		$transitem_id = $d['transitem_id'];
		$transaction_id = $d['transaction_id'];
		$product_id = $d['product_id'];
		$transitem_quantity = $d['transitem_quantity'];

		$p_data = $prod->get($product_id);
		$product_name = "";
		if(@$p_data['product_name']) $product_name = $p_data['product_name'];

		$arr = array(
			"transitem_id"=>$transitem_id,
			"transaction_id"=>$transaction_id,
			"product_id"=>$product_id,
			"product_name"=>$product_name,
			"transitem_quantity"=>$transitem_quantity
		);
		array_push($t_arr, $arr);
	}
    $data = json_encode($t_arr);
}

echo $data;

?>