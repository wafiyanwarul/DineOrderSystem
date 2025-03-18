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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Customer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Tambah Customer Baru</h1>
            </div>
            <div class="card-body">
                <form action="../actions/add_profile_action.php" method="post">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <select name="user_id" id="username" class="form-control">
                            <?php
                            // Menampilkan opsi dropdown dengan username yang sedang login
                            echo '<option value="' . $user_id . '">' . $username . '</option>';
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" id="phone" name="phone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <textarea id="address" name="address" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Customer</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
