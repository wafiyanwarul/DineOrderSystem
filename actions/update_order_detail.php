<?php
include "../includes/db_connect.php";

if (isset($_POST['order_detail_id'], $_POST['order_id'], $_POST['food_id'], $_POST['quantity'], $_POST['total_price'])) {
    $order_detail_id = $_POST['order_detail_id'];
    $order_id = $_POST['order_id'];
    $food_id = $_POST['food_id'];
    $quantity = $_POST['quantity'];
    $total_price = $_POST['total_price'];

    $sql = "UPDATE order_detail SET order_id = ?, food_id = ?, quantity = ?, total_price = ? WHERE order_detail_id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("iiidi", $order_id, $food_id, $quantity, $total_price, $order_detail_id);

    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $koneksi->close();
}
?>
