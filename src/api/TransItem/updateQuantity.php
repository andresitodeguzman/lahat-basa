<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * transitem
 * updateQuantity
 */

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\TransItem($mysqli);

if(empty($_REQUEST['transitem_id'])) throwError("Empty transitem_id");
if(empty($_REQUEST['transitem_quantity'])) throwError("Empty transitem_quatity");

$transitem_id = $_REQUEST['transitem_id'];
$transitem_quantity = $_REQUEST['transitem_quantity'];

$array = array(
	"transitem_id" => $transitem_id,
	"transitem_quantity" => $transitem_quantity
);

$result = $obj->updateQuantity($array);

if($result == True){
	$res = array(
		"code" => "200",
		"message" => "Successfully Edited"
	);
} else {
	$res = array(
		"code" => "400",
		"message" => $result
	);
}

echo(json_encode($res));

?>