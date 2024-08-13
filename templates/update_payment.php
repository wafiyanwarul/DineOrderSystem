<?php

// Sertakan file untuk koneksi database
include("../includes/db_connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_ids = $_POST['payment_ids'];
    $pmethod_ids = $_POST['pmethod_ids'];
    $statuses = $_POST['statuses'];

    foreach ($payment_ids as $index => $payment_id) {
        $pmethod_id = $pmethod_ids[$index];
        $status = $statuses[$index];

        $sql = "UPDATE payment SET pmethod_id = ?, status = ? WHERE payment_id = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param('isi', $pmethod_id, $status, $payment_id);

        if ($stmt->execute()) {
            $response['status'] = 'success';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to update record';
            echo json_encode($response);
            exit;
        }
    }

    $response['status'] = 'success';
    echo json_encode($response);
}
?>
