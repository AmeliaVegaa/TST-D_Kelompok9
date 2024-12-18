<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['item_index'])) {
        $inventory = $_SESSION['inventory'];
        $item = $inventory[$data['item_index']];

        // Simulasi checkout dengan ID transaksi
        $order = [
            'order_id' => uniqid(),
            'item' => $item,
            'status' => 'processing'
        ];
        $_SESSION['orders'][] = $order;
        echo json_encode(["status" => "success", "message" => "Item successfully checked out", "order_id" => $order['order_id']]);
    } else {
        echo json_encode(["status" => "error", "message" => "Missing item index"]);
    }
}
