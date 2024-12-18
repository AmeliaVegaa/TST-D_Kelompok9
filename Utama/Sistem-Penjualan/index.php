<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_transaction'])) {
    $client = new SoapClient(null, [
        'location' => 'http://localhost/integrasi/sistem_penjualan/penjualan.php',
        'uri' => 'http://localhost/integrasi/sistem_penjualan/penjualan.php',
        'soap_version' => SOAP_1_2
    ]);

    $response = $client->addTransaction($_POST['transaction_id'], $_POST['item_id'], $_POST['quantity']);
    echo $response['status'];
}

?>

<h2>Checkout Item</h2>
<form method="POST">
    <input type="text" name="transaction_id" placeholder="Transaction ID" required><br>
    <select name="item_id">
        <?php
        if (isset($_SESSION['inventory'])) {
            foreach ($_SESSION['inventory'] as $itemId => $item) {
                echo "<option value=\"$itemId\">{$item['name']} (Stock: {$item['stock']})</option>";
            }
        }
        ?>
    </select><br>
    <input type="number" name="quantity" placeholder="Quantity" required><br>
    <button type="submit" name="add_transaction">Checkout</button>
</form>

<h2>All Transactions</h2>
<ul>
    <?php
    if (isset($_SESSION['penjualan'])) {
        foreach ($_SESSION['penjualan'] as $transactionId => $transaction) {
            echo "<li>Transaction ID: $transactionId, Item: {$transaction['item']}, Quantity: {$transaction['quantity']}, Total: {$transaction['total']}</li>";
        }
    }
    ?>
</ul>
