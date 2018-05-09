<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Customer
 * getNumberByAccessToken
 */

$perm = 7;

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

if(empty($_REQUEST['customer_access_token'])) throwError("Empty Access Token");

$customer_access_token = (String) $_REQUEST['customer_access_token'];

$obj = new AllWet\Customer($mysqli);

$data = $obj->getNumberByAccessToken($customer_access_token);


if(empty($data)){
    $data = json_encode(array("customer_number"=>""));
} else {
    $data = json_encode(array("customer_number"=>$data));
}

echo $data;

?>