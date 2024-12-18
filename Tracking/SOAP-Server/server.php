ini_set('display_errors', 1);
error_reporting(E_ALL);

<?php
class TrackingService {
    public function getStatusUpdate($request) {
        return [
            'status' => 'In Transit',
            'lastUpdated' => date('c')
        ];
    }
}

$server = new SoapServer("inventory.wsdl");
$server->setClass('TrackingService');
$server->handle();
?>
