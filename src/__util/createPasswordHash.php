<?php
/*
All Wet
2018

_util
createPasswordHash
*/

if(!$_REQUEST['password']) die("Password is Required");

$password = $_REQUEST['password'];

$hashed_pw = password_hash($password, PASSWORD_DEFAULT);

echo $hashed_pw;

?>