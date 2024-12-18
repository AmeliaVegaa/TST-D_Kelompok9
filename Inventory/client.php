<?php
// Menyambung ke SOAP Server
$client = new SoapClient('http://localhost/integrasi/inventory/inventory.wsdl');

// Menambahkan item
$response = $client->addItem('Item A', 10);
echo $response;

// Mendapatkan daftar item
$items = $client->getItems();
echo "<pre>";
print_r($items);
echo "</pre>";
