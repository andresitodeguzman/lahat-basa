<?php
/**
 * All wet
 * 2018
 * 
 * _secure
 * 
 *
 * $perm
 * 1 - Public Not Logged In
 * 2 - All Logged In
 * 3 - Customer Only
 * 4 - Admin and Employee
 * 5 - Admin Only
 * 6 - Employee Only
 * 7 - Both Logged In and Not
*/

session_start();

header('Content-Type: application/json');

$unauth = json_encode(array("code"=>"400", "message"=>"Unathorized Access"));

$account_type = "";
if(!empty($_SESSION['account_type'])) $account_type = $_SESSION['account_type'];
if(empty($perm)) $perm = 1;


if(empty($_SESSION['logged_in'])){ $perm = 1; }

switch($perm){
  case 1:
    if(!isset($_SESSION['logged_in'])) die($unauth);
    break;
    
  case 2:
    if(empty($account_type)) die($unauth);
    break;
    
  case 3:
    if($account_type !== 'customer') die($unauth);
    break;
    
  case 4:
    if($account_type !== 'admin'){
     if($account_type !== 'employee'){
      die($unauth); 
     }
    }
    break;

  case 5:
    if($account_type !== 'admin') die($unauth);
    break;
    
  case 6:
    if($account_type !== 'employee') die($unauth);
    break;
  case 7:
    $a = 1;
    break;
    
  default:
    die($unauth);
    break;
}

?>