<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Transaction
 * updateStatus
 */

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Transaction($mysqli);

if(empty($_REQUEST['transaction_id'])) throwError("Empty id");
if(empty($_REQUEST['transaction_status'])) throwError("Empty status");

$transaction_id = $_REQUEST['transaction_id'];
$transaction_status = $_REQUEST['transaction_status'];

$array = array(
  "transaction_id"=>$transaction_id,
	"transaction_status" => $transaction_status	
);

$result = $obj->updateStatus($array);

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