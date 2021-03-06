<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Employee
 * add
 */

$perm = 5;

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Employee($mysqli);

if(!isset($_REQUEST['employee_name'])) throwError("Empty name");
if(!isset($_REQUEST['employee_username'])) throwError("Empty username");
if(!isset($_REQUEST['employee_password'])) throwError("Empty password");

$employee_name = $_REQUEST['employee_name'];
$employee_username = $_REQUEST['employee_username'];
$employee_password = $_REQUEST['employee_password'];
$employee_image = "";
if(isset($_REQUEST['employee_image'])) $employee_image = $_REQUEST['employee_image'];
$employee_salary = "";
if(isset($_REQUEST['employee_salary'])) $employee_salary = $_REQUEST['employee_salary'];

$array = array(

	"employee_name" => $employee_name,
	"employee_username" => $employee_username,
	"employee_password" => $employee_password,
	"employee_image" => $employee_image,
	"employee_salary" => $employee_salary
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