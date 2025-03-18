<?php
session_start();
include '../includes/db_connect.php'; // Sesuaikan dengan nama file koneksi Anda

// Pastikan user sudah login
if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit();
}

$username = $_SESSION['username'];

// Proses upload gambar
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
    $fileName = $_FILES['profile_picture']['name'];
    $fileSize = $_FILES['profile_picture']['size'];
    $fileType = $_FILES['profile_picture']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    // Tentukan ekstensi file yang diizinkan
    $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
    
    if (in_array($fileExtension, $allowedfileExtensions)) {
        // Direktori tujuan
        $uploadFileDir = '../assets/images/upload/profile/';
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $dest_path = $uploadFileDir . $newFileName;

        if(move_uploaded_file($fileTmpPath, $dest_path)) {
            // Path yang disimpan di database
            $imagePath = $uploadFileDir . $newFileName;

            // Query untuk mendapatkan customer_id
            $sql_customer = "SELECT customer.customer_id FROM customer JOIN user ON customer.user_id = user.user_id WHERE user.username = '$username'";
            $result_customer = $koneksi->query($sql_customer);
            if ($result_customer->num_rows > 0) {
                $row = $result_customer->fetch_assoc();
                $customer_id = $row['customer_id'];

                // Query untuk memperbarui gambar profil di database
                $sql_update = "UPDATE customer SET image = ? WHERE customer_id = ?";
                $stmt_update = $koneksi->prepare($sql_update);
                $stmt_update->bind_param("si", $imagePath, $customer_id);
                if ($stmt_update->execute()) {
                    $_SESSION['success_message'] = "Profile picture updated successfully.";
                } else {
                    $_SESSION['error_message'] = "Failed to update profile picture in database.";
                }
                $stmt_update->close();
            } else {
                $_SESSION['error_message'] = "Customer not found.";
            }
        } else {
            $_SESSION['error_message'] = "There was an error moving the uploaded file.";
        }
    } else {
        $_SESSION['error_message'] = "Upload failed. Allowed file types: " . implode(',', $allowedfileExtensions);
    }
} else {
    $_SESSION['error_message'] = "There was an error uploading the file.";
}

// Redirect back to profile page
header('Location: ../templates/profile.php');
exit();
?>