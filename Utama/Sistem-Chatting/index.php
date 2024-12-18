<?php
// Mengirim pesan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_chat'])) {
    $message = $_POST['message'];
    $url = 'http://localhost/integrasi/sistem_chatting/chat.php';
    $data = json_encode(['message' => $message]);

    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => $data
        ]
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    echo 'Message sent: ' . $result;
} else {
    // Menampilkan pesan yang ada
    $url = 'http://localhost/integrasi/sistem_chatting/chat.php';
    $result = file_get_contents($url);
    $messages = json_decode($result, true);
    foreach ($messages['messages'] as $message) {
        echo $message . '<br>';
    }
}
?>

<h2>Send Chat</h2>
<form method="POST">
    <input type="text" name="message" placeholder="Enter your message" required><br>
    <button type="submit" name="send_chat">Send</button>
</form>

<h2>Get Chat</h2>
<button onclick="location.reload()">Refresh Chat</button>