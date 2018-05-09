<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Category
 * getByCategoryCode
 */

$perm = 2;

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

if(empty($_REQUEST['category_code'])) throwError("Empty Code");

$id = $_REQUEST['category_code'];

$obj = new AllWet\Category($mysqli);

$data = $obj->getByCode($id);


if(empty($data)){
    $data = json_encode(array());
} else {
    $data = json_encode($data);
}

echo $data;

?>