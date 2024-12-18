<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['messages'])) {
    $_SESSION['messages'] = [];
}
echo json_encode($_SESSION['messages']);
