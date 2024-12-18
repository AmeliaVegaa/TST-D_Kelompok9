<?php
// Menyertakan file SOAPServer
class InventoryService
{
    private $inventory = [];

    // Menambahkan item baru
    public function addItem($name, $stock)
    {
        $this->inventory[] = [
            'name' => $name,
            'stock' => $stock
        ];
        return "Item '$name' berhasil ditambahkan!";
    }

    // Mendapatkan daftar item
    public function getItems()
    {
        $result = [];
        foreach ($this->inventory as $item) {
            $status = $item['stock'] < 5 ? 'Stok rendah' : 'Tersedia';
            $result[] = [
                'name' => $item['name'],
                'stock' => $item['stock'],
                'status' => $status
            ];
        }
        return $result;
    }
}

// Membuat instance SOAPServer
$server = new SoapServer('inventory.wsdl');
$server->setClass('InventoryService');
$server->handle();
