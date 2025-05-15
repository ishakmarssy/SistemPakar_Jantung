<?php
// Koneksi ke database
include '../../koneksi/db.php'; // Pastikan koneksi ke database sudah benar

// Mengecek apakah data telah dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $lokasi = $_POST['lokasi'];
    $embed_src = $_POST['embed_src'];

    // Menyimpan data ke dalam database
    $sql = "INSERT INTO map (lokasi, embed_src) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $lokasi, $embed_src);
        
        if ($stmt->execute()) {
            // Jika berhasil, alihkan ke halaman map_list.php
            header("Location: ../map_list.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

// Menutup koneksi
$conn->close();
?>
