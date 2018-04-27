<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * Admin
 * verifySignIn
 */

require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Admin($mysqli);

if(empty($_REQUEST['admin_username'])) throwError("Empty username");
if(empty($_REQUEST['admin_password'])) throwError("Empty password");

$admin_username = $_REQUEST['admin_username'];
$admin_password = $_REQUEST['admin_password'];

$arr = array(
  "admin_username"=>$admin_username,
  "admin_password"=>$admin_password
);

$result = $obj->verifySignIn($arr);

if($result === True){
  $result = array(
    "code"=>"200",
    "message"=>True
  );
} else {
  $result = array(
     "code"=>"500",
     "message"=>$result
  );
}
echo json_encode($result);
?>