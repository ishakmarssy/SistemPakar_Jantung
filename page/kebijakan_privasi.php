<!-- filepath: c:\xampp\htdocs\BetaPakar\page\kebijakan_privasi.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebijakan Privasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #bd2a73; /* Warna utama */
            --primary-hover-color: #0056b3; /* Warna utama saat hover */
            --secondary-color: #e84118; /* Warna sekunder */
            --background-color: #f8f9fa; /* Warna latar belakang */
            --text-color: #212529; /* Warna teks */
            --link-hover-color: #ffcc00; /* Warna link saat hover */
        }
        body {
            background-color: #f8f9fa;
            padding-top: 70px; /* Untuk navbar fixed-top */
            padding-bottom: 60px; /* Untuk navbar fixed-bottom */
        }

        .navbar {
            background-color:   #00B4DB;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #0083B0, #00B4DB);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #0083B0, #00B4DB); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        }

        .navbar .nav-link {
            color: white;
        }

        .navbar .nav-link:hover {
            color: #ffcc00;
        }

        .content {
            margin-top: 20px;
        }

        .navbar.fixed-bottom {
            height: 60px;
            background-color: var(--primary-color); /* Warna utama navbar bawah */
        }

        .navbar.fixed-bottom .nav-link {
            font-size: 12px;
        }

        .navbar.fixed-bottom .bi {
            font-size: 20px;
        }
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="../index.php">Sistem Pakar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../diagnosa.php">Diagnosa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../jenis_penyakit.php">Jenis Penyakit</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="kebijakan_privasi.php">Kebijakan Privasi</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container content">
    <h1 class="text-center mb-4">Kebijakan Privasi</h1>
    <div class="card">
        <div class="card-body">
            <p>
                Kami menghargai privasi Anda dan berkomitmen untuk melindungi informasi pribadi Anda. Halaman ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi data Anda saat menggunakan aplikasi Sistem Pakar Penyakit Jantung.
            </p>
            <h4>Informasi yang Kami Kumpulkan</h4>
            <ul>
                <li>Informasi yang Anda berikan secara langsung, seperti nama dan data gejala yang Anda masukkan.</li>
                <li>Data teknis, seperti alamat IP, jenis perangkat, dan browser yang Anda gunakan.</li>
            </ul>
            <h4>Bagaimana Kami Menggunakan Informasi Anda</h4>
            <ul>
                <li>Untuk memberikan hasil diagnosa berdasarkan gejala yang Anda masukkan.</li>
                <li>Untuk meningkatkan kualitas layanan kami.</li>
                <li>Untuk tujuan analisis dan pengembangan aplikasi.</li>
            </ul>
            <h4>Keamanan Data</h4>
            <p>
                Kami menggunakan langkah-langkah keamanan yang sesuai untuk melindungi data Anda dari akses yang tidak sah, perubahan, atau pengungkapan.
            </p>
            <h4>Perubahan Kebijakan</h4>
            <p>
                Kebijakan privasi ini dapat diperbarui dari waktu ke waktu. Kami akan memberi tahu Anda tentang perubahan melalui halaman ini.
            </p>
            <h4>Hubungi Kami</h4>
            <p>
                Jika Anda memiliki pertanyaan tentang kebijakan privasi ini, silakan hubungi kami melalui email di <a href="mailto:support@sistempakar.com">support@sistempakar.com</a>.
            </p>
        </div>
    </div>
</div>

<!-- Navbar Bawah (Hanya untuk Mobile) -->
<nav class="navbar navbar-expand navbar-dark fixed-bottom d-md-none">
    <div class="container justify-content-around">
        <a class="nav-link text-center text-white" href="../index.php">
            <i class="bi bi-house-door"></i><br>Home
        </a>
        <a class="nav-link text-center text-white" href="../diagnosa.php">
            <i class="bi bi-clipboard-data"></i><br>Diagnosa
        </a>
        <a class="nav-link text-center text-white" href="../jenis_penyakit.php">
            <i class="bi bi-heart-pulse"></i><br>Penyakit
        </a>
        <a class="nav-link text-center text-white" href="../tentang.php">
            <i class="bi bi-info-circle"></i><br>Tentang
        </a>
    </div>
</nav>

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