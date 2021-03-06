<?php
/*
All Wet
2018

Admin
Process
*/

// Start session
session_start();

// Include Keys
require_once("../../_system/keys.php");

// Include DB
require_once("../../_system/db.php");

// Include Required Class
require_once("../../class/AllWet/Admin.class.php");

$obj = new AllWet\Admin($mysqli);

if(empty($_POST['username'])) die("Username cannot be empty");
if(empty($_POST['password'])) die("Password cannot be empty");

$admin_username = $_POST['username'];
$admin_password = $_POST['password'];

$sign_arr = array(
    "admin_username"=>$admin_username,
    "admin_password"=>$admin_password
);

if($obj->verifySignIn($sign_arr) === True){
  
  $admin_data = $obj->getByUsername($admin_username);
  
  $_SESSION['account_type'] = "admin";
  $_SESSION['logged_in'] = True;
  $_SESSION['admin_id'] = $admin_data['admin_id'];
  $_SESSION['admin_username'] = $admin_data['admin_username'];
  
  header("Content-Type: application/json");
  
  echo json_encode($admin_data);
  
} else {
  die("You entered a wrong username or password");
}
?>