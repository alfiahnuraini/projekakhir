<?php
header('Content-Type: application/json');

// Ambil data JSON
$data = json_decode(file_get_contents('php://input'), true);

// Validasi input
if (!$data || !isset($data['nama']) || !isset($data['jumlah'])) {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
    exit;
}

// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "namadatabase"); // GANTI namadatabase!

if ($koneksi->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Koneksi gagal']);
    exit;
}

// Ambil data
$nama = $koneksi->real_escape_string($data['nama']);
$jumlah = intval($data['jumlah']);
$level = $koneksi->real_escape_string($data['level']);
$catatan = $koneksi->real_escape_string($data['catatan']);
$harga = intval($data['harga']);

$sql = "INSERT INTO keranjang (nama, jumlah, level, catatan, harga)
        VALUES ('$nama', $jumlah, '$level', '$catatan', $harga)";

if ($koneksi->query($sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $koneksi->error]);
}

$koneksi->close();
?>
