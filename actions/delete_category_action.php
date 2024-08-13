<?php
include('../includes/db_connect.php'); // Ganti dengan file koneksi database Anda

$response = array('success' => false);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['category_ids'])) {
        $categoryIds = $_POST['category_ids'];

        // Loop melalui setiap kategori yang akan dihapus
        foreach ($categoryIds as $categoryId) {
            $sqlDeleteCategory = "DELETE FROM category WHERE category_id = ?";
            if ($stmt = $koneksi->prepare($sqlDeleteCategory)) {
                $stmt->bind_param("i", $categoryId);
                if ($stmt->execute()) {
                    $response['success'] = true;
                } else {
                    $response['success'] = false;
                    $response['error'] = 'Error deleting category with ID ' . $categoryId . ': ' . $stmt->error;
                    break;
                }
                $stmt->close();
            } else {
                $response['success'] = false;
                $response['error'] = 'Error preparing statement for category ID ' . $categoryId;
                break;
            }
        }
    } else {
        $response['error'] = 'No category IDs received.';
    }
} else {
    $response['error'] = 'Invalid request method.';
}

$koneksi->close();

echo json_encode($response);
?>
