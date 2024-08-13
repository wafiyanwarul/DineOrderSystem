<?php
include '../includes/db_connect.php'; // Pastikan koneksi ke database disertakan

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['user_ids']) && !empty($_POST['user_ids'])) {
        $user_ids = $_POST['user_ids'];
        
        // Buat placeholders untuk query
        $placeholders = implode(',', array_fill(0, count($user_ids), '?'));

        // Persiapkan query SQL
        $sql = "DELETE FROM user WHERE user_id IN ($placeholders)";
        $stmt = $koneksi->prepare($sql);

        // Logging untuk debugging
        error_log('SQL: ' . $sql);
        error_log('User IDs: ' . print_r($user_ids, true));

        if ($stmt) {
            // Buat array parameter yang sesuai dengan bind_param
            $types = str_repeat('i', count($user_ids));
            if (!$stmt->bind_param($types, ...$user_ids)) {
                error_log('Bind Param Error: ' . $stmt->error);
            }

            // Eksekusi statement
            if ($stmt->execute()) {
                echo 'success';
            } else {
                error_log('Execute Error: ' . $stmt->error); // Logging error
                echo 'error';
            }

            $stmt->close();
        } else {
            error_log('Prepare Error: ' . $koneksi->error); // Logging error
            echo 'error';
        }
    } else {
        echo 'no_selection';
    }
} else {
    echo 'invalid_request';
}
?>
