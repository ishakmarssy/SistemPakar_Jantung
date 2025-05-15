<?php
// session_start();
include '../koneksi/db.php'; // Ganti dengan path ke file koneksi database Anda

// Inisialisasi variabel
$cf_total = 0; // Nilai default untuk menghindari error
$search = $_GET['search'] ?? '';

// Pagination
$limit = 10; // Jumlah data per halaman
$page = $_GET['page'] ?? 1;
$offset = ($page - 1) * $limit;

// Hitung total data
$total_sql = "SELECT COUNT(*) AS total FROM hasil_diagnosa WHERE nama_user LIKE '%$search%' OR tanggal_diagnosa LIKE '%$search%'";
$total_result = $conn->query($total_sql);
$total_data = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_data / $limit);

// Query dengan limit dan offset
$sql = "SELECT nama_user, cf_total, hasil_diagnosa, tanggal_diagnosa 
        FROM hasil_diagnosa 
        WHERE nama_user LIKE '%$search%' OR tanggal_diagnosa LIKE '%$search%' 
        ORDER BY tanggal_diagnosa DESC 
        LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Hapus semua data jika tombol "Hapus Semua" ditekan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_all'])) {
    $delete_sql = "DELETE FROM hasil_diagnosa";
    $conn->query($delete_sql);
    header("Location: laporan.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Diagnosa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Navbar tetap di atas */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1030; /* Pastikan navbar berada di atas elemen lain */
        }

        /* Tambahkan margin pada konten utama untuk menghindari tumpang tindih dengan navbar */
        .content {
            margin-top: 80px; /* Sesuaikan dengan tinggi navbar */
        }
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        <i class="bi bi-house-door"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="gejala.php">
                        <i class="bi bi-clipboard-data"></i> Kelola Gejala
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="penyakit.php">
                        <i class="bi bi-heart-pulse"></i> Kelola Penyakit
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="laporan.php">
                        <i class="bi bi-file-earmark-text"></i> Laporan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tentang.php">
                        <i class="bi bi-info-circle"></i> Tentang
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="logout.php">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container content">
    <h1 class="text-center">Laporan Diagnosa</h1>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <form method="GET" action="export_csv.php">
            <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn btn-success">Export ke CSV</button>
        </form>
        <form method="POST" action="">
            <button type="submit" name="delete_all" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus semua data?')">
                Hapus Semua
            </button>
        </form>
        <form method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari berdasarkan nama atau tanggal..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama User</th>
                <th>CF Total</th>
                <th>Hasil Diagnosa</th>
                <th>Tanggal Diagnosa</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $no = $offset + 1; while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama_user']) ?></td>
                        <td><?= number_format($row['cf_total'], 2) ?></td>
                        <td><?= htmlspecialchars($row['hasil_diagnosa']) ?></td>
                        <td><?= htmlspecialchars($row['tanggal_diagnosa']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Belum ada data diagnosa.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-between align-items-center mt-3">
        <p>Total Data: <?= $total_data ?></p>
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?search=<?= htmlspecialchars($search) ?>&page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
    <a href="index.php" class="btn btn-primary">Kembali</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('click', function (event) {
        const navbarToggler = document.querySelector('.navbar-toggler');
        const navbarCollapse = document.querySelector('.navbar-collapse');

        // Periksa apakah klik terjadi di luar navbar dan navbar sedang terbuka
        if (navbarCollapse.classList.contains('show') && !navbarToggler.contains(event.target) && !navbarCollapse.contains(event.target)) {
            navbarToggler.click(); // Tutup navbar
        }
    });
</script>
</body>
</html>