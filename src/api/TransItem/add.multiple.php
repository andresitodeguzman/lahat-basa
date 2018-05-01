<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * transitem
 * add
 */

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\TransItem($mysqli);

if(empty($_REQUEST['transaction_id'])) throwError("Empty Transaction Id");
if(empty($_REQUEST['transaction_items'])) throwError("Empty Transaction Items");

$transaction_id = $_REQUEST['transaction_id'];
$transaction_items = json_decode($_REQUEST['transaction_items'],true);

foreach($transaction_items as $ti){
	$product_id = $ti['product_id'];
	$transitem_quantity = $ti['transitem_quantity'];

	$array = array(
		"transaction_id" => $transaction_id,
		"product_id" => $product_id,
		"transitem_quantity" => $transitem_quantity
	);

	$result = $obj->add($array);
}

$res = array(
	"code" => "200",
	"message" => "Successfully Added"
);

echo(json_encode($res));

?>