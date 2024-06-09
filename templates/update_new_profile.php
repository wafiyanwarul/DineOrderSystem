<?php
include "../includes/db_connect.php";
session_start(); // Start the session for notification handling

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['user_id'], $_POST['phone'], $_POST['address'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
        exit;
    }

    $user_id = $_POST['user_id'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Check if the customer data exists
    $sql_check = "SELECT * FROM customer WHERE user_id = ?";
    $stmt_check = $koneksi->prepare($sql_check);
    $stmt_check->bind_param("i", $user_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $customer_exists = $result_check->num_rows > 0;
    $stmt_check->close();

    if ($customer_exists) {
        // Update existing customer data
        $sql = "UPDATE customer SET phone = ?, address = ? WHERE user_id = ?";
        $stmt = $koneksi->prepare($sql);

        if (!$stmt) {
            error_log("Failed to prepare statement: " . $koneksi->error);
            echo json_encode(['success' => false, 'message' => 'Database error']);
            exit;
        }

        $stmt->bind_param("ssi", $phone, $address, $user_id);
    } else {
        // Insert new customer data
        $sql = "INSERT INTO customer (user_id, phone, address) VALUES (?, ?, ?)";
        $stmt = $koneksi->prepare($sql);

        if (!$stmt) {
            error_log("Failed to prepare statement: " . $koneksi->error);
            echo json_encode(['success' => false, 'message' => 'Database error']);
            exit;
        }

        $stmt->bind_param("iss", $user_id, $phone, $address);
    }

    if ($stmt->execute()) {
        $_SESSION['notification'] = [
            'type' => 'success',
            'message' => 'Data profil berhasil diperbarui.'
        ];
        echo json_encode(['success' => true]);
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Gagal memperbarui data profil.'
        ];
        echo json_encode(['success' => false, 'message' => 'Failed to update profile data']);
    }
    $stmt->close(); // Close the statement
} else {
    $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'Invalid request method.'
    ];
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$koneksi->close(); // Close the connection
?>
