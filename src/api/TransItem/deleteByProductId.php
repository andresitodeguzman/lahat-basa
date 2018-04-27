<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * transitem
 * deleteByProductId
 */

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\TransItem($mysqli);

if(empty($_REQUEST['product_id'])) throwError("Empty Product id");

$product_id = $_REQUEST['product_id'];

$result = $obj->deleteByProductId($product_id);

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