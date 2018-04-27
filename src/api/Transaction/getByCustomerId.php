<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Transaction
 * getByCustomerId
 */

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Transaction($mysqli);

if(empty($_REQUEST['customer_id'])) throwError("Empty Customer id");

$id = $_REQUEST['customer_id'];

$data = $obj->getByCustomerId($id);


if(empty($data)){
    $data = json_encode(array());
} else {
    $data = json_encode($data);
}

echo $data;

?>