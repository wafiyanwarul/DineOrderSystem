<?php
session_start();
include '../includes/db_connect.php'; // Sesuaikan dengan nama file koneksi Anda

$username = $_SESSION['username'];

// Ambil data yang dikirimkan dari form
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$address = isset($_POST['address']) ? trim($_POST['address']) : '';

if (empty($phone) || empty($address)) {
    $_SESSION['error_message'] = 'Phone dan Address tidak boleh kosong.';
    header('Location: ../templates/profile.php');
    exit();
}

// Update data profil di database
$sql_update = "UPDATE customer 
               SET phone = ?, address = ? 
               WHERE user_id = (SELECT user_id FROM user WHERE username = ?)";
$stmt = $koneksi->prepare($sql_update);
$stmt->bind_param('sss', $phone, $address, $username);

if ($stmt->execute()) {
    $_SESSION['success_message'] = 'Data berhasil diperbarui.';
} else {
    $_SESSION['error_message'] = 'Data gagal diperbarui. Silakan coba lagi.';
}

?>