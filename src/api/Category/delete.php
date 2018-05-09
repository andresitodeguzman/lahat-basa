<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * category
 * delete
 */

$perm = 5;

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Category($mysqli);

if(empty($_REQUEST['category_id'])) throwError("Empty id");

$category_id = $_REQUEST['category_id'];

$result = (Int) $obj->delete($category_id);

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