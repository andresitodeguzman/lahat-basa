<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Customer
 * update
 */

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Customer($mysqli);

if(empty($_REQUEST['customer_id'])) throwError("Empty id");
if(empty($_REQUEST['customer_name'])) throwError("Empty name");
if(empty($_REQUEST['customer_address'])) throwError("Empty address");

$customer_id = $_REQUEST['customer_id'];
$customer_name = $_REQUEST['customer_name'];
$customer_address = $_REQUEST['customer_address'];

$array = array(
	"customer_id" => $customer_id,
	"customer_name" => $customer_name,
	"customer_address" => $customer_address
);

$result = $obj->updateBasic($array);

if($result){
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