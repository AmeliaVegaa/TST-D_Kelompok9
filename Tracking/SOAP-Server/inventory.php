<?php
class Inventory {
    public function checkStatus() {
        // Logika untuk mengecek status pengiriman
        $status = [
            'hasChanged' => true, // Simulasi perubahan status
            'latest' => 'Barang sedang dalam perjalanan',
        ];

        return $status;
    }
}
?>