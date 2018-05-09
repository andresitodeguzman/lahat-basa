<?php
/*
All Wet
2018

Authenticate
signInStatus
*/

session_start();

header("Content-Type: application/json");

if(empty($_SESSION['logged_in'])){
	$arr = array(
		"code"=>"400",
		"is_signed_in"=>False,
		"account_type"=>""
	);
	die(json_encode($arr));
}

if(@$_SESSION['logged_in']){
	$account_type = "customer";
	if(@$_SESSION['account_type']) $account_type = $_SESSION['account_type'];

	$arr = array(
		"code"=>"200",
		"is_signed_in"=>True,
		"account_type"=>$account_type
	);

	die(json_encode($arr));
}

?>