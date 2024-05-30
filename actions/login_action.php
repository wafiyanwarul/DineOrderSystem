<?php
    session_start();
    include "../includes/db_connect.php";
    $email = $_POST['email'];
    $password = $_POST['password'];
    $op = $_GET['op'];

    if ($op == "in") {
        $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
        $query = $koneksi->query($sql);
        if (mysqli_num_rows($query)==1){
            $data = $query->fetch_array();
            $_SESSION['email'] = $data['email'];
            $_SESSION['level'] = $data['level'];
            if ($data['level'] == "admin") {
                header("location: ../templates/dashboard.php");
            } else if ($data['level'] == "customer") {
                header("location: ../templates/dashboard.php");
            } else {
                die ("password salah <a href=\"javascript:history.back()\">kembali</a>");
            }
        }
    } else if ($op == "out") {
        unset($_SESSION['email']);
        unset($_SESSION['level']);
        header("location: ../templates/login.php");
    }