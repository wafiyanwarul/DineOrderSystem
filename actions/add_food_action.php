<?php
session_start();
include('../includes/db_connect.php'); // Ganti dengan file koneksi database Anda
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if (!isset($_SESSION['username'])) {
    die("<h1><center>Anda belum login</h1></center>");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $restaurant_id = $_POST['restaurant_id'];
    $food_name = $_POST['food_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $target_dir = "../assets/images/upload/food/";

    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
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
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => "Data Makanan $food_name gagal ditambahkan karena tipe file tidak sesuai ['jpg','png','jpeg','gif']"
        ];
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Insert food into database
            $sql = "INSERT INTO food (restaurant_id, food_name, price, description, image) VALUES ('$restaurant_id', '$food_name', '$price', '$description', '$target_file')";
            if ($koneksi->query($sql) === TRUE) {
                $_SESSION['notification'] = [
                    'type' => 'success',
                    'message' => "Data Makanan $food_name berhasil ditambahkan."
                ];
            } else {
                $_SESSION['notification'] = [
                    'type' => 'danger',
                    'message' => "Data Makanan $food_name gagal ditambahkan: " . $koneksi->error
                ];
            }
        } else {
            $_SESSION['notification'] = [
                'type' => 'danger',
                'message' => "Data Makanan $food_name gagal ditambahkan."
            ];
        }
    }

    header("Location: ../templates/add_food.php");
    exit();
}
