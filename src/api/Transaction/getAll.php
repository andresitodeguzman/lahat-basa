<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Transaction
 * getAll
 */

$perm = 4;

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Transaction($mysqli);
$customer = new AllWet\Customer($mysqli);

$data = $obj->getAll();

if(empty($data)){
    $data = json_encode(array());
} else {
    $data = json_encode($data);
}

echo $data;
?>