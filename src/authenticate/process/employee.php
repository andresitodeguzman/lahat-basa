<?php
/*
All Wet
2018

Employee
Process
*/

// Start session
session_start();

// Include Keys
require_once("../../_system/keys.php");

// Include DB
require_once("../../_system/db.php");

// Include Required Class
require_once("../../class/AllWet/Employee.class.php");

$obj = new AllWet\Employee($mysqli);

if(empty($_POST['username'])) die("Username cannot be empty");
if(empty($_POST['password'])) die("Password cannot be empty");

$employee_username = $_POST['username'];
$employee_password = $_POST['password'];

$sign_arr = array(
    "employee_username"=>$employee_username,
    "employee_password"=>$employee_password
);

if($obj->verifySignIn($sign_arr) === True){
  
  $employee_data = $obj->getByUsername($employee_username);
  
  $_SESSION['account_type'] = "employee";
  $_SESSION['logged_in'] = True;
  $_SESSION['employee_id'] = $employee_data['employee_id'];
  $_SESSION['employee_username'] = $admin_data['employee_username'];
  
  header("Content-Type: application/json");
  
  echo json_encode($employee_data);
  
} else {
  die("You entered a wrong username or password");
}
?>