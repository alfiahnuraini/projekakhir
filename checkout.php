<?php
include 'koneksi.php';

// Ambil data JSON dari JavaScript
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Data tidak valid."]);
    exit;
}

foreach ($data as $laporan) {
    $noMeja = $laporan['noMeja'];
    $namaProduk = $laporan['namaProduk'];
    $jumlah = $laporan['jmlh'];
    $subtotal = $laporan['subtotal'];
    $tanggal = $laporan['tanggal'];

    $stmt = $koneksi->prepare("INSERT INTO laporan (no_meja, nama_produk, jumlah, subtotal, tanggal) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssids", $noMeja, $namaProduk, $jumlah, $subtotal, $tanggal);
    $stmt->execute();
}

echo json_encode(["status" => "success", "message" => "Laporan berhasil disimpan ke database."]);
?>