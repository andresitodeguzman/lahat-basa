<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Product
 * add
 */

$perm = 5;
 
require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Product($mysqli);

if(empty($_REQUEST['product_code'])) throwError("Empty code");
if(empty($_REQUEST['product_name'])) throwError("Empty name");
if(empty($_REQUEST['product_description'])) throwError("Empty description");
if(empty($_REQUEST['product_price'])) throwError("Empty price");
if(empty($_REQUEST['product_available'])) throwError("Empty availability");

$product_code = $_REQUEST['product_code'];
$product_name = $_REQUEST['product_name'];
$product_description = $_REQUEST['product_description'];
$category_id = "";
if(isset($_REQUEST['category_id	'])) $category_id = $_REQUEST['category_id'];
$product_price = $_REQUEST['product_price'];
$product_available = $_REQUEST['product_available'];
$product_image = "";
if(isset($_REQUEST['product_image'])) $product_image = $_REQUEST['product_image'];

$array = array(
	"product_code" => $product_code,
	"product_name" => $product_name,
	"product_description" => $product_description,
	"category_id" => $category_id,
	"product_price" => $product_price,
	"product_available" => $product_available,
	"product_image" => $product_image
);

$result = $obj->add($array);

if($result === True){
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