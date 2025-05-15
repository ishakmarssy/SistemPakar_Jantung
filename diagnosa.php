<?php
// session_start(); // Pastikan session dimulai

// Koneksi ke database
include 'koneksi/db.php';

$user_id = $_SESSION['user_id'];
$user = $conn->query("SELECT display_name FROM users WHERE id = '$user_id'")->fetch_assoc();

$gejala = $conn->query("SELECT * FROM gejala");
if (!$gejala) {
    die("Query gagal: " . $conn->error);
}


// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Oops! Belum Login</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet'>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.6/lottie.min.js'></script>
        <style>
            :root {
                --primary-color: #273c75;
                --primary-hover-color: #0056b3;
                --secondary-color: #e84118;
                --background-color: rgb(255, 255, 255);
                --text-color: #212529;
                --link-hover-color: #ffcc00;
            }
            h1 {
                font-size: 3rem;
                font-weight: bold;
                color: var(--secondary-color);
                text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
                margin-bottom: 20px;
                animation: bounce 1.5s infinite;
            }
            p {
                font-size: 1.2rem;
                color: var(--text-color);
                line-height: 1.6;
                margin-bottom: 20px;
            }
            @keyframes bounce {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-10px); }
            }
            .btn-primary {
                background-color: var(--primary-color);
                color: white;
                border: none;
                border-radius: 8px;
                font-size: 1.2rem;
                font-weight: bold;
                padding: 12px 24px;
                transition: background-color 0.3s ease, transform 0.2s ease;
            }
            .btn-primary:hover {
                background-color: var(--primary-hover-color);
                transform: scale(1.05);
            }
            .btn-primary:active {
                background-color: #c0392b;
                transform: scale(0.95);
            }
        </style>
    </head>
    <body>
        <div class='container text-center mt-5'>
            <h1>Oops!</h1>
            <p>Sepertinya Anda belum login. Silakan login terlebih dahulu untuk mengakses halaman ini.</p>
            <div id='oops-animation' style='width: 300px; height: 300px; margin: 0 auto;'></div>
            <a href='login.php' class='btn btn-primary mt-4'>Login</a>
        </div>
        <script>
            Swal.fire({
                title: 'Oops!',
                text: 'Sepertinya Anda belum login. Silakan login terlebih dahulu.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            lottie.loadAnimation({
                container: document.getElementById('oops-animation'),
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: 'assets/animations/oops.json'
            }).addEventListener('DOMLoaded', function () {
                console.log('Lottie animation loaded successfully!');
            });
        </script>
    </body>
    </html>";
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Sistem Pakar Diagnosa Penyakit Jantung</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.6/lottie.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary-color: #2a4fbd;
            --primary-hover-color: #0056b3;
            --secondary-color: #e84118;
            --background-color: rgb(255, 255, 255);
            --text-color: #212529;
            --link-hover-color: #ffcc00;
        }
        body {
            background-color: var(--background-color);
            padding-top: 20px;
            padding-bottom: 120px;
        }
        .card {
            margin-bottom: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: scale(1.01);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .card-title {
            font-size: 0.9rem;
            color: var(--primary-color);
            font-weight: bold;
        }
        .form-check-label {
            font-size: 0.8rem;
            color: rgb(244, 15, 15);
        }
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            border-radius: 50px;
            width: 50%;
            padding: 10px;
            font-size: 1.0rem;
            position: fixed;  /* Posisi tetap di bawah */
            bottom: 70px;  /* Tombol berada di bawah layar dengan jarak 20px */
            /* left: 50%;  Posisikan tombol di tengah layar secara horizontal */
            transform: translateX(-50%); /* Koreksi posisi agar benar-benar di tengah */
            
        }
        .btn-primary:hover {
            background-color: var(--primary-color);
        }
        .navbar {
            background-color: #00B4DB;
            background: -webkit-linear-gradient(to right, #0083B0, #00B4DB);
            background: linear-gradient(to right, #0083B0, #00B4DB);
        }
        .navbar .nav-link {
            color: white;
            transition: color 0.3s ease;
        }
        .navbar .nav-link:hover {
            color: var(--link-hover-color);
        }
        .sticky-button {
            position: fixed;
            bottom: 70px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
        }
        .main-content {
            animation: fadeIn 1s ease-out;
        }
        .navbar.fixed-bottom {
            height: 60px;
            background-color: var(--primary-color);
        }
        .navbar.fixed-bottom .nav-link {
            font-size: 12px;
        }
        .navbar.fixed-bottom .bi {
            font-size: 20px;
        }
        /* Container horizontal */
.gejala-options {
    display: flex;
    gap: 20px;
}
.gejala{
    font-size: 0.9rem;
    font-weight: bold;
    color: green;
    text-align: center;
    margin-bottom: 15px;
}

/* Semua opsi */
.form-check {
    display: flex;
    align-items: center;
    gap: 5px;
}

/* Warna khusus per pilihan */
.form-check.kurang label {
    background-color:rgb(215, 248, 220);
    color:rgb(28, 114, 101);
    padding: 6px 10px;
    border-radius: 5px;
}

.form-check.sering label {
    background-color: #fff3cd;
    color: #856404;
    padding: 6px 10px;
    border-radius: 5px;
}

.form-check.sangat label {
    background-color:rgb(237, 212, 212);
    color:rgb(126, 39, 39);
    padding: 6px 10px;
    border-radius: 5px;
}

/* Tambahan efek saat hover */
.form-check label:hover {
    opacity: 0.8;
    cursor: pointer;
}
        
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">Sistem Pakar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tentang.php">Tentang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="riwayat.php">Riwayat</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container mt-5">
    <h1 class="text-center mb-4">Pilih Gejala</h1>
    <form action="hasil.php" method="POST" id="form-diagnosa">
        <input type="hidden" name="nama" value="<?= $user['display_name'] ?>">
        <div class="row">
            <?php foreach ($gejala as $row): ?>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <label class="gejala fw-bold"><?= $row['nama_gejala'] ?>?</label>
                            <div class="d-flex flex-column gap-2 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gejala[<?= $row['id_gejala'] ?>]" value="0.2" id="g<?= $row['id_gejala'] ?>_1">
                                    <label class="form-check-label" for="g<?= $row['id_gejala'] ?>_1">Kurang</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gejala[<?= $row['id_gejala'] ?>]" value="0.5" id="g<?= $row['id_gejala'] ?>_2">
                                    <label class="form-check-label" for="g<?= $row['id_gejala'] ?>_2">Sering</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gejala[<?= $row['id_gejala'] ?>]" value="1.0" id="g<?= $row['id_gejala'] ?>_3">
                                    <label class="form-check-label" for="g<?= $row['id_gejala'] ?>_3">Sangat</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Submit Diagnosa</button>
        </div>
    </form>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
document.getElementById('formDiagnosa').addEventListener('submit', function(e) {
    const checkedGejala = document.querySelectorAll('input[type=radio]:checked');
    let totalDipilih = 0;

    const gejalaDipilih = {};
    checkedGejala.forEach((input) => {
        const name = input.name;
        if (input.value !== "0") {
            gejalaDipilih[name] = true;
        }
    });

    totalDipilih = Object.keys(gejalaDipilih).length;

    if (totalDipilih < 1 || totalDipilih > 5) {
        alert("Silakan pilih minimal 1 dan maksimal 5 gejala.");
        e.preventDefault();
    }
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const submitButton = document.querySelector('button[type="submit"]');
    const radioInputs = document.querySelectorAll('input[type="radio"]');

    // Matikan tombol saat pertama kali load
    submitButton.disabled = true;

    function checkSelection() {
        let anySelected = false;

        // Periksa jika ada radio yang terpilih
        radioInputs.forEach(input => {
            if (input.checked) {
                anySelected = true;
            }
        });

        // Aktifkan / nonaktifkan tombol
        submitButton.disabled = !anySelected;
    }

    // Tambahkan event listener ke semua radio
    radioInputs.forEach(input => {
        input.addEventListener('change', checkSelection);
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    form.addEventListener("submit", function (e) {
        e.preventDefault(); // cegah submit langsung

        Swal.fire({
            title: 'Sedang mendiagnosa...',
            html: 'Mohon tunggu sebentar.',
            timer: 3000, // waktu dalam milidetik (3000 = 3 detik)
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
                const b = Swal.getHtmlContainer().querySelector('b');
                let timerInterval = setInterval(() => {
                    b.textContent = Math.ceil(Swal.getTimerLeft() / 1000);
                }, 100);
            },
            willClose: () => {
                form.submit(); // submit form setelah loading selesai
            }
        });
    });
});
</script>

</body>
</html>
