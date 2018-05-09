<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Customer
 * update
 */

$perm = 5;

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Customer($mysqli);

if(empty($_REQUEST['customer_id'])) throwError("Empty id");
if(empty($_REQUEST['customer_number'])) throwError("Empty number");
if(empty($_REQUEST['customer_name'])) throwError("Empty name");
if(empty($_REQUEST['customer_longitude'])) throwError("Empty longitude");
if(empty($_REQUEST['customer_latitude'])) throwError("Empty latitude");
if(empty($_REQUEST['customer_address'])) throwError("Empty address");
if(empty($_REQUEST['customer_image'])) throwError("Empty image");
if(empty($_REQUEST['customer_access_token'])) throwError("Empty access_token");

$customer_id = $_REQUEST['customer_id'];
$customer_number = $_REQUEST['customer_number'];
$customer_name = $_REQUEST['customer_name'];
$customer_longitude = $_REQUEST['customer_longitude'];
$customer_latitude = $_REQUEST['customer_latitude'];
$customer_address = $_REQUEST['customer_address'];
$customer_image = $_REQUEST['customer_image'];
$customer_access_token = $_REQUEST['customer_access_token'];

$array = array(
	"customer_id" => $customer_id,
	"customer_number" => $customer_number,
	"customer_name" => $customer_name,
	"customer_longitude" => $customer_longitude,
	"customer_latitude" => $customer_latitude,
	"customer_address" => $customer_address,	
	"customer_image" => $customer_image,
	"customer_available" => $customer_access_token
);

$result = $obj->update($array);

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