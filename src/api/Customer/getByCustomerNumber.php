<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Customer
 * get
 */

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

if(empty($_REQUEST['customer_number'])) throwError("Empty number");

$customer_number = (String) $_REQUEST['customer_number'];

$obj = new AllWet\Customer($mysqli);

$data = $obj->getByCustomerNumber($customer_number);


if(empty($data)){
    $data = json_encode(array());
} else {
    $data = json_encode($data);
}

echo $data;

?>