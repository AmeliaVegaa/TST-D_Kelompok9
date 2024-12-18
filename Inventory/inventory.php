<?php
// Mengaktifkan error reporting untuk debug
ini_set("display_errors", 1);
error_reporting(E_ALL);

// Data untuk menyimpan item
$items = [];

// Fungsi untuk menambah item
function addItem($itemName, $stock)
{
    global $items;

    $items[] = [
        'itemName' => $itemName,
        'stock' => $stock
    ];

    return ["status" => "Item '$itemName' berhasil ditambahkan."];
}

// Fungsi untuk mendapatkan item dan status stok
function getItem($itemName)
{
    global $items;

    foreach ($items as $item) {
        if ($item['itemName'] == $itemName) {
            $status = $item['stock'] < 5 ? "Stok rendah" : "Tersedia";
            return [
                'itemName' => $item['itemName'],
                'stock' => $item['stock'],
                'status' => $status
            ];
        }
    }

    return ["status" => "Item tidak ditemukan."];
}

// Membuat server SOAP
$server = new SoapServer("inventory.wsdl");

// Menambahkan fungsi-fungsi yang akan dipanggil oleh SOAP
$server->addFunction("addItem");
$server->addFunction("getItem");

// Menjalankan server SOAP
$server->handle();
