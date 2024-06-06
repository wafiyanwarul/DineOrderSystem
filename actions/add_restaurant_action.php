<?php
session_start();
include('../includes/db_connect.php'); // Ganti dengan file koneksi database Anda
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['username'])) {
    die("<h1><center>Anda belum login</h1></center>");
}

// Memproses form ketika dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $restaurant_name = $_POST['restaurant_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
    $target_dir = "../assets/images/upload/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    // Upload gambar
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Menyimpan path relatif gambar
        $image_path = 'assets/images/upload/' . basename($_FILES["image"]["name"]);

        // Menyimpan data ke database
        $sql = "INSERT INTO restaurant (restaurant_name, phone, address, description, image) VALUES (?, ?, ?, ?, ?)";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("sssss", $restaurant_name, $phone, $address, $description, $image_path);
        
        if ($stmt->execute()) {
            echo "Restoran berhasil ditambahkan.";
            header('Location: ../templates/restaurants.php');
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>