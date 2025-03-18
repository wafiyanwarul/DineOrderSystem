<?php
include('../includes/db_connect.php'); // Sesuaikan dengan file koneksi database Anda

// Pastikan method yang digunakan adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan order_id tersedia dan bukan string kosong
    if (!empty($_POST["order_id"])) {
        $order_id = $_POST["order_id"];

        // Lakukan validasi untuk order_items
        if (!empty($_POST["order_items"]) && is_array($_POST["order_items"])) {
            $order_items = $_POST["order_items"];

            // Lakukan iterasi melalui setiap item pesanan
            foreach ($order_items as $item) {
                // Pastikan food_id, quantity, dan total_price tersedia dan bukan string kosong
                if (isset($item['food_id']) && isset($item['quantity']) && isset($item['total_price']) &&
                    !empty($item['food_id']) && !empty($item['quantity']) && !empty($item['total_price'])) {
                    
                    $food_id = $item['food_id'];
                    $quantity = $item['quantity'];
                    $total_price = $item['total_price'];

                    // Lakukan penyimpanan data ke dalam database
                    $sql_insert = "INSERT INTO order_detail (order_id, food_id, quantity, total_price) VALUES ('$order_id', '$food_id', '$quantity', '$total_price')";
                    if ($koneksi->query($sql_insert) !== TRUE) {
                        // Jika terjadi kesalahan saat penyimpanan, keluarkan pesan error
                        http_response_code(500); // Internal Server Error
                        echo "Error: " . $sql_insert . "<br>" . $koneksi->error;
                        exit;
                    }
                } else {
                    // Jika data pesanan tidak valid, berikan tanggapan yang sesuai kepada pengguna
                    http_response_code(400); // Bad Request
                    echo "Invalid order item data.";
                    exit;
                }
            }

            // Semua data pesanan valid, lanjutkan dengan proses penyimpanan ke dalam database
            http_response_code(200); // OK
            echo "Order details have been successfully added.";
            exit;
        } else {
            // Jika order_items tidak tersedia atau bukan array, berikan tanggapan yang sesuai kepada pengguna
            http_response_code(400); // Bad Request
            echo "Invalid order items data.";
            exit;
        }
    } else {
        // Jika order_id tidak tersedia, berikan tanggapan yang sesuai kepada pengguna
        http_response_code(400); // Bad Request
        echo "Order ID is required.";
        exit;
    }
} else {
    // Jika tidak menggunakan metode POST, berikan tanggapan yang sesuai kepada pengguna
    http_response_code(405); // Method Not Allowed
    echo "Method Not Allowed.";
    exit;
}
?>
