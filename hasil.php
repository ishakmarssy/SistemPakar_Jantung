<?php
// session_start();
include 'koneksi/db.php';

// Ambil user_id dari session jika sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['user_id'];

$nama = $_POST['nama'];
$gejala_input = $_POST['gejala'];
$tanggal = date('Y-m-d H:i:s');

// Ambil nama gejala yang dipilih (nilai > 0)
$gejala_dipilih = [];
foreach ($gejala_input as $id_gejala => $nilai_user) {
    if ($nilai_user > 0) {
        $query = $conn->query("SELECT nama_gejala FROM gejala WHERE id_gejala = '$id_gejala'");
        $nama_gejala = $query->fetch_assoc()['nama_gejala'];

        if ($nilai_user == '0.2') {
            $tingkat = 'Kurang Yakin';
        } elseif ($nilai_user == '0.5') {
            $tingkat = 'Sering';
        } elseif ($nilai_user == '1.0') {
            $tingkat = 'Sangat Yakin';
        } else {
            $tingkat = 'Tidak Diketahui';
        }
        
        $gejala_dipilih[] = [
            'nama' => $nama_gejala,
            'tingkat' => $tingkat
        ];
    }
}

// Hitung CF untuk setiap penyakit
$cf_hasil = [];

$penyakit = $conn->query("SELECT * FROM penyakit");
while ($p = $penyakit->fetch_assoc()) {
    $cf_combine = 0;
    foreach ($gejala_input as $id_gejala => $nilai_user) {
        $rule = $conn->query("SELECT * FROM rule WHERE id_penyakit = '{$p['id_penyakit']}' AND id_gejala = '$id_gejala'");
        if ($rule->num_rows > 0) {
            $r = $rule->fetch_assoc();
            $cf = $nilai_user * $r['cf_pakar'];
            $cf_combine = $cf_combine + $cf * (1 - $cf_combine);
        }
    }
    if ($cf_combine > 0) {
        $cf_hasil[] = [
            'penyakit' => $p['nama_penyakit'],
            'cf' => $cf_combine
        ];
    }
}

// Ambil hasil tertinggi
usort($cf_hasil, fn($a, $b) => $b['cf'] <=> $a['cf']);
$hasil_akhir = $cf_hasil[0];

// Simpan ke database dengan user_id untuk riwayat diagnosa
$query = "INSERT INTO hasil_diagnosa (user_id, tanggal, nama_pasien, hasil, cf_total) 
          VALUES ('$user_id', '$tanggal', '$nama', '{$hasil_akhir['penyakit']}', '{$hasil_akhir['cf']}')";
$conn->query($query);
$id_hasil = $conn->insert_id; // Dapatkan id hasil yang baru disimpan

// Simpan detail diagnosa per gejala
foreach ($gejala_input as $id_gejala => $nilai_user) {
    $conn->query("INSERT INTO detail_diagnosa (id_hasil, id_gejala, nilai_user) VALUES ('$id_hasil', '$id_gejala', '$nilai_user')");
}

// Menampilkan SweetAlert untuk notifikasi sukses
echo "<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil Mendiagnosa!',
    text: 'Hasil diagnosa telah diproses dengan sukses.',
    timer: 3000,
    showConfirmButton: false
}).then(() => {
    window.location.href = 'riwayat.php'; // Redirect ke halaman riwayat setelah popup
});
</script>";
?>


<?php include 'includes/header.php'; ?>

    <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php"><i class="bi bi-clipboard-pulse"></i> Hasil Diagnosa</a>
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
                    <a class="nav-link" href="user/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-hasil">
    <h1><i class="bi bi-clipboard-pulse"></i> Hasil Diagnosa</h1>
    <hr>
    <p class="mb-3 mt-4">Terima kasih <strong><?= htmlspecialchars($nama) ?></strong>, telah melakukan diagnosa.</p>
    <p class="mb-2">Berikut adalah hasil diagnosa Anda:</p>
    <hr>
    <p class="mb-1">Nama: <?= htmlspecialchars($nama) ?></p>
    <p class="mb-1">Penyakit: <strong><?= htmlspecialchars($hasil_akhir['penyakit']) ?></strong></p>
    <p class="mb-1">Persentase Keyakinan: <?= round($hasil_akhir['cf'] * 100, 2) ?>%</p>
    <hr>
    <p class="mb-1 mt-4">Tanggal Diagnosa: <?= htmlspecialchars($tanggal) ?></p>
    <p class="mb-1">Gejala yang Dipilih:</p>
    <ul>
    <?php foreach ($gejala_dipilih as $g): ?>
        <li><?= htmlspecialchars($g['nama']) ?> - <strong><?= htmlspecialchars($g['tingkat']) ?></strong></li>
    <?php endforeach; ?>
    </ul>
    <!-- <p><a href="diagnosa.php">Kembali ke Halaman Diagnosa</a></p> -->
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
        <a class="nav-link text-center text-white" href="tentang.php">
            <i class="bi bi-info-circle"></i><br>Tentang
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil Mendiagnosa!',
        text: 'Hasil diagnosa telah diproses dengan sukses.',
        timer: 2500, // otomatis tertutup setelah 2 detik
        showConfirmButton: false
    });
});
</script>

<?php include 'includes/footer.php'; ?>