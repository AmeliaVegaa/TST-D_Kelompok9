<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_item'])) {
    // Memanggil SOAP client untuk menambahkan item ke inventory
    $client = new SoapClient(null, [
        'location' => 'http://localhost/integrasi/sistem_inventory/inventory.php',
        'uri' => 'http://localhost/integrasi/sistem_inventory/inventory.php',
        'soap_version' => SOAP_1_2
    ]);

    $response = $client->addItem($_POST['item_id'], $_POST['item_name'], $_POST['stock']);
    echo $response['status'];
}

// Menampilkan daftar item dari session
?>

<h2>Tambah Item Inventory</h2>
<form method="POST">
    <input type="text" name="item_id" placeholder="Item ID" required><br>
    <input type="text" name="item_name" placeholder="Item Name" required><br>
    <input type="number" name="stock" placeholder="Stock" required><br>
    <button type="submit" name="add_item">Add Item</button>
</form>

<h2>Inventory List</h2>
<ul>
    <?php
    // Menampilkan semua item yang ada dalam session inventory
    if (isset($_SESSION['inventory']) && count($_SESSION['inventory']) > 0) {
        foreach ($_SESSION['inventory'] as $itemId => $item) {
            echo "<li>Item ID: $itemId, Name: {$item['name']}, Stock: {$item['stock']}</li>";
        }
    } else {
        echo "<li>No items in inventory</li>";
    }
    ?>
</ul>
