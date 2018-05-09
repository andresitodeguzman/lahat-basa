<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Transaction
 * updatePrice
 */

$perm = 2;

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Transaction($mysqli);

if(empty($_REQUEST['transaction_id'])) throwError("Empty id");
if(empty($_REQUEST['transaction_price'])) throwError("Empty price");

$transaction_id = $_REQUEST['transaction_id'];
$transaction_price = $_REQUEST['transaction_price'];

$array = array(
  "transaction_id"=>$transaction_id,
	"transaction_price" => $transaction_price
);

$result = $obj->updatePrice($array);

if($result === True){
	$res = array(
		"code" => "200",
		"message" => "Successfully updated"
	);
} else {
	$res = array(
		"code" => "400",
		"message" => "Fail to update"
	);
}

echo(json_encode($res));

?>