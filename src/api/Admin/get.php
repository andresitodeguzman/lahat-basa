<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Admin
 * get
 */

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Admin($mysqli);

if(empty($_REQUEST['admin_id'])) throwError("Empty ID");

$id = $_REQUEST['admin_id'];

$data = $obj->get($id);

if(empty($data)){
    $data = json_encode(array());
} else {
    $data = json_encode($data);
}

echo $data;

?>