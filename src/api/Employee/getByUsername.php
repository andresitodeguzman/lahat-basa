<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Employee
 * getByUsername
 */

$perm = 7;

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

if(empty($_REQUEST['employee_username'])) throwError("Empty Username");

$employee_username = (String) $_REQUEST['employee_username'];

$obj = new AllWet\Employee($mysqli);

$data = $obj->getByUsername($employee_username);


if(empty($data)){
    $data = json_encode(array());
} else {
    $data = json_encode($data);
}

echo $data;

?>