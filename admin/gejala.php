<?php
// session_start();
// Cek apakah user sudah login dan memiliki role admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Redirect ke halaman login jika bukan admin
    header("Location: ../login.php");
    exit;
}

include '../koneksi/db.php';

$result = $conn->query("SELECT * FROM gejala ORDER BY id_gejala ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Gejala</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Warna latar belakang */
            margin-top: 70px; /* Untuk menghindari tumpang tindih dengan navbar */
            margin-bottom: 50px; /* Untuk menghindari tumpang tindih dengan footer */
            padding-bottom: 100px; /* Untuk footer */
        }
        
        /* Tambahkan margin pada konten utama untuk menghindari tumpang tindih dengan navbar */
        .content {
            margin-top: 90px; /* Sesuaikan dengan tinggi navbar */
        }
        .btn-primary:hover {
            transform: scale(1.1);
            transition: 0.3s ease;
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
    <h2 class="mb-3"><i class="bi bi-list-task"></i> Data Gejala</h2>
    <hr>
    <!-- Floating Tambah Gejala Button -->
<button class="btn btn-primary rounded-circle shadow-lg" 
        style="position: fixed; bottom: 80px; right: 30px; width: 60px; height: 60px; z-index: 9999; font-size: 30px; display: flex; align-items: center; justify-content: center;" 
        data-bs-toggle="modal" data-bs-target="#modalTambah">
    +
</button>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <?php while ($g = $result->fetch_assoc()): ?>
    <div class="col">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Kode: <?= htmlspecialchars($g['id_gejala']) ?></h5>
                <p class="card-text">Gejala: <?= htmlspecialchars($g['nama_gejala']) ?></p>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <!-- Tombol Edit -->
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $g['id_gejala'] ?>">Edit</button>
                
                <!-- Tombol Hapus -->
                <a href="api/gejala_proses.php?hapus=<?= $g['id_gejala'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus gejala ini?')">Hapus</a>
            </div>
        </div>
    </div>

    

    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit<?= $g['id_gejala'] ?>" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="api/gejala_proses.php">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Edit Gejala</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_gejala" value="<?= $g['id_gejala'] ?>">
                        <div class="mb-3">
                            <label>Nama Gejala</label>
                            <input type="text" name="nama_gejala" class="form-control" value="<?= htmlspecialchars($g['nama_gejala']) ?>" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="edit" class="btn btn-primary">Simpan Perubahan</button>
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
        <form method="POST" action="api/gejala_proses.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Tambah Gejala</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Kode Gejala</label>
                        <input type="text" name="id_gejala" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Nama Gejala</label>
                        <input type="text" name="nama_gejala" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="tambah" class="btn btn-success">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const editGejalaModal = document.getElementById('editGejalaModal');
    editGejalaModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Tombol yang diklik
        const id = button.getAttribute('data-id');
        const kodeGejala = button.getAttribute('data-kode_gejala');
        const pertanyaan = button.getAttribute('data-pertanyaan');
        const cfPakar = button.getAttribute('data-cf_pakar');

        // Isi data ke dalam form modal
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_kode_gejala').value = kodeGejala;
        document.getElementById('edit_pertanyaan').value = pertanyaan;
        document.getElementById('edit_cf_pakar').value = cfPakar;
    });
</script>
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