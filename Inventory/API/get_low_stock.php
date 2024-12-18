<?php
header('Content-Type: application/json');

// Simulasi data stok barang dalam bentuk array
$items = [
    ['name' => 'Laptop A', 'stock' => 5],
    ['name' => 'Monitor B', 'stock' => 2],
    ['name' => 'Mouse C', 'stock' => 15],
    ['name' => 'Keyboard D', 'stock' => 3],
    ['name' => 'Printer E', 'stock' => 1]
];

// Tentukan batas stok rendah, misalnya kurang dari 5
$low_stock_limit = 5;

// Filter barang dengan stok rendah
$low_stock_items = array_filter($items, function($item) use ($low_stock_limit) {
    return $item['stock'] < $low_stock_limit;
});

// Format response
$response = [
    'low_stock' => array_values($low_stock_items)
];

// Kirim response sebagai JSON
echo json_encode($response);
?>
