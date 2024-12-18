<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['messages'])) {
    $_SESSION['messages'] = [];
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["status" => "error", "message" => "No data received"]);
    exit;
}

if (!isset($data['message']) || empty(trim($data['message']))) {
    echo json_encode(["status" => "error", "message" => "Message content missing"]);
    exit;
}

$message = htmlspecialchars(trim($data['message']));
$user = $_SESSION['username'] ?? 'Admin';
$_SESSION['messages'][] = [
    'user' => $user,
    'message' => $message
];

echo json_encode(["status" => "success", "message" => "Message sent successfully"]);
