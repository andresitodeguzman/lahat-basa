<?php
require_once("../../_system/keys.php");
require_once("../_secure.php");
require_once("../_boot.php");

$obj = new AllWet\Product($mysqli);

echo(json_encode($obj->getAll()));
?>