<?php
session_start();
include('../includes/db_connect.php'); // Ganti dengan file koneksi database Anda

if (!isset($_SESSION['username'])) {
    die("<h1><center>Anda belum login</h1></center>");
}

// Mendapatkan data user dari session atau database
$username = $_SESSION['username'];
$sql = "SELECT username, level FROM user WHERE username = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Error executing query: " . $koneksi->error);
}

$user = $result->fetch_assoc();
$level = $user['level'] ?? 'unknown';

if ($level != 'admin') {
    die("Unauthorized access.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $food_id = $_POST['food_id'];
    $target_dir = "../assets/images/upload/food/";

    // Mendapatkan data makanan dari database
    $sql_food = "SELECT image FROM food WHERE food_id = ?";
    $stmt_food = $koneksi->prepare($sql_food);
    $stmt_food->bind_param('i', $food_id);
    $stmt_food->execute();
    $result_food = $stmt_food->get_result();

    if (!$result_food) {
        die("Error executing query: " . $koneksi->error);
    }

    $food_data = $result_food->fetch_assoc();
    $old_image_path = $food_data['image'];

    // Menghapus gambar lama
    if (file_exists($old_image_path)) {
        unlink($old_image_path);
    }

    // Upload gambar baru
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 5000000) { // 500KB
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        // If upload failed
        $response = [
            'success' => false,
            'food_name' => '',
            'message' => "Gambar gagal diunggah karena tipe file tidak sesuai ['jpg','png','jpeg','gif','webp']"
        ];
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Update path gambar di database
            $sql_update = "UPDATE food SET image = ? WHERE food_id = ?";
            $stmt_update = $koneksi->prepare($sql_update);
            $stmt_update->bind_param('si', $target_file, $food_id);
            $stmt_update->execute();

            $response = [
                'success' => true,
                'food_name' => '',
                'message' => "Gambar berhasil diperbarui."
            ];
        } else {
            $response = [
                'success' => false,
                'food_name' => '',
                'message' => "Gambar gagal diunggah."
            ];
        }
    }

    // Mengirimkan respons JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>
