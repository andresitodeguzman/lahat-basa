<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Category
 * get
 */

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

if(empty($_REQUEST['category_id'])) throwError("Empty id");

$id = $_REQUEST['category_id'];

$obj = new AllWet\Category($mysqli);

$data = $obj->get($id);


if(empty($data)){
    $data = json_encode(array());
} else {
    $data = json_encode($data);
}

echo $data;

?>