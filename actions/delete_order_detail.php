<?php
include "../includes/db_connect.php";

if (isset($_POST['order_detail_id'])) {
    $order_detail_id = $_POST['order_detail_id'];

    $sql = "DELETE FROM order_detail WHERE order_detail_id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $order_detail_id);

    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $koneksi->close();
}
?>
