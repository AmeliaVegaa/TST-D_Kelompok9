<?php
session_start();

class PenjualanService
{
    public function addTransaction($transactionId, $itemId, $quantity)
    {
        if (!isset($_SESSION['penjualan'])) {
            $_SESSION['penjualan'] = [];
        }

        if (isset($_SESSION['inventory'][$itemId]) && $_SESSION['inventory'][$itemId]['stock'] >= $quantity) {
            $_SESSION['penjualan'][$transactionId] = [
                'item' => $_SESSION['inventory'][$itemId]['name'],
                'price' => 100,  // Assume a fixed price for simplicity
                'quantity' => $quantity,
                'total' => 100 * $quantity
            ];
            $_SESSION['inventory'][$itemId]['stock'] -= $quantity; // Update stock
            return ['status' => 'Transaction added successfully'];
        } else {
            return ['error' => 'Insufficient stock or item not found'];
        }
    }

    public function getTransactionDetails($transactionId)
    {
        if (isset($_SESSION['penjualan'][$transactionId])) {
            return $_SESSION['penjualan'][$transactionId];
        } else {
            return ['error' => 'Transaction not found'];
        }
    }

    public function getAllItemsForSale()
    {
        return $_SESSION['inventory'] ?? [];
    }
}

$options = [
    'uri' => 'http://localhost/integrasi/sistem_penjualan/penjualan.php',
    'soap_version' => SOAP_1_2
];

$server = new SoapServer(null, $options);
$server->setClass('PenjualanService');
$server->handle();
