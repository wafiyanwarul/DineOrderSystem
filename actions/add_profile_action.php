<?php
session_start();
include('../includes/db_connect.php'); // Ganti dengan file koneksi database Anda
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (!isset($_SESSION['username'])) {
    die("Anda belum login");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Validasi input
    if (empty($user_id) || empty($phone) || empty($address)) {
        die("Semua field harus diisi!");
    }

    // Cek apakah data dengan user_id tersebut sudah ada di tabel customer
    $sql_check = "SELECT * FROM customer WHERE user_id = ?";
    $stmt_check = $koneksi->prepare($sql_check);
    $stmt_check->bind_param("i", $user_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Jika data sudah ada, tampilkan notifikasi dan kembalikan ke halaman profile
        echo "<script>
                alert('Data sudah ada di database.');
                window.location.href = '../templates/profile.php';
              </script>";
    } else {
        // Insert data ke tabel customer
        $sql_insert = "INSERT INTO customer (user_id, phone, address) VALUES (?, ?, ?)";
        $stmt_insert = $koneksi->prepare($sql_insert);
        $stmt_insert->bind_param("iss", $user_id, $phone, $address);

        if ($stmt_insert->execute()) {
            // Redirect ke profile.php setelah berhasil
            header("Location: ../templates/profile.php");
            exit();
        } else {
            echo "Error: " . $stmt_insert->error;
        }

        $stmt_insert->close();
    }

    $stmt_check->close();
    $koneksi->close();
}
?>
