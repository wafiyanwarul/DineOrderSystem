<?php
include '../includes/db_connect.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$access_code = $_POST['access_code'];

// set default level
$level = 'customer';

// Check access code
if ($access_code === 'ADMIN99') {
    $level = 'admin';
}

$password_hashed = password_hash($password, PASSWORD_BCRYPT);

$sql = "INSERT INTO user (username, email, password, access_code, level) VALUES ('" . $username . "','" . $email . "','" . $password . "','" . $access_code . "','" . $level . "')";

$query = $koneksi->query($sql);

if ($query === true) {
    echo "<script>
            alert('Registration Successful');
            window.location.href = '../templates/login.php';
        </script>";
    header('location: ../templates/login.php');
} else {
    echo "Registration Error";
}
?>