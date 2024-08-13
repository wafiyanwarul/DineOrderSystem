<?php
include('../includes/db_connect.php'); // Ganti dengan file koneksi database Anda

// Periksa apakah metode yang digunakan adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Tangkap data yang dikirimkan dari form
    $voucher_id = $_POST['voucher_id'];
    $customer_id = $_POST['customer_id'];
    $restaurant_id = $_POST['restaurant_id'];
    $order_date = date('Y-m-d H:i:s'); // Waktu sekarang
    $status = 'pending'; // Set status sebagai 'pending'

    // Query untuk menyimpan data ke dalam tabel orders
    $sql = "INSERT INTO orders (voucher_id, customer_id, restaurant_id, order_date, status)
            VALUES ('$voucher_id', '$customer_id', '$restaurant_id', '$order_date', '$status')";

    if ($koneksi->query($sql) === TRUE) {
        // Jika query berhasil dieksekusi, tampilkan pesan sukses menggunakan Sweet Alert
        echo "<script>alert('Order placed successfully!');</script>";
        // Redirect ke halaman order_detail.php untuk mengisi detail pesanan
        header("Location: ../templates/orders.php");
        exit;
    } else {
        // Jika terjadi kesalahan, tampilkan pesan error
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }

    // Tutup koneksi database
    $koneksi->close();
}
?>
