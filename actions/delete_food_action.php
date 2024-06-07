<?php
session_start();
include('../includes/db_connect.php'); // Ganti dengan file koneksi database Anda
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['username'])) {
    die("<h1><center>Anda belum login</h1></center>");
}

// Mendapatkan data user dari session atau database
$username = $_SESSION['username'];
$sql = "SELECT username, level FROM user WHERE username = '$username'";
$result = $koneksi->query($sql);

if (!$result) {
    die("Error executing query: " . $koneksi->error);
}

$user = $result->fetch_assoc();
$username = $user['username'] ?? 'Guest';
$level = $user['level'] ?? 'unknown';

if ($level == 'customer') {
    $role = 'Customer';
} else if ($level == 'admin') {
    $role = 'Admin';
} else {
    $role = 'Unknown';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['food_ids'])) {
        $food_ids = $_POST['food_ids'];
        $ids = implode(',', array_map('intval', $food_ids)); // Konversi setiap ID menjadi integer untuk keamanan

        // Ambil path gambar dari database sebelum menghapus data
        $sql_select = "SELECT image FROM food WHERE food_id IN ($ids)";
        $result_select = $koneksi->query($sql_select);

        $images = [];
        if ($result_select->num_rows > 0) {
            while ($row = $result_select->fetch_assoc()) {
                $images[] = $row['image'];
            }
        }

        // Hapus data makanan dari database
        $sql_delete = "DELETE FROM food WHERE food_id IN ($ids)";
        if ($koneksi->query($sql_delete) === TRUE) {
            // Hapus gambar dari server
            foreach ($images as $image) {
                if (file_exists($image)) {
                    unlink($image);
                }
            }
            echo "Selected foods deleted successfully.";
            // Redirect atau tampilkan pesan sukses
        } else {
            echo "Error deleting record: " . $koneksi->error;
        }
    } else {
        echo "No foods selected for deletion.";
    }
}
?>
