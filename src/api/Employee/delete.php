<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * employee
 * delete
 */

$perm = 5;

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Employee($mysqli);

if(empty($_REQUEST['employee_id'])) throwError("Empty id");

$employee_id = (Int) $_REQUEST['employee_id'];

$result = $obj->delete($employee_id);

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