<?php
// session_start();

// Koneksi ke database
include '../koneksi/db.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil data dari session
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$display_name = $_SESSION['display_name'] ?? 'Nama Pengguna';

// Ambil data pengguna dari database
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Proses update profil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $display_name = $_POST['display_name'] ?? $user['display_name'];
    $profile_photo = $user['profile_photo'];
    $cover_photo = $user['cover_photo'];

    // Upload foto profil
    if (!empty($_FILES['profile_photo']['name'])) {
        $profile_photo = 'uploads/' . basename($_FILES['profile_photo']['name']);
        move_uploaded_file($_FILES['profile_photo']['tmp_name'], '../' . $profile_photo);
    }

    // Upload cover foto
    if (!empty($_FILES['cover_photo']['name'])) {
        $cover_photo = 'uploads/' . basename($_FILES['cover_photo']['name']);
        move_uploaded_file($_FILES['cover_photo']['tmp_name'], '../' . $cover_photo);
    }

    // Update data di database
    $sql = "UPDATE users SET display_name = ?, profile_photo = ?, cover_photo = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $display_name, $profile_photo, $cover_photo, $user_id);
    $stmt->execute();

    // Refresh halaman
    header("Location: profile.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
    --primary-color: #bd2a73; /* Warna utama */
    --primary-hover-color: #0056b3; /* Warna utama saat hover */
    --secondary-color: #6c757d; /* Warna sekunder */
    --background-color: #f8f9fa; /* Warna latar belakang */
    --text-color: #212529; /* Warna teks */
    --link-hover-color: #ffcc00; /* Warna link saat hover */
}

body {
    background-color: var(--background-color);
    padding-top: 50px; /* Untuk navbar fixed-top */
}

.profile-cover {
    height: 200px;
    background-size: cover;
    background-position: center;
    border-radius: 10px;
}

.profile-photo {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid white;
    margin-top: -75px;
}

footer {
    background-color: var(--primary-color); /* Warna utama footer */
    color: white; /* Warna teks footer */
}

footer a {
    color: var(--link-hover-color); /* Warna link di footer */
    text-decoration: none;
}

footer a:hover {
    text-decoration: underline; /* Efek hover pada link */
}

.navbar {
    background-color: #00B4DB;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #0083B0, #00B4DB);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #0083B0, #00B4DB); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
}

.navbar .nav-link {
    color: white; /* Warna teks link */
    transition: color 0.3s ease;
}

.navbar .nav-link:hover {
    color: var(--link-hover-color); /* Warna link saat hover */
}

.navbar.fixed-bottom {
    height: 60px; /* Tinggi navbar bawah */
    background-color: #00B4DB;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #0083B0, #00B4DB);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #0083B0, #00B4DB); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
}

.navbar.fixed-bottom .nav-link {
    font-size: 12px; /* Ukuran teks */
}

.navbar.fixed-bottom .bi {
    font-size: 20px; /* Ukuran ikon */
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
                    <a class="nav-link" href="../penyakit.php">Penyakit</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../tentang.php">Tentang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="card">
        <div class="card-body">
            <!-- Cover Photo -->
            <div class="profile-cover mb-3" style="background-image: url('../<?= htmlspecialchars($user['cover_photo'] ?? 'assets/img/default_cover.jpg') ?>');"></div>

            <!-- Profile Photo -->
            <div class="text-center">
                <img src="../<?= htmlspecialchars($user['profile_photo'] ?? 'assets/img/default_profile.jpg') ?>" alt="Profile Photo" class="profile-photo">
            </div>

            <!-- Display Name -->
            <h3 class="text-center mt-3"><?= htmlspecialchars($user['display_name'] ?? 'Nama Pengguna') ?></h3>

            <!-- Button to Open Modal -->
            <div class="text-center mt-4">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    <i class="bi bi-pencil"></i> Edit Profile
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="display_name" class="form-label">Nama Tampilan</label>
                        <input type="text" class="form-control" id="display_name" name="display_name" value="<?= htmlspecialchars($user['display_name'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="profile_photo" class="form-label">Foto Profil</label>
                        <input type="file" class="form-control" id="profile_photo" name="profile_photo">
                    </div>
                    <div class="mb-3">
                        <label for="cover_photo" class="form-label">Cover Foto</label>
                        <input type="file" class="form-control" id="cover_photo" name="cover_photo">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Navbar Bawah (Hanya untuk Mobile) -->
<?php if (isset($_SESSION['username'])): ?>
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
<?php endif; ?>

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