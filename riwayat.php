<?php
// session_start();
require 'koneksi/db.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil histori diagnosa berdasarkan user_id
$query = "SELECT id, tanggal, nama_pasien, hasil, cf_total 
          FROM hasil_diagnosa 
          WHERE user_id = ? 
          ORDER BY tanggal DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<?php include 'includes/header.php'; ?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">Sistem Pakar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="user/profile.php">Hi, <?= htmlspecialchars($_SESSION['display_name'] ?? $_SESSION['username']) ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user/logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Navbar Bawah (Hanya untuk Mobile) -->
<?php if (isset($_SESSION['username'])): ?>
<nav class="navbar navbar-expand navbar-dark fixed-bottom d-md-none">
    <div class="container justify-content-around">
        <a class="nav-link text-center text-white" href="index.php">
            <i class="bi bi-house-door"></i><br>Home
        </a>
        <a class="nav-link text-center text-white" href="diagnosa.php">
            <i class="bi bi-clipboard-data"></i><br>Diagnosa
        </a>
        <a class="nav-link text-center text-white" href="jenis_penyakit.php">
            <i class="bi bi-heart-pulse"></i><br>Penyakit
        </a>
        <a class="nav-link text-center text-white" href="riwayat.php">
            <i class="bi bi-info-circle"></i><br>Riwayat
        </a>
    </div>
</nav>
<?php endif; ?>

<div class="container mt-5">
    <h4 class="mb-4"><i class="bi bi-clock-history"></i> Riwayat Diagnosa Anda</h4>
    <?php if ($result->num_rows > 0): ?>
        <div class="row row-cols-1 row-cols-md-2 g-1">
            <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                <div class="col">
                    <div class="card border-primary shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-1">Diagnosa #<?= $no++ ?></h5>
                            <p class="card-text mb-1"><strong>Tanggal:</strong> <?= date('d-m-Y H:i', strtotime($row['tanggal'])) ?></p>
                            <p class="card-text mb-1"><strong>Nama Pasien:</strong> <?= htmlspecialchars($row['nama_pasien']) ?></p>
                            <p class="card-text mb-1"><strong>Hasil Diagnosa:</strong> <?= htmlspecialchars($row['hasil']) ?></p>
                            <p class="card-text mb-1"><strong>CF Total:</strong> <?= round($row['cf_total'] * 100, 2) ?>%</p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Belum ada riwayat diagnosa.</div>
    <?php endif; ?>
</div>



<script src="js/riwayat.js"></script>
<?php include 'includes/footer.php'; ?>
