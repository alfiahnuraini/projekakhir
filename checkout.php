<?php
include 'koneksi.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Data tidak valid."]);
    exit;
}

foreach ($data as $item) {
    $noMeja = $item['noMeja'];
    $namaProduk = $item['namaProduk'];
    $jumlah = (int)$item['jmlh'];
    $subtotal = $item['subtotal'];
    $tanggal = $item['tanggal'];

    // Simpan ke tabel laporan
    $stmt = $koneksi->prepare("INSERT INTO laporan (no_meja, nama_produk, jumlah, subtotal, tanggal) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssids", $noMeja, $namaProduk, $jumlah, $subtotal, $tanggal);
    $stmt->execute();

    // Kurangi stok produk
    $stmt2 = $koneksi->prepare("SELECT stok FROM produk WHERE nama = ?");
    $stmt2->bind_param("s", $namaProduk);
    $stmt2->execute();
    $result = $stmt2->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $stokSekarang = (int)$row['stok'];
        $stokBaru = $stokSekarang - $jumlah;
        if ($stokBaru < 0) $stokBaru = 0; // Jangan negatif

        $stmt3 = $koneksi->prepare("UPDATE produk SET stok = ? WHERE nama = ?");
        $stmt3->bind_param("is", $stokBaru, $namaProduk);
        $stmt3->execute();
    }
}

echo json_encode(["status" => "success", "message" => "Checkout berhasil, stok diperbarui."]);
?>