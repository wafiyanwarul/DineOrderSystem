<?php
session_start();
include('../includes/db_connect.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'Anda belum login']);
    exit;
}

$restaurant_id = $_POST['restaurant_id'] ?? null;

if ($restaurant_id === null) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

// Handle file upload
$image_path = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $file_tmp_path = $_FILES['image']['tmp_name'];
    $file_name = basename($_FILES['image']['name']);
    $upload_dir = '../assets/images/upload/';
    $image_path = $upload_dir . $file_name;

    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0777, true)) {
            error_log("Failed to create upload directory");
            echo json_encode(['success' => false, 'message' => 'Failed to create upload directory']);
            exit;
        }
    }

    if (!move_uploaded_file($file_tmp_path, $image_path)) {
        error_log("Failed to move uploaded file from $file_tmp_path to $image_path");
        echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file']);
        exit;
    }

    $image_path = 'assets/images/upload/' . $file_name;

    $sql = "SELECT image FROM restaurant WHERE restaurant_id = ?";
    $stmt = $koneksi->prepare($sql);
    if (!$stmt) {
        error_log("Failed to prepare statement: " . $koneksi->error);
        echo json_encode(['success' => false, 'message' => 'Database error']);
        exit;
    }
    $stmt->bind_param('i', $restaurant_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (!empty($row['image']) && file_exists('../' . $row['image'])) {
            if (!unlink('../' . $row['image'])) {
                error_log("Failed to delete old image: ../" . $row['image']);
            }
        }
    }

    $sql = "UPDATE restaurant SET image = ? WHERE restaurant_id = ?";
    $stmt = $koneksi->prepare($sql);
    if (!$stmt) {
        error_log("Failed to prepare statement: " . $koneksi->error);
        echo json_encode(['success' => false, 'message' => 'Database error']);
        exit;
    }
    $stmt->bind_param('si', $image_path, $restaurant_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'restaurant_name' => htmlspecialchars($restaurant['restaurant_name'] ?? 'Restaurant')]);
    } else {
        error_log("Database update failed: " . $stmt->error);
        echo json_encode(['success' => false, 'message' => 'Database update failed']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No file uploaded']);
}
?>
