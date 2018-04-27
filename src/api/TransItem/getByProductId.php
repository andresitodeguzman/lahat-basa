<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Transitem
 * getByProductId
 */

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\TransItem($mysqli);

if(empty($_REQUEST['product_id'])) throwError("Empty Product ID");

$id = $_REQUEST['product_id'];

$data = $obj->getByProductId($id);

if(empty($data)){
    $data = json_encode(array());
} else {
    $data = json_encode($data);
}

echo $data;

?>