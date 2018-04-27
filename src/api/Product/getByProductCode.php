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

if(empty($_REQUEST['product_code'])) throwError("Empty Product Code");

$product_code = $_REQUEST['product_code'];

$data = $obj->getByProductCode($product_code);

if(empty($data)){
    $data = json_encode(array());
} else {
    $data = json_encode($data);
}

echo $data;

?>