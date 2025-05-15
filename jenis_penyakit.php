<?php
// session_start();

// Koneksi ke database
include 'koneksi/db.php';

// Ambil data penyakit dari database
$penyakit = [];
$sql = "SELECT * FROM penyakit";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $penyakit[] = $row;
    }
}
?>

<?php include 'includes/header.php'; ?>


<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">SisPak Jantung</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="diagnosa.php">Diagnosa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tentang.php">Tentang</a>
                </li>
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container mt-5 ">
    <h1 class="text-center mb-4">Jenis Penyakit</h1>
    <div class="row  main-content">
        <?php foreach ($penyakit as $index => $p): ?>
            <div class="col-md-4">
                <div class="card position-relative" data-bs-toggle="modal" data-bs-target="#modalPenyakit<?= $index ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($p['nama_penyakit']) ?></h5>
                    </div>
                    <!-- Arrow Right -->
                    <div class="arrow-right">
                        <i class="bi bi-arrow-right-circle"></i>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modalPenyakit<?= $index ?>" tabindex="-1" aria-labelledby="modalPenyakitLabel<?= $index ?>" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalPenyakitLabel<?= $index ?>"><?= htmlspecialchars($p['nama_penyakit']) ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><?= nl2br(htmlspecialchars($p['deskripsi'])) ?></p>
                            <hr>
                            <h6><strong>Saran Penanganan:</strong></h6>
                            <p><?= nl2br(htmlspecialchars($p['saran'])) ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

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
<?php include 'includes/footer.php'; ?>