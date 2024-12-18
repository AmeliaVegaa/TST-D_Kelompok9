<?php
session_start();

class InventoryService
{
    public function addItem($itemId, $itemName, $stock)
    {
        if (!isset($_SESSION['inventory'])) {
            $_SESSION['inventory'] = [];
        }
        $_SESSION['inventory'][$itemId] = ['name' => $itemName, 'stock' => $stock];
        return ['status' => 'Item added successfully'];
    }

    public function getItemDetails($itemId)
    {
        if (isset($_SESSION['inventory'][$itemId])) {
            return $_SESSION['inventory'][$itemId];
        } else {
            return ['error' => 'Item not found'];
        }
    }

    public function getAllItems()
    {
        return $_SESSION['inventory'] ?? [];
    }
}

$options = [
    'uri' => 'http://localhost/integrasi/sistem_inventory/inventory.php',
    'soap_version' => SOAP_1_2
];

$server = new SoapServer(null, $options);
$server->setClass('InventoryService');
$server->handle();
