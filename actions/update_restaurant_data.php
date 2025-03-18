<?php
session_start();
include('../includes/db_connect.php'); // Ganti dengan file koneksi database Anda
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'Anda belum login']);
    exit;
}

$restaurant_id = $_POST['restaurant_id'] ?? null;
$restaurant_name = $_POST['restaurant_name'] ?? null;
$address = $_POST['address'] ?? null;
$phone = $_POST['phone'] ?? null;
$description = $_POST['description'] ?? null;

if ($restaurant_id === null || $restaurant_name === null || $address === null || $phone === null || $description === null) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

$sql = "UPDATE restaurant SET restaurant_name = ?, address = ?, phone = ?, description = ? WHERE restaurant_id = ?";
$stmt = $koneksi->prepare($sql);
if (!$stmt) {
    error_log("Failed to prepare statement: " . $koneksi->error);
    echo json_encode(['success' => false, 'message' => 'Database error']);
    exit;
}
$stmt->bind_param('ssssi', $restaurant_name, $address, $phone, $description, $restaurant_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'restaurant_name' => htmlspecialchars($restaurant_name)]);
} else {
    error_log("Database update failed: " . $stmt->error);
    echo json_encode(['success' => false, 'message' => 'Database update failed']);
}
?>