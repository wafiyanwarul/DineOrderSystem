<?php
session_start();
include('../includes/db_connect.php'); // Ganti dengan file koneksi database Anda
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (!isset($_SESSION['username'])) {
    die("<h1><center>Anda belum login</h1></center>");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $order_id = (int)$_POST['order_id'];
    $pmethod_id = (int)$_POST['pmethod_id'];
    $amount = (float)$_POST['amount'];
    $status = 'pending'; // Set status awal menjadi pending

    // Insert data ke tabel payment
    $sql_payment = "INSERT INTO payment (order_id, pmethod_id, payment_date, amount, status) VALUES (?, ?, NOW(), ?, ?)";
    $stmt_payment = $koneksi->prepare($sql_payment);
    $stmt_payment->bind_param("iids", $order_id, $pmethod_id, $amount, $status);

    if ($stmt_payment->execute()) {
        // Pembayaran berhasil dibuat
        $_SESSION['payment_success'] = true;
    } else {
        // Pembayaran gagal dibuat
        $_SESSION['payment_success'] = false;
    }

    $stmt_payment->close();
    header("Location: " . $_SERVER['HTTP_REFERER']); // Redirect kembali ke halaman sebelumnya
    exit();
}
?>
