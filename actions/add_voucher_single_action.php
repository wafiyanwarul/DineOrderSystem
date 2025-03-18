<?php
session_start();
include('../includes/db_connect.php'); // Ganti dengan file koneksi database Anda
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if (!isset($_SESSION['username'])) {
    die("<h1><center>Anda belum login</h1></center>");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $nama_voucher = $_POST['nama_voucher'];
    $code = $_POST['code'];
    $discount = $_POST['discount'];
    $expiry_date = $_POST['expiry_date'];

    // Validate form data
    if (empty($nama_voucher) || empty($code) || empty($discount) || empty($expiry_date)) {
        echo "All fields are required.";
        exit;
    }

    // Insert data into database
    $query = "INSERT INTO voucher (nama_voucher, code, discount, expiry_date) VALUES (?, ?, ?, ?)";
    if ($stmt = $koneksi->prepare($query)) {
        $stmt->bind_param("ssds", $nama_voucher, $code, $discount, $expiry_date);
        if ($stmt->execute()) {
            echo "Voucher added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: " . $koneksi->error;
    }

    // Close database connection
    $koneksi->close();
} else {
    echo "Invalid request method.";
}
?>
