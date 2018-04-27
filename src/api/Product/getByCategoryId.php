<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Product
 * getByCategoryId
 */
require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$_SESSION['logged_in'] = True;

$obj = new AllWet\Product($mysqli);
$cat = new AllWet\Category($mysqli);

if(empty($_REQUEST['category_id'])) throwError("Empty Category id");

$category_id = $_REQUEST['category_id'];

$data = $obj->getByCategoryId($category_id);

if(empty($data)){
    $data = json_encode(array());
} else {
    $data = json_encode($data);
}
echo $data;

?>