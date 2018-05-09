<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Admin
 * getByUsername
 */

$perm = 5;

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Admin($mysqli);

if(empty($_REQUEST['admin_username'])) throwError("Empty Username");

$admin_username = $_REQUEST['admin_username'];

$data = $obj->getByUsername($admin_username);

if(empty($data)){
    $data = json_encode(array());
} else {
    $data = json_encode($data);
}

echo $data;

?>