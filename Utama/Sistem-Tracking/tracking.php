<?php
session_start();

class TrackingService
{
    public function trackTransaction($transactionId)
    {
        if (isset($_SESSION['penjualan'][$transactionId])) {
            // Simplified tracking status
            return [
                'status' => 'Shipped',
                'location' => 'Warehouse A'
            ];
        } else {
            return ['error' => 'Transaction not found'];
        }
    }
}

$options = [
    'uri' => 'http://localhost/integrasi/sistem_tracking/tracking.php',
    'soap_version' => SOAP_1_2
];

$server = new SoapServer(null, $options);
$server->setClass('TrackingService');
$server->handle();
