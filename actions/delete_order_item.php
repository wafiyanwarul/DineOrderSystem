<?php
session_start();
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_items']) && is_array($_POST['delete_items'])) {
        $delete_items = $_POST['delete_items'];

        // Buat query untuk menghapus item dari tabel order_detail berdasarkan food_id
        $placeholders = implode(',', array_fill(0, count($delete_items), '?'));
        $sql = "DELETE FROM order_detail WHERE food_id IN ($placeholders)";

        // Siapkan statement
        if ($stmt = $koneksi->prepare($sql)) {
            // Bind parameter
            $stmt->bind_param(str_repeat('i', count($delete_items)), ...$delete_items);

            // Eksekusi statement
            if ($stmt->execute()) {
                $_SESSION['message'] = 'Item berhasil dihapus';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Gagal menghapus item';
                $_SESSION['message_type'] = 'danger';
            }

            $stmt->close();
        } else {
            $_SESSION['message'] = 'Gagal menyiapkan statement';
            $_SESSION['message_type'] = 'danger';
        }
    } else {
        $_SESSION['message'] = 'Tidak ada item yang dipilih untuk dihapus';
        $_SESSION['message_type'] = 'warning';
    }
} else {
    $_SESSION['message'] = 'Metode permintaan tidak valid';
    $_SESSION['message_type'] = 'danger';
}

// Redirect kembali ke halaman detail order
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
