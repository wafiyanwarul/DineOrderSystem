<?php
session_start();
include('../includes/db_connect.php'); // Ganti dengan file koneksi database Anda
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (!isset($_SESSION['username'])) {
    die("Anda belum login");
}

// Mendapatkan data user dari session atau database
$username = $_SESSION['username'];
$sql = "SELECT user_id, username FROM user WHERE username = '$username'";
$result = $koneksi->query($sql);
$user = $result->fetch_assoc();

$user_id = $user['user_id'];
$username = $user['username'] ?? 'Guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Customer</title>
</head>
<body>
    <h1>Tambah Customer Baru</h1>
    <form action="../actions/add_profile_action.php" method="post">
        <label for="username">Username:</label>
        <select name="user_id" id="username">
            <?php
            // Menampilkan opsi dropdown dengan username yang sedang login
            echo '<option value="' . $user_id . '">' . $username . '</option>';
            ?>
        </select>
        <br><br>
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required>
        <br><br>
        <label for="address">Address:</label>
        <textarea id="address" name="address" required></textarea>
        <br><br>
        <button type="submit">Tambah Customer</button>
    </form>
</body>
</html>
