<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Product
 * get
 */
 
require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Product($mysqli);

if(empty($_REQUEST['product_id'])) throwError("Empty id");

$id = $_REQUEST['product_id'];

$data = $obj->get($id);

if(empty($data)){
    $data = json_encode(array());
} else {
    $data = json_encode($data);
}

echo $data;

?>