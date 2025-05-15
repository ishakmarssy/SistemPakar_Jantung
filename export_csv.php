<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "sistem_pakar";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil parameter pencarian
$search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING) ?? '';

// Query data berdasarkan pencarian dengan prepared statements
$stmt = $conn->prepare("SELECT * FROM hasil_diagnosa WHERE nama_user LIKE ? OR tanggal_diagnosa LIKE ? ORDER BY tanggal_diagnosa DESC");
$search_param = "%$search%";
$stmt->bind_param("ss", $search_param, $search_param);
$stmt->execute();
$result = $stmt->get_result();

// Header untuk file CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=laporan_diagnosa.csv');
header('Pragma: no-cache');
header('Expires: 0');

// Buat file CSV
$output = fopen('php://output', 'w');
fputcsv($output, ['No', 'Nama User', 'CF Total', 'Hasil Diagnosa', 'Tanggal Diagnosa']);

if ($result->num_rows > 0) {
    $no = 1;
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $no++,
            $row['nama_user'],
            $row['cf_total'],
            $row['hasil_diagnosa'],
            $row['tanggal_diagnosa']
        ]);
    }
}
fclose($output);
exit;
?>