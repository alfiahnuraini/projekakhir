<?php
include 'koneksi.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['laporan']) || !is_array($data['laporan'])) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak valid']);
    exit;
}

$laporan = $data['laporan'];
$status = 'success';

foreach ($laporan as $item) {
    $no_meja     = $item['no_meja'];
    $nama_produk = $item['nama_produk'];
    $jumlah      = (int)$item['jumlah'];
    $subtotal    = (int)$item['subtotal'];
    $tanggal     = date("Y-m-d H:i:s");

    $stmt = $koneksi->prepare("INSERT INTO laporan (no_meja, nama_produk, jumlah, subtotal, tanggal) VALUES (?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssiis", $no_meja, $nama_produk, $jumlah, $subtotal, $tanggal);
        $stmt->execute();
        $stmt->close();
    } else {
        $status = 'error';
        break;
    }
}

echo json_encode(['status' => $status]);
?>