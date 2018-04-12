<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * transitem
 * delete
 */

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\TransItem($mysqli);

if(empty($_REQUEST['transitem_id'])) throwError("Empty id");

$transitem_id = $_REQUEST['transitem_id'];

$result = $obj->delete($array);

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