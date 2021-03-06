<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Admin
 * update
 */

$perm = 5;

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Admin($mysqli);

if(empty($_REQUEST['admin_id'])) throwError("Empty id");
if(empty($_REQUEST['admin_name'])) throwError("Empty name");
if(empty($_REQUEST['admin_username'])) throwError("Empty username");
if(empty($_REQUEST['admin_image'])) $admin_image = "";
if(empty($_REQUEST['admin_password'])) $admin_password="";
$admin_id = $_REQUEST['admin_id'];
$admin_name = $_REQUEST['admin_name'];
$admin_username = $_REQUEST['admin_username'];
if(!empty($_REQUEST['admin_image'])) $admin_image = $_REQUEST['admin_image'];
if(!empty($_REQUEST['admin_password'])) $admin_password=$_REQUEST['admin_password'];

$array = array(
	"admin_id" => $admin_id,
	"admin_name" => $admin_name,
	"admin_username" => $admin_username,
	"admin_image" => $admin_image,
	"admin_password"=>$admin_password
);

$result = $obj->update($array);

if($result){
	$res = array(
		"code" => "200",
		"message" => "Successfully updated"
	);
} else {
	$res = array(
		"code" => "400",
		"message" => "Failed to update" 
	);
}

echo(json_encode($res));

?>