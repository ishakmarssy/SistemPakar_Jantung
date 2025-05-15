<?php
// Koneksi ke database
include('../koneksi/db.php'); // Gantilah dengan file koneksi Anda

// Cek apakah user sudah login dan memiliki role admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Redirect ke halaman login jika bukan admin
    header("Location: ../login.php");
    exit;
}

// Ambil ID map dari URL
$id = $_GET['id'] ?? null;
if ($id) {
    // Ambil data map berdasarkan ID
    $query = "SELECT * FROM map WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    $map = $stmt->fetch();
    
    if (!$map) {
        echo "Data tidak ditemukan!";
        exit;
    }
}

// Proses update jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lokasi = $_POST['lokasi'];
    $embed_src = $_POST['embed_src'];

    // Update data
    $updateQuery = "UPDATE map SET lokasi = ?, embed_src = ? WHERE id = ?";
    $stmt = $pdo->prepare($updateQuery);
    $stmt->execute([$lokasi, $embed_src, $id]);

    // Redirect ke halaman sebelumnya atau ke halaman lain setelah sukses
    header('Location: map_list.php'); // Gantilah ke halaman daftar map jika ada
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Embed Google Maps</title>
    <!-- Sertakan Bootstrap atau framework lain jika perlu -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Embed Google Maps - <?= htmlspecialchars($map['lokasi']) ?></h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="lokasi" class="form-label">Nama Lokasi</label>
                <input type="text" id="lokasi" name="lokasi" class="form-control" value="<?= htmlspecialchars($map['lokasi']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="embed_src" class="form-label">Embed Google Maps</label>
                <textarea id="embed_src" name="embed_src" class="form-control" rows="5" required><?= htmlspecialchars($map['embed_src']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
    
    <!-- Sertakan JS untuk Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
