<?php
/**
 * All wet
 * 2018
 * 
 * _secure
 */

session_start();

if(empty($_SESSION['logged_in'])){
    header('Content-Type: application/json');
    $ret = json_encode(array("code"=>"400", "Not Logged In"));
    die($ret);
}
?>