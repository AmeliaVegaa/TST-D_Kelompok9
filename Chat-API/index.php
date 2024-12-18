<?php
include 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {

    echo json_encode([
        "status" => "success",
        "data" => $_SESSION['chats']
    ]);
} elseif ($method === 'POST') {

    $input = json_decode(file_get_contents("php://input"), true);

    if (isset($input['sender'], $input['message'])) {
        $message = [
            "sender" => htmlspecialchars($input['sender']),
            "message" => htmlspecialchars($input['message']),
            "timestamp" => date("Y-m-d H:i:s")
        ];

        $_SESSION['chats'][] = $message;

        echo json_encode([
            "status" => "success",
            "message" => "Pesan berhasil dikirim",
            "data" => $message
        ]);
    } else {
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => "Sender dan message wajib diisi."
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        "status" => "error",
        "message" => "Metode tidak diizinkan."
    ]);
}
