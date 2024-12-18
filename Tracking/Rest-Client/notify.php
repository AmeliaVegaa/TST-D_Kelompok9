<?php
$data = json_decode(file_get_contents("php://input"), true);

$trackingId = $data['trackingId'];
$newStatus = $data['newStatus'];

file_put_contents("status_log.txt", "Tracking ID: $trackingId - Status: $newStatus\n", FILE_APPEND);

echo json_encode(["message" => "Notification sent successfully."]);
?>
