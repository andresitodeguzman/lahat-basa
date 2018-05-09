<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Employee
 * verifySignIn
 */

$perm = 1;

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Employee($mysqli);

if(empty($_REQUEST['employee_username'])) throwError("Empty username");
if(empty($_REQUEST['employee_password'])) throwError("Empty password");

$employee_username = $_REQUEST['employee_username'];
$employee_password = $_REQUEST['employee_password'];

$arr = array(
  "employee_username"=>$employee_username,
  "employee_password"=>$employee_password
);

$result = $obj->verifySignIn($arr);

if($result === True){
  $result = array(
    "code"=>"200",
    "message"=>True
  );
} else {
  $result = array(
     "code"=>"500",
     "message"=>$result
  );
}
echo json_encode($result);
?>