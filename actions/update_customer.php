<?php
include '../includes/db_connect.php'; // Pastikan koneksi ke database disertakan

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['customer_id']) && isset($_POST['username']) && isset($_POST['phone'])) {
        $customer_id = $_POST['customer_id'];
        $username = $_POST['username'];
        $phone = $_POST['phone'];

        // Mulai transaksi
        $koneksi->begin_transaction();

        try {
            // Update username di tabel user
            $sql_update_user = "UPDATE user u
                                JOIN customer c ON u.user_id = c.user_id
                                SET u.username = ?
                                WHERE c.customer_id = ?";
            $stmt_user = $koneksi->prepare($sql_update_user);
            $stmt_user->bind_param('si', $username, $customer_id);
            $stmt_user->execute();

            // Update phone di tabel customer
            $sql_update_customer = "UPDATE customer SET phone = ? WHERE customer_id = ?";
            $stmt_customer = $koneksi->prepare($sql_update_customer);
            $stmt_customer->bind_param('si', $phone, $customer_id);
            $stmt_customer->execute();

            // Commit transaksi
            $koneksi->commit();

            echo 'success';
        } catch (Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            $koneksi->rollback();
            echo 'error';
        }
    } else {
        echo 'invalid_request';
    }
} else {
    echo 'invalid_request';
}
?>
