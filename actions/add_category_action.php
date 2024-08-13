<?php
include('../includes/db_connect.php'); // Ganti dengan file koneksi database Anda

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan data dari form
    $category_name = $_POST['category_name'];

    // Query untuk menambahkan kategori baru
    $sql_insert = "INSERT INTO category (category_name) VALUES (?)";

    if ($stmt = $koneksi->prepare($sql_insert)) {
        $stmt->bind_param("s", $category_name);
        if ($stmt->execute()) {
            // Jika berhasil, redirect ke halaman sebelumnya dengan pesan sukses
            header("Location: ../templates/categories.php?status=success");
        } else {
            // Jika gagal, redirect ke halaman sebelumnya dengan pesan error
            header("Location: ../templates/categories.php?status=error");
        }
        $stmt->close();
    } else {
        // Jika gagal menyiapkan statement, redirect ke halaman sebelumnya dengan pesan error
        header("Location: ../templates/categories.php?status=error");
    }

    // Tutup koneksi ke database
    $koneksi->close();
} else {
    // Jika metode yang digunakan bukan POST, redirect ke halaman sebelumnya
    header("Location: ../templates/categories.php");
}
?>
