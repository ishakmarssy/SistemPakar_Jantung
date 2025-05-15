<?php
// Koneksi ke database
include '../koneksi/db.php'; // Pastikan koneksi ke database sudah benar

// Mengambil data dari tabel map
$sql = "SELECT * FROM map"; // Sesuaikan nama tabelnya
$result = $conn->query($sql);

// Cek apakah query berhasil dijalankan
if ($result === false) {
    echo "Error: " . $conn->error; // Jika query gagal, tampilkan error
} else {
    // Cek apakah ada data
    if ($result->num_rows > 0) {
        // Ambil data hasil query dan simpan ke dalam array
        $maps = [];
        while ($row = $result->fetch_assoc()) {
            $maps[] = $row;
        }
    } else {
        $maps = []; // Jika tidak ada data
    }
}

// Menutup koneksi
$conn->close();

// Cek apakah sudah ada data, jika ada maka nonaktifkan tombol tambah
$isMapExist = count($maps) > 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lokasi Map</title>
    <!-- Sertakan Bootstrap atau framework lain jika perlu -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Warna latar belakang */
            margin-top: 70px; /* Untuk menghindari tumpang tindih dengan navbar */
            padding-bottom: 100px; /* Untuk footer */
        }
        /* Navbar tetap di atas */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1030; /* Pastikan navbar berada di atas elemen lain */
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

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
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

    <div class="container mt-4">
        <h2>Daftar Lokasi Map</h2>

        <!-- Tombol Tambah Lokasi (Nonaktif jika sudah ada satu lokasi) -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal" <?php echo $isMapExist ? 'disabled' : ''; ?>>+ Tambah Lokasi</button>

        <!-- Card Daftar Lokasi -->
        <div class="row">
            <?php if (!empty($maps)): ?>
                <?php foreach ($maps as $map): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($map['lokasi']) ?></h5>
                                <p class="card-text"><pre><?= htmlspecialchars($map['embed_src']) ?></pre></p>
                                <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?= $map['id'] ?>" data-lokasi="<?= htmlspecialchars($map['lokasi']) ?>" data-embed="<?= htmlspecialchars($map['embed_src']) ?>">Edit</a>
                                <a href="delete_map.php?id=<?= $map['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus lokasi ini?')">Hapus</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">Tidak ada data yang ditemukan.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal Tambah Lokasi -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="add_map_process.php">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Tambah Lokasi Map</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" name="lokasi" id="lokasi" required>
                        </div>
                        <div class="mb-3">
                            <label for="embed_src" class="form-label">Embed Google Maps</label>
                            <textarea class="form-control" name="embed_src" id="embed_src" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Lokasi -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="api/edit_map_process.php">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Lokasi Map</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editId">
                        <div class="mb-3">
                            <label for="editLokasi" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" name="lokasi" id="editLokasi" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEmbedSrc" class="form-label">Embed Google Maps</label>
                            <textarea class="form-control" name="embed_src" id="editEmbedSrc" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Sertakan JS untuk Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Mengisi modal edit dengan data yang dipilih
        var editModal = document.getElementById('editModal')
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget
            var id = button.getAttribute('data-id')
            var lokasi = button.getAttribute('data-lokasi')
            var embed = button.getAttribute('data-embed')

            var modalId = editModal.querySelector('#editId')
            var modalLokasi = editModal.querySelector('#editLokasi')
            var modalEmbedSrc = editModal.querySelector('#editEmbedSrc')

            modalId.value = id
            modalLokasi.value = lokasi
            modalEmbedSrc.value = embed
        })
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
