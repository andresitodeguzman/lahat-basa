<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Employee
 * getByUsername
 */

$perm = 4;

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

if(empty($_REQUEST['employee_id'])) throwError("Empty ID");
if(empty($_REQUEST['employee_username'])) throwError("Empty Username");
if(empty($_REQUEST['employee_password'])) throwError("Empty Password");

$employee_id = (Integer) $_REQUEST['employee_id'];
$employee_username = (String) $_REQUEST['employee_username'];
$employee_password = (String) $_REQUEST['employee_password'];

$obj = new AllWet\Employee($mysqli);

$arr = array(
  "employee_id"=>$employee_id,
  "employee_username"=>$employee_username,
  "employee_password"=>$employee_password
);

$data = $obj->getByUsername($employee_username);


if(empty($data)){
    $data = json_encode(array());
} else {
    $data = json_encode($data);
}

echo $data;

?>