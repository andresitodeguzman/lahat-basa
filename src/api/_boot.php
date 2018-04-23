<?php
/**
 * All Wet
 * 2018
 * 
 * API
 * _boot
 */

/*
spl_autoload_register(function($class_name){
    include('../../class/'.$class_name.'.class.php');
});*/

require_once("../../class/AllWet/Admin.class.php");
require_once("../../class/AllWet/Category.class.php");
require_once("../../class/AllWet/Customer.class.php");
require_once("../../class/AllWet/Employee.class.php");
require_once("../../class/AllWet/Product.class.php");
require_once("../../class/AllWet/Transaction.class.php");
require_once("../../class/AllWet/TransItem.class.php");


$time_zone = "Asia/Manila";
date_default_timezone_set($time_zone);

$mysqli = new mysqli($sql_host,$sql_username,$sql_password,$sql_database);

header('Content-Type: application/json');

function throwError($msg){
	if(empty($msg)) $msg = "An error happened";
	$error = array(
		"code"=>"500",
		"message"=>$msg
	);
	die(json_encode($error));
}

?>