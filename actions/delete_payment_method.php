<?php
include '../includes/db_connect.php'; // Pastikan koneksi ke database disertakan

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['pmethod_id'])) {
        $pmethod_id = $data['pmethod_id'];

        // Persiapkan query SQL untuk menghapus metode pembayaran
        $sql_delete_payment_method = "DELETE FROM payment_methods WHERE pmethod_id = ?";
        $stmt = $koneksi->prepare($sql_delete_payment_method);

        if ($stmt) {
            $stmt->bind_param('i', $pmethod_id);

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
