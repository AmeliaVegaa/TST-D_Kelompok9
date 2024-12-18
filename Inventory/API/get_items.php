<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['inventory'])) {
    echo json_encode($_SESSION['inventory']);
} else {
    echo json_encode([]);
}
