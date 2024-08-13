<?php
include '../includes/db_connect.php'; // Pastikan koneksi ke database disertakan

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['pmethod_id']) && isset($_POST['pmethod_name'])) {
        $pmethod_id = $_POST['pmethod_id'];
        $pmethod_name = $_POST['pmethod_name'];

        // Persiapkan query SQL untuk mengupdate nama metode pembayaran
        $sql_update_payment_method = "UPDATE payment_methods SET pmethod_name = ? WHERE pmethod_id = ?";
        $stmt = $koneksi->prepare($sql_update_payment_method);

        if ($stmt) {
            $stmt->bind_param('si', $pmethod_name, $pmethod_id);

            if ($stmt->execute()) {
                echo 'success';
            } else {
                error_log('Execute Error: ' . $stmt->error); // Logging error
                echo 'error';
            }

            $stmt->close();
        } else {
            error_log('Prepare Error: ' . $koneksi->error); // Logging error
            echo 'error';
        }
    } else {
        echo 'invalid_request';
    }
} else {
    echo 'invalid_request';
}
?>
