<?php
require('Inventory.php');

$server = new SoapServer("inventory.wsdl");
$server->setClass("Inventory");

$server->handle();
