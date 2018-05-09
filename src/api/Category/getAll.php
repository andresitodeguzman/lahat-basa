<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Category
 * getAll
 */

$perm = 2;

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Category($mysqli);

$data = $obj->getAll();

if(empty($data)){
    $data = json_encode(array());
} else {
    $data = json_encode($data);
}

echo $data;

?>