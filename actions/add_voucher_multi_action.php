<?php
session_start();
include('../includes/db_connect.php'); // Ganti dengan file koneksi database Anda
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
header('Content-Type: application/json'); // Set response type to JSON

$response = array('success' => false, 'message' => '');

if (!isset($_SESSION['username'])) {
    $response['message'] = "Anda belum login.";
    echo json_encode($response);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $nama_voucher = $_POST['nama_voucher'];
    $code = $_POST['code'];
    $discount = $_POST['discount'];
    $expiry_date = $_POST['expiry_date'];

    // Validate form data
    for ($i = 0; $i < 3; $i++) {
        if (empty($nama_voucher[$i]) || empty($code[$i]) || empty($discount[$i]) || empty($expiry_date[$i])) {
            $response['message'] = "All fields are required for all vouchers.";
            echo json_encode($response);
            exit;
        }
    }

    // Insert data into database
    $query = "INSERT INTO voucher (nama_voucher, code, discount, expiry_date) VALUES (?, ?, ?, ?)";
    if ($stmt = $koneksi->prepare($query)) {
        for ($i = 0; $i < 3; $i++) {
            $stmt->bind_param("ssds", $nama_voucher[$i], $code[$i], $discount[$i], $expiry_date[$i]);
            if (!$stmt->execute()) {
                $response['message'] = "Error: " . $stmt->error;
                $stmt->close();
                $koneksi->close();
                echo json_encode($response);
                exit;
            }
        }
        $response['success'] = true;
        $response['message'] = "Vouchers added successfully.";
        $stmt->close();
    } else {
        $response['message'] = "Error: " . $koneksi->error;
    }

    // Close database connection
    $koneksi->close();
} else {
    $response['message'] = "Invalid request method.";
}

echo json_encode($response);
?>
