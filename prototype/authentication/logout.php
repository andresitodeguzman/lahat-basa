<?php
session_start();

require_once("../_class/Account.class.php");

$account = new Account();

$account->destroySession();

header("Location: ../");
?>