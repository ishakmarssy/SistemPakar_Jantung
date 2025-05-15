<?php
// session_start();
// Cek apakah user sudah login dan memiliki role admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Redirect ke halaman login jika bukan admin
    header("Location: ../login.php");
    exit;
}

include '../koneksi/db.php';

// Hitung total gejala
$result_gejala = $conn->query("SELECT COUNT(*) AS total FROM gejala");
$total_gejala = $result_gejala->fetch_assoc()['total'];

// Hitung total penyakit
$result_penyakit = $conn->query("SELECT COUNT(*) AS total FROM penyakit");
$total_penyakit = $result_penyakit->fetch_assoc()['total'];

// Hitung total relasi
$result_relasi = $conn->query("SELECT COUNT(*) AS total FROM rule");
$total_relasi = $result_relasi->fetch_assoc()['total'];

// Hitung total user
$result_user = $conn->query("SELECT COUNT(*) AS total FROM users");
$total_user = $result_user->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Sidebar untuk desktop */
        #sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
            display: block;
        }

        #sidebar .nav-link {
            color: white;
            margin: 10px 0;
        }

        #sidebar .nav-link:hover {
            background-color: #495057;
            border-radius: 5px;
        }

        #content {
            margin-top: 56px; /* Tambahkan margin untuk navbar */
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }

        /* Sembunyikan sidebar pada layar kecil */
        @media (max-width: 991px) {
            #sidebar {
                display: none;
            }

            #content {
                margin-left: 0;
                width: 100%;
            }

            #mobile-navbar {
                display: block;
                background-color: #343a40;
                color: white;
            }
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
        <a class="navbar-brand" href="#">Dashboard</a>
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
                        <i class="bi bi-link-45deg"></i> Kelola Relasi
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

<!-- Sidebar -->
<div id="sidebar">
    <h4 class="text-center py-3">Dashboard</h4>
    <ul class="nav flex-column px-3">
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
            <a class="nav-link" href="relasi.php">
                <i class="bi bi-link-45deg"></i> Kelola Relasi
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="ads.php">
                <i class="bi bi-link-45deg"></i> Kelola ADS
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="detail_user.php">
                <i class="bi bi-link-45deg"></i> Data User
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

<!-- Main Content -->
<div id="content">
    <div class="container">
    <h1>Hi!, <?= htmlspecialchars($_SESSION['display_name']) ?>!</h1>
    <p>Anda login sebagai: <strong><?= htmlspecialchars($_SESSION['role']) ?></strong></p>
        <hr>
        <!-- <p>Gunakan navigasi di sidebar untuk mengelola data sistem.</p> -->

        <!-- Card Total Data -->
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Gejala</h5>
                            <p class="card-text fs-3"><?= $total_gejala ?></p>
                        </div>
                        <i class="bi bi-clipboard-data fs-1"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Penyakit</h5>
                            <p class="card-text fs-3"><?= $total_penyakit ?></p>
                        </div>
                        <i class="bi bi-heart-pulse fs-1"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Relasi</h5>
                            <p class="card-text fs-3"><?= $total_relasi ?></p>
                        </div>
                        <i class="bi bi-link-45deg fs-1"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-black bg-warning mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total User</h5>
                            <p class="card-text fs-3"><?= $total_user ?></p>
                        </div>
                        <i class="bi bi-people fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>

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

<!-- Bootstrap JS -->
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