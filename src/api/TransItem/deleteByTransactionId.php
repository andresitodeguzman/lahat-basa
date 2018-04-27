<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * transitem
 * deleteByTransactionId
 */

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\TransItem($mysqli);

if(empty($_REQUEST['transaction_id'])) throwError("Empty Transaction id");

$transaction_id = $_REQUEST['transaction_id'];

$result = $obj->deleteByTransactionId($transaction_id);

if($result == True){
	$res = array(
		"code" => "200",
		"message" => "Successfully deleted"
	);
} else {
	$res = array(
		"code" => "400",
		"message" => "Failed to delete"
	);
}

echo(json_encode($res));

?>