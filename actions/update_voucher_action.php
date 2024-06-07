<?php
session_start();
include('../includes/db_connect.php'); // Ganti dengan file koneksi database Anda

$response = array('success' => false);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $voucher_ids = array_keys($_POST['nama_voucher']);
    $nama_vouchers = $_POST['nama_voucher'];
    $codes = $_POST['code'];
    $discounts = $_POST['discount'];
    $expiry_dates = $_POST['expiry_date'];

    foreach ($voucher_ids as $voucher_id) {
        $nama_voucher = $nama_vouchers[$voucher_id];
        $code = $codes[$voucher_id];
        $discount = $discounts[$voucher_id];
        $expiry_date = $expiry_dates[$voucher_id];

        $query = "UPDATE voucher SET nama_voucher=?, code=?, discount=?, expiry_date=? WHERE voucher_id=?";
        if ($stmt = $koneksi->prepare($query)) {
            $stmt->bind_param("ssdsi", $nama_voucher, $code, $discount, $expiry_date, $voucher_id);
            if ($stmt->execute()) {
                $response['success'] = true;
            } else {
                $response['success'] = false;
                break;
            }
            $stmt->close();
        } else {
            $response['success'] = false;
            break;
        }
    }

    $koneksi->close();
}

echo json_encode($response);
?>