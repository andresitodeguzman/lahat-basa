<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Product
 * updateCategoryId
 */
 
require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Product($mysqli);

if(empty($_REQUEST['product_id'])) throwError("Empty id");
if(empty($_REQUEST['category_id'])) throwError("Empty Category");

$product_id = $_REQUEST['product_id'];
$category_id = $_REQUEST['category_id'];

$array = array(
	"product_id" => $product_id,
	"category_id" => $category_id,
);

$result = $obj->updateCategoryId($array);

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