<?php
session_start();

require_once("../_class/Account.class.php");
require_once("../_system/secrets.php");

$code = "";

if(empty($_REQUEST['code'])) die("An Error Occured");

if(!empty($_REQUEST['code'])) $code = $_REQUEST['code'];

$account = new Account();

$userData = $account->getAccessTokenPhoneNumber($app_id,$app_secret,$code);

if(empty($userData)) die("An Error Occured");

if(!empty($userData)){

    $access_token = $userData['access_token'];
    $subscriber_number = $userData['subscriber_number'];

    $account->initSession($access_token,$subscriber_number);

    header("Location: ../app");

} 

?>