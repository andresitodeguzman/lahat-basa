<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Product
 * delete
 */

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Product($mysqli);

if(empty($_REQUEST['product_id'])) throwError("Empty id");

$product_id = $_REQUEST['product_id'];

$result = $obj->delete($array);

if($result){
	$res = array(
		"code" => "200",
		"message" => "Successfully deleted"
	);
} else {
	$res = array(
		"code" => "400",
		"message" => "Fail to delete"
	);
}

echo(json_encode($res));

?>