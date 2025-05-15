<?php
include '../../koneksi/db.php';

// Tambah data
if (isset($_POST['tambah'])) {
    $id         = $_POST['id_penyakit'];
    $nama       = $_POST['nama_penyakit'];
    $deskripsi  = $_POST['deskripsi'];
    $saran      = $_POST['saran'];

    $stmt = $conn->prepare("INSERT INTO penyakit (id_penyakit, nama_penyakit, deskripsi, saran) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $id, $nama, $deskripsi, $saran);
    
    if ($stmt->execute()) {
        header("Location: ../penyakit.php?msg=tambah_sukses");
    } else {
        echo "Gagal menambahkan data: " . $conn->error;
    }
    exit;
}

// Edit data
if (isset($_POST['edit'])) {
    $id         = $_POST['id_penyakit'];
    $nama       = $_POST['nama_penyakit'];
    $deskripsi  = $_POST['deskripsi'];
    $saran      = $_POST['saran'];

    $stmt = $conn->prepare("UPDATE penyakit SET nama_penyakit=?, deskripsi=?, saran=? WHERE id_penyakit=?");
    $stmt->bind_param("ssss", $nama, $deskripsi, $saran, $id);

    if ($stmt->execute()) {
        header("Location: ../penyakit.php?msg=edit_sukses");
    } else {
        echo "Gagal mengedit data: " . $conn->error;
    }
    exit;
}

// Hapus data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    $stmt = $conn->prepare("DELETE FROM penyakit WHERE id_penyakit=?");
    $stmt->bind_param("s", $id);

    if ($stmt->execute()) {
        header("Location: ../penyakit.php?msg=hapus_sukses");
    } else {
        echo "Gagal menghapus data: " . $conn->error;
    }
    exit;
}
?>
