<?php
include '../../koneksi/db.php';

// Tambah Rule
if (isset($_POST['tambah'])) {
    $id_penyakit = $_POST['id_penyakit'];
    $id_gejala = $_POST['id_gejala'];
    $cf_pakar = $_POST['cf_pakar'];

    $stmt = $conn->prepare("INSERT INTO rule (id_penyakit, id_gejala, cf_pakar) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $id_penyakit, $id_gejala, $cf_pakar);
    $stmt->execute();
    $stmt->close();

    header("Location: ../rule.php");
    exit;
}

// Edit Rule
if (isset($_POST['edit'])) {
    $id_rule = $_POST['id_rule'];
    $id_penyakit = $_POST['id_penyakit'];
    $id_gejala = $_POST['id_gejala'];
    $cf_pakar = $_POST['cf_pakar'];

    $stmt = $conn->prepare("UPDATE rule SET id_penyakit=?, id_gejala=?, cf_pakar=? WHERE id_rule=?");
    $stmt->bind_param("ssdi", $id_penyakit, $id_gejala, $cf_pakar, $id_rule);
    $stmt->execute();
    $stmt->close();

    header("Location: ../rule.php");
    exit;
}

// Hapus Rule
if (isset($_GET['hapus'])) {
    $id_rule = $_GET['hapus'];
    $stmt = $conn->prepare("DELETE FROM rule WHERE id_rule = ?");
    $stmt->bind_param("i", $id_rule);
    $stmt->execute();
    $stmt->close();

    header("Location: ../rule.php");
    exit;
}
?>
