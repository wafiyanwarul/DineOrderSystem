<?php
session_start();
include('../includes/db_connect.php'); // Ganti dengan file koneksi database Anda
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (!isset($_SESSION['username'])) {
    die("Anda belum login");
}

// Mendapatkan data user dari session
$username = $_SESSION['username'];

// Mendapatkan data dari form
$phone = $_POST['phone'];
$address = $_POST['address'];

// Mendapatkan user_id dari username
$sql_user = "SELECT user_id FROM user WHERE username = '$username'";
$result_user = $koneksi->query($sql_user);

if ($result_user->num_rows == 1) {
    $user = $result_user->fetch_assoc();
    $user_id = $user['user_id'];
    
    // Update data di tabel customer
    $sql_update = "UPDATE customer SET phone = ?, address = ? WHERE user_id = ?";
    $stmt = $koneksi->prepare($sql_update);
    $stmt->bind_param("ssi", $phone, $address, $user_id);
    
    if ($stmt->execute()) {
        // Redirect ke halaman profile dengan pesan sukses
        header("Location: ../pages/profile.php?status=success");
    } else {
        // Redirect ke halaman profile dengan pesan error
        header("Location: ../pages/profile.php?status=error");
    }
    $stmt->close();
} else {
    // Redirect ke halaman profile dengan pesan error jika user tidak ditemukan
    header("Location: ../pages/profile.php?status=error");
}

$koneksi->close();
?>
