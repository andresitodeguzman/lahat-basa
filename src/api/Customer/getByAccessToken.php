<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Customer
 * getByAccessToken
 */

$perm = 7;

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

if(empty($_REQUEST['customer_access_token'])) throwError("Empty Access Token");

$customer_access_token = (String) $_REQUEST['customer_access_token'];

$obj = new AllWet\Customer($mysqli);

$data = $obj->getByAccessToken($customer_access_token);


if(empty($data)){
    $data = json_encode(array());
} else {
    $data = json_encode($data);
}

echo $data;

?>