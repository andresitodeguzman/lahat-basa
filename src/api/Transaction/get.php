<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Transaction
 * get
 */

$perm = 2;

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Transaction($mysqli);

if(empty($_REQUEST['transaction_id'])) throwError("Empty id");

$id = $_REQUEST['transaction_id'];

$data = $obj->get($id);


if(empty($data)){
    $data = json_encode(array());
} else {
    $data = array_reverse(json_encode($data));
}

echo $data;

?>