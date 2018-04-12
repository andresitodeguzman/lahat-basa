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

if(empty($_REQUEST['transaction_date'])) throwError("Empty date");
if(empty($_REQUEST['transaction_time'])) throwError("Empty time");
if(empty($_REQUEST['customer_id'])) throwError("Empty customer id");
if(empty($_REQUEST['transaction_items'])) throwError("Empty items");
if(empty($_REQUEST['transaction_count'])) throwError("Empty count");
if(empty($_REQUEST['transaction_price'])) throwError("Empty price");
if(empty($_REQUEST['transaction_payment_method'])) throwError("Empty payment method");
if(empty($_REQUEST['transaction_status'])) throwError("Empty status");
if(empty($_REQUEST['transaction_longitude'])) throwError("Empty longitude");
if(empty($_REQUEST['transaction_latitude'])) throwError("Empty latitude");
if(empty($_REQUEST['transaction_address'])) throwError("Empty address");

$transaction_date = $_REQUEST['transaction_date'];
$transaction_time = $_REQUEST['transaction_time'];
$customer_id = $_REQUEST['customer_id'];
$transaction_items = $_REQUEST['transaction_items'];
$transaction_count = $_REQUEST['transaction_count'];
$transaction_price = $_REQUEST['transaction_price'];
$transaction_payment_method_token = $_REQUEST['transaction_payment_method'];
$transaction_status = $_REQUEST['transaction_status'];
$transaction_longitude = $_REQUEST['transaction_longitude'];
$transaction_latitude = $_REQUEST['transaction_latitude'];
$transaction_address = $_REQUEST['transaction_address'];


$array = array(
	"transaction_date" => $transaction_date,
	"transaction_time" => $transaction_time,
	"customer_id" => $customer_id,
	"transaction_items" => $transaction_items,	
	"transaction_count" => $transaction_count,	
	"transaction_price" => $transaction_price,
	"transaction_payment_method" => $transaction_payment_method,
	"transaction_status" => $transaction_status,
	"transaction_description" => $transaction_longitude,
	"transaction_latitude" => $transaction_latitude,
	"transaction_price" => $transaction_address	
	
);

$result = $obj->add($array);

if($result){
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