<?php
session_start();
include('../includes/db_connect.php'); // Ganti dengan file koneksi database Anda

$response = array('success' => false);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $voucher_ids = $_POST['voucher_id'];

    foreach ($voucher_ids as $voucher_id) {
        $query = "DELETE FROM voucher WHERE voucher_id=?";
        if ($stmt = $koneksi->prepare($query)) {
            $stmt->bind_param("i", $voucher_id);
            if ($stmt->execute()) {
                $response['success'] = true;
            } else {
                $response['success'] = false;
                break;
            }
            $stmt->close();
        } else {
            $response['success'] = false;
            break;
        }
    }

    $koneksi->close();
}

echo json_encode($response);
