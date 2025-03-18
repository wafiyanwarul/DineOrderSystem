<?php
include('../includes/db_connect.php'); // Sesuaikan dengan path dan nama file koneksi database Anda

// Inisialisasi respons awal
$response = array('success' => false);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan data yang diterima sesuai dengan yang diharapkan
    if (isset($_POST['nama_kategori']) && isset($_POST['category_ids'])) {
        // Mendapatkan data kategori yang akan diupdate
        $categoryIds = $_POST['category_ids'];
        $namaKategori = $_POST['nama_kategori'];

        // Loop melalui setiap kategori untuk melakukan pembaruan
        foreach ($categoryIds as $categoryId) {
            // Pastikan kategori ada dalam database sebelum melakukan pembaruan
            $sqlCheckCategory = "SELECT * FROM category WHERE category_id = ?";
            $stmtCheckCategory = $koneksi->prepare($sqlCheckCategory);
            $stmtCheckCategory->bind_param("i", $categoryId);
            $stmtCheckCategory->execute();
            $resultCheckCategory = $stmtCheckCategory->get_result();

            if ($resultCheckCategory->num_rows > 0) {
                // Jika kategori ditemukan, lakukan pembaruan
                $newCategoryName = $namaKategori[$categoryId];
                $sqlUpdateCategory = "UPDATE category SET category_name = ? WHERE category_id = ?";
                $stmtUpdateCategory = $koneksi->prepare($sqlUpdateCategory);
                $stmtUpdateCategory->bind_param("si", $newCategoryName, $categoryId);

                if ($stmtUpdateCategory->execute()) {
                    // Pembaruan berhasil
                    $response['success'] = true;
                } else {
                    // Terjadi kesalahan saat melakukan pembaruan
                    $response['error'] = 'Error updating category with ID ' . $categoryId . ': ' . $koneksi->error;
                }
            } else {
                // Jika kategori tidak ditemukan dalam database
                $response['error'] = 'Category with ID ' . $categoryId . ' not found.';
            }
        }
    } else {
        // Jika data tidak lengkap
        $response['error'] = 'Incomplete data received.';
    }
} else {
    // Jika metode yang digunakan bukan POST
    $response['error'] = 'Invalid request method.';
}

// Tutup koneksi ke database
$koneksi->close();

// Mengembalikan respons dalam format JSON
echo json_encode($response);
?>
