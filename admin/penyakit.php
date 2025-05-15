<?php
include '../koneksi/db.php'; // koneksi ke database

// Ambil data penyakit
$penyakit = $conn->query("SELECT * FROM penyakit ORDER BY id_penyakit ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Data Penyakit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa; /* Warna latar belakang */
            margin-top: 70px; /* Untuk menghindari tumpang tindih dengan navbar */
            margin-bottom: 130px; /* Untuk menghindari tumpang tindih dengan navbar bawah */
        }
        
        
        .table-responsive {
            margin-top: 80px; /* Sesuaikan dengan tinggi navbar */
        }
        .btn-primary:hover {
            transform: scale(1.1);
            transition: 0.3s ease;
        }
        .modal-header {
            background-color: #007bff;
            color: white;
        }
        .modal-footer {
            background-color: #f1f1f1;
        }
        #content {
            margin-top: 56px; /* Tambahkan margin untuk navbar */
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }
        /* Navbar untuk mobile */
        #mobile-navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1030;
            background-color: #343a40;
            color: white;
        }

        #mobile-navbar .nav-link {
            color: white;
        }

        #mobile-navbar .nav-link:hover {
            background-color: #495057;
            border-radius: 5px;
        }

        /* Tampilkan sidebar pada layar besar */
        @media (min-width: 992px) {
            #mobile-navbar {
                display: none;
            }
        }
        .navbar.fixed-bottom {
            height: 60px; /* Tinggi navbar bawah */
            background-color: var(--primary-color); /* Warna utama navbar bawah */
        }

        .navbar.fixed-bottom .nav-link {
            font-size: 12px; /* Ukuran teks */
        }

        .navbar.fixed-bottom .bi {
            font-size: 20px; /* Ukuran ikon */
        }
        .navbar {
            background: #00c6ff;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #0072ff, #00c6ff);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #0072ff, #00c6ff); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */


}

.navbar .nav-link {
    color: white; /* Warna teks link */
    transition: color 0.3s ease;
}

.navbar .nav-link:hover {
    color: var(--link-hover-color); /* Warna link saat hover */
}
        </style>
</head>
<body>
    <!-- Navbar -->
<!-- Navbar untuk Mobile -->
<nav id="mobile-navbar" class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNavbarContent" aria-controls="mobileNavbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mobileNavbarContent">
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
                    <a class="nav-link" href="rule.php">
                    <i class="bi bi-gear"></i> Kelola Relasi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ads.php">
                        <i class="bi bi-link-45deg"></i> Kelola Ads
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="map_list.php">
                    <i class="bi bi-pin-map-fill"></i> Atur Lokasi
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="laporan.php">
                        <i class="bi bi-file-earmark-text"></i> Laporan
                    </a>
                </li> -->
                <!-- <li class="nav-item">
                    <a class="nav-link" href="tentang.php">
                        <i class="bi bi-info-circle"></i> Tentang
                    </a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link text-danger" href="logout.php">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Navbar untuk mobile -->
<nav class="navbar navbar-expand navbar-dark fixed-bottom d-md-none">
    <div class="container justify-content-around">
        <a class="nav-link text-center text-white" href="index.php">
            <i class="bi bi-house-door"></i><br>Home
        </a>
        <a class="nav-link text-center text-white" href="gejala.php">
            <i class="bi bi-clipboard-data"></i><br>Gejala
        </a>
        <a class="nav-link text-center text-white" href="penyakit.php">
            <i class="bi bi-heart-pulse"></i><br>Penyakit
        </a>
        <a class="nav-link text-center text-white" href="rule.php">
        <i class="bi bi-gear"></i><br>Rule
        </a>
    </div>
</nav>

<div class="container mt-5">
<h2 class="mb-3"><i class="bi bi-list-task"></i> Data Penyakit</h2>
<hr>

<!-- Floating Tambah Gejala Button -->
<button class="btn btn-primary rounded-circle shadow-lg" 
        style="position: fixed; 
        bottom: 80px; 
        right: 30px; 
        width: 60px; 
        height: 60px; 
        z-index: 9999; 
        font-size: 30px; 
        display: flex; 
        align-items: center; 
        justify-content: center;" 
        data-bs-toggle="modal" data-bs-target="#modalTambah">
    +
</button>

    <!-- Tombol Tambah
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Penyakit</button> -->

    <div class="row">
    <?php while ($p = $penyakit->fetch_assoc()): ?>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($p['nama_penyakit']) ?> (<strong><?= htmlspecialchars($p['id_penyakit']) ?></strong>)</h5>
                    <p class="card-text"><strong>Deskripsi:</strong><br><?= nl2br(htmlspecialchars($p['deskripsi'])) ?></p>
                    <p class="card-text"><strong>Saran:</strong><br><?= nl2br(htmlspecialchars($p['saran'])) ?></p>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <!-- Edit Button -->
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $p['id_penyakit'] ?>">Edit</button>
                    <!-- Hapus Button -->
                    <a href="api/penyakit_proses.php?hapus=<?= $p['id_penyakit'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="modalEdit<?= $p['id_penyakit'] ?>" tabindex="-1">
            <div class="modal-dialog">
                <form method="post" action="api/penyakit_proses.php">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Penyakit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="edit" value="1">
                            <div class="mb-3">
                                <label>Kode Penyakit</label>
                                <input type="text" class="form-control" name="id_penyakit" value="<?= $p['id_penyakit'] ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label>Nama Penyakit</label>
                                <input type="text" class="form-control" name="nama_penyakit" value="<?= $p['nama_penyakit'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" required><?= $p['deskripsi'] ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Saran</label>
                                <textarea class="form-control" name="saran" required><?= $p['saran'] ?></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php endwhile; ?>
</div>

</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog">
    <form method="post" action="api/penyakit_proses.php">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Penyakit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label>Kode Penyakit</label>
                <input type="text" class="form-control" name="id_penyakit" required>
            </div>
            <div class="mb-3">
                <label>Nama Penyakit</label>
                <input type="text" class="form-control" name="nama_penyakit" required>
            </div>
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea class="form-control" name="deskripsi" required></textarea>
            </div>
            <div class="mb-3">
                <label>Saran</label>
                <textarea class="form-control" name="saran" required></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="tambah" class="btn btn-success">Tambah</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
