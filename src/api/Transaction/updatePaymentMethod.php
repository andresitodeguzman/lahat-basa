<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Transaction
 * updatePaymentMethod
 */

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Transaction($mysqli);

if(empty($_REQUEST['transaction_id'])) throwError("Empty id");
if(empty($_REQUEST['transaction_payment_method'])) throwError("Empty Payment Method");

$transaction_id = $_REQUEST['transaction_id'];
$transaction_payment_method = $_REQUEST['transaction_payment_method'];

$array = array(
  "transaction_id"=>$transaction_id,
	"transaction_payment_method" => $transaction_payment_method
);

$result = $obj->updatePaymentMethod($array);

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