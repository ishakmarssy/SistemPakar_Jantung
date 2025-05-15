<?php
// session_start();

include 'koneksi/db.php';

$map = $conn->query("SELECT * FROM map LIMIT 1")->fetch_assoc();

// Ambil Iklan
$ads = [];
$result = $conn->query("SELECT * FROM ads");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $ads[$row['position']] = $row['code'];
    }
}
?>
<?php include 'includes/header.php'; ?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">SisPak Jantung</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                    
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="user/profile.php">Profil</a>
                        <!-- <a class="nav-link" href="user/profile.php">Hi, <?= htmlspecialchars($_SESSION['display_name'] ?? $_SESSION['username']) ?></a> -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
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

<!-- Main Content -->
<div class="container mt-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 d-none d-md-block mt-5">
            <div class="card">
                <div class="card-header text-white text-center">
                    <strong>Menu</strong>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <a href="diagnosa.php" class="text-decoration-none">Diagnosa</a>
                    </li>
                    <li class="list-group-item">
                        <a href="jenis_penyakit.php" class="text-decoration-none">Jenis Penyakit</a>
                    </li>
                    <li class="list-group-item">
                        <a href="tentang.php" class="text-decoration-none">Tentang Aplikasi</a>
                    </li>
                </ul>
            </div>

            <!-- Iklan Sidebar -->
            <?php if (!empty($ads['sidebar'])): ?>
                <div class="mt-4">
                    <?= $ads['sidebar'] ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Konten Utama -->
        <div class="col-md-9">
            <div class="text-left mb-4" >
                <h1 class="judul mb-1">Sistem Pakar</h1>
                <h1 class="judul">Diagnosa Penyakit Jantung</h1>
                <hr>
                <?php if (isset($_SESSION['username'])): ?>
                    <h3 style="font-size: 1rem;">Hi, <strong><?= htmlspecialchars($_SESSION['display_name'] ?? $_SESSION['username']) ?></strong>! Sehat selalu yaaaa ;-)</h3>
                <?php else: ?>
                    <h3>Selamat datang di Sistem Pakar Penyakit Jantung!</h3>
                <?php endif; ?>
            </div>
            <hr>
            <h2 class="mb-4 judul"> <i class="bi bi-menu-app"></i> Menu</h2>
            <div class="row main-content">
                
                <!-- Diagnosa -->
                <div class="col-md-4">
                    <div class="card text-center position-relative" style="background-image: url('assets/img/diagnosa.jpeg'); background-size: cover; background-position: center; color: white;">
                        <div class="overlay"></div>
                        <div class="card-body position-relative">
                            <h5 class="card-title"><strong>Diagnosa</strong></h5>
                            <p class="card-text">Mulai diagnosa untuk mengetahui kemungkinan penyakit berdasarkan gejala.</p>
                            <a href="diagnosa.php" class="btn btn-light btn-warna">
                                Mulai Diagnosa <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Jenis Penyakit -->
                <div class="col-md-4">
                    <div class="card text-center position-relative" style="background-image: url('assets/img/jenispenyakit.jpg'); background-size: cover; background-position: center; color: white;">
                        <div class="overlay"></div>
                        <div class="card-body position-relative">
                            <h5 class="card-title"><strong>Jenis Penyakit</strong></h5>
                            <p class="card-text">Lihat daftar jenis penyakit yang tersedia dalam sistem pakar ini.</p>
                            <a href="jenis_penyakit.php" class="btn btn-light btn-warna">
                                Lihat Penyakit <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tentang Aplikasi -->
                <div class="col-md-4">
                    <div class="card text-center position-relative" style="background-image: url('assets/img/1.jpg'); background-size: cover; background-position: center; color: white;">
                        <div class="overlay"></div>
                        <div class="card-body position-relative">
                            <h5 class="card-title"><strong>Tentang Aplikasi</strong></h5>
                            <p class="card-text">Pelajari lebih lanjut tentang aplikasi sistem pakar ini.</p>
                            <a href="tentang.php" class="btn btn-light btn-warna">
                                Tentang Aplikasi <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <!-- Map Lokasi -->
            <div class="row mt-4">
                <h2 class="mb-4 judul"> <i class="bi bi-geo-alt"></i> Lokasi <?= htmlspecialchars($map['lokasi']) ?></h2>
                <div class="col-md-12">
                    <div class="card">
                        <!-- <div class="card-header bg-primary text-white">
                            <strong>Lokasi Rumah Sakit Rujukan di Masohi</strong>
                        </div> -->
                        <div class="card-body p-0">
                            <div style="width: 100%">
                            <?= $map['embed_src'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <!-- Iklan Bawah -->
            <div class="row mt-4">
                <h2 class="mb-4 judul"> <i class="bi bi-megaphone"></i> Ads</h2>
                <div class="col-md-12">
                    <?php if (!empty($ads['bottom'])): ?>
                        <?= $ads['bottom'] ?>
                    <?php else: ?>
                        <p>Tidak ada iklan saat ini.</p>
                    <?php endif; ?>
                </div>
            </div>
            <hr>
        </div>
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

<!-- Footer -->
<footer class="navbar text-white text-center py-3 mt-5">
    <p class="mb-2">&copy; <?= date('Y') ?> Sistem Pakar Penyakit Jantung. All Rights Reserved. <a href="page/kebijakan_privasi.php">Kebijakan Privasi</a></p>
</footer>


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
<script>
    // Menggunakan SweetAlert2 untuk menampilkan notifikasi
    <?php if (isset($_SESSION['message'])): ?>
        Swal.fire({
            icon: '<?= $_SESSION['message']['type'] ?>',
            title: '<?= $_SESSION['message']['title'] ?>',
            text: '<?= $_SESSION['message']['text'] ?>',
            showConfirmButton: false,
            timer: 3000
        });
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
</script>
<?php include 'includes/footer.php'; ?>