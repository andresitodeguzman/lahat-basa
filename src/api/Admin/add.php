<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Admin
 * add
 */

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Admin($mysqli);

if(empty($_REQUEST['admin_name'])) throwError("Empty name");
if(empty($_REQUEST['admin_username'])) throwError("Empty username");
if(empty($_REQUEST['admin_password'])) throwError("Empty password");
if(empty($_REQUEST['admin_image'])) throwError("Empty image");


$admin_name = $_REQUEST['admin_name'];
$admin_username = $_REQUEST['admin_username'];
$admin_password = $_REQUEST['admin_password'];
$admin_image = $_REQUEST['admin_image'];

$array = array(

	"admin_name" => $admin_name,
	"admin_username" => $admin_username,
	"admin_password" => $admin_password,
	"admin_image" => $admin_image
);

$result = $obj->add($array);

if($result == True){
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