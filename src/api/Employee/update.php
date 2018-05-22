<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Employee
 * add
 */

$perm = 4;

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Employee($mysqli);

if(empty($_REQUEST['employee_id'])) throwError("Empty id");
if(empty($_REQUEST['employee_name'])) throwError("Empty name");
if(empty($_REQUEST['employee_username'])) throwError("Empty username");
if(empty($_REQUEST['employee_image'])) $employee_image = "";

$employee_id = $_REQUEST['employee_id'];
$employee_name = $_REQUEST['employee_name'];
$employee_username = $_REQUEST['employee_username'];
$employee_image = $_REQUEST['employee_image'];
$employee_salary = "";
if(isset($_REQUEST['employee_salary'])) $employee_salary = $_REQUEST['employee_salary'];

$array = array(
	"employee_id" => $employee_id,
	"employee_name" => $employee_name,
	"employee_username" => $employee_username,
	"employee_image" => $employee_image,
	"employee_salary" => $employee_salary
);

$result = $obj->update($array);

if(!empty($_REQUEST['employee_password'])){
  $employee_password = $_REQUEST['employee_password'];
  $array = array(
	"employee_id" => $employee_id,
    "employee_username" => $employee_username,
    "employee_password" => $employee_password
  );
  $result = $obj->updateSignIn($array);
}

if($result){
	$res = array(
		"code" => "200",
		"message" => "Successfully Updated"
	);
} else {
	$res = array(
		"code" => "400",
		"message" => "Fail to update"
	);
}

echo(json_encode($res));

?>