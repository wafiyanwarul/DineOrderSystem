<?php
session_start();
include('../includes/db_connect.php');
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (!isset($_SESSION['username'])) {
    die("<h1><center>Anda belum login</h1></center>");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Periksa apakah semua input tersedia
    if (!isset($_POST['food_id'], $_POST['restaurant_id'], $_POST['food_name'], $_POST['price'], $_POST['description'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
        exit;
    }

    $food_id = $_POST['food_id'];
    $restaurant_id = $_POST['restaurant_id'];
    $food_name = $_POST['food_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $sql = "UPDATE food SET restaurant_id = ?, food_name = ?, price = ?, description = ? WHERE food_id = ?";
    $stmt = $koneksi->prepare($sql);

    if (!$stmt) {
        error_log("Failed to prepare statement: " . $koneksi->error);
        echo json_encode(['success' => false, 'message' => 'Database error']);
        exit;
    }

    // Bind parameter dengan jenis data yang sesuai
    $stmt->bind_param('isdsi', $restaurant_id, $food_name, $price, $description, $food_id);

    if ($stmt->execute()) {
        $_SESSION['notification'] = [
            'type' => 'success',
            'message' => 'Data makanan berhasil diperbarui.'
        ];
        echo json_encode(['success' => true, 'food_name' => $food_name]);
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Gagal memperbarui data makanan.'
        ];
        echo json_encode(['success' => false, 'message' => 'Failed to update food data']);
    }
} else {
    $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'Invalid request method.'
    ];
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>