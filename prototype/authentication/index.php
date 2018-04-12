<?php
session_start();

require_once("../_system/secrets.php");

require_once("../_class/Account.class.php");
require_once("../_system/config.php");

$account = new Account();

if($account->isLoggedIn() == True){
  header("Location: ../app");
} else {
  header("Location: http://developer.globelabs.com.ph/dialog/oauth?app_id=$app_id");
}
?>