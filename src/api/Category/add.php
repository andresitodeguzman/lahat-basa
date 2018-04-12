<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * category
 * add
 */

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Category($mysqli);

if(empty($_REQUEST['category_name'])) throwError("Empty name");
if(empty($_REQUEST['category_description'])) throwError("Empty description");
if(empty($_REQUEST['category_code'])) throwError("Empty code");

$category_name = $_REQUEST['category_name'];
$category_description = $_REQUEST['category_description'];
$category_code = $_REQUEST['category_code'];

$array = array(	
	"category_name" => $category_name,
	"category_description" => $category_description,
	"category_code" => $category_code
);

$result = $obj->add($array);

if($result){
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