<?php
    $host = "localhost";
    $username = "root";
    $password = "DBku98*#";
    $database = "food_order";
    $koneksi = mysqli_connect($host, $username, $password, $database);
    if ($koneksi) {
        echo "";
    } else {
        echo "Not connected";
    }
    ?>