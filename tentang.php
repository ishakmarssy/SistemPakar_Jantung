<?php
// session_start();
// Koneksi ke database
include 'koneksi/db.php';

// Proses input user
$jawaban = isset($_POST['gejala']) && is_array($_POST['gejala']) ? $_POST['gejala'] : [];
$cf_total = 0;
$cf_combine = null;

foreach ($jawaban as $kode_gejala => $value) {
    if (isset($gejala[$kode_gejala])) {
        $cf_pakar = $gejala[$kode_gejala];
        if ($cf_combine === null) {
            $cf_combine = $cf_pakar;
        } else {
            $cf_combine = $cf_combine + ($cf_pakar * (1 - $cf_combine));
        }
    }
}

$cf_total = $cf_combine;

// Ambil jenis penyakit berdasarkan gejala yang dipilih
$jenis_penyakit = [];
if (!empty($jawaban)) {
    $placeholders = implode(',', array_fill(0, count($jawaban), '?'));
    $stmt = $conn->prepare("
        SELECT DISTINCT p.nama_penyakit, p.deskripsi 
        FROM relasi_gejala_penyakit rgp
        JOIN penyakit p ON rgp.kode_penyakit = p.kode_penyakit
        WHERE rgp.kode_gejala IN ($placeholders)
    ");
    $stmt->bind_param(str_repeat('s', count($jawaban)), ...array_keys($jawaban));
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $jenis_penyakit[] = $row;
    }
    $stmt->close();
}

// Tentukan hasil diagnosa
$hasil = "";
if ($cf_total >= 0.7) {
    $hasil = "Kemungkinan besar Anda memiliki penyakit jantung.";
} elseif ($cf_total >= 0.4) {
    $hasil = "Kemungkinan Anda memiliki penyakit jantung.";
} else {
    $hasil = "Kemungkinan kecil Anda memiliki penyakit jantung.";
}

// Ambil nama pengguna
$nama_user = isset($_SESSION['username']) ? $_SESSION['username'] : (filter_input(INPUT_POST, 'nama_user', FILTER_SANITIZE_STRING) ?? 'Anonim');

// Simpan hasil diagnosa ke database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("INSERT INTO hasil_diagnosa (nama_user, cf_total, hasil_diagnosa) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $nama_user, $cf_total, $hasil);
    $stmt->execute();
    $stmt->close();
}
?>

<?php include 'includes/header.php'; ?>


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
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <!--<li class="nav-item">
                    <a class="nav-link" href="laporan.php">Laporan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="tentang.php">Tentang</a>
                </li>-->
                <li class="nav-item">
                    <a class="nav-link" href="user/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">
<!-- <h3 class="text-center mb-4">Profil Developer</h3> -->
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card profile-card text-center shadow">
                <img src="assets/img/dev.jpg" class="card-img-top  mx-auto mt-4" alt="Foto Developer">
                <div class="card-body">
                    <h5 class="card-title">Ishak Marasabessy</h5>
                    <!-- <p class="card-text mb-1"><strong>NIM:</strong> 18024014075</p> -->
                    <p class="card-text mb-1"><strong>Lokasi:</strong> Masohi</p>
                    <p class="card-text">"Jangan takut ERROR, mereka adalah guru terbaik dalam dunia coding."</p>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>


<!-- Main Content -->
<div class="container content">
    <h1 class="text-center mb-4">Tentang Sistem Pakar Penyakit Jantung</h1>
    <div class="card">
    <div class="card-body">
    <p>
        Sistem Pakar Penyakit Jantung merupakan aplikasi berbasis web yang dikembangkan oleh <strong>Ishak Marasabessy (NIM 18024014075)</strong> sebagai bagian dari tugas akhir/skripsi. 
        Aplikasi ini dirancang untuk membantu pengguna dalam mendiagnosis kemungkinan penyakit jantung berdasarkan gejala yang dirasakan, khususnya di wilayah <strong>Masohi</strong>.
    </p>
    <p>
        Sistem ini menggunakan metode <strong>Certainty Factor (CF)</strong> untuk menghitung tingkat kepastian dari hasil diagnosa yang diberikan.
    </p>
    <p>
        Dengan menggunakan aplikasi ini, pengguna dapat:
    </p>
    <ul>
        <li>Memilih gejala-gejala yang sesuai dengan kondisi mereka.</li>
        <li>Mendapatkan hasil diagnosa lengkap dengan tingkat kepastian (persentase).</li>
        <li>Melihat riwayat atau laporan dari hasil diagnosa yang telah dilakukan.</li>
    </ul>
    <p>
        Aplikasi ini dikembangkan untuk tujuan edukasi dan sebagai alat bantu awal, bukan sebagai pengganti dari konsultasi medis secara langsung. 
        Jika Anda mengalami gejala serius, segera hubungi dokter atau fasilitas kesehatan terdekat.
    </p>
</div>

    </div>
    <!--<div class="text-center mt-4">
        <a href="index.php" class="btn btn-primary">Kembali ke Halaman Utama</a>
    </div>-->
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

<script src="js/tentang.js"></script>
<?php include 'includes/footer.php'; ?>