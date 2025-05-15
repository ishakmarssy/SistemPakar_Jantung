<?php
session_start();

// Cek apakah user sudah login dan memiliki role admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Redirect ke halaman login jika bukan admin
    header("Location: ../login.php");
    exit;
}

include '../koneksi/db.php';

// Tambah atau Update Iklan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_ad'])) {
    $id = intval($_POST['id'] ?? 0);
    $position = $_POST['position'];
    $code = $_POST['code'];

    if ($id > 0) {
        // Update Iklan
        $stmt = $conn->prepare("UPDATE ads SET position = ?, code = ? WHERE id = ?");
        $stmt->bind_param("ssi", $position, $code, $id);
        if ($stmt->execute()) {
            $success = "Iklan berhasil diperbarui!";
        } else {
            $error = "Terjadi kesalahan saat memperbarui iklan.";
        }
    } else {
        // Tambah Iklan
        $stmt = $conn->prepare("INSERT INTO ads (position, code) VALUES (?, ?)");
        $stmt->bind_param("ss", $position, $code);
        if ($stmt->execute()) {
            $success = "Iklan berhasil ditambahkan!";
        } else {
            $error = "Terjadi kesalahan saat menambahkan iklan.";
        }
    }
    $stmt->close();
}

// Hapus Iklan
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM ads WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $success = "Iklan berhasil dihapus!";
    } else {
        $error = "Terjadi kesalahan saat menghapus iklan.";
    }
    $stmt->close();
}

// Ambil Iklan
$ads = [];
$result = $conn->query("SELECT * FROM ads");
if ($result) {
    $ads = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Iklan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            margin-top: 70px; /* Sesuaikan dengan tinggi navbar */
            padding-bottom: 100px; /* Untuk footer */
            background-color: #f8f9fa; /* Warna latar belakang */
                }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="gejala.php">Kelola Gejala</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="penyakit.php">Kelola Penyakit</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="relasi.php">Kelola Relasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ads.php">Kelola Iklan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <!-- <h1 class="mb-4">Kelola Iklan</h1> -->
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#adModal">
        Tambah Iklan
    </button> -->

    <!-- Floating Tambah Gejala Button -->
<button class="btn btn-primary rounded-circle shadow-lg" 
        style="position: fixed; bottom: 30px; right: 30px; width: 60px; height: 60px; z-index: 9999; font-size: 30px; display: flex; align-items: center; justify-content: center;" 
        data-bs-toggle="modal" data-bs-target="#adModal">
    +
</button>
    
    <h2><i class="bi bi-code-slash"></i> Daftar Ads</h2>
    <hr>
    <div class="row">
    <?php foreach ($ads as $ad): ?>
    <div class="col-md-6 col-lg-4 mb-3">
        <div class="card shadow-sm border-secondary">
            <div class="card-body">
                <h5 class="card-title mb-2"><strong>Posisi:</strong> <?= htmlspecialchars($ad['position']) ?></h5>
                <p class="card-text">
                    <strong>Kode Iklan:</strong>
                    <pre class="bg-light p-2 border rounded small"><?= htmlspecialchars($ad['code']) ?></pre>
                </p>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-warning btn-sm"
                        data-bs-toggle="modal" data-bs-target="#adModal"
                        data-id="<?= $ad['id'] ?>"
                        data-position="<?= htmlspecialchars($ad['position']) ?>"
                        data-code="<?= htmlspecialchars($ad['code']) ?>">
                        Edit
                    </button>
                    <a href="?delete=<?= $ad['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus iklan ini?')">
                        Hapus
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

</div>

<!-- Modal Tambah/Edit Iklan -->
<div class="modal fade" id="adModal" tabindex="-1" aria-labelledby="adModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adModalLabel">Tambah/Edit Iklan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <input type="hidden" id="ad_id" name="id">
                    <div class="mb-3">
                        <label for="ad_position" class="form-label">Posisi Iklan</label>
                        <select class="form-select" id="ad_position" name="position" required>
                            <option value="footer">Footer</option>
                            <option value="sidebar">Sidebar</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ad_code" class="form-label">Kode Iklan</label>
                        <textarea class="form-control" id="ad_code" name="code" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" name="save_ad" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const adModal = document.getElementById('adModal');
    adModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Tombol yang diklik
        const id = button.getAttribute('data-id');
        const position = button.getAttribute('data-position');
        const code = button.getAttribute('data-code');

        // Isi data ke dalam form modal
        document.getElementById('ad_id').value = id || '';
        document.getElementById('ad_position').value = position || '';
        document.getElementById('ad_code').value = code || '';
    });
</script>
</body>
</html>