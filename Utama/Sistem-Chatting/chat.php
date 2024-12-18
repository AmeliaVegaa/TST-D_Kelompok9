<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    file_put_contents('chat.txt', $data['message'] . PHP_EOL, FILE_APPEND);
    echo json_encode(['status' => 'Message sent']);
} else {

    $messages = file('chat.txt');
    echo json_encode(['messages' => $messages]);
}
