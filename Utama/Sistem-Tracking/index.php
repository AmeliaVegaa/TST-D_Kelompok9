<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['transaction_id'])) {
    $client = new SoapClient(null, [
        'location' => 'http://localhost/integrasi/sistem_tracking/tracking.php',
        'uri' => 'http://localhost/integrasi/sistem_tracking/tracking.php',
        'soap_version' => SOAP_1_2
    ]);

    $response = $client->trackTransaction($_GET['transaction_id']);
    if (isset($response['status'])) {
        echo 'Status: ' . $response['status'] . '<br>';
        echo 'Location: ' . $response['location'];
    } else {
        echo $response['error'];
    }
}
?>

<h2>Track Transaction</h2>
<form method="GET">
    <input type="number" name="transaction_id" placeholder="Transaction ID" required><br>
    <button type="submit">Track</button>
</form>
