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

if(empty($_REQUEST['transaction_id'])) throwError("Empty transaction_id");
if(empty($_REQUEST['product_id'])) throwError("Empty product_id");
if(empty($_REQUEST['transitem_quantity'])) throwError("Empty transitem_quatity");


$transaction_id = $_REQUEST['transaction_id'];
$product_id = $_REQUEST['product_id'];
$transitem_quantity = $_REQUEST['transitem_quantity'];

$array = array(

	"transaction_id" => $transaction_id,
	"product_id" => $product_id,
	"transitem_quantity" => $transitem_quantity
);

$result = $obj->add($array);

if($result == True){
	$res = array(
		"code" => "200",
		"message" => "Successfully Added"
	);
} else {
	$res = array(
		"code" => "400",
		"message" => $result
	);
}

echo(json_encode($res));

?>