<?php
session_start();
header('Content-Type: application/json');

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $orders = isset($_SESSION['orders']) ? $_SESSION['orders'] : [];

    foreach ($orders as $order) {
        if ($order['order_id'] == $order_id) {
            echo json_encode($order);
            return;
        }
    }

    echo json_encode(["status" => "error", "message" => "Order not found"]);
} else {
    echo json_encode(["status" => "error", "message" => "Missing order ID"]);
}
