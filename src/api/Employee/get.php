<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Employee
 * get
 */

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

if(empty($_REQUEST['employee_id'])) throwError("Empty id");

$id = $_REQUEST['employee_id'];

$obj = new AllWet\Employee($mysqli);

$data = $obj->get($id);


if(empty($data)){
    $data = json_encode(array());
} else {
    $data = json_encode($data);
}

echo $data;

?>