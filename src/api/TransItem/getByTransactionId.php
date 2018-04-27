<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Transitem
 * getByTransactionId
 */

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\TransItem($mysqli);

if(empty($_REQUEST['transaction_id'])) throwError("Empty Transaction ID");

$id = $_REQUEST['transaction_id'];

$data = $obj->getByTransactionId($id);

if(empty($data)){
    $data = json_encode(array());
} else {
    $data = json_encode($data);
}

echo $data;

?>