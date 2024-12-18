<?php
$client = new SoapClient("http://localhost/trackingApp/soap_server/inventory.wsdl");

$trackingId = "12345";
$response = $client->__soapCall("getStatusUpdate", [
    ['trackingId' => $trackingId]
]);

echo "Status: " . $response->status . "\n";
echo "Last Updated: " . $response->lastUpdated . "\n";
?>
