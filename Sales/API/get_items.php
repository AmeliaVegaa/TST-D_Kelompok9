<?php
session_start();
header('Content-Type: application/json');

$inventory = isset($_SESSION['inventory']) ? $_SESSION['inventory'] : [];
echo json_encode($inventory);
