<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Transaction
 * add
 */

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Transaction($mysqli);

if(empty($_REQUEST['customer_id'])) throwError("Empty customer id");
if(empty($_REQUEST['transaction_count'])) throwError("Empty count");
if(empty($_REQUEST['transaction_price'])) throwError("Empty price");
if(empty($_REQUEST['transaction_payment_method'])) throwError("Empty payment method");
if(empty($_REQUEST['transaction_status'])) throwError("Empty status");
if(empty($_REQUEST['transaction_address'])) throwError("Empty address");

$customer_id = $_REQUEST['customer_id'];
$transaction_count = $_REQUEST['transaction_count'];
$transaction_price = $_REQUEST['transaction_price'];
$transaction_payment_method = $_REQUEST['transaction_payment_method'];
$transaction_status = $_REQUEST['transaction_status'];
$transaction_longitude = "";
$transaction_latitude = "";
if(isset($_REQUEST['transaction_longitude'])) $transaction_longitude = $_REQUEST['transaction_longitude'];
if(isset($_REQUEST['transaction_latitude'])) $transaction_latitude = $_REQUEST['transaction_latitude'];
$transaction_address = $_REQUEST['transaction_address'];


$array = array(
	"customer_id" => $customer_id,
	"transaction_count" => $transaction_count,	
	"transaction_price" => $transaction_price,
	"transaction_payment_method" => $transaction_payment_method,
	"transaction_status" => $transaction_status,
	"transaction_longitude" => $transaction_longitude,
	"transaction_latitude" => $transaction_latitude,
  "transaction_address"=>$transaction_address
);

$result = $obj->add($array);

if($result === False){
	$res = array(
		"code" => "400",
		"message" => $result
	);
} else {
	$res = array(
		"code" => "200",
		"message" => "Successfully Added",
		"transaction_id"=>$result
	);
 }

echo(json_encode($res));

?>