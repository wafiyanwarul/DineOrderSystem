<?php
include '../includes/db_connect.php'; // Pastikan koneksi ke database disertakan

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['pmethod_name'])) {
        $pmethod_name = $_POST['pmethod_name'];

        // Persiapkan query SQL untuk menambahkan metode pembayaran baru
        $sql_add_payment_method = "INSERT INTO payment_methods (pmethod_name) VALUES (?)";
        $stmt = $koneksi->prepare($sql_add_payment_method);

        if ($stmt) {
            $stmt->bind_param('s', $pmethod_name);

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
