<?php
session_start();
include('../includes/db_connect.php'); // Ganti dengan file koneksi database Anda

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['payment_id'])) {
        $payment_id = $_POST['payment_id'];

        // Update status pembayaran menjadi success
        $sql_update = "UPDATE payment SET status = 'success' WHERE payment_id = ?";
        $stmt_update = $koneksi->prepare($sql_update);
        $stmt_update->bind_param("i", $payment_id);

        if ($stmt_update->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }

        $stmt_update->close();
    }
    $koneksi->close();
}
?>
