<?php
// session_start();
include '../koneksi/db.php';

// Ambil data untuk tabel dan modal
$rules = $conn->query("SELECT r.*, p.nama_penyakit, g.nama_gejala 
                       FROM rule r 
                       JOIN penyakit p ON r.id_penyakit = p.id_penyakit 
                       JOIN gejala g ON r.id_gejala = g.id_gejala 
                       ORDER BY r.id_rule ASC");

$penyakitList = $conn->query("SELECT * FROM penyakit")->fetch_all(MYSQLI_ASSOC);
$gejalaList = $conn->query("SELECT * FROM gejala")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Relasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Warna latar belakang */
            margin-top: 70px; /* Untuk menghindari tumpang tindih dengan navbar */
            padding-bottom: 100px; /* Untuk footer */
            margin-bottom: 40px; /* Untuk footer */
        }
        

        .content {
            margin-top: 70px;
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

<div class="container mt-4">
    <h2><i class="bi bi-gear-wide-connected"></i> Data Rule (Aturan)</h2>
    <hr>
    <!-- <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Rule</button> -->

    <!-- Floating Tambah Gejala Button -->
<button class="btn btn-primary rounded-circle shadow-lg" 
        style="position: fixed; bottom: 80px; right: 30px; width: 60px; height: 60px; z-index: 9999; font-size: 30px; display: flex; align-items: center; justify-content: center;" 
        data-bs-toggle="modal" data-bs-target="#modalTambah">
    +
</button>

    <div class="row">
    <?php foreach ($rules as $index => $r): ?>
    <div class="col-md-6 col-lg-4 mb-3">
        <div class="card shadow-sm border-primary">
            <div class="card-body">
                <h5 class="card-title mb-1">Rule #<?= $r['id_rule'] ?></h5>
                <p class="mb-1"><strong>Penyakit:</strong> <?= $r['nama_penyakit'] ?></p>
                <p class="mb-1"><strong>Gejala:</strong> <?= $r['nama_gejala'] ?></p>
                <p class="mb-3"><strong>CF Pakar:</strong> <?= $r['cf_pakar'] ?></p>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditRule<?= $index ?>">Edit</button>
                    <a href="api/rule_proses.php?hapus=<?= $r['id_rule'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

</div>

<!-- Modal Tambah -->
<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="api/rule_proses.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Tambah Rule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Penyakit</label>
                        <select name="id_penyakit" class="form-control" required>
                            <option value="">-- Pilih Penyakit --</option>
                            <?php foreach ($penyakitList as $p): ?>
                                <option value="<?= $p['id_penyakit'] ?>"><?= $p['nama_penyakit'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Gejala</label>
                        <select name="id_gejala" class="form-control" required>
                            <option value="">-- Pilih Gejala --</option>
                            <?php foreach ($gejalaList as $g): ?>
                                <option value="<?= $g['id_gejala'] ?>"><?= $g['nama_gejala'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>CF Pakar</label>
                        <input type="number" step="0.01" min="0" max="1" name="cf_pakar" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button name="tambah" class="btn btn-success">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<?php foreach ($rules as $index => $r): ?>
<div class="modal fade" id="modalEditRule<?= $index ?>" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="api/rule_proses.php">
            <input type="hidden" name="edit" value="1">
            <input type="hidden" name="id_rule" value="<?= $r['id_rule'] ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit Rule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Penyakit</label>
                        <select name="id_penyakit" class="form-select" required>
                            <?php foreach ($penyakitList as $p): ?>
                                <option value="<?= $p['id_penyakit'] ?>" <?= $p['id_penyakit'] == $r['id_penyakit'] ? 'selected' : '' ?>><?= $p['nama_penyakit'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Gejala</label>
                        <select name="id_gejala" class="form-select" required>
                            <?php foreach ($gejalaList as $g): ?>
                                <option value="<?= $g['id_gejala'] ?>" <?= $g['id_gejala'] == $r['id_gejala'] ? 'selected' : '' ?>><?= $g['nama_gejala'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>CF Pakar</label>
                        <input type="number" name="cf_pakar" step="0.01" min="0" max="1" class="form-control" value="<?= $r['cf_pakar'] ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php endforeach; ?>

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