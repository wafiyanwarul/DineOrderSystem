<?php
session_start();
include "../includes/db_connect.php";

$user = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$op = $_GET['op'];

if ($op == "in") {
    // Cek apakah email terdaftar
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $query = $koneksi->query($sql);

    if (mysqli_num_rows($query) == 0) {
        // Jika email tidak terdaftar
        $_SESSION['error'] = "Email belum terdaftar";
        header("Location: ../templates/login.php");
    } else {
        // Jika email terdaftar, cek password
        $data = $query->fetch_array();
        if (!password_verify($password, $data['password'])) {
            // Jika password salah
            $_SESSION['error'] = "Password yang anda masukkan salah";
            header("Location: ../templates/login.php");
        } else {
            // Jika email dan password benar
            $_SESSION['user_id'] = $data['id'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['level'] = $data['level'];
            if ($data['level'] == "admin") {
                header("location: ../templates/dashboard.php");
            } else if ($data['level'] == "customer") {
                header("location: ../templates/dashboard.php");
            }
        }
    }
} else if ($op == "out") {
    session_destroy();
    header("location: ../templates/login.php");
}
?>
