<?php
include '../../koneksi/db.php';

// Tambah
if (isset($_POST['tambah'])) {
    $id = $_POST['id_gejala'];
    $nama = $_POST['nama_gejala'];

    $stmt = $conn->prepare("INSERT INTO gejala (id_gejala, nama_gejala) VALUES (?, ?)");
    $stmt->bind_param("ss", $id, $nama);
    $stmt->execute();
    header("Location: ../gejala.php");
    exit;
}

// Edit
if (isset($_POST['edit'])) {
    $id = $_POST['id_gejala'];
    $nama = $_POST['nama_gejala'];

    $stmt = $conn->prepare("UPDATE gejala SET nama_gejala=? WHERE id_gejala=?");
    $stmt->bind_param("ss", $nama, $id);
    $stmt->execute();
    header("Location: ../gejala.php");
    exit;
}

// Hapus
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    $stmt = $conn->prepare("DELETE FROM gejala WHERE id_gejala=?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    header("Location: ../gejala.php");
    exit;
}
?>
