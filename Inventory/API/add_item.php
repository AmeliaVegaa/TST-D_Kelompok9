<?php
session_start();
header('Content-Type: application/json');

// Inisialisasi sesi inventory jika belum ada
if (!isset($_SESSION['inventory'])) {
    $_SESSION['inventory'] = [
        ['name' => 'Laptop A', 'price' => 15000, 'stock' => 5],
        ['name' => 'Monitor B', 'price' => 7000, 'stock' => 2],
        ['name' => 'Mouse C', 'price' => 300, 'stock' => 15],
    ];
}

// Ambil input dari request
$input = json_decode(file_get_contents('php://input'), true);

// Validasi input
if (!isset($input['name']) || !isset($input['price'])) {
    echo json_encode(['status' => 'error', 'message' => 'Item name and price are required']);
    exit;
}

$name = trim($input['name']);
$price = floatval($input['price']);

// Referensi ke inventory dalam sesi
$inventory = &$_SESSION['inventory'];
$itemFound = false;

// Periksa apakah item sudah ada di inventory
foreach ($inventory as &$item) {
    if (strtolower($item['name']) === strtolower($name)) {
        // Jika item ditemukan, tambahkan stok +1
        $item['stock'] += 1;
        $itemFound = true;
        break;
    }
}

// Jika item tidak ditemukan, tambahkan item baru dengan stok 1
if (!$itemFound) {
    $inventory[] = ['name' => $name, 'price' => $price, 'stock' => 1];
}

// Cari stok item yang baru diperbarui/ditambahkan
$updatedItem = null;
foreach ($inventory as $item) {
    if (strtolower($item['name']) === strtolower($name)) {
        $updatedItem = $item;
        break;
    }
}

// Kembalikan notifikasi berdasarkan stok
if ($updatedItem['stock'] < 5) {
    $message = "Notifikasi Stok Rendah: {$updatedItem['name']} (Stok: {$updatedItem['stock']})";
    $status = 'low_stock';
} else {
    $message = "Stok Tersedia: {$updatedItem['name']} = {$updatedItem['stock']}";
    $status = 'available';
}

// Kembalikan respons
echo json_encode([
    'status' => $status,
    'message' => $message,
    'item' => $updatedItem
]);
exit;
?>
