<?php
include 'config.php';

// Input berupa: [{"id_gejala":"G01", "tingkat":"sering"}, ...]
$data = json_decode(file_get_contents("php://input"), true);

$bobot_cf_user = [
    "kurang" => 0.4,
    "sering" => 0.7,
    "sangat" => 1.0
];

$hasil_cf = [];

// Loop input user
foreach ($data as $item) {
    $id_gejala = $item['id_gejala'];
    $tingkat = $item['tingkat'];
    $cf_user = $bobot_cf_user[$tingkat];

    // Ambil semua rule yang cocok
    $rule = mysqli_query($conn, "SELECT * FROM rule WHERE id_gejala='$id_gejala'");
    while ($r = mysqli_fetch_assoc($rule)) {
        $cf_pakar = $r['cf_pakar'];
        $cf_hasil = $cf_user * $cf_pakar;
        $id_penyakit = $r['id_penyakit'];

        if (!isset($hasil_cf[$id_penyakit])) {
            $hasil_cf[$id_penyakit] = $cf_hasil;
        } else {
            // Kombinasi CF
            $hasil_cf[$id_penyakit] = $hasil_cf[$id_penyakit] + ($cf_hasil * (1 - $hasil_cf[$id_penyakit]));
        }
    }
}

// Ambil penyakit dengan CF tertinggi
arsort($hasil_cf);
$tertinggi = array_key_first($hasil_cf);
$nilai_tertinggi = $hasil_cf[$tertinggi];

// Ambil detail penyakit
$query = mysqli_query($conn, "SELECT * FROM penyakit WHERE id_penyakit='$tertinggi'");
$penyakit = mysqli_fetch_assoc($query);

echo json_encode([
    "success" => true,
    "hasil" => [
        "id_penyakit" => $tertinggi,
        "nama_penyakit" => $penyakit['nama_penyakit'],
        "cf" => round($nilai_tertinggi, 3),
        "deskripsi" => $penyakit['deskripsi'],
        "saran" => $penyakit['saran']
    ]
]);
?>
