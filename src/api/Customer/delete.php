<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Customer
 * delete
 */

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Customer($mysqli);

if(empty($_REQUEST['customer_id'])) throwError("Empty id");

$customer_id = $_REQUEST['customer_id'];

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